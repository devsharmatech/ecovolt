@extends('admin.layouts.master')

@section('title') Edit Quotation @endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card" style="border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: none;">
                    <div class="card-body">
                        <h4 class="card-title text-success mb-4" style="font-weight: 800; font-size: 22px;">Edit Investment Proposal</h4>
                        
                        <form action="{{ route($role . '.quotes.update', $quote->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" style="font-weight: 700;">Linked Project</label>
                                    <input type="text" class="form-control" value="{{ $quote->project ? $quote->project->project_code . ' — ' . $quote->project->customer_name : 'No Project' }}" readonly style="border-radius: 12px; height: 50px; background: #f8f9fa;">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" style="font-weight: 700;">Lead ID (Linked)</label>
                                    <input type="text" class="form-control" value="{{ $quote->project && $quote->project->lead ? $quote->project->lead->lead_code : 'N/A' }}" readonly style="border-radius: 12px; height: 50px; background: #f0fdf4; color: #166534; font-weight: 700;">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" style="font-weight: 700;">Package Name</label>
                                <input type="text" name="package_name" id="package_name" class="form-control" value="{{ old('package_name', $quote->package_name) }}" required style="border-radius: 12px; height: 50px;">
                            </div>

                            <div class="mb-4">
                                <label class="form-label" style="font-weight: 700;">Total Investment (₹)</label>
                                <input type="number" step="0.01" name="total_price" id="total_price" class="form-control" value="{{ old('total_price', $quote->total_price) }}" required style="border-radius: 12px; height: 50px;">
                            </div>

                            <div class="card bg-light border-0 mb-4" style="border-radius: 15px;">
                                <div class="card-body">
                                    <h5 class="mb-3" style="font-weight: 800; color: #2e7d32;">Component Breakdown</h5>
                                    @php $components = is_array($quote->components) ? $quote->components : json_decode($quote->components, true) ?? []; @endphp
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Solar Panels</label>
                                            <input type="text" name="components[panels]" class="form-control" value="{{ $components['panels'] ?? '' }}" style="border-radius: 10px;">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Inverter</label>
                                            <input type="text" name="components[inverter]" class="form-control" value="{{ $components['inverter'] ?? '' }}" style="border-radius: 10px;">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Battery</label>
                                            <input type="text" name="components[battery]" class="form-control" value="{{ $components['battery'] ?? '' }}" style="border-radius: 10px;">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Warranty</label>
                                            <input type="text" name="components[warranty]" class="form-control" value="{{ $components['warranty'] ?? '' }}" style="border-radius: 10px;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label" style="font-weight: 700;">Project Timeline & Description</label>
                                <textarea name="timeline" class="form-control" rows="4" style="border-radius: 12px;">{{ old('timeline', $quote->timeline) }}</textarea>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route($role . '.quotes.index') }}" class="btn btn-light" style="border-radius: 12px; padding: 12px 30px;">Cancel</a>
                                <button type="submit" class="btn btn-primary" style="border-radius: 12px; padding: 12px 40px; font-weight: 700;">Update Proposal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
