<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
        $this -> call(ProductSeeder::class); // 把要產生的 seeder 一一放上來
        $this -> command -> info('已產生 ProductSeeder 資料'); // 在 Log 顯示的文字
        // ... 其他 Seeder 擺放 ...
        // ...
    }
}
