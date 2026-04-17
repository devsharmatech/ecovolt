@extends('admin.layouts.master')

<style>
.doc-upload-wrap { padding: 10px; background: #fafafa; min-height: 100vh; }
.doc-card { background: #fff; border-radius: 24px; box-shadow: 0 10px 40px rgba(0,0,0,0.03); border: 1px solid #f1f5f9; overflow: hidden; }
.doc-head { background: linear-gradient(135deg, #166534, #15803d); padding: 32px 40px; color: #fff; display: flex; align-items: center; justify-content: space-between; }

.section-title { font-size: 1.1rem; font-weight: 800; color: #1e293b; margin-bottom: 24px; display: flex; align-items: center; gap: 10px; border-bottom: 2px solid #f1f5f9; padding-bottom: 12px; }

.upload-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px; }
.upload-box { 
    background: #fff; border: 2px dashed #e2e8f0; border-radius: 20px; padding: 24px; 
    transition: .3s; position: relative; display: flex; flex-direction: column; gap: 15px;
}
.upload-box:hover { border-color: #27ae60; background: #f0fdf4; }
.box-label { font-size: .9rem; font-weight: 800; color: #475569; display: flex; align-items: center; gap: 8px; }
.box-icon { font-size: 1.5rem; color: #166534; opacity: 0.7; }

.file-input { 
    font-size: .8rem; font-weight: 600; color: #64748b; 
    padding: 10px; border-radius: 12px; background: #f8fafc; border: 1px solid #e2e8f0; width: 100%;
}

.mandatory-tag { background: #fee2e2; color: #dc2626; font-size: .65rem; padding: 2px 8px; border-radius: 6px; text-transform: uppercase; font-weight: 800; }

.submit-btn { 
    background: #166534; color: #fff; border: none; padding: 18px 60px; border-radius: 16px; 
    font-weight: 800; font-size: 1.1rem; cursor: pointer; box-shadow: 0 10px 20px rgba(22, 101, 52, 0.2); 
    transition: .2s;
}
.submit-btn:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(22, 101, 52, 0.3); }

.form-input { 
    width: 100%; padding: 14px 20px; border-radius: 14px; border: 1.5px solid #e2e8f0; 
    font-size: .95rem; font-weight: 700; color: #1e293b; outline: none;
}
</style>

@section('content')
<div class="doc-upload-wrap">
    <div class="doc-card">
        <div class="doc-head">
            <div>
                <h2 style="margin: 0; font-weight: 800; color:#fff"><i class="fas fa-file-invoice"></i> Multi-Document Onboarding</h2>
                <p style="margin: 5px 0 0; opacity: 0.85;">Upload the complete solar project KYC set for the lead.</p>
            </div>
            <a href="{{ route(auth()->user()->getRoleNames()->first() . '.documents.index') }}" style="color:#fff; text-decoration:none; font-weight:700; opacity:0.9;"><i class="fas fa-arrow-left"></i> Back to List</a>
        </div>

        <form action="{{ route(auth()->user()->getRoleNames()->first() . '.documents.store') }}" method="POST" enctype="multipart/form-data" style="padding: 40px;">
            @csrf

            <!-- Lead Selection Section -->
            <div class="section-title"><i class="fas fa-user-circle"></i> Customer & Lead Information</div>
            <div class="row mb-5">
                <div class="col-md-6">
                    <label class="box-label">Select Active Lead</label>
                    <select name="lead_id" class="form-input" required>
                        <option value="">-- Choose Lead --</option>
                        @foreach($leads as $lead)
                            <option value="{{ $lead->id }}">{{ $lead->full_name }} ({{ $lead->lead_code }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="box-label">Customer Name (As per records)</label>
                    <input type="text" name="customer_name" class="form-input" placeholder="Enter Full Name" required>
                </div>
            </div>

            <!-- Documents Checklist Section -->
            <div class="section-title"><i class="fas fa-tasks"></i> Required Document Checklist</div>
            
            <div class="upload-grid">
                <!-- PAN Card -->
                <div class="upload-box">
                    <span class="box-label"><i class="fas fa-id-card box-icon"></i> PAN Card</span>
                    <input type="file" name="doc_pan" class="file-input">
                    <p style="font-size: .7rem; color: #94a3b8; margin: 0;">Upload clear scanned copy of PAN.</p>
                </div>

                <!-- Aadhaar Card -->
                <div class="upload-box">
                    <span class="box-label"><i class="fas fa-fingerprint box-icon"></i> Aadhaar Card</span>
                    <input type="file" name="doc_aadhaar" class="file-input">
                    <p style="font-size: .7rem; color: #94a3b8; margin: 0;">Upload Front & Back in one PDF/Image.</p>
                </div>

                <!-- Electricity Bill -->
                <div class="upload-box">
                    <span class="box-label"><i class="fas fa-lightbulb box-icon"></i> Electricity Bill</span>
                    <input type="file" name="doc_bill" class="file-input">
                    <p style="font-size: .7rem; color: #94a3b8; margin: 0;">Last 3 months bill authorized copy.</p>
                </div>

                <!-- Bank Statement -->
                <div class="upload-box">
                    <span class="box-label"><i class="fas fa-university box-icon"></i> Bank Statement</span>
                    <input type="file" name="doc_bank" class="file-input">
                    <p style="font-size: .7rem; color: #94a3b8; margin: 0;">Last 6 months verified statement.</p>
                </div>

                <!-- Geo-tagged Photos -->
                <div class="upload-box" style="border-color: #fee2e2; background: #fffafb;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span class="box-label"><i class="fas fa-camera box-icon" style="color: #dc2626;"></i> Site Photographs</span>
                        <span class="mandatory-tag">Mandatory</span>
                    </div>
                    <input type="file" name="doc_geo" class="file-input" required>
                    <p style="font-size: .7rem; color: #dc2626; font-weight: 600; margin: 0;">Must include GPS coordinates (Geo-tagged).</p>
                </div>

                <!-- Email & Mobile Verification -->
                <div class="upload-box">
                    <span class="box-label"><i class="fas fa-envelope-open-text box-icon"></i> Email & Mobile Info</span>
                    <input type="email" name="doc_email_verify" class="file-input" placeholder="Primary Email Address">
                    <input type="text" name="doc_mobile_verify" class="file-input" placeholder="Primary Mobile Number" 
                           maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');" style="margin-top: 10px;">
                </div>
            </div>

            <div style="margin-top: 60px; text-align: center;">
                <button type="submit" class="submit-btn small"><i class="fas fa-cloud-upload-alt"></i> Complete Onboarding & Save</button>
            </div>
        </form>
    </div>
</div>
@endsection
