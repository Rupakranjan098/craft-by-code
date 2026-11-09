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
        // 1. Departments Table
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->string('manager_name')->nullable();
            $table->timestamps();
        });

        // 2. Employees Table
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->string('designation');
            $table->date('joining_date');
            $table->decimal('salary', 12, 2)->default(0);
            $table->enum('status', ['active', 'on_leave', 'terminated'])->default('active');
            $table->string('avatar')->nullable();
            $table->string('address')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->timestamps();
        });

        // 3. Attendances Table
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->date('date');
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
            $table->enum('status', ['present', 'late', 'half_day', 'absent', 'on_leave'])->default('present');
            $table->string('notes')->nullable();
            $table->timestamps();
            $table->unique(['employee_id', 'date']);
        });

        // 4. Leave Requests Table
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->string('leave_type'); // Casual Leave, Sick Leave, Annual PTO, Parental
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('days')->default(1);
            $table->text('reason');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_remarks')->nullable();
            $table->timestamps();
        });

        // 5. Payrolls Table
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->string('month'); // e.g. "November 2026"
            $table->decimal('basic_salary', 12, 2);
            $table->decimal('allowance', 12, 2)->default(0);
            $table->decimal('deductions', 12, 2)->default(0);
            $table->decimal('net_salary', 12, 2);
            $table->date('payment_date')->nullable();
            $table->string('payment_method')->default('Bank Transfer');
            $table->enum('status', ['pending', 'processed', 'paid'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
        Schema::dropIfExists('leaves');
        Schema::dropIfExists('attendances');
        Schema::dropIfExists('employees');
        Schema::dropIfExists('departments');
    }
};

