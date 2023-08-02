<div>
    @auth('student')
        <div class="card rounded-3 shadow-lg">
            <div class="card-body" style="text-align: center;">
                <p>Logged as <b>{{ Auth::guard('student')->user()->email }}</b></p>
                <div>
                    <button class="btn btn-danger" wire:click.prevent="logout">Logout</button>
                </div>
            </div>
        </div>
    @else
        @if($showRegisterForm)
            <div class="card rounded-3 shadow-lg">
                <div class="card-body">
                    <h1 class="display-6">Register</h1>
                    <br>
                    <div>
                        <div class="mb-3">
                            <input type="text" class="form-control @if($errors->has('name')) is-invalid @endif" wire:model="name" aria-describedby="validationNameFeedback" placeholder="Your Name" required>
                            <div id="validationNameFeedback" class="invalid-feedback">
                            {{ $errors->first('name') }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <select class="form-control @if($errors->has('grade')) is-invalid @endif" wire:model="grade" aria-describedby="validationGradeFeedback" required>
                                <option value="">Select your Grade</option>                                
                                @foreach ($grades as $grade)
                                    <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                @endforeach
                            </select>
                            <div id="validationGradeFeedback" class="invalid-feedback">
                            {{ $errors->first('grade') }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control @if($errors->has('email')) is-invalid @endif" wire:model="email" aria-describedby="validationEmailFeedback" placeholder="Your Email" required>
                            <div id="validationEmailFeedback" class="invalid-feedback">
                            {{ $errors->first('email') }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control @if($errors->has('password')) is-invalid @endif" wire:model="password" aria-describedby="validationPasswordFeedback" placeholder="Password" required>
                            <div id="validationPasswordFeedback" class="invalid-feedback">
                            {{ $errors->first('password') }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control @if($errors->has('password_confirmation')) is-invalid @endif" wire:model="password_confirmation" aria-describedby="validationPasswordConfirmationFeedback" placeholder="Confirm Password" required>
                            <div id="validationPasswordConfirmationFeedback" class="invalid-feedback">
                            {{ $errors->first('password_confirmation') }}
                            </div>
                        </div>
                        <button class="btn btn-primary" wire:click.prevent="register">Register</button>
                    </div>
                    <br>
                    <span style="font-size: 12px;">or <a class="text-decoration-none" style="cursor: pointer" wire:click.prevent="loginForm">Back to Login</a></span>
                </div>
            </div>
        @else
            <div class="card rounded-3 shadow-lg">
                <div class="card-body">
                    <h1 class="display-6">Login</h1>
                    <br>
                    <div>
                        <div class="mb-3">
                            <input type="text" class="form-control @if($errors->has('email')) is-invalid @endif" wire:model="email" aria-describedby="validationEmailFeedback" placeholder="Your Email">
                            <div id="validationEmailFeedback" class="invalid-feedback">
                            {{ $errors->first('email') }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control @if($errors->has('password')) is-invalid @endif" wire:model="password" aria-describedby="validationPasswordFeedback" placeholder="Password">
                            <div id="validationPasswordFeedback" class="invalid-feedback">
                            {{ $errors->first('password') }}
                            </div>
                        </div>
                        <button class="btn btn-primary" wire:click.prevent="login">Login</button>
                        @if($errorMsg != null)
                            <br>
                            <span class="text-danger" style="font-size: 12px;">{{ $errorMsg }}</span>
                        @endif
                    </div>
                    <br>
                    <span style="font-size: 12px;">or <a class="text-decoration-none" style="cursor: pointer" wire:click.prevent="registerForm">Register Now</a></span>
                </div>
            </div>
        @endif
    @endauth
</div>
