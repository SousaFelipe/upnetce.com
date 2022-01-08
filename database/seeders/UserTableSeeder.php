<?php
namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'provedor'      => 1,
            'id_ixc'        => 8,
            'tipo'          => 'V',
            'name'          => 'Felipe Sousa',
            'email'         => 'sousa.felipe@darth.com',
            'password'      => bcrypt('marver1234'),
            'ixc_token'     => '8:0cd768b9960525b66a9b493de95452ae3422b78b5b1387f63f130af57ebe0eb7',
            'created_at'    => Carbon::now()->toDateTimeString(),
        ]);
    }
}
