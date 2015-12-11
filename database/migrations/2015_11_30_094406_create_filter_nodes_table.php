<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilterNodesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filter_nodes', function (Blueprint $table) {
            $table->unsignedInteger('filter_id');
            $table->char('language_id', 2);
            $table->string('title', 60);

            $table->primary(['filter_id', 'language_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('filter_nodes');
    }
}
