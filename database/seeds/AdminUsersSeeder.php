<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();
        $users = [
            [
                'first_name' => 'Jody',
                'last_name' => 'McKay',
                'email' => 'jrmckay@uncg.edu',
                'provider_id' => '112722541301366186704',
                'email_verified_at' => $now,
                'avatar' => 'https://lh3.googleusercontent.com/a-/AAuE7mAGMXA4u1c9i2Lxj0HjnAjlzGVMR4cNsZfQVm1q',
                'spartan_id' => 777777777,
                'role' => 'Super Admin',
            ],
            [
                'first_name' => 'Chris',
                'last_name' => 'Metivier',
                'email' => 'cmmetivi@uncg.edu',
                'provider_id' => '117851868689191228560',
                'email_verified_at' => $now,
                'avatar' => 'https://lh3.googleusercontent.com/a-/AAuE7mCNMfOXWgQ2hz_7QTQue6uf12XEHkhNQtTls0H-Mw',
                'spartan_id' => 888888888,
                'role' => 'Super Admin',
            ],
            [
                'first_name' => 'Hiroshi',
                'last_name' => 'Suda',
                'email' => 'h_suda@uncg.edu',
                'provider_id' => '106673382126701774354',
                'email_verified_at' => $now,
                'avatar' => 'https://lh3.googleusercontent.com/a-/AAuE7mAooqGmXAPd84KYTJZAEdSOc5av_O0jKCGxkBnmdw',
                'spartan_id' => 999999999,
                'role' => 'Super Admin',
            ],
        ];

        foreach ($users as $user) {
            $newUser = User::firstOrNew(
                ['email' => $user['email']],
                [
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name']
                ]
            );

            $newUser->provider_name = 'google';
            $newUser->provider_id = $user['provider_id'];
            $newUser->email_verified_at = $user['email_verified_at'];
            $newUser->avatar = $user['avatar'];
            $newUser->spartan_id = $user['spartan_id'];
            $newUser->assignRole($user['role']);
            $newUser->save();
        }
    }
}
