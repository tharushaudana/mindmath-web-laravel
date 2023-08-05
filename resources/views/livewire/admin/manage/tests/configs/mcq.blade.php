<div class="card-body">   
    <label>Number of Questions</label>
    <div class="input-group mb-3">
        <input type="number" class="form-control @if($errors->has('config.num_questions')) is-invalid @endif" wire:model="config.num_questions" value="1" min="1">
        <div class="invalid-feedback">
            {{ $errors->first('config.num_questions') }}
        </div>
    </div>
    <label>Duration for Per Question (in seconds)</label>
    <div class="input-group mb-3">
        <input type="number" class="form-control @if($errors->has('config.dur_per')) is-invalid @endif" wire:model="config.dur_per" value="1" min="1">
        <div class="invalid-feedback">
            {{ $errors->first('config.dur_per') }}
        </div>
    </div>
    <label>Extra Duration for Whole Test (in minutes)</label>
    <div class="input-group mb-3">
        <input type="number" class="form-control @if($errors->has('config.dur_extra')) is-invalid @endif" wire:model="config.dur_extra" value="1" min="1">
        <div class="invalid-feedback">
            {{ $errors->first('config.dur_extra') }}
        </div>
    </div> 

    @if ($config->num_questions > 0)
    <div class="card">
        <div class="card-header"><label>Structure of Questions</label></div>
        <div class="card-body">
            <button class="btn btn-secondary btn-sm" onclick="showStructEditModal('{{ $config->struct }}')">Edit Structure</button>

            @error('config.struct')
            <div class="mb-1"></div>
            <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
            @enderror
        </div>
    </div>        
    @endif

    <div class="d-flex mb-3">
        <input type="checkbox" wire:model="config.shuffle_questions" value="1" {{ $config->shuffle_questions == 1 ? 'checked' : '' }}>
        <span>&nbsp;&nbsp;Shuffle Questions</span>
    </div>

    <div class="d-flex">
        <button class="btn btn-primary" wire:click.prevent="configureTest">Save</button>
        <button class="btn btn-outline-danger ml-2" wire:click.prevent="showConfigure(false)">Cancel</button>
    </div>    
</div>

<div class="modal fade" id="structModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" wire:ignore>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Structure</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <button onclick="addStruct()" class="btn btn-outline-primary w-100">Add Item</button>
                <div class="mb-3"></div>
                <div id="struct-content">
                    <span class="text-muted"><i>No items added yet...</i></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Done</button>
            </div>
        </div>
    </div>
</div>