<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //seecer is going to work like a controller
        //can use any function ike: save(), create(), createMany(),insert()

        //we can use __constructor to make the connection to the table as well
        //but for now, we only have one function, so we used this 
        $category = new Category;

        //with createMany, we don't need to add the timestamps(its inserted automatically)
        //but for insert()function, we need to add the timestamps
        //this seeder adds 3more rows to categories table
        //but for a seeder to work, we need to add $this->call() function in the DatabaseSeeder.php
        $categories =[
            [
                'name' => 'Theatre',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],[
                'name' => 'Wellness',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],[
                'name' => 'Business',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]
        ];

        $category->insert($categories);
    }
}
