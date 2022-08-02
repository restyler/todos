<?php

namespace Database\Seeders;

use App\Models\Board;
use Illuminate\Database\Seeder;

class BoardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Board::query()->insert([
            'name' => 'Urgent',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        Board::query()->insert([
            'name' => 'Todos',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
