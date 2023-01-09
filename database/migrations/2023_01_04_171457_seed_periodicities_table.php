<?php

use App\Models\Periodicity;
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
        Periodicity::create(['id' => Periodicity::NONE , 'name' => 'none']);
        Periodicity::create(['id' => Periodicity::DAILY , 'name' => 'daily']);
        Periodicity::create(['id' => Periodicity::WEEKLY , 'name' => 'weekly']);
        Periodicity::create(['id' => Periodicity::MONTHLY , 'name' => 'monthly']);
        Periodicity::create(['id' => Periodicity::YEARLY , 'name' => 'yearly']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Periodicity::all()->delete();
    }
};
