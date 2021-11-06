<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateChargeListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charge_lists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('district_id')->comment('district_id')->nullable();
            // $table->string('charge_name',20)->comment('charge_name')->nullable();
            $table->string('charge_rate', 10)->comment('charge_rate')->default(0);
            $table->enum('status', ['active','pending','rejected'])->default('active')->comment(' status');
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Time of creation');
			$table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->comment('Time of Update');
            $table->index(['id','created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('charge_lists');
    }
}
