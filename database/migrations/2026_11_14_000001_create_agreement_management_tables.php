<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Agreement Templates
        Schema::create('agreement_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category')->default('Software Development');
            $table->text('description')->nullable();
            $table->longText('content');
            $table->text('default_payment_terms')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Agreements Table (Strict Admin-Only Contracts)
        Schema::create('agreements', function (Blueprint $table) {
            $table->id();
            $table->string('agreement_number')->unique();
            $table->foreignId('template_id')->nullable()->constrained('agreement_templates')->nullOnDelete();
            $table->string('title');
            $table->string('client_name');
            $table->string('client_email');
            $table->string('client_company')->nullable();
            $table->string('client_phone')->nullable();
            $table->text('client_address')->nullable();
            $table->decimal('contract_value', 12, 2)->default(0.00);
            $table->string('currency', 10)->default('USD');
            $table->enum('status', [
                'draft',
                'pending_signature',
                'fully_signed',
                'estamp_pending',
                'active',
                'completed',
                'expired',
                'cancelled'
            ])->default('draft');
            $table->longText('content');
            $table->text('scope_of_work')->nullable();
            $table->text('payment_terms')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->dateTime('signed_at')->nullable();
            $table->dateTime('finalized_at')->nullable();
            $table->dateTime('cancelled_at')->nullable();
            $table->text('cancellation_reason')->nullable();
            
            // Private PDF Storage & Integrity
            $table->string('pdf_path')->nullable();
            $table->string('pdf_hash', 64)->nullable();
            $table->dateTime('pdf_generated_at')->nullable();
            
            // Cryptographic Digital Signature
            $table->string('digital_signature_hash', 64)->nullable();
            $table->json('digital_signature_metadata')->nullable();
            
            // Legal e-Stamp Details
            $table->string('estamp_number')->nullable();
            $table->string('estamp_certificate_path')->nullable();
            $table->string('estamp_state')->nullable();
            $table->decimal('estamp_amount', 10, 2)->nullable();
            $table->dateTime('estamp_issued_at')->nullable();

            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index('client_email');
        });

        // 3. Agreement Audit Logs
        Schema::create('agreement_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agreement_id')->nullable()->constrained('agreements')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action'); // created, updated, pdf_generated, pdf_downloaded, digitally_signed, estamp_attached, approved, cancelled, status_changed
            $table->text('details')->nullable();
            $table->json('metadata')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['agreement_id', 'created_at']);
            $table->index('action');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agreement_audit_logs');
        Schema::dropIfExists('agreements');
        Schema::dropIfExists('agreement_templates');
    }
};

