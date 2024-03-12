@extends('layouts.app')
@section('title')
    سر ترم ها
@endsection
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-2">
                        ترم ها
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-block btn-primary" data-toggle="modal"
                                data-target="#insertModal">
                            ثبت ترم جدید
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-hover mt-3 table-bordered">
                    <thead class="thead-light">
                    <th scope="col">ترم</th>
                    <th scope="col">حذف</th>
                    </thead>
                    <tbody>
                    @foreach($terms as $term)
                        <tr id="term-{{$term->id}}">
                            <td>{{$term->code}}</td>
                            <td>
                                <button class="btn"
                                        onclick="del('{{$term->id}}')"
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
                {{$terms->links()}}
            </div>
        </div>
        @include('admin.term.create')
    </div>
@endsection
@section('script')
    <script>
        let fields = ['code'];
        $(document).ready(function () {
            $('#insertModal').on('hide.bs.modal', function (e) {
                $('input[type="submit"]').prop('value', 'ثبت').removeClass('btn-warning').addClass('btn-success');
                $('#id').val('');
                clearErrors(fields);
                clearForm(fields);
            });
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
                        'url': `/term/${id}`
                    }).then(function (response) {
                        $(`#term-${id}`).fadeOut();
                        NProgress.done();
                    }).catch(function (error) {
                        console.log(error);
                    })
                }
            })
        }

        function create() {
            event.preventDefault();
            clearErrors(fields);
            let id = $('#id').val();
            store();
        }

        function store() {
            event.preventDefault();
            let code = $('#code').val();
            NProgress.start();
            axios({
                method: 'post',
                url: '/term',
                data: {
                    code: code,
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
                console.log(errors);
                Object.keys(errors).forEach(function (index) {
                    $('#' + index).addClass('is-invalid');
                    $('#' + index + '-error').text(errors[index]);
                });
                NProgress.done();
            })
        }
    </script>
@endsection
