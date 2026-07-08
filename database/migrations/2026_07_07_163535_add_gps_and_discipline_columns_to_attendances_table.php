<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->double('check_in_latitude')->nullable()->after('check_in_time');
            $table->double('check_in_longitude')->nullable()->after('check_in_latitude');
            $table->double('check_out_latitude')->nullable()->after('check_out_time');
            $table->double('check_out_longitude')->nullable()->after('check_out_latitude');
            $table->boolean('is_late')->default(false)->after('status');
            $table->boolean('is_early_checkout')->default(false)->after('is_late');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn([
                'check_in_latitude',
                'check_in_longitude',
                'check_out_latitude',
                'check_out_longitude',
                'is_late',
                'is_early_checkout'
            ]);
        });
    }
};
