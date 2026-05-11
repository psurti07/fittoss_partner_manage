<div class="modal fade" id="showEmployee" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="employeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="employeeModalLabel">Employee Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <dl class="row">
                                <dd class="col-md-4">Name</dd>
                                <dt class="col-md-8">{{ $employee->name }}</dt>
                            </dl>
                            <hr>
                            <dl class="row">
                                <dd class="col-md-4">Email</dd>
                                <dt class="col-md-8">{{ $employee->email }}</dt>
                            </dl>
                            <hr>
                            <dl class="row">
                                <dd class="col-md-4">Mobile No</dd>
                                <dt class="col-md-8">{{ $employee->mobile_no }}</dt>
                            </dl>
                            <hr>
                            <dl class="row">
                                <dd class="col-md-4">Department</dd>
                                <dt class="col-md-8">{{ $employee->department }}</dt>
                            </dl>
                            <hr>
                            <dl class="row">
                                <dd class="col-md-4">Date of Birth</dd>
                                <dt class="col-md-8">{{ \Carbon\Carbon::parse($employee->dob)->format('d/m/Y') }}</dt>
                            </dl>
                            <hr>
                            <dl class="row">
                                <dd class="col-md-4">Date of Joining</dd>
                                <dt class="col-md-8">{{ \Carbon\Carbon::parse($employee->doj)->format('d/m/Y') }}</dt>
                            </dl>
                            <hr>
                            <dl class="row">
                                <dd class="col-md-4">Resign Date</dd>
                                <dt class="col-md-8">{{ $employee->resign_date ? \Carbon\Carbon::parse($employee->resign_date)->format('d/m/Y') : 'N/A' }}</dt>
                            </dl>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
