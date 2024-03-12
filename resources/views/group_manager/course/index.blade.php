@extends('layouts.app')
@section('title')
    دروس
@endsection
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-2">
                        دروس
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-block btn-primary" data-toggle="modal"
                                data-target="#insertModal">
                            ثبت درس جدید
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover mt-3">
                    <thead class="thead-light">
                    <th scope="col">#</th>
                    <th scope="col">نام</th>
                    <th scope="col">تعداد واحد</th>
                    <th scope="col">عملیات</th>
                    </thead>
                    <tbody>
                    @foreach($courses as $course)
                        <tr id="course-{{$course->id}}">
                            <td>{{$course->id}}</td>
                            <td>{{$course->name}}</td>
                            <td>{{$course->unit}}</td>
                            <td>
                                <button class="btn"
                                        onclick="edit('{{$course->id}}','{{$course->name}}','{{$course->unit}}')"
                                        data-toggle="tooltip" data-placement="top" title="تغییر">
                                    <i class="fa fa-edit text-primary fa-lg pointer"></i>
                                </button>
                                <button class="btn"
                                        onclick="del('{{$course->id}}')"
                                        data-toggle="tooltip" data-placement="top" title="حذف">
                                    <i class="fa fa-trash text-danger fa-lg pointer"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{$courses->links()}}
            </div>
        </div>
        @include('group_manager.course.create')
    </div>
@endsection
@section('script')
    <script>
        let fields = ['id', 'name', 'unit'];
        $(document).ready(function () {
            $('#insertModal').on('hide.bs.modal', function (e) {
                $('input[type="submit"]').prop('value', 'ثبت').removeClass('btn-warning').addClass('btn-success');
                $('#id').val('');
                clearErrors(fields);
                clearForm(fields);
            });
        });

        function edit(id, name, unit) {
            $('#id').val(id);
            $('#name').val(name);
            $('#unit').val(unit);
            $('input[type="submit"]').prop('value', 'تغییر');
            $('#insertModal').modal('show');
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
            let unit = $('#unit').val();
            NProgress.start();
            axios({
                method: 'POST',
                url: '/course',
                data: {
                    name: name,
                    unit: unit,
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
            let unit = $('#unit').val();
            NProgress.start();
            axios({
                method: 'PUT',
                url: `/course/${id}`,
                data: {
                    name: name,
                    unit: unit,
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
                        'url': `/course/${id}`
                    }).then(function (response) {
                        $(`#course-${id}`).fadeOut();
                        NProgress.done();
                    }).catch(function (error) {
                        console.log(error);
                    })
                }
            })
        }
    </script>
@endsection
