<?php

use Illuminate\Database\Seeder;
use App\Models\User\UserEloquent;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        Eloquent::unguard();

        $au = [
            [
                'email' => 'yanatch1982@gmail.com',
                'name' => 'hiroki yanagisawa',
            ],
        ];

        // 管理者情報
        foreach ($au as $key => $u) {
            UserEloquent::create([
                'email' => $u['email'],
                'name' => $u['name'],
                'password' => bcrypt('password'),   // 一旦password固定
            ]);
        };

        Eloquent::reguard();
    }
}
