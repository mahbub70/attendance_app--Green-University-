@extends('dashboard.layouts.app')

@section('title')
    <title>Account</title>
@endsection

@section('page-title')
    My Account
@endsection

@section('css')
    
@endsection

@section('page-content')
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles markWrap">
            @if (session('error'))
                <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
            @endif
            @if (session('success'))
                <div class="alert alert-success" role="alert">{{ session('success') }}</div>
            @endif
            <form action="{{ route('account.password.change') }}" method="post" id="student_result_form">
                @csrf
                <div class="row">
                    <div class="col-xl-6 col-lg-6 m-auto">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title">Change Password</h2>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <div class="form-group">
                                        <input type="password" class="form-control input-default @error('old_password') is-invalid @enderror" placeholder="Enter Old Password" name="old_password" value="{{ old('old_password') }}">
                                        @error('old_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control input-default @error('new_password') is-invalid @enderror" placeholder="Enter New Password" name="new_password" value="{{ old('new_password') }}">
                                        @error('new_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control input-default " placeholder="Enter Confirm Password" name="new_password_confirmation" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row ">
                    <div class="card-body" style="margin-left: 450px;">
                        <button type="submit" class="btn btn-success" id="resultSubmitBtn">Submit</button>
                    </div>
                </div>
                <!-- row -->
            </form>
        </div>
    </div>
</div>
@endsection


@section('js')

@endsection

