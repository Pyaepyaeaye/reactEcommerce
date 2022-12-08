<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::create([
            'name'=> "user",
            'email'=> "user@gmail.com",
            'password'=>Hash::make('123456'),

        ]);
        Admin::create([
            'name'=> "admin",
            'email'=> "admin@gmail.com",
            'password'=>Hash::make('123456'),
            
        ]);
        $category=['Shoes','T-shirt', 'Hat','Mobile'];
        foreach($category as $c){
            Category::create([
                'slug'=> Str::slug($c),
                'name'=> $c,
            ]);
        }
        $brand=['Skechers','Samsung', 'Huawei','Apple'];
        foreach($brand as $b){
            Brand::create([
                'slug'=> Str::slug($b),
                'name'=> $b,
            ]);
        }
        $color=['red', 'green','blue','pink'];
        foreach($color as $b){
            Color::create([
                'slug'=> Str::slug($b),
                'name'=> $b,
            ]);
        } 
        $supplier = ['supplier One','supplier Two'];
        foreach($supplier as $s){
            Supplier::create([
                'name'=> Str::slug($s),
                'image'=>""
            ]);
        }
       

    }
}
