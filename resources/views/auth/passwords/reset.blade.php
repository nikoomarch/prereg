@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="card col-5 p-0 border-primary">
                <div class="card-header text-center text-white bg-primary">تغییر رمز عبور</div>
                <div class="card-body">
                    <form action="{{route('auth.set-password')}}" method="post">
                        @csrf
                        <div class="my-4 row justify-content-center">
                            <div class="form-group col-12 ">
                                <label class="text-left">رمز عبور فعلی</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password">
                                @error('current_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-12">
                                <label class="text-left">رمز عبور جدید</label>
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password">
                                @error('new_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-12">
                                <label class="text-left">تکرار رمز عبور جدید</label>
                                <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" name="confirm_password">
                                @error('confirm_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <input type="submit" class="btn btn-warning btn-block" value="ثبت" />
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
