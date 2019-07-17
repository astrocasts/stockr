<?php

declare(strict_types=1);

namespace Stockr\EventSauce\EventSourcing;

use EventSauce\EventSourcing\AggregateRootId;
use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageRepository;
use EventSauce\EventSourcing\Serialization\MessageSerializer;
use Generator;

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

    public function __construct(MessageSerializer $messageSerializer, int $jsonEncodeOptions = 0)
    {
        $this->messageSerializer = $messageSerializer;
        $this->jsonEncodeOptions = $jsonEncodeOptions;
    }

    public function persist(Message ...$messages)
    {
        print_r(['messages to be persisted' => $messages]);
    }

    public function retrieveAll(AggregateRootId $id): Generator
    {

    }
}
