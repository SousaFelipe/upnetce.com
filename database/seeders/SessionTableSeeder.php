<?php
namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SessionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sessions')->insert([
            'provedor'      => 1,
            'user'          => 1,
            'token'         => '8:0cd768b9960525b66a9b493de95452ae3422b78b5b1387f63f130af57ebe0eb7',
            'updated_at'    => '2022-01-06 17:55:00'
        ]);
    }
}
