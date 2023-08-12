<div>
    <button class="btn btn-primary" wire:click.prevent='showCreateInvitationForm(true)' @if ($showCreateInvitation) disabled @endif>Invite</button>

    <div class="mt-3"></div>

    @if ($showCreateInvitation)
    <div class="mt-3"></div>
    <div class="card card-secondary">
        <div class="card-header border-0 bg-secondary">
            <div class="d-flex justify-content-between">
                <h3 class="card-title">Create Invitation</h3>
            </div>
        </div>
        <div class="card-body">
            <label>Email</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control @if($errors->has('inviteEmail')) is-invalid @endif" wire:model="inviteEmail" placeholder="Email">
                <div class="invalid-feedback">
                    {{ $errors->first('inviteEmail') }}
                </div>
            </div>     
            <div class="d-flex">
                <button class="btn btn-primary" wire:click.prevent="createInvitation">Create</button>
                <button class="btn btn-outline-danger ml-2" wire:click.prevent="showCreateInvitationForm(false)">Cancel</button>
            </div>    
        </div>
    </div>
    @endif

    <div class="card card-primary card-outline">
        <div class="card-header border-0">
            <div class="d-flex justify-content-between">
                <h3 class="card-title">Other Admins</h3>
            </div>
        </div>
        <div class="card-body" style="overflow-x: scroll;">
            <table id="tableAdmins" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($admins as $a)
                        @if ($a->id != $me->id)
                        <tr>
                            <td>{{ $a->id }}</td>
                            <td>{{ $a->name }}</td>
                            <td>{{ $a->email }}</td>
                        </tr>                            
                        @endif                                
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4"></div>

    <div class="card card-primary card-outline">
        <div class="card-header border-0">
            <div class="d-flex justify-content-between">
                <h3 class="card-title">Invitations</h3>
            </div>
        </div>
        <div class="card-body" style="overflow-x: scroll;">
            <table id="tableInvitations" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Email</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invitations as $a)
                        @if ($a->email != $me->email)
                        <tr>
                            <td>{{ $a->id }}</td>
                            <td>{{ $a->email }}</td>
                            <td><button class="btn btn-danger" wire:click.prevent="deleteInvitation({{ $a->id }})">Delete</button></td>
                        </tr>                            
                        @endif                                
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>

$('#tableAdmins').DataTable({
    paging: true,
    lengthChange: false,
    searching: true,
    ordering: true,
    info: true,
    autoWidth: false,
    responsive: true,
});

$('#tableInvitations').DataTable({
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
