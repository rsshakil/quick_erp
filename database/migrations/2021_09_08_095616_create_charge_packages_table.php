<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateChargePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charge_packages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('charge_list_id')->comment('charge_list_id')->nullable();
            $table->unsignedBigInteger('weight_list_id')->comment('weight_list_id')->nullable();
            $table->enum('status', ['active','pending','rejected'])->default('active')->comment(' status');
            $table->string('charge', 10)->comment('rate')->nullable();
            $table->foreign('charge_list_id')->references('id')->on('charge_lists')->onDelete('cascade');
            $table->foreign('weight_list_id')->references('id')->on('weight_lists')->onDelete('cascade');
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Time of creation');
			$table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->comment('Time of Update');
            $table->index(['id','charge_list_id','created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('charge_packages');
    }
}
