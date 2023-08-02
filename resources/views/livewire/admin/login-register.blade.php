@auth
    <div class="card">
        <div class="card-body login-card-body">
            <p>Logged as <b>{{ Auth::user()->email }}</b></p>
            <div>
                <button class="btn btn-danger" wire:click.prevent="logout">Logout</button>
            </div>
        </div>
    </div>    
@else
    <div>
        @if ($showRegisterForm)
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Register for Invitation</p>

                    <div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control @if($errors->has('name')) is-invalid @endif" wire:model="name" placeholder="Name">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="email" class="form-control @if($errors->has('email')) is-invalid @endif" wire:model="email" placeholder="Email">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control @if($errors->has('password')) is-invalid @endif" wire:model="password" placeholder="Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                            <div class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control @if($errors->has('password_confirmation')) is-invalid @endif" wire:model="password_confirmation" placeholder="Confirm Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                            <div class="invalid-feedback">
                                {{ $errors->first('password_confirmation') }}
                            </div>
                        </div>
                        <div class="row">
                            <!-- /.col -->
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block" wire:click.prevent="register">Register</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </div>

                    <br>

                    <p class="mb-0">
                        <a class="text-center" wire:click.prevent="loginForm" style="cursor: pointer;">Back to Login</a>
                    </p>
                </div>
            </div>        
        @else
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Sign in to start your session</p>

                    <div>
                        <div class="input-group mb-3">
                            <input type="email" class="form-control @if($errors->has('email')) is-invalid @endif" wire:model="email" placeholder="Email">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control @if($errors->has('password')) is-invalid @endif" wire:model="password" placeholder="Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                            <div class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </div>
                        </div>
                        <div class="row">
                            <!-- /.col -->
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block" wire:click.prevent="login">Log In</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </div>

                    <br>

                    <p class="mb-0">
                        <a class="text-center" wire:click.prevent="registerForm" style="cursor: pointer;">Register a for inivitation</a>
                    </p>
                </div>
            </div>
        @endif
    </div>
@endauth