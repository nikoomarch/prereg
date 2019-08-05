@extends('layouts.app')
@section('content')
    <div class="container">
        <a class="btn btn-primary mb-3 col-2" data-toggle="collapse" href="#create" role="button" aria-expanded="false" aria-controls="create">
            ثبت
        </a>
        <div class="collapse" id="create">
            <div class="card card-body">
                <form action="{{route('course.store')}}" method="POST" id="form">
                    @csrf
                    <input type="hidden" name="_method" value="PUT" disabled>
                    <input type="hidden" name="field_id" value="{{Auth::user()->field_id}}"/>
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
                        <label class="text-left col-form-label">تعداد واحد</label>
                        <div class="col-md-3">
                            <input type="number" class="form-control @error('unit') is-invalid @enderror" name="unit" id="unit" value="{{old('unit')}}" >
                            @error('unit')
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
            <td>تعداد واحد</td>
            </thead>
            <tbody>
            @foreach($courses as $course)
                <tr id="course-{{$course->id}}">
                    <td>{{$course->id}}</td>
                    <td>{{$course->name}}</td>
                    <td>{{$course->unit}}</td>
                    <td><a onclick="edit('{{$course->id}}','{{$course->name}}','{{$course->unit}}')" class="btn btn-warning">تغییر</a></td>
                    <td><a class="btn btn-danger" onclick="del({{$course->id}})">حذف</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$courses->links()}}
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
                        'url': `/course/${id}`
                    }).then(function (response) {
                        $(`#course-${id}`).remove();
                    }).catch(function (error) {
                        console.log(error);
                    })
                }
            })
        }
        function edit(id, name, unit) {
            $('#form').prop('action',`/course/${id}`);
            $('#name').val(name);
            $('#unit').val(unit);
            $('input[name="_method"]').prop('disabled',false);
            $('input[type="submit"]').prop('value','تغییر').removeClass('btn-success').addClass('btn-warning');
            $('.collapse').collapse('show');
            $('html, body').animate({
                scrollTop: $("#create").offset().top
            }, 500);
        }
    </script>
@endsection