@extends('layouts.app')
@section('content')
    <div class="container">
        <a class="btn btn-primary mb-3 col-2" data-toggle="collapse" href="#create" role="button" aria-expanded="false" aria-controls="create">
            ثبت
        </a>
        <a class="btn btn-primary mb-3 col-2" href="{{route('user.createFromFile')}}">
            ثبت گروهی
        </a>
        <div class="collapse" id="create">
            <div class="card card-body">
                <form action="{{route('user.store')}}" method="POST" id="form">
                    @csrf
                    <input type="hidden" name="_method" value="PUT" disabled>
                    <input type="hidden" name="field_id" value="{{Auth::user()->field_id}}">
                    <input type="hidden" name="role" value="student">
                    <div class="form-group row justify-content-center">
                        <label class="text-left col-form-label">نام</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{old('name')}}" >
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <label class="text-left col-form-label">نام خانوادگی</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control @error('family') is-invalid @enderror" name="family" id="family" value="{{old('family')}}" >
                            @error('family')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <label class="text-left col-form-label">جنسیت</label>
                        <div class="col-md-3">
                            <select id="" name="gender" class="form-control @error('gender') is-invalid @enderror">
                                <option value="" disabled selected>انتخاب کنید ...</option>
                                <option value="M">مرد</option>
                                <option value="F">زن</option>
                            </select>
                            @error('gender')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row justify-content-center">
                        <label class="text-left col-form-label">نام کاربری</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" id="username" value="{{old('username')}}" >
                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <label class="text-left col-form-label">کد ملی</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control @error('nationalCode') is-invalid @enderror" name="nationalCode" id="nationalCode" value="{{old('nationalCode')}}" >
                            @error('nationalCode')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <label class="text-left col-form-label">ترم ورود</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control @error('entranceTerm') is-invalid @enderror" name="entranceTerm" id="entranceTerm" value="{{old('entranceTerm')}}" >
                            @error('entranceTerm')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <input type="submit" value="ثبت" class="btn btn-success btn-block">
                </form>
            </div>
        </div>
        <table class="table table-striped mt-3">
            <thead>
            <td>#</td>
            <td>نام</td>
            <td>نام خانوادگی</td>
            <td>جنسیت</td>
            <td>نام کاربری</td>
            <td>امکان ورود</td>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr id="user-{{$user->id}}">
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->family}}</td>
                    <td>
                        @if($user->gender == 'M')
                            مرد
                        @elseif($user->gender == 'F')
                            زن
                        @endif
                    </td>
                    <td>{{$user->username}}</td>
                    <td>
                        @if($user->isAllowed)
                            <span class="fa fa-check text-success"></span>
                        @else
                            <span class="fa fa-times text-danger"></span>
                        @endif
                    </td>
                    <td><a class="btn btn-danger" onclick="del({{$user->id}})">حذف</a></td>
                    <td><a onclick="edit('{{$user->id}}','{{$user->name}}','{{$user->family}}','{{$user->gender}}','{{$user->username}}','{{$user->nationalCode}}','{{$user->entranceTerm}}')" class="btn btn-warning">تغییر</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$users->links()}}
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            if($('span[role="alert"]').length){
                $('.collapse').collapse('show');
            }
        });
        function del(id) {
            Swal.fire({
                title: 'آیا مطمئن هستید؟',
                text: "این عمل قابل بازگشت نیست",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'بله',
                cancelButtonText: 'خیر'
            }).then((result) => {
                if (result.value) {
                    axios({
                        'method': 'DELETE',
                        'url': `/user/${id}`
                    }).then(function (response) {
                        $(`#user-${id}`).remove();
                    }).catch(function (error) {
                        console.log(error);
                    })
                }
            })
        }
        function edit(id, name, family, gender, username, nationalCode, entranceTerm) {
            $('#form').prop('action',`/user/${id}`);
            $('#name').val(name);
            $('#family').val(family);
            $('#username').val(username);
            $('#nationalCode').val(nationalCode);
            $('#entranceTerm').val(entranceTerm);
            $(`option[value=${gender}]`).prop('selected',true);
            $('input[name="_method"]').prop('disabled',false);
            $('input[type="submit"]').prop('value','تغییر').removeClass('btn-success').addClass('btn-warning');
            $('#create').collapse('show');
            $('html, body').animate({
                scrollTop: $("#create").offset().top
            }, 500);
        }
    </script>
@endsection