@extends('layouts.app')
@section('title')
    مدیران گروه
@endsection
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-2">
                        مدیران گروه
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#insertModal">
                            ثبت مدیر گروه جدید
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-hover mt-3">
                    <thead class="thead-light">
                    <th scope="col">#</th>
                    <th scope="col">نام</th>
                    <th scope="col">نام خانوادگی</th>
                    <th scope="col">رشته</th>
                    <th scope="col">نام کاربری</th>
                    <th scope="col">تغییر</th>
                    <th scope="col">حذف</th>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr id="user-{{$user->id}}">
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->family}}</td>
                            <td>{{$user->field->name}}</td>
                            <td>{{$user->username}}</td>
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
            <div class="card-footer clearfix">
                {{$users->links()}}
            </div>
        </div>
        @include('admin.user.create')
    </div>
@endsection
@section('script')
    <script>
        let fields = ['name','family','field','username','password','confirm'];
        $(document).ready(function () {
            $('#insertModal').on('hide.bs.modal', function (e) {
                $('input[type="submit"]').prop('value', 'ثبت').removeClass('btn-warning').addClass('btn-success');
                $('#id').val('').prop('disabled', true);
                clearErrors(fields);
                clearForm(fields);
            });
        });

        function edit(id) {
            NProgress.start();
            axios({
                'method': 'GET',
                'url': `/admin/user/${id}`,
            }).then(function (response) {
                NProgress.done();
                let data = response.data;
                $('#id').val(data.id);
                $('#name').val(data.name);
                $('#family').val(data.family);
                $('#username').val(data.username);
                $(`#field`).val(data.field.name);
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
            let field = $('#field').val();
            let username = $('#username').val();
            let password = $('#password').val();
            let confirm = $('#confirm').val();
            NProgress.start();
            axios({
                method: 'POST',
                url: '/admin/user',
                data: {
                    name: name,
                    family: family,
                    field: field,
                    username: username,
                    password: password,
                    confirm: confirm,
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
            let field = $('#field').val();
            let username = $('#username').val();
            let password = $('#password').val();
            let confirm = $('#confirm').val();
            NProgress.start();
            axios({
                method: 'PUT',
                url: `/admin/user/${id}`,
                data: {
                    name: name,
                    family: family,
                    field: field,
                    username: username,
                    password: password,
                    confirm: confirm,
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
                        'url': `/admin/user/${id}`
                    }).then(function (response) {
                        $(`#user-${id}`).fadeOut();
                        NProgress.done();
                    }).catch(function (error) {
                        console.log(error);
                    })
                }
            })
        }
    </script>
@endsection
