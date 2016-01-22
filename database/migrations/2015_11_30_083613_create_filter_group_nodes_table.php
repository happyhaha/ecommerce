<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilterGroupNodesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filter_group_nodes', function (Blueprint $table) {
            $table->unsignedInteger('filter_group_id')->nullable();
            $table->char('language_id', 2);
            $table->string('title', 60);

            $table->primary(['filter_group_id', 'language_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('filter_group_nodes');
    }
}
