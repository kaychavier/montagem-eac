<?php

use App\Models\Status;
use App\Models\Team;
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
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Status::class, 'status_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Team::class, 'team_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name')->nullable();            
            $table->string('address')->nullable();     
            $table->string('city')->nullable();     
            $table->json('phones')->nullable();
            $table->boolean('is_teen')->nullable();
            $table->boolean('is_coordinator')->nullable();
            $table->softDeletes();     
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
