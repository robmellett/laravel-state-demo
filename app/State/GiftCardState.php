<?php

namespace App\State;

use Spatie\ModelStates\State;

abstract class GiftCardState extends State
{
    public static function config(): \Spatie\ModelStates\StateConfig
    {
        return parent::config()
            ->default(PendingState::class)
            ->allowTransition(PendingState::class, ActiveState::class)
            ->allowTransition(PendingState::class, InActiveState::class)
            ->allowTransition(ActiveState::class, ExpiredState::class)
            ->allowTransition([PendingState::class, ActiveState::class, InActiveState::class], DisabledState::class);
    }
}
