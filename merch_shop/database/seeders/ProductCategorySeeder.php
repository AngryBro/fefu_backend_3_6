<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    private const DEPTH = 4;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductCategory::query()->delete();
        $this->seedChildren(ProductCategory::factory(random_int(1,3))->create()->pluck('id'),1);
    }

    function seedChildren($parentIds,$depth) {
        if ($depth > self::DEPTH) {
            return;
        }
        foreach($parentIds as $parentId) {
            $this->seedChildren(ProductCategory::factory(random_int(1,3))->child($parentId)->create()->pluck('id'),$depth+1);
        }
    }
}
