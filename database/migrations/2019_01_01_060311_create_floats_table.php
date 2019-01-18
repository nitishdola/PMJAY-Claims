<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFloatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('floats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('float_file_id', false, true);

            $table->string('float_serial_number', 50);
            $table->string('patient_name', 127);
            $table->integer('beneficiary_district_id', false, true);
            $table->integer('hospital_id', false, true);
            $table->string('tpa_claim_reference_number', 127);
            $table->date('date_of_admission');
            $table->date('date_of_discharge');
            $table->decimal('gross_bill', 50,2);
            $table->decimal('deduction', 20,2);
            $table->decimal('tds', 20,2);
            $table->decimal('net_amount', 50,2);
            $table->date('date_of_payment');
            $table->boolean('status')->default(1);
            

            $table->timestamps();

            $table->foreign('float_file_id')->references('id')->on('float_files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('floats');
    }
}
