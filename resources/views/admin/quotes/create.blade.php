@extends('admin.layouts.master')

@section('title') Create Quotation @endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card" style="border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: none;">
                    <div class="card-body">
                        <h4 class="card-title text-success mb-4" style="font-weight: 800; font-size: 22px;">Create New Investment Proposal</h4>
                        
                        <form action="{{ route($role . '.quotes.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" style="font-weight: 700;">Select Project</label>
                                    <select name="project_id" id="project_id" class="form-select" style="border-radius: 12px; height: 50px;" required onchange="fillProjectDetails()">
                                        <option value="">-- Choose Project --</option>
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}" 
                                                data-name="{{ $project->customer_name }}" 
                                                data-type="{{ $project->system_type }}" 
                                                data-capacity="{{ $project->kw_capacity }}"
                                                data-amount="{{ $project->total_amount }}"
                                                data-lead-code="{{ $project->lead ? $project->lead->lead_code : 'N/A' }}"
                                                {{ (isset($selectedProject) && $selectedProject->id == $project->id) ? 'selected' : '' }}>
                                                {{ $project->project_code }} — {{ $project->customer_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" style="font-weight: 700;">Lead ID (Linked)</label>
                                    <input type="text" id="lead_id_disp" class="form-control" value="N/A" readonly style="border-radius: 12px; height: 50px; background: #f0fdf4; color: #166534; font-weight: 700;">
                                    <input type="hidden" name="proposal_id" id="proposal_id" value="EV-2024-{{ strtoupper(substr(md5(time()), 0, 5)) }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" style="font-weight: 700;">Package Name</label>
                                <input type="text" name="package_name" id="package_name" class="form-control" placeholder="e.g. 5kW Hybrid Solar Package" required style="border-radius: 12px; height: 50px;">
                            </div>

                            <div class="mb-4">
                                <label class="form-label" style="font-weight: 700;">Total Investment (₹)</label>
                                <input type="number" step="0.01" name="total_price" id="total_price" class="form-control" placeholder="0.00" required style="border-radius: 12px; height: 50px;">
                            </div>

                            <script>
                                function fillProjectDetails() {
                                    const select = document.getElementById('project_id');
                                    const option = select.options[select.selectedIndex];
                                    if (option.value) {
                                        const capacity = option.getAttribute('data-capacity');
                                        const type = option.getAttribute('data-type');
                                        const amount = option.getAttribute('data-amount');
                                        const leadCode = option.getAttribute('data-lead-code');
                                        
                                        document.getElementById('lead_id_disp').value = leadCode;
                                        document.getElementById('package_name').value = capacity + 'kW ' + type.charAt(0).toUpperCase() + type.slice(1) + ' Solar Package';
                                        document.getElementById('total_price').value = amount;
                                    } else {
                                        document.getElementById('lead_id_disp').value = 'N/A';
                                    }
                                }
                                // Trigger on load if project selected
                                window.onload = fillProjectDetails;
                            </script>

                            <div class="card bg-light border-0 mb-4" style="border-radius: 15px;">
                                <div class="card-body">
                                    <h5 class="mb-3" style="font-weight: 800; color: #2e7d32;">Component Breakdown</h5>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Solar Panels</label>
                                            <input type="text" name="components[panels]" class="form-control" placeholder="e.g. 6X Mono Panels (550W)" style="border-radius: 10px;">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Inverter</label>
                                            <input type="text" name="components[inverter]" class="form-control" placeholder="e.g. 5kVa Hybrid Smart" style="border-radius: 10px;">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Battery</label>
                                            <input type="text" name="components[battery]" class="form-control" placeholder="e.g. 2.4kWh Li-Ion Pack" style="border-radius: 10px;">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Warranty</label>
                                            <input type="text" name="components[warranty]" class="form-control" placeholder="e.g. 10 Years Standard" style="border-radius: 10px;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label" style="font-weight: 700;">Project Timeline & Description</label>
                                <textarea name="timeline" class="form-control" rows="4" style="border-radius: 12px;" placeholder="Describe the installation timeline and process..."></textarea>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route($role . '.quotes.index') }}" class="btn btn-light" style="border-radius: 12px; padding: 12px 30px;">Cancel</a>
                                <button type="submit" class="btn btn-success" style="border-radius: 12px; padding: 12px 40px; font-weight: 700;">Create Proposal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
