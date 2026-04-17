@extends('admin.layouts.master')

@section('title')
    Import Leads
@endsection

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-12 ">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="bi bi-upload me-2"></i> Import Leads
                        </h5>
                    </div>
                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="alert alert-info">
                            <h6><i class="bi bi-info-circle me-2"></i> Import Instructions</h6>
                            <ul class="mb-0">
                                <li>Download the <a href="{{ route('admin.leads.download-template') }}"
                                        class="alert-link">template file</a> for proper formatting</li>
                                <li>Maximum file size: 2MB</li>
                                <li>Supported formats: .xlsx, .xls, .csv</li>
                                <li>Required columns: Lead Name, Company</li>
                            </ul>
                        </div>

                        <form action="{{ route('admin.leads.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="import_type" class="form-label">Import Type</label>
                                <select class="form-select" id="import_type" name="import_type" required>
                                    <option value="create">Create New Leads Only</option>
                                    <option value="update">Update Existing Leads</option>
                                    <option value="replace">Replace All Data</option>
                                </select>
                                <div class="form-text">
                                    <small>
                                        <strong>Create:</strong> Only creates new leads<br>
                                        <strong>Update:</strong> Updates existing leads (matched by email/company)<br>
                                        <strong>Replace:</strong> Deletes all existing leads and imports new ones
                                    </small>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="file" class="form-label">Select File</label>
                                <input type="file" class="form-control" id="file" name="file"
                                    accept=".xlsx,.xls,.csv" required>
                                <div class="form-text">Accepted formats: Excel (.xlsx, .xls) or CSV (.csv)</div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.leads.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-1"></i> Back to Leads
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-upload me-1"></i> Import Leads
                                </button>
                            </div>
                        </form>

                        <hr class="my-4">

                        <div class="card">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Sample Data Format</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <thead class="table-light">
                                            <tr>
                                                <th>local_name</th>
                                                <th>company</th>
                                                <th>status</th>
                                                <th>owner</th>
                                                <th>email</th>
                                                <th>value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>John Smith</td>
                                                <td>ABC Corp</td>
                                                <td>Open</td>
                                                <td>John Doe</td>
                                                <td>john@abc.com</td>
                                                <td>5000</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
