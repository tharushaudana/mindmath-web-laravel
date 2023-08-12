<div>
    <div>
        <button class="btn btn-primary" wire:click.prevent='showCreateGradeForm(true)' @if ($showCreateGrade) disabled @endif>Create Grade</button>
    
        <div class="mt-3"></div>
    
        @if ($showCreateGrade)
        <div class="mt-3"></div>
        <div class="card card-secondary">
            <div class="card-header border-0 bg-secondary">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Create Grade</h3>
                </div>
            </div>
            <div class="card-body">
                <label>Name</label>
                <div class="input-group mb-3">
                    <input type="text" class="form-control @if($errors->has('gradeName')) is-invalid @endif" wire:model="gradeName" placeholder="Name of Grade">
                    <div class="invalid-feedback">
                        {{ $errors->first('gradeName') }}
                    </div>
                </div>     
                <div class="d-flex">
                    <button class="btn btn-primary" wire:click.prevent="createGrade">Create</button>
                    <button class="btn btn-outline-danger ml-2" wire:click.prevent="showCreateGradeForm(false)">Cancel</button>
                </div>    
            </div>
        </div>
        @endif
    
        <div class="card card-primary card-outline">
            <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Students</h3>
                </div>
            </div>
            <div class="card-body" style="overflow-x: scroll;">
                <table id="tableGrades" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Grade</th>
                            <th>Registered At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $s)
                        <tr>
                            <td>{{ $s->id }}</td>
                            <td>{{ $s->name }}</td>
                            <td>{{ $s->email }}</td>
                            <td><span class="badge badge-dark">{{ $s->grade->name }}</span></td>
                            <td>{{ \Carbon\Carbon::parse($s->created_at)->diffForHumans() }}</td>
                        </tr>                                              
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    
        <div class="mt-4"></div>
    
        <div class="card card-primary card-outline">
            <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Grades</h3>
                </div>
            </div>
            <div class="card-body" style="overflow-x: scroll;">
                <table id="tableInvitations" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Name</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($grades as $a)
                        <tr>
                            <td>{{ $a->id }}</td>
                            <td>{{ $a->name }}</td>
                            <td><button class="btn btn-danger" onclick="deleteGrade({{ $a->id }})">Delete</button></td>
                        </tr>                                         
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
    
    $('#tableStudents').DataTable({
        paging: true,
        lengthChange: false,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: false,
        responsive: true,
    });
    
    $('#tableGrades').DataTable({
        paging: true,
        lengthChange: false,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: false,
        responsive: true,
    });

    function deleteGrade($id) {
        //var confirm = confirm('After deleting this grade, The all ')
    }
    
    </script>
    
    @endpush
    
</div>
