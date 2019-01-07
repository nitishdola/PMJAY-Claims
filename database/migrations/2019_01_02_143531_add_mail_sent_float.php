<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMailSentFloat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('floats', function (Blueprint $table) {
            $table->boolean('mail_sent')->default(0)->after('date_of_payment');
            $table->dateTime('mail_sent_on')->nullable()->after('mail_sent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('floats', function (Blueprint $table) {
            //
        });
    }
}
