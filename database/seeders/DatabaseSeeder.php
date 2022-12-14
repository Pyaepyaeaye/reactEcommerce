<?php

namespace Database\Seeders;

use App\Models\Size;
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
            'image' => "",

        ]);
        Admin::create([
            'name'=> "admin",
            'email'=> "admin@gmail.com",
            'password'=>Hash::make('123456'),
            
        ]);
        $category=['Shoes','Women Bag','T-shirt', 'Hat','Mobile'];
        foreach($category as $c){
            Category::create([
                'slug'=> Str::slug($c),
                'name'=> $c,
                'mm_name'=> "",
                'image'=> ""
            ]);
        }
        $brand=['Skechers','MBT','Samsung', 'Huawei','Apple'];
        foreach($brand as $b){
            Brand::create([
                'slug'=> Str::slug($b),
                'name'=> $b              
            ]);
        }
        $color=['red', 'green','blue', 'pink', 'white', 'black','orange'];
        foreach($color as $b){
            Color::create([
                'slug'=> Str::slug($b),
                'name'=> $b,
            ]);
        } 

        $size=['XS', 'S','M', 'L', 'XL'];
        foreach($size as $s){
            Size::create([
                'slug'=> Str::slug($s),
                'name'=> $s,
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
