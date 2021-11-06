<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateDeliveryAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_agents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('district_id')->comment('district_id')->nullable();
            $table->unsignedBigInteger('thana_id')->comment('thana_id')->nullable();
            $table->unsignedBigInteger('area_id')->comment('area_id')->nullable();
            $table->string('agent_name', 40)->comment('Delivery Agent Name')->nullable();
            $table->string('company_name', 40)->comment('company_name')->nullable();
            $table->string('full_address', 200)->comment('full_address')->nullable();
            $table->string('contact_number', 20)->comment('contact_number')->nullable();
            $table->string('facebook', 200)->comment('facebook')->nullable();
            $table->enum('status', ['active','pending','rejected'])->default('pending')->comment(' status');
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
            $table->foreign('thana_id')->references('id')->on('thanas')->onDelete('cascade');
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Time of creation');
			$table->dateTime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->comment('Time of Update');
            $table->index(['id','contact_number','created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_agents');
    }
}
