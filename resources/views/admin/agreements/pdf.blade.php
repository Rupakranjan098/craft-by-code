<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $agreement->agreement_number }} - {{ $agreement->title }}</title>
    <style>
        @page {
            margin: 20mm 15mm 20mm 15mm;
            @bottom-right {
                content: "Page " counter(page) " of " counter(pages);
                font-size: 8pt;
                color: #64748b;
            }
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.5;
            color: #1e293b;
            margin: 0;
            padding: 0;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .brand-title {
            font-size: 18pt;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.5px;
        }
        .brand-subtitle {
            font-size: 8pt;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: bold;
        }
        .header-meta {
            text-align: right;
            font-size: 8.5pt;
            color: #475569;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            font-size: 8pt;
            font-weight: bold;
            border-radius: 4px;
            text-transform: uppercase;
        }
        .badge-active { background-color: #dcfce7; color: #166534; }
        .badge-signed { background-color: #e0e7ff; color: #3730a3; }
        .badge-estamp { background-color: #fef3c7; color: #92400e; }
        .badge-draft { background-color: #f1f5f9; color: #475569; }
        
        .parties-table {
            width: 100%;
            margin-bottom: 20px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
        }
        .party-box {
            width: 50%;
            vertical-align: top;
            padding: 12px 14px;
        }
        .party-title {
            font-size: 8pt;
            font-weight: bold;
            color: #2563eb;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .party-name {
            font-size: 11pt;
            font-weight: bold;
            color: #0f172a;
        }
        .party-detail {
            font-size: 8.5pt;
            color: #475569;
            line-height: 1.4;
        }
        
        .summary-bar {
            width: 100%;
            border: 1px solid #cbd5e1;
            background-color: #f1f5f9;
            margin-bottom: 22px;
            border-radius: 6px;
        }
        .summary-cell {
            padding: 8px 12px;
            text-align: center;
            border-right: 1px solid #cbd5e1;
        }
        .summary-cell:last-child {
            border-right: none;
        }
        .summary-label {
            font-size: 7.5pt;
            color: #64748b;
            text-transform: uppercase;
            font-weight: bold;
            display: block;
        }
        .summary-value {
            font-size: 10.5pt;
            font-weight: bold;
            color: #0f172a;
        }
        
        .section-heading {
            font-size: 11.5pt;
            font-weight: bold;
            color: #0f172a;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 4px;
            margin-top: 18px;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .content-body {
            font-size: 9.5pt;
            color: #334155;
            line-height: 1.6;
            white-space: pre-line;
            margin-bottom: 20px;
        }

        .estamp-cert-box {
            background-color: #fffbeb;
            border: 1.5px solid #f59e0b;
            border-radius: 6px;
            padding: 10px 14px;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .estamp-title {
            font-size: 9pt;
            font-weight: bold;
            color: #b45309;
            text-transform: uppercase;
            margin-bottom: 4px;
        }
        
        .signature-table {
            width: 100%;
            margin-top: 30px;
            page-break-inside: avoid;
        }
        .signature-box {
            width: 48%;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 12px 14px;
            background-color: #ffffff;
            vertical-align: top;
        }
        .sig-header {
            font-size: 8pt;
            font-weight: bold;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 8px;
        }
        .sig-stamp {
            border: 1px dashed #2563eb;
            background-color: #eff6ff;
            padding: 8px;
            border-radius: 4px;
            margin-bottom: 8px;
        }
        .sig-stamp-text {
            font-size: 7.5pt;
            color: #1e40af;
            font-family: monospace;
            word-break: break-all;
        }

        .footer-integrity {
            margin-top: 35px;
            padding-top: 10px;
            border-top: 1px solid #e2e8f0;
            font-size: 7.5pt;
            color: #94a3b8;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Header & Letterhead -->
    <table class="header-table">
        <tr>
            <td style="vertical-align: middle;">
                <div class="brand-title">CraftByCode</div>
                <div class="brand-subtitle">Digital Product Engineering &amp; Legal Contract Office</div>
            </td>
            <td class="header-meta" style="vertical-align: middle;">
                <div><strong>Agreement No:</strong> {{ $agreement->agreement_number }}</div>
                <div><strong>Date:</strong> {{ $agreement->created_at ? $agreement->created_at->format('F d, Y') : now()->format('F d, Y') }}</div>
                <div style="margin-top: 4px;">
                    <span class="badge {{ in_array($agreement->status, ['active', 'fully_signed', 'completed']) ? 'badge-active' : ($agreement->status === 'estamp_pending' ? 'badge-estamp' : 'badge-draft') }}">
                        Status: {{ strtoupper(str_replace('_', ' ', $agreement->status)) }}
                    </span>
                </div>
            </td>
        </tr>
    </table>

    <!-- Parties Identification Box -->
    <table class="parties-table">
        <tr>
            <td class="party-box" style="border-right: 1px solid #e2e8f0;">
                <div class="party-title">First Party / Service Provider</div>
                <div class="party-name">CraftByCode Technologies</div>
                <div class="party-detail">
                    100 Innovation Way, Suite 400<br>
                    San Francisco, CA 94105, United States<br>
                    legal@craftbycode.tech | +1 (555) 019-2834
                </div>
            </td>
            <td class="party-box">
                <div class="party-title">Second Party / Client</div>
                <div class="party-name">{{ $agreement->client_company ?: $agreement->client_name }}</div>
                <div class="party-detail">
                    Representative: {{ $agreement->client_name }}<br>
                    Email: {{ $agreement->client_email }}<br>
                    @if($agreement->client_phone)Phone: {{ $agreement->client_phone }}<br>@endif
                    @if($agreement->client_address){{ $agreement->client_address }}@endif
                </div>
            </td>
        </tr>
    </table>

    <!-- Executive Summary Strip -->
    <table class="summary-bar">
        <tr>
            <td class="summary-cell">
                <span class="summary-label">Agreement Type</span>
                <span class="summary-value">{{ $agreement->template?->category ?: 'Software Development' }}</span>
            </td>
            <td class="summary-cell">
                <span class="summary-label">Total Contract Value</span>
                <span class="summary-value">{{ $agreement->getFormattedValue() }} {{ $agreement->currency }}</span>
            </td>
            <td class="summary-cell">
                <span class="summary-label">Commencement Date</span>
                <span class="summary-value">{{ $agreement->start_date ? $agreement->start_date->format('M d, Y') : 'Immediate' }}</span>
            </td>
            <td class="summary-cell">
                <span class="summary-label">Target Completion</span>
                <span class="summary-value">{{ $agreement->end_date ? $agreement->end_date->format('M d, Y') : 'Per Milestones' }}</span>
            </td>
        </tr>
    </table>

    <!-- Scope of Work Schedule -->
    @if($agreement->scope_of_work)
        <div class="section-heading">Schedule A — Scope of Deliverables &amp; Specifications</div>
        <div class="content-body">{{ $agreement->scope_of_work }}</div>
    @endif

    <!-- Commercial & Payment Terms -->
    @if($agreement->payment_terms)
        <div class="section-heading">Schedule B — Consideration &amp; Payment Milestones</div>
        <div class="content-body">{{ $agreement->payment_terms }}</div>
    @endif

    <!-- Agreement Clauses and Legal Terms -->
    <div class="section-heading">Schedule C — Terms, Conditions &amp; Covenants</div>
    <div class="content-body">{{ $agreement->content }}</div>

    <!-- Official e-Stamp Certificate Block (If Attached) -->
    @if($agreement->hasEstamp())
        <div class="estamp-cert-box">
            <div class="estamp-title">Official e-Stamp Certificate Endorsement</div>
            <table style="width: 100%; font-size: 8.5pt;">
                <tr>
                    <td><strong>Certificate ID / GRN:</strong> {{ $agreement->estamp_number }}</td>
                    <td><strong>Jurisdiction:</strong> {{ $agreement->estamp_state ?? 'Delaware' }}</td>
                    <td><strong>Stamp Duty Paid:</strong> {{ $agreement->currency }} {{ number_format((float) $agreement->estamp_amount, 2) }}</td>
                    <td><strong>Issued Date:</strong> {{ $agreement->estamp_issued_at ? $agreement->estamp_issued_at->format('M d, Y') : 'Verified' }}</td>
                </tr>
            </table>
        </div>
    @endif

    <!-- Digital Signature Execution Block -->
    <table class="signature-table">
        <tr>
            <td class="signature-box">
                <div class="sig-header">For &amp; On Behalf of CraftByCode:</div>
                @if($agreement->hasDigitalSignature())
                    <div class="sig-stamp">
                        <div style="font-size: 8.5pt; font-weight: bold; color: #1e3a8a; margin-bottom: 2px;">
                            ✓ Cryptographically Signed &amp; Sealed
                        </div>
                        <div class="sig-stamp-text">
                            Signatory: {{ $agreement->digital_signature_metadata['signed_by'] ?? 'Admin Craft By Code' }}<br>
                            Designation: {{ $agreement->digital_signature_metadata['signatory_role'] ?? 'Authorized Officer' }}<br>
                            Timestamp: {{ $agreement->signed_at ? $agreement->signed_at->format('Y-m-d H:i:s T') : 'Verified' }}<br>
                            Hash: {{ substr($agreement->digital_signature_hash, 0, 32) }}...
                        </div>
                    </div>
                @else
                    <div style="height: 50px; border-bottom: 1px solid #94a3b8; margin-bottom: 8px;"></div>
                    <div style="font-size: 8pt; color: #64748b;">Authorized Signatory</div>
                @endif
                <div style="font-size: 8.5pt; font-weight: bold; color: #0f172a;">CraftByCode Technologies</div>
            </td>
            <td style="width: 4%;"></td>
            <td class="signature-box">
                <div class="sig-header">For &amp; On Behalf of Client:</div>
                <div style="height: 50px; border-bottom: 1px solid #94a3b8; margin-bottom: 8px;"></div>
                <div style="font-size: 8.5pt; font-weight: bold; color: #0f172a;">{{ $agreement->client_name }}</div>
                <div style="font-size: 8pt; color: #64748b;">{{ $agreement->client_company ?: 'Authorized Representative' }}</div>
            </td>
        </tr>
    </table>

    <!-- Document Fingerprint & Tamper-Evident Hash -->
    <div class="footer-integrity">
        Strict Admin-Only Record &bull; Generated by CraftByCode Security Back-Office &bull; 
        @if($agreement->pdf_hash)
            SHA-256 Digest: {{ $agreement->pdf_hash }}
        @else
            Document Ref: {{ $agreement->agreement_number }}
        @endif
    </div>

</body>
</html>

