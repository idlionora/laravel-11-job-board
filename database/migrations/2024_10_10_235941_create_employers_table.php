<?php

use App\Models\Placement;
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
        Schema::create('employers', function (Blueprint $table) {
            $table->id();

            $table->string('company_name');
            $table->foreignIdFor(\App\Models\User::class)->nullable()->constrained();
            //need to call nullable before constrained

            $table->timestamps();
        });

        Schema::table('placements', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Employer::class)->constrained();
        });
        // important to add this after we create the employers table, or even create it in separate migration
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('placements', function(Blueprint $table) {
            $table->dropForeignIdFor((\App\Models\Employer::class));
        });
        // need to drop the foreign key first before the whole table
        Schema::dropIfExists('employers');
    }
};
