<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Event;
use App\Models\Location;
use App\Models\Performer;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::truncate();
        Performer::truncate();
        Location::truncate();
        Event::truncate();

        User::factory(2)->create();

        $performer1 = Performer::factory()->create();
        $performer2 = Performer::factory()->create();
        $performer3 = Performer::factory()->create();
        $performer4 = Performer::factory()->create();
        $performer5 = Performer::factory()->create();

        $location1 = Location::factory()->create();
        $location2 = Location::factory()->create();
        $location3 = Location::factory()->create();
        $location4 = Location::factory()->create();
        $location5 = Location::factory()->create();

        Event::factory()->create([
            'performer_id' => $performer1->id,
            'location_id' => $location1->id
        ]);
        Event::factory()->create([
            'performer_id' => $performer2->id,
            'location_id' => $location2->id
        ]);
        Event::factory()->create([
            'performer_id' => $performer3->id,
            'location_id' => $location3->id
        ]);
        Event::factory()->create([
            'performer_id' => $performer4->id,
            'location_id' => $location4->id
        ]);
        Event::factory()->create([
            'performer_id' => $performer5->id,
            'location_id' => $location5->id
        ]);
    }
}
