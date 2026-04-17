@extends('admin.layouts.master')

<style>
/* ── Global ─────────────────────────────────────── */
.gst-wrap { padding: 24px; }

/* ── Header ─────────────────────────────────────── */
.gst-header {
    background: linear-gradient(135deg, #166534, #15803d);
    border-radius: 16px; padding: 24px 32px; margin-bottom: 28px;
    display: flex; align-items: center; justify-content: space-between;
    box-shadow: 0 4px 20px rgba(21, 128, 61, 0.2);
}
.gst-header h2 { font-size: 1.6rem; font-weight: 800; color: #fff; margin: 0; }
.gst-header p { font-size: .88rem; color: rgba(255,255,255,0.85); margin: 4px 0 0; }

/* ── Info Cards ─────────────────────────────────── */
.gst-card {
    background: #fff; border-radius: 20px; overflow: hidden;
    box-shadow: 0 2px 14px rgba(0,0,0,0.06); border: 1px solid #f1f5f9;
}
.gst-card-head {
    padding: 24px; background: #f8fafc; border-bottom: 1px solid #f1f5f9;
    display: flex; align-items: center; gap: 16px;
}
.gst-card-icon {
    width: 48px; height: 48px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem; color: #fff;
    background: linear-gradient(135deg, #2ecc71, #27ae60);
}
.gst-card-body { padding: 32px; }

/* ── GST Preview Box ────────────────────────────── */
.gst-preview-box {
    background: #f0fdf4; border: 1.5px dashed #22c55e;
    border-radius: 16px; padding: 24px; margin-top: 24px;
}
.preview-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 12px 0; border-bottom: 1px solid rgba(34, 197, 94, 0.1);
}
.preview-row:last-child { border-bottom: none; border-top: 2px solid #22c55e; margin-top: 10px; }
.pr-label { font-size: .88rem; font-weight: 600; color: #166534; }
.pr-value { font-size: 1.1rem; font-weight: 800; color: #14532d; }

/* ── Form Styling ───────────────────────────────── */
.gst-input-group { position: relative; max-width: 200px; margin-bottom: 18px; }
.gst-input {
    width: 100%; border: 1.5px solid #e2e8f0; border-radius: 12px;
    padding: 12px 45px 12px 16px; font-size: 1.1rem; font-weight: 700; color: #1e293b;
    transition: .2s; outline: none;
}
.gst-input:focus { border-color: #27ae60; box-shadow: 0 0 0 4px rgba(39, 174, 96, 0.1); }
.gst-input-addon { position: absolute; right: 16px; top: 50%; transform: translateY(-50%); font-weight: 800; color: #64748b; }

.gst-update-btn {
    padding: 12px 28px; border: none; border-radius: 12px;
    background: linear-gradient(135deg, #2ecc71, #27ae60);
    color: #fff; font-weight: 700; font-size: .95rem; cursor: pointer;
    box-shadow: 0 4px 12px rgba(39, 174, 96, 0.3);
}

</style>

@section('content')
<div class="gst-wrap">
    <div class="gst-header">
        <div>
            <h2><i class="fas fa-file-invoice-dollar" style="margin-right: 12px;"></i>GST Configuration</h2>
            <p>Define the overall system-wide GST rate for inclusive calculations.</p>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #dcfce7; color: #166534; padding: 12px 20px; border-radius: 12px; margin-bottom: 24px; font-weight: 600;">
            <i class="fas fa-check-circle" style="margin-right: 10px;"></i> {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-5">
            <div class="gst-card">
                <div class="gst-card-head">
                    <div class="gst-card-icon"><i class="fas fa-percent"></i></div>
                    <h5>System GST Rate</h5>
                </div>
                <div class="gst-card-body">
                    <form action="{{ route(auth()->user()->getRoleNames()->first() . '.gst.update') }}" method="POST">
                        @csrf
                        <label style="font-size: .75rem; font-weight:700; color:#64748b; text-transform:uppercase; margin-bottom:10px; display:block;">Overall Percentage</label>
                        <div class="gst-input-group">
                            <input type="number" name="gst_rate" class="gst-input" value="{{ $globalGst }}" step="0.01" min="0" max="100" required>
                            <span class="gst-input-addon">%</span>
                        </div>
                        <button type="submit" class="gst-update-btn">Update Global Rate</button>
                    </form>

                    <div style="margin-top: 24px; font-size: .82rem; color: #64748b; line-height: 1.6;">
                        <i class="fas fa-info-circle"></i> This rate is applied to all solar pricing categories. Updating this will affect all future quotations and invoice calculations.
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="gst-card">
                <div class="gst-card-head">
                    <div class="gst-card-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);"><i class="fas fa-calculator"></i></div>
                    <h5>Calculation Logic Preview</h5>
                </div>
                <div class="gst-card-body">
                    <p style="font-size: .88rem; color: #64748b;">Example calculation for a <strong>₹{{ number_format($previewValue) }}</strong> Inclusive Package:</p>
                    
                    <div class="gst-preview-box">
                        <div class="preview-row">
                            <span class="pr-label">System Total (GST Inclusive)</span>
                            <span class="pr-value">₹{{ number_format($previewValue) }}</span>
                        </div>
                        <div class="preview-row">
                            <span class="pr-label">Taxable Base Value (Taxable)</span>
                            <span class="pr-value">₹{{ number_format($taxable, 2) }}</span>
                        </div>
                        <div class="preview-row">
                            <span class="pr-label">GST Component ({{ $globalGst }}%)</span>
                            <span class="pr-value" style="color: #d97706;">+ ₹{{ number_format($gstAmount, 2) }}</span>
                        </div>
                        <div class="preview-row">
                            <span class="pr-label" style="color:#d97706">Invoice Total</span>
                            <span class="pr-value">₹{{ number_format($previewValue) }}</span>
                        </div>
                    </div>

                    <div style="margin-top: 24px; padding: 16px; background:#f8fafc; border-radius:12px; font-size:.82rem; color:#475569;">
                        <strong>Note on Margin Floor (15%):</strong><br>
                        All margins in the EcoVolt system are calculated based on the **GST-Inclusive** price (Total Invoice Value) as per corporate policy.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
