<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToCarts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carts', function (Blueprint $table) {
            // 在 carts 建立一個 column: user_id, constrained('users') 對應到 Table:users 的 id, after 新增在 column: id 的後面
            $table -> foreignId('user_id') -> constrained('users') -> after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carts', function (Blueprint $table) {
            // 這邊就不是單純dropColumn, dropConstrainedForeignId 因為上面有做一些條件(constrained) 所以要先移除條件後在移除 column
            $table -> dropConstrainedForeignId('user_is');
        });
    }
}
