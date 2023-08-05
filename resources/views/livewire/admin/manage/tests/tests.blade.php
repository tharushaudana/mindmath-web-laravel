<div>
    <button class="btn btn-primary" wire:click.prevent='showCreate(true)' @if ($showCreateTest || $showConfigureTest) disabled @endif>Create</button>

    <div class="mt-3"></div>

    <div class="row">
        <div class="col-md-{{ $showCreateTest || $showConfigureTest ? '8' : '12' }}">
            <div class="card card-primary card-outline">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">Recent Tests</h3>
                    </div>
                </div>
                <div class="card-body" style="overflow-x: scroll;">
                    <table id="tableTests" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Grade</th>
                                <th>Max Attempts</th>
                                <th>Open At</th>
                                <th>Close At</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tests as $t)
                            <tr class="@if($t->id == $test->id) bg-warning @endif">
                                <td>{{ $t->id }}</td>
                                <td>{{ $t->name }}</td>
                                <td><span class="badge badge-info">{{ Str::upper($t->type->name) }}</span></td>
                                <td><span class="badge badge-dark">{{ $t->grade ? $t->grade->name : 'Every Grades' }}</span></td>
                                <td>{{ $t->max_attempts }}</td>
                                <td>{{ $t->open_at }}</td>
                                <td>{{ $t->close_at }}</td>
                                <td>
                                    <button class="btn btn-secondary" wire:click.prevent="showConfigure(true, '{{ $t->id }}')">Configure</button>
                                    
                                    @if ($t->config->id == null)
                                    <br><span class="text-danger" style="font-size: 10px;"><i class="fa-solid fa-triangle-exclamation"></i>&nbsp;&nbsp;not configured.</span>
                                    @else
                                    <br><span class="text-success" style="font-size: 10px;"><i class="fa-solid fa-circle-check"></i>&nbsp;&nbsp;configured.</span>
                                    @endif
                                </td>
                            </tr>                                
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.col -->
        <div class="col-md-4">
            <div class="card card-secondary @if (!$showCreateTest) d-none @endif">
                <div class="card-header border-0 bg-secondary">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">Create Test</h3>
                    </div>
                </div>
                <div class="card-body">
                    <label>Name of Test</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control @if($errors->has('test.name')) is-invalid @endif" wire:model="test.name" placeholder="Name of Test">
                        <div class="invalid-feedback">
                            {{ $errors->first('test.name') }}
                        </div>
                    </div>
                    <label>Type of Test</label>
                    <div class="input-group mb-3">
                        <select class="form-control @if($errors->has('test.test_type_id')) is-invalid @endif" wire:model="test.test_type_id">
                            <option>Select here</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}">{{ Str::upper($type->name) }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            {{ $errors->first('test.test_type_id') }}
                        </div>
                    </div> 
                    <label>Test for</label>
                    <div class="input-group mb-3">
                        <select class="form-control @if($errors->has('test.grade_id')) is-invalid @endif" wire:model="test.grade_id">
                            <option value="">Every Grades</option>
                            @foreach ($grades as $grade)
                                <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            {{ $errors->first('test.grade_id') }}
                        </div>
                    </div>   
                    <label>Max attempts for per student</label>
                    <div class="input-group mb-3">
                        <input type="number" class="form-control @if($errors->has('test.max_attempts')) is-invalid @endif" wire:model="test.max_attempts" placeholder="max attempts" value="1" min="1">
                        <div class="invalid-feedback">
                            {{ $errors->first('test.max_attempts') }}
                        </div>
                    </div>
                    <label>Open at <span class="text-muted">(leave empty for open after test when ready)</span></label>
                    <div class="input-group mb-3">
                        <input onchange="setOpenAt(this.value)" type="text" class="form-control datetimepicker @if($errors->has('test.open_at')) is-invalid @endif" wire:model="test.open_at">
                        <div class="invalid-feedback">
                            {{ $errors->first('test.open_at') }}
                        </div>
                    </div> 
                    <label>Close at</label>
                    <div class="input-group mb-3">
                        <input onchange="setCloseAt(this.value)" type="text" class="form-control datetimepicker @if($errors->has('test.close_at')) is-invalid @endif" wire:model="test.close_at">
                        <div class="invalid-feedback">
                            {{ $errors->first('test.close_at') }}
                        </div>
                    </div>       
                    <div class="d-flex">
                        <button class="btn btn-primary" wire:click.prevent="createTest">Save</button>
                        <button class="btn btn-outline-danger ml-2" wire:click.prevent="showCreate(false)">Cancel</button>
                    </div>    
                </div>
            </div>

            <div class="card card-secondary @if (!$showConfigureTest) d-none @endif">
                <div class="card-header border-0 bg-warning">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">Configure Test <b>#{{ $test->id }}</b></h3>
                    </div>
                </div>

                @if (!is_null($test->type))
                    @if ($test->type->name == 'mcq')
                        @include('livewire.admin.manage.tests.configs.mcq')
                    @endif
                @endif
            </div>
        </div>
        <!-- /.col -->
      </div>
</div>

@push('scripts')
<script>

var loaded = false;

$('.datetimepicker').daterangepicker({
    timePicker: true,
    singleDatePicker: true,
    showDropdowns: true,
    locale: { format: 'YYYY-MM-DD HH:mm:ss' },
});

/*$('#tableTests').DataTable({
    paging: true,
    lengthChange: false,
    searching: true,
    ordering: true,
    info: true,
    autoWidth: false,
    responsive: true,
});*/

document.addEventListener('DOMContentLoaded', function () {
    loaded = true;
});

function setOpenAt(value) {
    if (!loaded) return;
    @this.setValue('test.open_at', value);
}

function setCloseAt(value) {
    if (!loaded) return;
    @this.setValue('test.close_at', value);
}

</script>

@include('livewire.admin.manage.tests.configs.mcqjs')

@endpush
