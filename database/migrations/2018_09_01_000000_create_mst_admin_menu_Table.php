<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMstAdminMenuTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        if (!Schema::hasTable('mst_admin_menu')) {
            Schema::create('mst_admin_menu', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('parent_menu_id')->unsigned()->nullable();
                $table->tinyInteger('level')->unsigned();
                $table->string('menu_name', 64);
                $table->string('eng_menu_name', 64)->nullable();
                $table->string('url', 256)->nullable();
                $table->string('icon', 128)->nullable();
                $table->tinyInteger('active')->unsigned();
                $table->string('overview', 1024)->nullable();
                $table->smallInteger('service');
                $table->string('display_order', 10);
                $table->tinyInteger('is_show_menu')->unsigned();
                $table->tinyInteger('is_head_office');
                $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->integer('created_id')->unsigned()->nullable();
                $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
                $table->integer('updated_id')->unsigned()->nullable();
                $table->timestamp('deleted_at')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_admin_menu');
    }

}
