<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusAndIndexesToSliders extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->boolean('status')->default(1)->after('model_type');

            $table->index(['model_id', 'model_type', 'status']);
            $table->index(['model_type', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropIndex('sliders_model_id_model_type_status_index');
            $table->dropIndex('sliders_model_type_status_index');

            $table->dropColumn('status');
        });
    }

}
