<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Event::create([
            'hoster_id' => 1,
            'event_title' => 'How to code',
            'location' => 'Nigeria',
            'date' => '2022-10-10',
            'time' => '10:45pm',
            'description' => 'Learn to code ',
            'ticket_count' => '100',
            'recommended_donation_box' => 'P50',
            'ticket_price' => '50',
            'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b6/Image_created_with_a_mobile_phone.png/640px-Image_created_with_a_mobile_phone.png',
            'user_id' => '[1,2]',
        ]);
    }
}
