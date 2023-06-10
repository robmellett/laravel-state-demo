<?php

namespace Database\Factories;

use App\Models\GiftCard;
use App\State\ActiveState;
use App\State\DisabledState;
use App\State\PendingState;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class GiftCardFactory extends Factory
{
    protected $model = GiftCard::class;

    public function definition(): array
    {
        $amount = $this->faker->randomElement([5, 10, 25, 50, 100]);
        $balance = $this->faker->numberBetween(1, $amount);

        return [
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now(),
            'amount' => $amount,
            'balance' => $balance,
            'status' => PendingState::class,
        ];
    }

    public function isReadyToBeActivated()
    {
        return $this->state([
            'status' => PendingState::class,
            'start_date' => Carbon::now()->subMinute(),
            'end_date' => Carbon::now()->addDay(),
        ]);
    }

    public function isActivated()
    {
        return $this->state([
            'status' => ActiveState::class,
            'start_date' => Carbon::now()->subMinute(),
            'end_date' => Carbon::now()->addDay(),
        ]);
    }

    public function hasStartDateInPast()
    {
        return $this->state([
            'start_date' => Carbon::now()->subMinute(),
        ]);
    }

    public function hasStartDateInFuture()
    {
        return $this->state([
            'start_date' => Carbon::now()->addMinute(),
        ]);
    }

    public function hasEndDateInPast()
    {
        return $this->state([
            'end_date' => Carbon::now()->subMinute(),
        ]);
    }

    public function hasEndDateInFuture()
    {
        return $this->state([
            'end_date' => Carbon::now()->addMinute(),
        ]);
    }

    public function asActiveState()
    {
        return $this->state([
            'status' => ActiveState::class,
        ]);
    }

    public function asDisabledState()
    {
        return $this->state([
            'status' => DisabledState::class,
        ]);
    }
}
