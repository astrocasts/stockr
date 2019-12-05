<?php

declare(strict_types=1);

namespace Stockr\CommandBus;

use InvalidArgumentException;

class InvalidPayload extends InvalidArgumentException
{
    static public function missingRequiredFields(string ...$fields): self
    {
        $fieldsString = implode(', ', array_map(function($field) {
            return '"'.$field.'"';
        }, $fields));
        $fieldLabel = count($fields) === 1 ? 'field' : 'fields';

        return new static(sprintf('Payload missing required %s %s', $fieldLabel, $fieldsString));
    }
}
