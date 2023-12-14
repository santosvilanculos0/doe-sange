<?php

use App\Models\Appointment;
use App\Models\BloodType;
use App\Models\Branch;
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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Appointment::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(BloodType::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(Branch::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->double('volume', 8, 2);
            $table->double('hemoglobin', 8, 2);
            $table->double('blood_pressure', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
