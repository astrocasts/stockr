<?php

declare(strict_types=1);

namespace Stockr\EventSauce\EventSourcing;

use Doctrine\DBAL\Driver\Connection;
use EventSauce\EventSourcing\AggregateRootId;
use EventSauce\EventSourcing\Header;
use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageRepository;
use EventSauce\EventSourcing\Serialization\MessageSerializer;
use Generator;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use stdClass;

class DbMessageRepository implements MessageRepository
{
    /**
     * @var MessageSerializer
     */
    private $messageSerializer;

    /**
     * @var int
     */
    private $jsonEncodeOptions;

    /**
     * @var string
     */
    private $tableName;

    public function __construct(
        string $tableName,
        MessageSerializer $messageSerializer,
        int $jsonEncodeOptions = 0
    ) {
        $this->messageSerializer = $messageSerializer;
        $this->jsonEncodeOptions = $jsonEncodeOptions;
        $this->tableName = $tableName;
    }

    public function persist(Message ...$messages)
    {
        if (count($messages) === 0) {
            return;
        }

        $sql = $this->baseSql($this->tableName);
        $params = [];
        $values = [];

        foreach ($messages as $index => $message) {
            $payload = $this->messageSerializer->serializeMessage($message);
            $eventIdColumn = 'event_id_' . $index;
            $aggregateRootTypeColumn = 'aggregate_root_type_' . $index;
            $aggregateRootIdColumn = 'aggregate_root_id_' . $index;
            $eventTypeColumn = 'event_type_' . $index;
            $aggregateRootVersionColumn = 'aggregate_root_version_' . $index;
            $recordedAtColumn = 'recorded_at_' . $index;
            $payloadColumn = 'payload_' . $index;
            $values[] = "(:{$eventIdColumn}, :{$aggregateRootTypeColumn}, :{$eventTypeColumn}, :{$aggregateRootIdColumn},
            :{$aggregateRootVersionColumn}, :{$recordedAtColumn}, :{$payloadColumn})";
            $params[$aggregateRootTypeColumn] = $payload['headers']['__aggregate_root_type'];
            $params[$aggregateRootVersionColumn] = $payload['headers'][Header::AGGREGATE_ROOT_VERSION] ?? 0;
            $params[$recordedAtColumn] = $payload['headers'][Header::TIME_OF_RECORDING];
            $params[$eventIdColumn] = $payload['headers'][Header::EVENT_ID] = $payload['headers'][Header::EVENT_ID] ?? Uuid::uuid4()->toString();
            $params[$payloadColumn] = json_encode($payload, $this->jsonEncodeOptions);
            $params[$eventTypeColumn] = $payload['headers'][Header::EVENT_TYPE] ?? null;
            $params[$aggregateRootIdColumn] = $payload['headers'][Header::AGGREGATE_ROOT_ID] ?? null;
        }

        $sql .= join(', ', $values);

        DB::transaction(function () use ($sql, $params) {
            DB::insert($sql, $params);
        });
    }

    protected function baseSql(string $tableName): string
    {
        return "INSERT INTO {$tableName} (event_id, aggregate_root_type, event_type, aggregate_root_id, aggregate_root_version, recorded_at, payload) VALUES ";
    }

    public function retrieveAll(AggregateRootId $id): Generator
    {
        $rows = DB::table('events')
            ->select('payload')
            ->from($this->tableName)
            ->where('aggregate_root_id', '=', $id->toString())
            ->orderBy('recorded_at', 'ASC')
            ->get()
            ->map(function (stdClass $row) {
                yield from $this->messageSerializer->unserializePayload(json_decode($row->payload, true));
            })
            ->toArray();

        foreach ($rows as $row) {
            yield from $row;
        }
    }
}
