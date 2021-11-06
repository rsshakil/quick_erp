<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParcelAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parcel_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parcel_id')->comment('parcel_id')->nullable();
            $table->string('collection_amount', 10)->comment('collection_amount')->nullable();
            $table->string('charge_amount', 10)->comment('charge_amount')->nullable();
            $table->string('total_collection', 10)->comment('total_collection')->nullable();
            $table->enum('status', ['active','pending'])->default('pending')->comment('status');
            $table->foreign('parcel_id')->references('id')->on('parcels')->onDelete('cascade');
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Time of creation');
			$table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->comment('Time of Update');
            $table->index(['id','parcel_id','created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parcel_accounts');
    }
}
