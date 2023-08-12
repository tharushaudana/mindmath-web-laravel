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
    
        <div class="card card-success card-outline" wire:ignore>
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
                            <td><button class="btn btn-secondary" onclick="showMarksModel({{ $student->id }}, '{{ $student->name }}')">View Marks</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="marksModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="marksModalTitle">Attempt Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3"></div>
                    <div id="marksModalContent">
                        @if (!is_null($selectedStudentId))
                        <table id="tableMarks" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#Attempt ID</th>
                                    <th>Marks</th>
                                    <th>Finished At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($test->closedAttempts($selectedStudentId) as $attempt)
                                <tr>
                                    <td>{{ $attempt->id }}</td>
                                    <td><span class="{{ $attempt->calcMarks() > 0 ? 'badge bg-primary' : ''}}">{{ $attempt->calcMarks() }} %</span></td>
                                    <td>{!! is_null($attempt->finished_at) ? '<span class="text-muted">AUTO FINISHED</span>' : \Carbon\Carbon::parse($attempt->finished_at)->diffForHumans($attempt->created_at) !!}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Done</button>
                </div>
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

    function showMarksModel(studentId, studentName) {
        $('#marksModalContent').html('<p align="center"><span style="font-size: 30px;"><i class="fa-solid fa-spinner fa-spin-pulse"></i></span></p>');
        $('#marksModal').modal();
        @this.selectedStudentId = studentId;
    }
    
    </script>
    @endpush
    
</div>
