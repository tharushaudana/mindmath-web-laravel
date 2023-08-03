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

    <div class="card">
        <div class="card-header">Operations</div>
        <div class="card-body">
            @error('noperations')
            <span class="text-danger">{{ $message }}</span>
            <div class="mb-1"></div>
            <br>
            @enderror
            <label>[+] Plus Count</label>
            <div class="input-group mb-3">
                <input type="number" class="form-control @if($errors->has('config.nplus')) is-invalid @endif" wire:model="config.nplus" value="1" min="0">
                <div class="invalid-feedback">
                    {{ $errors->first('config.nplus') }}
                </div>
            </div>
            <label>[-] Minus Count</label>
            <div class="input-group mb-3">
                <input type="number" class="form-control @if($errors->has('config.nminus')) is-invalid @endif" wire:model="config.nminus" value="1" min="0">
                <div class="invalid-feedback">
                    {{ $errors->first('config.nminus') }}
                </div>
            </div>  
            <label>[x] Multiply Count</label>
            <div class="input-group mb-3">
                <input type="number" class="form-control @if($errors->has('config.nmultiply')) is-invalid @endif" wire:model="config.nmultiply" value="1" min="0">
                <div class="invalid-feedback">
                    {{ $errors->first('config.nmultiply') }}
                </div>
            </div>  
            <label>[/] Divition Count</label>
            <div class="input-group mb-3">
                <input type="number" class="form-control @if($errors->has('config.ndivition')) is-invalid @endif" wire:model="config.ndivition" value="1" min="0">
                <div class="invalid-feedback">
                    {{ $errors->first('config.ndivition') }}
                </div>
            </div>  
        </div>
    </div>
    <label>Operation Order</label>
    <br>
    <span class="text-muted" style="font-size: 12px;">leave empty for random order</span>
    <div class="input-group mb-3">
        <input type="text" class="form-control @if($errors->has('config.operation_order')) is-invalid @endif" wire:model="config.operation_order" placeholder="like +,+,-,+">
        <div class="invalid-feedback">
            {!! $errors->first('config.operation_order') !!}
        </div>
    </div>
    <label>Digits Order</label>
    <div class="input-group mb-3">
        <input type="text" class="form-control @if($errors->has('config.digits_order')) is-invalid @endif" wire:model="config.digits_order" placeholder="like 1,1,2,3,2">
        <div class="invalid-feedback">
            {{ $errors->first('config.digits_order') }}
        </div>
    </div>
    <div class="input-group mb-3">
        <input type="checkbox" wire:model="config.shuffle_digits_order">
        <span>&nbsp;&nbsp;Shuffle Digits Order</span>
        {{ $errors->first('config.shuffle_digits_order') }}
    </div>
    <div class="d-flex">
        <button class="btn btn-primary" wire:click.prevent="configureTest">Save</button>
        <button class="btn btn-outline-danger ml-2" wire:click.prevent="showConfigure(false)">Cancel</button>
    </div>    
</div>