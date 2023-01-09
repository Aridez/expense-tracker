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
        Schema::create('upcoming_transactions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->date('original_date');
            $table->string('description', 128);
            $table->decimal('amount', 13, 2);
            $table->date('repeat_until')->nullable()->default(null);

            $table->timestamps();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('periodicity_id')->default(Periodicity::where('name', 'none')->first()->id);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('periodicity_id')->references('id')->on('periodicities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('upcoming_transactions');
    }
};
