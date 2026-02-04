<?php

namespace Database\Seeders;

use App\Models\Db;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dbs = [
            [
                'name' => 'dc_a',
                'connection' => 'mysql_dc_a',
                'mode' => 'active',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'dc_b',
                'connection' => 'mysql_dc_b',
                'mode' => 'sync',
                'created_at' => Carbon::now()
            ],
        ];

        foreach ($dbs as $db) {
            
            Db::create($db);
        }
    }
}
