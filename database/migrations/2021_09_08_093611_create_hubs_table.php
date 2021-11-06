<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateHubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hubs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('district_id')->comment('district_id')->nullable();
            $table->unsignedBigInteger('thana_id')->comment('thana_id')->nullable();
            $table->unsignedBigInteger('area_id')->comment('area_id')->nullable();
            $table->string('hub_name', 40)->comment('hub_name')->nullable();
            $table->string('address', 300)->comment('address')->nullable();
            $table->string('facebook', 350)->comment('facebook')->nullable();
            $table->string('phone', 50)->comment('phone')->nullable();
            $table->string('website', 150)->comment('website')->nullable();
            $table->enum('status', ['active','pending','rejected'])->default('pending')->comment(' status');
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
            $table->foreign('thana_id')->references('id')->on('thanas')->onDelete('cascade');
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Time of creation');
			$table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->comment('Time of Update');
            $table->index(['id','hub_name','created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hubs');
    }
}
