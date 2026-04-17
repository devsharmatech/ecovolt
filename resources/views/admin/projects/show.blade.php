@extends('admin.layouts.master')
@section('title', 'Project Pipeline — ' . $project->project_code)

<style>
.show-wrap { padding: 28px; background: #f0f4f8; min-height: 100vh; }

/* Hero */
.proj-hero {
    background: linear-gradient(135deg, #14532d, #166534 60%, #15803d);
    border-radius: 24px; padding: 36px 44px;
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 28px;
    box-shadow: 0 8px 30px rgba(21,128,61,0.25);
}
.proj-hero h2 { color: #fff; margin: 0; font-weight: 900; font-size: 1.6rem; }
.proj-hero p { color: rgba(255,255,255,.7); margin: 5px 0 0; }
.hero-tag { background: rgba(255,255,255,0.2); color: #fff; padding: 5px 14px; border-radius: 20px; font-size: .75rem; font-weight: 800; display: inline-block; margin-bottom: 10px; }
.back-btn { background: #fff; color: #166534; padding: 12px 24px; border-radius: 12px; font-weight: 800; text-decoration: none; }

/* Progress Bar */
.prog-card { background: #fff; border-radius: 20px; padding: 24px 32px; margin-bottom: 28px; border: 1px solid #e2e8f0; }
.main-prog-bar { height: 12px; border-radius: 99px; background: #f1f5f9; overflow: hidden; }
.main-prog-fill { height: 100%; border-radius: 99px; background: linear-gradient(90deg, #4ade80, #166534); transition: width .5s; }

/* Timeline */
.timeline-card { background: #fff; border-radius: 20px; padding: 32px 36px; border: 1px solid #e2e8f0; margin-bottom: 28px; }
.timeline { position: relative; padding-left: 32px; }
.timeline::before { content: ''; position: absolute; left: 15px; top: 0; bottom: 0; width: 2px; background: #f1f5f9; }

.tl-item { position: relative; margin-bottom: 30px; }
.tl-dot {
    position: absolute; left: -25px; top: 3px;
    width: 22px; height: 22px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: .65rem; font-weight: 900; border: 2px solid #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.tl-done { background: #166534; color: #fff; }
.tl-current { background: #f59e0b; color: #fff; animation: pulse 1.5s infinite; }
.tl-future { background: #e2e8f0; color: #94a3b8; }

@keyframes pulse { 0%,100% { box-shadow: 0 0 0 0 rgba(245,158,11,0.4); } 50% { box-shadow: 0 0 0 8px rgba(245,158,11,0); } }

.tl-label { font-weight: 800; color: #1e293b; font-size: .9rem; }
.tl-label.done { color: #15803d; }
.tl-label.future { color: #94a3b8; font-weight: 600; }
.tl-date { font-size: .72rem; color: #94a3b8; margin-top: 3px; }

/* Advance Form */
.advance-card { background: #fff; border-radius: 20px; padding: 28px 36px; border: 2px solid #dcfce7; }
.next-stage-badge { background: linear-gradient(135deg, #166534, #15803d); color: #fff; padding: 8px 20px; border-radius: 12px; font-weight: 900; font-size: .9rem; display: inline-block; margin-bottom: 20px; }
.adv-btn { background: #166534; color: #fff; border: none; padding: 14px 40px; border-radius: 14px; font-weight: 800; font-size: .95rem; cursor: pointer; transition: .2s; }
.adv-btn:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(22,101,52,0.3); }
.f-input { width: 100%; padding: 12px 16px; border: 1.5px solid #e2e8f0; border-radius: 12px; font-size: .9rem; font-weight: 600; outline: none; }
.f-input:focus { border-color: #166534; }

/* Meta Grid */
.meta-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; }
.meta-item { background: #f8fafc; border-radius: 14px; padding: 16px 20px; }
.meta-key { font-size: .7rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; }
.meta-val { font-size: 1rem; font-weight: 800; color: #1e293b; margin-top: 4px; }
</style>

@section('content')
<div class="show-wrap">

    @if(session('success'))
        <div style="background:#dcfce7; color:#166534; padding:14px 24px; border-radius:14px; margin-bottom:20px; font-weight:700; border: 1.5px solid #bbf7d0;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Hero -->
    <div class="proj-hero">
        <div>
            <span class="hero-tag"><i class="fas fa-solar-panel"></i> {{ $project->project_code }}</span>
            <h2>{{ $project->customer_name }}</h2>
            <p>Lead: <strong style="color:#86efac;">{{ $project->lead ? $project->lead->lead_code : 'N/A' }}</strong> &nbsp;|&nbsp; Started: {{ $project->created_at->format('d M Y') }}</p>
        </div>
        <a href="{{ route(auth()->user()->getRoleNames()->first().'.projects.index') }}" class="back-btn"><i class="fas fa-arrow-left"></i> All Projects</a>
    </div>

    <div class="row">
        <!-- Left: Timeline -->
        <div class="col-lg-7">
            <!-- Progress Bar -->
            <div class="prog-card">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px;">
                    <h6 style="margin:0; font-weight:800; color:#1e293b;">Overall Pipeline Progress</h6>
                    <span style="font-weight:900; color:#166534; font-size:1.1rem;">{{ $project->progressPercent() }}%</span>
                </div>
                <div class="main-prog-bar">
                    <div class="main-prog-fill" style="width: {{ $project->progressPercent() }}%;"></div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="timeline-card">
                <h6 style="font-weight:800; color:#1e293b; margin-bottom:28px; font-size:1rem;"><i class="fas fa-stream" style="color:#166534; margin-right:8px;"></i>Project Flow Timeline</h6>
                <div class="timeline">
                    @php $stages = \App\Models\Project::getStages($project->payment_mode); @endphp
                    @foreach($stages as $idx => $stage)
                        @php
                            $currentStages = \App\Models\Project::getStages($project->payment_mode);
                            $currentIdx = array_search($project->current_stage, $currentStages);
                            $stageIdx = array_search($stage, $currentStages);
                            $isDone = $stageIdx < $currentIdx;
                            $isCurrent = $stage === $project->current_stage;
                        @endphp
                        <div class="tl-item">
                            <div class="tl-dot {{ $isDone ? 'tl-done' : ($isCurrent ? 'tl-current' : 'tl-future') }}">
                                @if($isDone) <i class="fas fa-check"></i> @elseif($isCurrent) <i class="fas fa-bolt"></i> @else {{ $idx+1 }} @endif
                            </div>
                            <div class="tl-label {{ $isDone ? 'done' : ($isCurrent ? '' : 'future') }}">
                                {{ \App\Models\Project::stageLabel($stage) }}
                                @if($isCurrent) <span style="background:#fef9c3; color:#92400e; font-size:.7rem; padding:2px 8px; border-radius:6px; margin-left:8px; font-weight:800;">CURRENT</span> @endif
                            </div>
                            @if($isDone)
                                <div class="tl-date"><i class="fas fa-calendar-check"></i> {{ $project->stageTimestamp($stage) ?? 'Completed' }}</div>
                            @elseif($isCurrent)
                                <div class="tl-date" style="color:#f59e0b;"><i class="fas fa-clock"></i> In Progress...</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right: Advance Stage + Meta -->
        <div class="col-lg-5">

            @if($project->status !== 'completed')
            <div class="advance-card mb-4">
                <h6 style="margin:0 0 16px; font-weight:800; color:#1e293b;"><i class="fas fa-forward" style="color:#166534; margin-right:8px;"></i>Advance to Next Stage</h6>

                @php
                    $allStages  = \App\Models\Project::getStages($project->payment_mode);
                    $currIdx    = array_search($project->current_stage, $allStages);
                    $nextStage  = $allStages[$currIdx+1] ?? null;
                @endphp

                @if($nextStage)
                    <span class="next-stage-badge"><i class="fas fa-chevron-double-right"></i> {{ \App\Models\Project::stageLabel($nextStage) }}</span>
                    <form action="{{ route(auth()->user()->getRoleNames()->first().'.projects.advance', $project) }}" method="POST">
                        @csrf

                        {{-- Payment Mode Selection --}}
                        @if($project->current_stage === 'payment_mode_selection')
                        <div class="mb-3">
                            <label style="font-weight:800; font-size:.85rem; color:#475569; display:block; margin-bottom:8px;">Choose Payment Mode *</label>
                            <div style="display:flex; gap:12px;">
                                <label style="flex:1; background:#fffbeb; border:2px solid #fde68a; border-radius:12px; padding:14px; text-align:center; cursor:pointer; font-weight:800;">
                                    <input type="radio" name="payment_mode" value="cash" style="margin-right:8px;"> <i class="fas fa-money-bill-wave" style="color:#92400e;"></i> CASH
                                </label>
                                <label style="flex:1; background:#eff6ff; border:2px solid #bfdbfe; border-radius:12px; padding:14px; text-align:center; cursor:pointer; font-weight:800;">
                                    <input type="radio" name="payment_mode" value="bank" style="margin-right:8px;"> <i class="fas fa-university" style="color:#1d4ed8;"></i> BANK
                                </label>
                            </div>
                        </div>
                        @endif

                        {{-- Part Payment Field --}}
                        @if($nextStage === 'part_payment')
                        <div class="mb-3">
                            <label style="font-weight:800; font-size:.85rem; color:#475569; display:block; margin-bottom:8px;">Part Payment Amount (₹)</label>
                            <input type="number" name="part_payment_amount" class="f-input" placeholder="Enter received amount">
                        </div>
                        @endif

                        {{-- Subsidy Field --}}
                        @if($nextStage === 'subsidy_redemption')
                        <div class="mb-3">
                            <label style="font-weight:800; font-size:.85rem; color:#475569; display:block; margin-bottom:8px;">Subsidy Amount (₹)</label>
                            <input type="number" name="subsidy_amount" class="f-input" placeholder="Approved subsidy amount">
                        </div>
                        @endif

                        <button type="submit" class="adv-btn w-100 mt-2"><i class="fas fa-chevron-circle-right"></i> Mark as Complete & Advance</button>
                    </form>
                @else
                    <div style="text-align:center; padding:20px; color:#94a3b8;">
                        <i class="fas fa-trophy" style="font-size:2rem; color:#fbbf24; display:block; margin-bottom:10px;"></i>
                        Project is at final stage!
                    </div>
                @endif
            </div>
            @else
            <div style="background:#dcfce7; border-radius:20px; padding:28px; text-align:center; margin-bottom:28px;">
                <i class="fas fa-trophy" style="font-size:3rem; color:#15803d; display:block; margin-bottom:12px;"></i>
                <h5 style="font-weight:800; color:#166534;">Project Commissioned!</h5>
                <p style="color:#64748b; margin:0;">Subsidy has been redeemed successfully.</p>
            </div>
            @endif

            <!-- Meta Info & Technical Specs -->
            <div class="timeline-card">
                <h6 style="font-weight:800; color:#1e293b; margin-bottom:20px;"><i class="fas fa-info-circle" style="color:#166534; margin-right:8px;"></i>System Specifications</h6>
                <div class="meta-grid">
                    <div class="meta-item">
                        <div class="meta-key">System Type</div>
                        <div class="meta-val" style="text-transform: capitalize;">{{ $project->system_type ?? 'N/A' }}</div>
                    </div>
                    <div class="meta-item">
                        <div class="meta-key">Capacity</div>
                        <div class="meta-val">{{ $project->kw_capacity ?? '0' }} kW</div>
                    </div>
                    <div class="meta-item">
                        <div class="meta-key">Total Amount</div>
                        <div class="meta-val">₹{{ number_format($project->total_amount ?? 0, 0) }}</div>
                    </div>
                    <div class="meta-item">
                        <div class="meta-key">Part Payment</div>
                        <div class="meta-val">₹{{ number_format($project->part_payment_amount ?? 0, 0) }}</div>
                    </div>
                </div>
            </div>

            <div class="timeline-card">
                <h6 style="font-weight:800; color:#1e293b; margin-bottom:20px;"><i class="fas fa-file-signature" style="color:#166534; margin-right:8px;"></i>Registration Details</h6>
                <div class="meta-grid">
                    <div class="meta-item">
                        <div class="meta-key">App No.</div>
                        <div class="meta-val">{{ $project->suryaghar_app_no ?? 'PENDING' }}</div>
                    </div>
                    <div class="meta-item">
                        <div class="meta-key">DISCOM</div>
                        <div class="meta-val">{{ $project->discom_name ?? 'N/A' }}</div>
                    </div>
                    <div class="meta-item">
                        <div class="meta-key">Consumer No.</div>
                        <div class="meta-val">{{ $project->consumer_no ?? 'N/A' }}</div>
                    </div>
                    <div class="meta-item">
                        <div class="meta-key">Meter No.</div>
                        <div class="meta-val">{{ $project->meter_no ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>

            @if($project->notes)
            <div class="meta-item" style="border-radius:14px; background:#fff; border:1px solid #e2e8f0; padding:16px 20px;">
                <div class="meta-key">Notes</div>
                <div style="color:#475569; font-weight:600; margin-top:4px;">{{ $project->notes }}</div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
