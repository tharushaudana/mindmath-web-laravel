<div>
    <div>    
        <div class="mt-3"></div>
    
        @if (count($test->openedAttempts()) > 0)
        <div class="card card-warning card-outline">
            <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                        <span class="text-danger" style="font-size: 13px;"><i class="fa-solid fa-circle fa-beat-fade"></i></span>
                        <div style="width: 10px;"></div>
                        <h3 class="card-title">Opened Attempts</h3>
                    </div>
                </div>
            </div>
            <div class="card-body" style="overflow-x: scroll;">
                <table id="tableOpenedAttempts" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Student Name</th>
                            <th>Start At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($test->openedAttempts() as $attempt)
                        <tr>
                            <td>{{ $attempt->id }}</td>
                            <td>{{ $attempt->student->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($attempt->created_at)->diffForHumans() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    
        <div class="card card-success card-outline">
            <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                        <span class="text-success" style="font-size: 14px;"><i class="fa-solid fa-circle-check"></i></span>
                        <div style="width: 10px;"></div>
                        <h3 class="card-title">Finished Students</h3>
                    </div>
                </div>
            </div>
            <div class="card-body" style="overflow-x: scroll;">
                <table id="tableFinishedStudents" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Student Name</th>
                            <th>Attempts Used</th>
                            <th>Marks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($test->hasResultStudents() as $student)
                        <tr>
                            <td>{{ $student->id }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->attempts($test)->count() }}</td>
                            <td><button class="btn btn-secondary">View Marks</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
    
    $('#tableFinishedStudents').DataTable({
        paging: true,
        lengthChange: false,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: false,
        responsive: true,
    });
    
    </script>
    
    @endpush
    
</div>
