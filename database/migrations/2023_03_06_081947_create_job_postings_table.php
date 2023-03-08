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
        Schema::create('job_postings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->date('closed_at');
            $table->string('employment_type')->default('FULL_TIME');
            $table->string('address')->nullable();
            $table->string('locality')->nullable();
            $table->string('region')->nullable();
            $table->string('postal_code')->nullable();
            $table->boolean('is_remote')->default(false);
            $table->string('salary_min');
            $table->string('salary_max')->nullable();
            $table->string('salary_unit')->default('MONTH');
            $table->string('company_name');
            $table->text('company_description');
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['title', 'company_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_postings');
    }
};
