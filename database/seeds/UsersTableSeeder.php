<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $faker = \Faker\Factory::create();

        // 모든 유저를 같은 비번으로 생성
        // 루프 돌기 전 비번을 먼저 해쉬로 변경
        // 해쉬로 바꾸지 않으면 너무 느려 짐
        $password = Hash::make('toptal');

        User::create([
            'name'=>'Administrator',
            'email'=>'admin@test.com',
            'password'=>$password
        ]);

        for ($i = 0; $i <10; $i++){
            User::create([
                'name'=>$faker->name,
                'email'=>$faker->email,
                'password'=>$password
            ]);
        }

    }
}
