<?php

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
        Schema::create('job', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('job_type_id')->constrained()->onDelete('cascade');
            $table->integer('vacancy');
            $table->string('salary')->nullble();
            $table->string('location');
            $table->text('description')->nullble();
            $table->text('benefits')->nullble();
            $table->text('responsibility')->nullble();
            $table->text('qualifications')->nullble();
            $table->text('keywords')->nullble();
            $table->string('experience');
            $table->string('company_name');
            $table->string('company_location')->nullble();;
            $table->string('company_website')->nullble();;

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job');
    }
};
