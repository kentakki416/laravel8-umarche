<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('primary_categories')->insert([
            [
                'name' => 'レディースファッション',
                'sort_order' => 1,
            ],
            [
                'name' => 'メンズファッション',
                'sort_order' => 2,
            ],
            [
                'name' => 'ギフト・贈り物',
                'sort_order' => 3,
            ],
        ]);

        DB::table('secondary_categories')->insert([
            [
                'name' => 'トップス',
                'sort_order' => 1,
                'primary_category_id' => 1,
            ],
            [
                'name' => 'ボトムス',
                'sort_order' => 2,
                'primary_category_id' => 1,
            ],
            [
                'name' => 'ワンピース',
                'sort_order' => 3,
                'primary_category_id' => 1,
            ],
            [
                'name' => 'トップス',
                'sort_order' => 4,
                'primary_category_id' => 2,
            ],
            [
                'name' => 'ボトムス',
                'sort_order' => 5,
                'primary_category_id' => 2,
            ],
            [
                'name' => 'アウター',
                'sort_order' => 6,
                'primary_category_id' => 1,
            ],
            [
                'name' => '花束',
                'sort_order' => 7,
                'primary_category_id' => 3,
            ],
            [
                'name' => '食品',
                'sort_order' => 8,
                'primary_category_id' => 3,
            ],
            [
                'name' => '飲み物',
                'sort_order' => 9,
                'primary_category_id' => 3,
            ],
        ]);
    }
}
