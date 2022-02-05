<?php

use App\Models\Car;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;

test('non users cannot get the list of available cars', function () {
    $this->getJson(route('dashboard'))
        ->assertStatus(401);
});

test('users can get the list of available cars', function () {
    $user = User::factory()->create();

    Car::factory()->count(2)->create(['number_of_available_cars' => 0, 'in_stock' => false]);
    Car::factory()->count(3)->state(new Sequence(
        ['car_name' => 'first car'],
        ['car_name' => 'second car'],
        ['car_name' => 'third car'],
    ))->create(['number_of_available_cars' => 1, 'in_stock' => true]);

    $this->actingAs($user)->getJson(route('dashboard'))
        ->assertOk()
        ->assertJson([['id' => 3, 'car_name' => 'first car'],
         ['id' => 4, 'car_name' => 'second car']])
        ->assertJsonCount(3);
});