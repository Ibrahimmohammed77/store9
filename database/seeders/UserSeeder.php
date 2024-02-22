<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'admin',
            'email'=>'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'phone_number'=>'777849873'

        ]);
        User::create([
            'name' => 'ibra',
            'email' => 'ibra@gmail.com',
            'password' => Hash::make('admin123'),
            'phone_number' => '777849876',
            'type' => 'admin'
        ]);
        // User::create([
        //     'name' => 'sales',
        //     'email'=>'sales@gmail.com',
        //     'password' => Hash::make('sales123'),
        //     'phone_number'=>'777849878',
        //     'store_id'=>4
        // ]);
        $user = User::where('name', 'admin')->update(['type'=>'super-admin']);
        // $user->type ='super-admin';
        // $user->save();
    }
}
