@extends('front.layouts.app')

@section('main')

<section class="section-5">

    <div class="container my-5">
        <div class="py-lg-2">&nbsp;</div>
        @if(Session::has('success'))
            <div class="alert alert-success">
            <p class="mb-0 pb-0">{{ Session::get('success') }}</p>
            </div>
        @endif

        @if(Session::has('error'))
        <div class="alert alert-danger">
                <p class="mb-0 pb-0">{{ Session::get('error') }}</p>
            </div>
        @endif
        <div class="row d-flex justify-content-center">
            <div class="col-md-5">
                <div class="card shadow border-0 p-5">
                    <h1 class="h3">Reset Password</h1>
                    <form action="{{ route('ProcessresetPassword') }}" method="post">
                        @csrf
                        <input type="hidden" name="token" value="{{$tokenString}}">
                        <div class="mb-3">
                            <label for="" class="mb-2">New Password</label>
                            <input type="text" value="" name="newpassword" id="newpassword" class="form-control @error('newpassword') is-invalid @enderror" placeholder="newpassword">
                         
                            @error('new_password')
                        <p class="invalid-feedback">{{ $message }}</p>

                        @enderror

                        </div> 
                        <div class="mb-3">
                            <label for="" class="mb-2">Confirm Password</label>
                            <input type="text" value="" name="confirmpassword" id="confirmpassword" class="form-control @error('confirmpassword') is-invalid @enderror" placeholder="confirmpassword">
                         
                            @error('confirmpassword')
                        <p class="invalid-feedback">{{ $message }}</p>

                        @enderror

                        </div> 
                        <div class="justify-content-between d-flex">
                        <button class="btn btn-primary mt-2">Submit</button>
                            <a href="{{route('account.login') }}" class="mt-3">Back to Login</a>
                        </div>
                    </form>                    
                </div>
                <div class="mt-4 text-center">
                    <p>Do not have an account? <a  href="{{ route('account.registration') }}">Register</a></p>
                </div>
            </div>
        </div>

    <div class="py-lg-5">&nbsp;</div>
    </div>
</section>



@endsection