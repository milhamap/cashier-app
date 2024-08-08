<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            [
                'name' => 'Categories',
                'url' => 'categories',
                'background_color' => 'bg-primary bg-gradient',
            ],
            [
                'name' => 'Types',
                'url' => 'types',
                'background_color' => 'bg-success bg-gradient',
            ],
            [
                'name' => 'Sch',
                'url' => 'sches',
                'background_color' => 'bg-warning bg-gradient',
            ],
            [
                'name' => 'Ratings',
                'url' => 'ratings',
                'background_color' => 'bg-danger bg-gradient',
            ],
            [
                'name' => 'Specs',
                'url' => 'specs',
                'background_color' => 'bg-info bg-gradient',
            ],
            [
                'name' => 'Sizes',
                'url' => 'sizes',
                'background_color' => 'bg-secondary bg-gradient',
            ],
            [
                'name' => 'Brands',
                'url' => 'brands',
                'background_color' => 'bg-dark bg-gradient',
            ]
        ];

        foreach ($menus as $menu) {
            \App\Models\Menu::create($menu);
        }
    }
}
