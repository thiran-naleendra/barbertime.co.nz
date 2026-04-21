@extends('layouts.admin', ['title' => 'Admin Login'])

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-6 col-lg-4">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                 
                <h1 class="h5 fw-semibold mb-3">Admin Login</h1>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif
                   
                <form method="POST" action="{{ route('admin.login.post') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               class="form-control"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password"
                               name="password"
                               class="form-control"
                               required>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">
                            Remember me
                        </label>
                    </div>

                    <button class="btn btn-dark w-100" type="submit">Login</button> <p></p>
                   
                    

                    {{-- <p class="text-muted small mt-3 mb-0">
                        Tip: change default password after first login.
                    </p> --}}
                   
                </form>
                <form action="POST">
                     <a href="{{ route('home') }}"><div class="btn btn-info w-100" >Back to Home</div></a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
