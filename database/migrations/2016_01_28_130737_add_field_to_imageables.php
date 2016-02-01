<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldToImageables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('imageables', function (Blueprint $table) {
            $table->string('subtype', 50)->nullable()->after('imageable_type');
            $table->string('url', 255)->nullable()->after('subtype');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('imageables', function (Blueprint $table) {
            $table->dropColumn('subtype');
            $table->dropColumn('url');
        });
    }

}
