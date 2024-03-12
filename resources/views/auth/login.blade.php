@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
        </div>
        <div class="col-md-6">
            <div class="card text-center" style="background-color: rgba(255, 255, 255, 0.33);">
                <div class="card-header" style="background-color: white;">سامانه انتخاب واحد</div>
                @if($errors->any())
                    <div class="alert m-3 alert-danger"><strong>خطا:</strong>&nbsp;{{$errors->first()}}</div>
                @endif
                <div class="card-body" style="background-color: rgba(0,0,0,0)">
                    <form method="POST" action="/login">
                        @csrf

                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6 col-md-offset-3 text-center">
                                <div class="form-group">
                                    <input id="username" type="text" class="form-control text-center" name="username" value="{{ old('username') }}" placeholder="نام کاربری (شماره دانشجویی)" required autofocus>
                                </div>
                                <div class="form-group">
                                    <input id="password" type="password" class="form-control text-center" name="password" required autocomplete="current-password" placeholder="گذرواژه (کد ملی)">
                                </div>
                                <img src="{{ captcha_src('flat') }}" />
                                <div class="form-group mt-2">
                                    <input type="text" class="form-control text-center" name="captcha" placeholder="کد کپچا" required>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">

                        </div>

                        <div class="form-group mt-2">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-block">
                                    ورود
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    @if(!is_null($success))
        <script>
            Swal.fire("موفقیت آمیز", "با تشکر از شما", "success");
        </script>
    @endif
@endsection