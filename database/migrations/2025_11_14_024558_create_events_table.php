<?php

use App\Enums\Event\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->string('title');
            $table->text('description');
            $table->text('location');
            $table->string('pic');
            $table->foreignId('event_category_id');
            $table->foreignId('company_id');
            $table->foreignId('requestor_id');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('reason')->nullable();
            $table->string('status')->default(Status::PENDING->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
