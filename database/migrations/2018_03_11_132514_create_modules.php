<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->increments('id');
            $table->char('name',50)->default('')->comment('模块名称');
            $table->char('sign',50)->default('')->comment('模块标识');
            $table->char('namespace',150)->default('')->comment('命名空间');
            $table->unsignedInteger('status')->default(0)->commet('状态，1开启，2隐藏，3关闭');
            $table->unsignedBigInteger('created_at')->default(0)->comment('创建时间');
            $table->unsignedBigInteger('updated_at')->default(0)->comment('修改时间');
            $table->unsignedBigInteger('deleted_at')->default(null)->nullable()->comment('删除时间');

            $table->unique('sign');
            $table->unique('namespace');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modules');
    }
}
