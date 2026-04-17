@extends('admin.layouts.master')

<style>
    .doc-edit-wrap { padding: 32px; background: #fafafa; min-height: 100vh; }
    .doc-card { background: #fff; border-radius: 24px; box-shadow: 0 10px 40px rgba(0,0,0,0.03); border: 1px solid #f1f5f9; overflow: hidden; }
    .doc-head { background: linear-gradient(135deg, #166534, #15803d); padding: 32px 40px; color: #fff; display: flex; align-items: center; justify-content: space-between; }
    
    .section-title { font-size: 1.1rem; font-weight: 800; color: #1e293b; margin-bottom: 24px; display: flex; align-items: center; gap: 10px; border-bottom: 2px solid #f1f5f9; padding-bottom: 12px; }
    
    .upload-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px; }
    .upload-box { 
        background: #fff; border: 2px dashed #e2e8f0; border-radius: 20px; padding: 24px; 
        transition: .3s; position: relative;
    }
    .upload-box.has-file { border-style: solid; border-color: #22c55e; background: #f0fdf4; }
    
    .box-label { font-size: .9rem; font-weight: 800; color: #475569; display: flex; align-items: center; gap: 8px; margin-bottom: 12px; }
    .file-input { font-size: .8rem; width: 100%; }
    
    .current-file-badge { background: #166534; color: #fff; font-size: .65rem; padding: 4px 10px; border-radius: 6px; font-weight: 800; text-transform: uppercase; margin-top: 10px; display: inline-block; }
    
    .update-btn { 
        background: #166534; color: #fff; border: none; padding: 18px 60px; border-radius: 16px; 
        font-weight: 800; font-size: 1.1rem; cursor: pointer; transition: .2s;
    }
</style>

@section('content')
<div class="doc-edit-wrap">
    <div class="doc-card">
        <div class="doc-head">
            <div>
                <h2 style="margin: 0; font-weight: 800; color:#fff"><i class="fas fa-edit"></i> Edit Documentation Set</h2>
                <p style="margin: 5px 0 0; opacity: 0.85;">Update or replace files for <strong>{{ $document->customer_name }}</strong></p>
            </div>
            <a href="{{ route(auth()->user()->getRoleNames()->first() . '.documents.index') }}" style="color:#fff; font-weight:700;"><i class="fas fa-arrow-left"></i> Back to Matrix</a>
        </div>

        <form action="{{ route(auth()->user()->getRoleNames()->first() . '.documents.update', $document) }}" method="POST" enctype="multipart/form-data" style="padding: 40px;">
            @csrf
            @method('PUT')

            <div class="section-title"><i class="fas fa-user-circle"></i> Identity Information</div>
            <div class="row mb-5">
                <div class="col-md-6 mb-3">
                    <label class="box-label">Customer Name</label>
                    <input type="text" name="customer_name" class="form-control" value="{{ $document->customer_name }}" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="box-label">Verified Email</label>
                    <input type="email" name="doc_email_verify" class="form-control" value="{{ $document->email_val }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="box-label">Verified Mobile</label>
                    <input type="text" name="doc_mobile_verify" class="form-control" value="{{ $document->mobile_val }}" maxlength="10">
                </div>
            </div>

            <div class="section-title"><i class="fas fa-cloud-upload-alt"></i> Update Files (Select Only if Replacing)</div>
            
            <div class="upload-grid">
                <!-- PAN -->
                <div class="upload-box {{ $document->pan_path ? 'has-file' : '' }}">
                    <span class="box-label"><i class="fas fa-id-card"></i> PAN Card</span>
                    <input type="file" name="doc_pan" class="file-input">
                    @if($document->pan_path) <span class="current-file-badge"><i class="fas fa-check"></i> Current File Exists</span> @endif
                </div>

                <!-- Aadhaar -->
                <div class="upload-box {{ $document->aadhaar_path ? 'has-file' : '' }}">
                    <span class="box-label"><i class="fas fa-fingerprint"></i> Aadhaar Card</span>
                    <input type="file" name="doc_aadhaar" class="file-input">
                    @if($document->aadhaar_path) <span class="current-file-badge"><i class="fas fa-check"></i> Current File Exists</span> @endif
                </div>

                <!-- Bill -->
                <div class="upload-box {{ $document->bill_path ? 'has-file' : '' }}">
                    <span class="box-label"><i class="fas fa-lightbulb"></i> Electricity Bill</span>
                    <input type="file" name="doc_bill" class="file-input">
                    @if($document->bill_path) <span class="current-file-badge"><i class="fas fa-check"></i> Current File Exists</span> @endif
                </div>

                <!-- Bank -->
                <div class="upload-box {{ $document->bank_path ? 'has-file' : '' }}">
                    <span class="box-label"><i class="fas fa-university"></i> Bank Statement</span>
                    <input type="file" name="doc_bank" class="file-input">
                    @if($document->bank_path) <span class="current-file-badge"><i class="fas fa-check"></i> Current File Exists</span> @endif
                </div>

                <!-- Geo -->
                <div class="upload-box {{ $document->geo_path ? 'has-file' : '' }}">
                    <span class="box-label"><i class="fas fa-map-marker-alt"></i> Site Photos</span>
                    <input type="file" name="doc_geo" class="file-input">
                    @if($document->geo_path) <span class="current-file-badge"><i class="fas fa-check"></i> Current File Exists</span> @endif
                </div>
            </div>

            <div style="margin-top: 60px; text-align: center;">
                <button type="submit" class="update-btn"><i class="fas fa-save"></i> Save All Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection
