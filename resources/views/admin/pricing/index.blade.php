@extends('admin.layouts.master')

<style>
/* ── Global ─────────────────────────────────────── */
.pm-wrap { padding: 24px; }

/* ── Header ─────────────────────────────────────── */
.pm-header {
    background: linear-gradient(135deg, #166534, #15803d);
    border-radius: 16px; padding: 24px 32px; margin-bottom: 28px;
    display: flex; align-items: center; justify-content: space-between;
    box-shadow: 0 4px 20px rgba(21, 128, 61, 0.2);
}
.pm-header h2 { font-size: 1.6rem; font-weight: 800; color: #fff; margin: 0; }
.pm-header p { font-size: .88rem; color: rgba(255,255,255,0.85); margin: 4px 0 0; }

/* ── Pricing Grid ─────────────────────────────────── */
.pm-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px; }

.pm-card {
    background: #fff; border-radius: 20px; overflow: hidden;
    box-shadow: 0 2px 14px rgba(0,0,0,0.06); border: 1px solid #f1f5f9;
    transition: transform .3s ease;
}
.pm-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.08); }

.pm-card-head {
    padding: 24px; background: #f8fafc; border-bottom: 1px solid #f1f5f9;
    display: flex; align-items: center; gap: 16px;
}
.pm-card-icon {
    width: 48px; height: 48px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem; color: #fff;
    background: linear-gradient(135deg, #2ecc71, #27ae60);
}
.pm-card-head h4 { margin: 0; font-size: 1.15rem; font-weight: 700; color: #1e293b; }

.pm-card-body { padding: 24px; }

/* ── Form Styling ───────────────────────────────── */
.pm-label {
    display: block; font-size: .75rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .05em; color: #64748b;
    margin-bottom: 8px;
}
.pm-input-group { position: relative; margin-bottom: 18px; }
.pm-input {
    width: 100%; border: 1.5px solid #e2e8f0; border-radius: 12px;
    padding: 12px 16px; font-size: .95rem; font-weight: 600; color: #334155;
    transition: .2s; outline: none;
}
.pm-input:focus { border-color: #27ae60; box-shadow: 0 0 0 4px rgba(39, 174, 96, 0.1); }

.pm-input-addon {
    position: absolute; right: 16px; top: 50%; transform: translateY(-50%);
    color: #94a3b8; font-weight: 700; font-size: .85rem;
}

.pm-submit-btn {
    width: 100%; padding: 14px; border: none; border-radius: 12px;
    background: linear-gradient(135deg, #2ecc71, #27ae60);
    color: #fff; font-weight: 700; font-size: .9rem; cursor: pointer;
    transition: .2s; box-shadow: 0 4px 12px rgba(39, 174, 96, 0.2);
}
.pm-submit-btn:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(39, 174, 96, 0.3); }

/* ── Info Pill ──────────────────────────────────── */
.pm-info-pill {
    display: flex; align-items: center; gap: 8px;
    background: #f0fdf4; border: 1px solid #dcfce7;
    padding: 10px 14px; border-radius: 10px; margin-top: 16px;
}
.pm-info-pill i { color: #16a34a; font-size: .85rem; }
.pm-info-pill span { color: #166534; font-size: .75rem; font-weight: 600; }

</style>

@section('content')
<div class="pm-wrap">
    <div class="pm-header">
        <div>
            <h2><i class="fas fa-solar-panel" style="margin-right: 12px;"></i>Standard Pricing Management</h2>
            <p>System-wide standard rates used for Quotations and Margin calculations.</p>
        </div>
        @can('pricings.create')
        {{-- For now, we seed, but if needed, we can add a create modal here --}}
        @endcan
    </div>

    @if(session('success'))
        <div style="background: #dcfce7; color: #166534; padding: 12px 20px; border-radius: 12px; margin-bottom: 24px; font-weight: 600;">
            <i class="fas fa-check-circle" style="margin-right: 10px;"></i> {{ session('success') }}
        </div>
    @endif

    <div class="pm-grid">
        @foreach($pricings as $price)
        <div class="pm-card">
            <div class="pm-card-head" style="justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <div class="pm-card-icon">
                        @if($price->category == 'On-grid') <i class="fas fa-network-wired"></i>
                        @elseif($price->category == 'Hybrid') <i class="fas fa-bolt"></i>
                        @else <i class="fas fa-battery-full"></i>
                        @endif
                    </div>
                    <h4>{{ $price->category }}</h4>
                </div>
                
                @can('pricings.delete')
                <form action="{{ route(auth()->user()->getRoleNames()->first() . '.pricings.destroy', $price->id) }}" 
                      method="POST" id="del-form-{{ $price->id }}">
                    @csrf @method('DELETE')
                    <button type="button" class="del-trigger" onclick="confirmDel({{ $price->id }})"
                            style="background:rgba(239,68,68,0.1); border:none; color:#ef4444; width:34px; height:34px; border-radius:8px; cursor:pointer; transition:.2s;">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </form>
                @endcan
            </div>
            <div class="pm-card-body">
                <form action="{{ route(auth()->user()->getRoleNames()->first() . '.pricings.update', $price->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="pm-field">
                        <label class="pm-label">Price per kW (GST Inclusive)</label>
                        <div class="pm-input-group">
                            <input type="number" name="price_per_kw" class="pm-input" value="{{ $price->price_per_kw }}" min="0" step="0.01" required>
                            <span class="pm-input-addon">₹</span>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div class="pm-field">
                            <label class="pm-label">GST Rate</label>
                            <div class="pm-input-group">
                                <input type="number" name="gst_rate" class="pm-input" value="{{ $price->gst_rate }}" min="0" max="100" step="0.01" required>
                                <span class="pm-input-addon">%</span>
                            </div>
                        </div>
                        <div class="pm-field">
                            <label class="pm-label">Margin Floor</label>
                            <div class="pm-input-group">
                                <input type="number" name="margin_floor" class="pm-input" value="{{ $price->margin_floor }}" min="0" max="100" step="0.01" required>
                                <span class="pm-input-addon">%</span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="pm-submit-btn">Update {{ $price->category }} Rates</button>
                    
                    <div class="pm-info-pill">
                        <i class="fas fa-info-circle"></i>
                        <span>GST-Inclusive calculations will be applied.</span>
                    </div>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDel(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This pricing category will be removed!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('del-form-' + id).submit();
        }
    })
}
</script>
<style>
.del-trigger:hover { background: #ef4444 !important; color: #fff !important; transform: scale(1.1); }
</style>
@endpush
