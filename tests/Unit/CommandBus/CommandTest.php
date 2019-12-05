<?php

declare(strict_types=1);

namespace Tests\Unit\CommandBus;

use Stockr\CommandBus\InvalidPayload;
use Tests\TestCase;
use Tests\Unit\CommandBus\Fixtures\CommandWithAllowedFieldsOnly;
use Tests\Unit\CommandBus\Fixtures\CommandWithBothAllowedAndRequiredFields;

class CommandTest extends TestCase
{
    /** @test */
    public function it_validates_command_with_both_required_and_allowed_successfully()
    {
        $payload = CommandWithBothAllowedAndRequiredFields::validate(
            [
                'test_allowed_field' => 'allowed',
                'test_required_field' => 'required',
                'test_ignored_field' => 'ignored'
            ]
        );

        $this->assertEquals(
            [
                'test_allowed_field' => 'allowed',
                'test_required_field' => 'required',
            ],
            $payload
        );
    }


    /** @test */
    public function it_validates_command_with_only_allowed_successfully()
    {
        $payload = CommandWithAllowedFieldsOnly::validate(
            [
                'test_allowed_field' => 'allowed',
                'test_ignored_field' => 'ignored'
            ]
        );

        $this->assertEquals(
            [
                'test_allowed_field' => 'allowed',
            ],
            $payload
        );
    }


    /** @test */
    public function it_validates_command_with_only_required_successfully()
    {
        $payload = CommandWithBothAllowedAndRequiredFields::validate(
            [
                'test_required_field' => 'required',
                'test_ignored_field' => 'ignored'
            ]
        );

        $this->assertEquals(
            [
                'test_required_field' => 'required',
            ],
            $payload
        );
    }

    /** @test */
    public function it_fails_to_validate_command_with_both_required_and_allowed_successfully()
    {
        $this->expectException(InvalidPayload::class);

        CommandWithBothAllowedAndRequiredFields::validate(
            [
                'test_allowed_field' => 'allowed',
                'test_ignored_field' => 'ignored'
            ]
        );
    }

    /** @test */
    public function it_fails_to_validate_command_with_only_required_successfully()
    {
        $this->expectException(InvalidPayload::class);

        CommandWithBothAllowedAndRequiredFields::validate(
            [
                'test_ignored_field' => 'ignored'
            ]
        );
    }
}
