<?php

namespace App\Models;

use App\State\ActiveState;
use App\State\ExpiredState;
use App\State\GiftCardState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LogicException;
use Spatie\ModelStates\HasStates;

class GiftCard extends Model
{
    use HasFactory;
    use HasStates;

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'status' => GiftCardState::class,
    ];

    public function activate(): void
    {
        if ($this->start_date->isFuture()) {
            throw new LogicException("Cannot activate a GiftCard that has a 'start_date' in the future.");
        }

        if ($this->end_date->isPast()) {
            throw new LogicException("Cannot activate a GiftCard that has an 'end_date' in the past.");
        }

        $this->status->transitionTo(ActiveState::class);
    }

    public function expire(): void
    {
        if ($this->end_date->isFuture()) {
            throw new LogicException("Cannot expire a GiftCard that has an 'end_date' in the future.");
        }

        $this->status->transitionTo(ExpiredState::class);
    }
}
