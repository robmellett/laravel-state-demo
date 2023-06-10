<?php

namespace Tests\Unit;

use App\Models\GiftCard;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use LogicException;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function can_active_giftcard()
    {
        $card = GiftCard::factory()
            ->isReadyToBeActivated()
            ->create();

        $card->activate();

        $this->assertEquals('active', $card->status);
    }

    /** @test */
    public function cannot_activate_giftcards_with_start_date_in_the_future()
    {
        $this->expectException(LogicException::class, 'Cannot activate a GiftCard that has a \'start_date\' in the future.');

        $card = GiftCard::factory()
            ->isReadyToBeActivated()
            ->hasStartDateInFuture()
            ->create();

        $card->activate();
    }

    /** @test */
    public function cannot_activate_giftcards_with_end_date_in_the_past()
    {
        $this->expectException(LogicException::class, 'Cannot activate a GiftCard that has an \'end_date\' in the past.');

        $card = GiftCard::factory()
            ->isReadyToBeActivated()
            ->hasEndDateInPast()
            ->create();

        $card->activate();
    }

    /** @test */
    public function can_expire_giftcards()
    {
        $card = GiftCard::factory()
            ->isActivated()
            ->hasEndDateInPast()
            ->create();

        $card->expire();

        $this->assertEquals('expired', $card->status);
    }

    /** @test */
    public function cannot_expire_giftcards_with_end_date_in_the_future()
    {
        $this->expectException(LogicException::class, 'Cannot expire a GiftCard that has an \'end_date\' in the future.');

        $card = GiftCard::factory()
            ->isActivated()
            ->hasEndDateInFuture()
            ->create();

        $card->expire();
    }

    /** @test */
    public function cannot_transition_when_disabled()
    {
        $this->expectException(\Spatie\ModelStates\Exceptions\TransitionNotFound::class);

        $card = GiftCard::factory()
            ->isReadyToBeActivated()
            ->asDisabledState()
            ->create();

        $card->activate();
    }
}
