<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModuleRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_relation', function (Blueprint $table) {
            $table->unsignedInteger('module_id')->default(0)->comment('模块ID');
            $table->unsignedBigInteger('relation_id')->default(0)->comment('关联表ID');
            $table->char('relation_type',100)->default(0)->comment('关联类型');

            $table->primary(['relation_id','relation_type','module_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('module_relation');
    }
}
