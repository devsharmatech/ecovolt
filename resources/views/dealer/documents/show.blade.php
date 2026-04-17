@extends('admin.layouts.master')

<style>
    .doc-show-wrap { padding: 32px; background: #f8fafc; min-height: 100vh; }
    .profile-card { background: #fff; border-radius: 24px; box-shadow: 0 10px 40px rgba(0,0,0,0.03); border: 1px solid #f1f5f9; overflow: hidden; }
    .profile-head { background: linear-gradient(135deg, #166534, #15803d); padding: 40px; color: #fff; display: flex; align-items: center; justify-content: space-between; }
    
    .doc-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px; padding: 40px; }
    .doc-item { 
        background: #fff; border: 1.5px solid #f1f5f9; border-radius: 20px; padding: 20px; 
        transition: .3s; display: flex; flex-direction: column; align-items: center; gap: 15px;
    }
    .doc-item:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.05); border-color: #22c55e; }
    
    .doc-icon { width: 60px; height: 60px; border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
    .icon-pan { background: #eef2ff; color: #4338ca; }
    .icon-aadhaar { background: #f0fdf4; color: #166534; }
    .icon-bill { background: #fffbeb; color: #b45309; }
    .icon-bank { background: #f5f3ff; color: #7c3aed; }
    .icon-geo { background: #fff1f2; color: #e11d48; }

    .btn-view { background: #166534; color: #fff; padding: 10px 20px; border-radius: 10px; text-decoration: none; font-weight: 700; width: 100%; text-align: center; }
    .btn-missing { background: #f1f5f9; color: #94a3b8; padding: 10px 20px; border-radius: 10px; width: 100%; text-align: center; font-weight: 700; pointer-events: none; }
</style>

@section('content')
<div class="doc-show-wrap">
    <div class="profile-card">
        <div class="profile-head">
            <div>
                <span style="background: rgba(255,255,255,0.2); padding: 4px 12px; border-radius: 8px; font-size: .75rem; font-weight: 800; text-transform: uppercase;">Compliance Package</span>
                <h2 style="margin: 10px 0 0; font-weight: 800; color:#fff">{{ $document->customer_name }}</h2>
                <p style="margin: 5px 0 0; opacity: 0.85;">
                    Lead ID: <strong style="color: #fca5a5;">{{ $document->lead ? $document->lead->lead_code : 'N/A' }}</strong> | 
                    Onboarded: {{ $document->uploaded_date->format('M d, Y') }}
                </p>
            </div>
            <a href="{{ route(auth()->user()->getRoleNames()->first() . '.documents.index') }}" 
               style="background: #fff; color: #166534; padding: 12px 24px; border-radius: 12px; font-weight: 800; text-decoration: none;">
               <i class="fas fa-arrow-left"></i> Back to Matrix
            </a>
        </div>

        <div class="doc-grid">
            <!-- PAN Item -->
            <div class="doc-item">
                <div class="doc-icon icon-pan"><i class="fas fa-file-invoice"></i></div>
                <div style="text-align: center;">
                    <h5 style="margin: 0; font-weight: 800;">PAN Card</h5>
                    <p style="font-size: .8rem; color: #64748b; margin-top: 5px;">Primary Identification</p>
                </div>
                @if($document->pan_path)
                    <a href="{{ asset('storage/'.$document->pan_path) }}" target="_blank" class="btn-view">View Document</a>
                @else
                    <div class="btn-missing">Not Uploaded</div>
                @endif
            </div>

            <!-- Aadhaar Item -->
            <div class="doc-item">
                <div class="doc-icon icon-aadhaar"><i class="fas fa-id-card-alt"></i></div>
                <div style="text-align: center;">
                    <h5 style="margin: 0; font-weight: 800;">Aadhaar Card</h5>
                    <p style="font-size: .8rem; color: #64748b; margin-top: 5px;">Resident Verification</p>
                </div>
                @if($document->aadhaar_path)
                    <a href="{{ asset('storage/'.$document->aadhaar_path) }}" target="_blank" class="btn-view">View Document</a>
                @else
                    <div class="btn-missing">Not Uploaded</div>
                @endif
            </div>

            <!-- Bill Item -->
            <div class="doc-item">
                <div class="doc-icon icon-bill"><i class="fas fa-lightbulb"></i></div>
                <div style="text-align: center;">
                    <h5 style="margin: 0; font-weight: 800;">Electricity Bill</h5>
                    <p style="font-size: .8rem; color: #64748b; margin-top: 5px;">Site Utility Proof</p>
                </div>
                @if($document->bill_path)
                    <a href="{{ asset('storage/'.$document->bill_path) }}" target="_blank" class="btn-view">View Document</a>
                @else
                    <div class="btn-missing">Not Uploaded</div>
                @endif
            </div>

            <!-- Bank Item -->
            <div class="doc-item">
                <div class="doc-icon icon-bank"><i class="fas fa-university"></i></div>
                <div style="text-align: center;">
                    <h5 style="margin: 0; font-weight: 800;">Bank Statement</h5>
                    <p style="font-size: .8rem; color: #64748b; margin-top: 5px;">Financial Snapshot</p>
                </div>
                @if($document->bank_path)
                    <a href="{{ asset('storage/'.$document->bank_path) }}" target="_blank" class="btn-view">View Document</a>
                @else
                    <div class="btn-missing">Not Uploaded</div>
                @endif
            </div>

            <!-- Geo Item -->
            <div class="doc-item">
                <div class="doc-icon icon-geo"><i class="fas fa-map-marker-alt"></i></div>
                <div style="text-align: center;">
                    <h5 style="margin: 0; font-weight: 800;">Site Photos</h5>
                    <p style="font-size: .8rem; color: #64748b; margin-top: 5px;">Verification Assets</p>
                </div>
                @if($document->geo_path)
                    <a href="{{ asset('storage/'.$document->geo_path) }}" target="_blank" class="btn-view" style="background: #e11d48;">View Live Site</a>
                @else
                    <div class="btn-missing">Not Uploaded</div>
                @endif
            </div>
        </div>

        <!-- Meta Info Footer -->
        <div style="background: #fdfdfd; padding: 24px 40px; border-top: 1px solid #f1f5f9; display: flex; gap: 40px;">
             <div>
                 <span style="font-size: .75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Verified Email</span>
                 <div style="font-weight: 700; color: #1e293b;">{{ $document->email_val ?? 'N/A' }}</div>
             </div>
             <div>
                <span style="font-size: .75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Verified Mobile</span>
                <div style="font-weight: 700; color: #1e293b;">{{ $document->mobile_val ?? 'N/A' }}</div>
            </div>
            <div style="margin-left: auto;">
                <span style="font-size: .75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase;">Compliance Status</span>
                <div>
                    @if($document->status == 'verified')
                        <span style="color: #166534; font-weight: 800;"><i class="fas fa-check-double"></i> Fully Verified</span>
                    @else
                        <span style="color: #d97706; font-weight: 800;"><i class="fas fa-clock"></i> Audit In Progress</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
