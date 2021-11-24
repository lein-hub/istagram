<?php

namespace Database\Seeders;

use App\Models\Channel;
use App\Models\ChannelUser;
use Illuminate\Database\Seeder;

class ChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Channel::create([
        //     'name' => '채널A'
        // ]);
        // Channel::create([
        //     'name' => 'ANIMAX'
        // ]);
        ChannelUser::create([
            'channel_id' => 1,
            'user_id' => 1,
        ]);
        ChannelUser::create([
            'channel_id' => 1,
            'user_id' => 2,
        ]);
        ChannelUser::create([
            'channel_id' => 2,
            'user_id' => 1,
        ]);
    }
}
