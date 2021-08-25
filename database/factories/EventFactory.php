<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'name' => $this->faker->text($maxNbChars = 40),
            'eventDescription' => $this->faker->text($maxNbChars = 180),
            'isItRecurringYearly' => (bool)random_int(0, 1)
        ];
    }
}
