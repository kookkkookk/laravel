<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product; // 哪一個 Table 就使用哪一個 model

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create 是只要呼叫，就能一直往下新增該資料
        Product::create(['title' => 'Append標題', 'content' => 'Append內容', 'price' => rand(0, 100), 'quantity' => 3]);

        // upsert
        // (參數1: Ary 產生的資料樣子,
        // 參數2: Ary 固定值唯一值 通常是id 用來判斷 固定值唯一值已在該Table存在 就不新增資料，沒有則新增, 
        // 參數3: Ary 如果固定值唯一值已在該Table存在 哪一些 data row是可以被覆蓋 )
        Product::upsert([
            ['id' => 6, 'title' => '固定標題3', 'content' => '固定內容3', 'price' => rand(0, 100), 'quantity' => 3],
            ['id' => 7, 'title' => '固定標題4', 'content' => '固定內容4', 'price' => rand(0, 100), 'quantity' => 4],
        ],
        ['id'],
        ['price', 'quantity']);
    }
}
