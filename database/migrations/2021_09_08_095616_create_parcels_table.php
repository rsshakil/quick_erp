<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateParcelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parcels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_address_id')->comment('customer_id')->nullable();
            $table->unsignedBigInteger('merchant_id')->comment('merchant_id')->nullable();
            $table->unsignedBigInteger('charge_package_id')->comment('charge_package_id')->nullable();
            $table->unsignedBigInteger('delivery_option_id')->comment('delivery_option_id')->nullable();
            $table->string('marchent_order_id', 20)->comment('marchent_order_id')->nullable();
            $table->enum('selected_pickup_address', ['Business Address','Full Address'])->default('Business Address')->comment(' selected_pickup_address');
            $table->string('pickup_address', 200)->comment('pickup_address')->nullable();
            $table->string('product_description', 200)->comment('product_description')->nullable();
            $table->string('remark', 100)->comment('remark')->nullable();
            $table->enum('status', ['pending','picking','on_delivery','delivered','returned'])->default('pending')->comment(' status');

            $table->foreign('charge_package_id')->references('id')->on('charge_packages')->onDelete('cascade');
            $table->foreign('customer_address_id')->references('id')->on('customer_addresses')->onDelete('cascade');
            $table->foreign('merchant_id')->references('id')->on('merchants')->onDelete('cascade');
            $table->foreign('delivery_option_id')->references('id')->on('delivery_options')->onDelete('cascade');
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Time of creation');
			$table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->comment('Time of Update');
            $table->index(['id','merchant_id','status','created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parcels');
    }
}
