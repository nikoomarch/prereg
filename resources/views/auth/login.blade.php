@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <p class="text-center text-danger">لطفا با استفاده از شماره دانشجویی بعنوان نام کاربری و کد ملی (یا شماره گذرنامه) بعنوان رمز عبور وارد سامانه شوید.</p>
            <p class="text-center text-danger">
                در حین تعیین دروس، پیش نیازها و هم نیازها را رعایت کنید و حداکثر 18 واحد انتخاب نمایید و پس از انتخاب "دکمه ثبت" را فشار دهید.
            </p>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">ورود</div>
                @if($errors->any())
                    <div class="alert m-3 alert-danger"><strong>خطا:</strong>&nbsp;{{$errors->first()}}</div>
                @endif
                <div class="card-body">
                    <form method="POST" action="/login">
                        @csrf

                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-6 col-md-offset-3 text-center">
                                <div class="form-group">
                                    <label for="email" class="">نام کاربری</label>
                                    <input id="username" type="text" class="form-control text-center" name="username" value="{{ old('username') }}" required autofocus>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="">گذرواژه (بدون صفر ابتدا)</label>
                                    <input id="password" type="password" class="form-control text-center" name="password" required autocomplete="current-password">
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="g-recaptcha m-2" style="display: inline-block;"
                                 data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}">
                            </div>
                        </div>

                        <div class="form-group mt-2">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-outline-primary btn-block">
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