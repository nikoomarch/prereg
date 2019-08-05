@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card card-body">
            <form action="{{route('user.storeFromFile')}}" method="POST" id="form" enctype="multipart/form-data">
                @csrf
                <div class="form-group row justify-content-center">
                    <label class="text-left col-form-label">انتخاب فایل</label>
                    <div class="col-md-3">
                        <input type="file" style="width: 100%;" name="excel" id="excel" class="@error('excel') is-invalid @enderror">
                        @error('excel')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <button class="btn btn-primary" type="button" onclick="upload()">آپلود</button>
                </div>
                <div class="columns hidden">
                    <div class="form-group row justify-content-center">
                        <label class="text-left col-form-label">نام</label>
                        <div class="col-md-3">
                            <select class="form-control cols" name="name">
                            </select>
                        </div>
                        <label class="text-left col-form-label">نام خانوادگی</label>
                        <div class="col-md-3">
                            <select class="form-control cols" name="family">
                            </select>
                        </div>
                        <label class="text-left col-form-label">شماره دانشجویی</label>
                        <div class="col-md-3">
                            <select class="form-control cols" name="username">
                            </select>
                        </div>
                    </div>
                    <div class="form-group row justify-content-center">
                        <label class="text-left col-form-label">کد ملی</label>
                        <div class="col-md-3">
                            <select class="form-control cols" name="nationalCode">
                            </select>
                        </div>
                        <label class="text-left col-form-label">جنسیت</label>
                        <div class="col-md-3">
                            <select class="form-control cols" name="gender">
                            </select>
                        </div>
                        <label class="text-left col-form-label">ترم ورود</label>
                        <div class="col-md-3">
                            <select class="form-control cols" name="entranceTerm">
                            </select>
                        </div>
                    </div>
                </div>

                <input type="submit" value="ثبت" class="btn btn-success btn-block" style="cursor: pointer;">
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function upload() {
            var fd = new FormData();
            fd.append('excel', document.getElementById('excel').files[0]);
            axios({
                url: 'http://127.0.0.1:9000/get-file',
                method: 'POST',
                data: fd,
                headers: {
                    "content-type": "multipart/form-data"
                }
            }).then(function (res) {
                let cols = res.data.columns;
                let body = "<option value='' disabled selected>انتخاب کنید...</option>";
                cols.forEach(function (item) {
                    body = body.concat(`<option value="${item}">${item}</option>`)
                });
                console.log(body);
                $('.cols').html(body);
                $('.columns').removeClass('hidden');
            }).catch(error=>console.log(error))
        }
    </script>
@endsection