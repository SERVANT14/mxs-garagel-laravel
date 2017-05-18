<?php

use Illuminate\Database\Seeder;

class TrackCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Services\Tracks\Models\TrackCategory::truncate();

        $categories = ['Motocross', 'Supercross'];

        foreach ($categories as $categoryName) {
            $category = new \App\Services\Tracks\Models\TrackCategory();
            $category->name = $categoryName;
            $category->save();
        }
    }
}
