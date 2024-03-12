@extends('layouts.app')
@section('title')
    دانشجویان
@endsection
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-2">
                        دانشجویان
                    </div>
                    <div class="col-1">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa-ellipsis-v fa"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <button type="button" class="dropdown-item" data-toggle="modal"
                                        data-target="#insertModal">
                                    ثبت
                                </button>
                                <a class="dropdown-item" href="{{route('group-manager.user.create-from-file')}}">ثبت گروهی</a>
                                <button type="button" class="dropdown-item" data-toggle="modal"
                                        data-target="#bulkDeleteModal">
                                    حذف گروهی
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if(!request()->has('student_code'))
                    <div class="alert alert-info">
                        <span>تعداد کل دانشجویان:</span> <span class="font-weight-bold">{{$totalUsersCount}}</span><br/>
                        <span>تعداد دانشجویان مجاز به ورود:</span> <span class="font-weight-bold">{{$maleAllowedCount}} <span>مرد،</span> {{$femaleAllowedCount}} <span>زن</span></span>
                    </div>
                @endif
                <div class="row justify-content-center">
                    <form action="{{route('group-manager.user.index')}}" method="GET" class="form-inline">
                        <div class="form-row">
                            <input type="text" class="form-control" name="student_code" value="{{request('student_code')}}" placeholder="شماره دانشجویی"/>
                            <button type="submit" class="btn btn-primary mx-1"><i class="fa fa-search fa-lg text-white pointer"></i></button>
                            @if(request()->hasAny('student_code'))
                                <div class="col-md-auto col-auto">
                                    <a href="{{route('group-manager.user.index')}}" class="btn btn-block btn-danger" data-toggle="tooltip" data-placement="top" title="حذف فیلترها">
                                        <i class="fa fa-filter fa-lg pointer"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
                <table class="table table-hover mt-3 mt-3">
                    <thead class="thead-light">
                    <th scope="col">#</th>
                    <th scope="col">نام</th>
                    <th scope="col">نام خانوادگی</th>
                    <th scope="col">جنسیت</th>
                    <th scope="col">نام کاربری</th>
                    <th scope="col">امکان ورود</th>
                    <th scope="col">عملیات</th>
                    <th scope="col">عملیات</th>
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
                                    <span
                                        @class([
                                            'fa',
                                            'fa-check text-success' => $user->is_allowed,
                                            'fa-times text-danger' => !$user->is_allowed
                                        ])></span>
                            </td>
                            <td>
                                <button class="btn"
                                        onclick="edit('{{$user->id}}')"
                                        data-toggle="tooltip" data-placement="top" title="تغییر">
                                    <i class="fa fa-user-edit text-primary fa-lg pointer"></i>
                                </button>
                            </td>
                            <td>
                                <button class="btn"
                                        onclick="del('{{$user->id}}')"
                                        data-toggle="tooltip" data-placement="top" title="حذف">
                                    <i class="fa fa-user-minus text-danger fa-lg pointer"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer clearfix">
            {{$users->links()}}
        </div>
        </div>
    </div>
    @include('group_manager.user.create')
    @include('group_manager.user.bulk_delete')
@endsection
@section('script')
    <script>
        let fields = ['name', 'family', 'gender', 'username', 'national_code', 'entrance_term_id', 'is_allowed'];
        $(document).ready(function () {
            $('#insertModal').on('hide.bs.modal', function (e) {
                $('input[type="submit"]').prop('value', 'ثبت').removeClass('btn-warning').addClass('btn-success');
                $('#id').val('').prop('disabled', true);
                clearErrors(fields);
                clearForm(fields);
                $('#is_allowed').prop('checked', false);
            });
            $('select[name="terms[]"]').select2({theme: 'bootstrap4'});
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
                    NProgress.start();
                    axios({
                        'method': 'DELETE',
                        'url': `/group-manager/user/${id}`
                    }).then(function (response) {
                        $(`#user-${id}`).fadeOut();
                        NProgress.done();
                    }).catch(function (error) {
                        console.log(error);
                    })
                }
            })
        }

        function edit(id) {
            NProgress.start();
            axios({
                'method': 'GET',
                'url': `/group-manager/user/${id}`,
            }).then(function (response) {
                NProgress.done();
                let data = response.data;
                $('#id').val(data.id);
                $('#name').val(data.name);
                $('#family').val(data.family);
                $('#gender').val(data.gender);
                $('#username').val(data.username);
                $('#national_code').val(data.national_code);
                $('#entrance_term_id').val(data.entrance_term_id);
                if (data.is_allowed)
                    $('#is_allowed').prop('checked', true);
                $('input[type="submit"]').prop('value', 'تغییر').removeClass('btn-success').addClass('btn-warning');
                $('#insertModal').modal('show');
            }).catch(function (error) {
                console.log(error);
            });
        }

        function create() {
            event.preventDefault();
            clearErrors(fields);
            let id = $('#id').val();
            if (id == '')
                store();
            else
                update(id);
        }

        function store() {
            let name = $('#name').val();
            let family = $('#family').val();
            let gender = $('#gender').val();
            let username = $('#username').val();
            let national_code = $('#national_code').val();
            let entrance_term_id = $('#entrance_term_id').val();
            let is_allowed = $('#is_allowed:checkbox:checked').length > 0;

            NProgress.start();
            axios({
                method: 'POST',
                url: '/group-manager/user',
                data: {
                    name: name,
                    family: family,
                    gender: gender,
                    username: username,
                    national_code: national_code,
                    entrance_term_id: entrance_term_id,
                    is_allowed: is_allowed
                }
            }).then(function (res) {
                NProgress.done();
                Swal.fire({
                    title: 'موفقیت آمیز',
                    text: "با موفقیت انجام شد.",
                    type: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'خب!',
                }).then((result) => {
                    location.reload();
                })
            }).catch(function (error) {
                let errors = error.response.data.errors;
                Object.keys(errors).forEach(function (index) {
                    $('#' + index).addClass('is-invalid');
                    $('#' + index + '-error').text(errors[index]);
                });
                NProgress.done();
            })
        }

        function update(id) {
            let name = $('#name').val();
            let family = $('#family').val();
            let gender = $('#gender').val();
            let username = $('#username').val();
            let national_code = $('#national_code').val();
            let entrance_term_id = $('#entrance_term_id').val();
            let is_allowed = $('#is_allowed:checkbox:checked').length > 0;
            NProgress.start();
            axios({
                method: 'PUT',
                url: `/group-manager/user/${id}`,
                data: {
                    name: name,
                    family: family,
                    gender: gender,
                    username: username,
                    national_code: national_code,
                    entrance_term_id: entrance_term_id,
                    is_allowed: is_allowed
                }
            }).then(function (res) {
                NProgress.done();
                Swal.fire({
                    title: 'موفقیت آمیز',
                    text: "با موفقیت انجام شد.",
                    type: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'خب!',
                }).then((result) => {
                    location.reload();
                })
            }).catch(function (error) {
                let errors = error.response.data.errors;
                Object.keys(errors).forEach(function (index) {
                    $('#' + index).addClass('is-invalid');
                    $('#' + index + '-error').text(errors[index]);
                });
                NProgress.done();
            })
        }

        function bulkDelete() {
            event.preventDefault();
            let terms = $('select[name="terms[]"]').val();
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
                    NProgress.start();
                    axios({
                        'method': 'DELETE',
                        'url': `/group-manager/user/bulk-delete/`,
                        data: {
                            terms: terms
                        }
                    }).then(function (response) {
                        NProgress.done();
                        Swal.fire({
                            title: 'موفقیت آمیز',
                            text: "با موفقیت انجام شد.",
                            type: 'success',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'خب!',
                        }).then((result) => {
                            location.reload();
                        })
                    }).catch(function (error) {
                        console.log(error);
                    })
                }
            })
        }
    </script>
@endsection
