@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card card-body">
            <p class="text-center text-danger">
                لطفا فایل اکسل مشخصات دانشجویان را انتخاب کرده و سپس روی دکمه آپلود کلیک کنید.<br/>
                این فایل باید حتما شامل ستون های نام، نام خانوادگی، شماره دانشجویی، کد ملی، جنسیت و ترم ورود باشد. ضمنا در ردیف اول فایل نیز باید نام ستون ها قرار داشته باشد.<br/>
                لطفا قبل از بارگذاری توجه کنید که در هر ردیف تمامی ستون ها(مشخصات) حتما مقدار داشته باشند.
            </p>
            <form action="{{route('group-manager.user.store-from-file')}}" method="POST" id="form" enctype="multipart/form-data">
                @csrf
                <div class="form-group row justify-content-center">
                    <label class="text-left col-form-label">انتخاب فایل</label>
                    <div class="col-md-3">
                        <input type="file" style="width: 100%;" name="excel" id="excel" onchange="enable()" class="@error('excel') is-invalid @enderror">
                        @error('excel')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <button class="btn btn-primary" type="button" id="upload" disabled >بارگذاری</button>
                </div>
                <div class="columns hidden">
                    <div class="form-group row justify-content-center">
                        <label class="text-left col-form-label">نام</label>
                        <div class="col-md-3">
                            <select class="form-control cols @error('name') is-invalid @enderror" name="name" required></select>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <label class="text-left col-form-label">نام خانوادگی</label>
                        <div class="col-md-3">
                            <select class="form-control cols @error('family') is-invalid @enderror" name="family" required></select>
                            @error('family')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <label class="text-left col-form-label">شماره دانشجویی</label>
                        <div class="col-md-3">
                            <select class="form-control cols @error('username') is-invalid @enderror" name="username" required></select>
                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row justify-content-center">
                        <label class="text-left col-form-label @error('nationalCode') is-invalid @enderror">کد ملی</label>
                        <div class="col-md-3">
                            <select class="form-control cols" name="nationalCode" required></select>
                            @error('nationalCode')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <label class="text-left col-form-label">جنسیت</label>
                        <div class="col-md-3">
                            <select class="form-control cols @error('gender') is-invalid @enderror" name="gender" required></select>
                            @error('gender')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <label class="text-left col-form-label @error('entranceTerm') is-invalid @enderror">ترم ورود</label>
                        <div class="col-md-3">
                            <select class="form-control cols" name="entranceTerm" required></select>
                            @error('entranceTerm')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <input type="submit" id="submit" value="ثبت" class="btn btn-outline-success" style="cursor: pointer; display: none;">
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            if ($('span[role="alert"]').length) {
                $('.columns').fadeIn();
            }
            $('#upload').click(upload)
        });

        function enable() {
            $('#upload').prop('disabled',false);
        }

        function upload() {
            NProgress.start();
            let fd = new FormData();
            fd.append('file', document.getElementById('excel').files[0]);
            axios({
                url: "/api/get-headers",
                method: 'POST',
                data: fd,
                headers: {
                    "content-type": "multipart/form-data"
                }
            }).then(function (res) {
                let cols = res.data;
                let body = "<option value='' disabled selected>انتخاب کنید...</option>";
                cols.forEach(function (item) {
                    body = body.concat(`<option value="${item}">${item}</option>`)
                });
                $('.cols').html(body);
                $('.columns').fadeIn();
                $('#submit').show();
                NProgress.done();
            }).catch(error=>console.log(error))
        }
    </script>
@endsection
