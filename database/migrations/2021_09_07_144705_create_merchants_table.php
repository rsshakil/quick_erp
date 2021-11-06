<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('district_id')->comment('district_id')->nullable();
            $table->unsignedBigInteger('thana_id')->comment('thana_id')->nullable();
            $table->unsignedBigInteger('area_id')->comment('area_id')->nullable();
            $table->unsignedBigInteger('user_id')->comment('users_id')->nullable();
            $table->string('company_name', 40)->comment('company_name')->nullable();
            $table->string('full_address', 200)->comment('full_address')->nullable();
            $table->string('business_address', 200)->comment('business_address')->nullable();
            $table->string('phone', 30)->comment('phone number')->nullable();
            $table->string('facebook', 200)->comment('facebook')->nullable();
            $table->string('website', 200)->comment('website')->nullable();
            $table->string('bank_name', 50)->comment('Bank Name')->nullable();
            $table->string('account_holder_name', 100)->comment('Bank Account Holder Name')->nullable();
            $table->string('account_number', 25)->comment('Bank Account Number')->nullable();
            $table->string('bkash_number', 20)->comment('Bkash Account Number')->nullable();
            $table->string('nagad_number', 20)->comment('Nagad Account Number')->nullable();
            $table->string('rocket_number', 20)->comment('Duch bangla mobile banking Number')->nullable();
            $table->string('nid', 100)->comment('nid')->nullable();
            $table->string('trade_license', 100)->comment('trade_license')->nullable();
            $table->string('tin', 100)->comment('tin')->nullable();
            $table->string('image', 200)->comment('image')->nullable();
            $table->enum('status', ['active','pending','rejected'])->default('pending')->comment(' status');
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
            $table->foreign('thana_id')->references('id')->on('thanas')->onDelete('cascade');
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Time of creation');
			$table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->comment('Time of Update');
            $table->index(['id','user_id','created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('merchants');
    }
}
