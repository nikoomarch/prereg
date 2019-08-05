@extends('layouts.app')
@section('content')
    <div class="container">
        <a class="btn btn-primary mb-3 col-2" data-toggle="collapse" href="#create" role="button" aria-expanded="false" aria-controls="create">
            ثبت
        </a>
        <div class="collapse" id="create">
            <div class="card card-body">
                <form action="{{route('field.store')}}" method="POST" id="form">
                    @csrf
                    <input type="hidden" name="_method" value="PUT" disabled>
                    <div class="form-group row">
                        <label class="text-left col-sm-2 col-form-label">نام</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{old('name')}}" >
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <input type="submit" value="ثبت" class="btn btn-success">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <table class="table table-striped mt-3">
            <thead>
            <td>#</td>
            <td>کد</td>
            </thead>
            <tbody>
            @foreach($fields as $field)
                <tr id="field-{{$field->id}}">
                    <td>{{$field->id}}</td>
                    <td>{{$field->name}}</td>
                    <td><a onclick="edit('{{$field->id}}','{{$field->name}}')" class="btn btn-warning">تغییر</a></td>
                    <td><a class="btn btn-danger" onclick="del({{$field->id}})">حذف</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$fields->links()}}
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
                        'url': `/field/${id}`
                    }).then(function (response) {
                        $(`#field-${id}`).remove();
                    }).catch(function (error) {
                        console.log(error);
                    })
                }
            })
        }
        function edit(id, name) {
            $('#form').prop('action',`/field/${id}`);
            $('#name').val(name);
            $('input[name="_method"]').prop('disabled',false);
            $('input[type="submit"]').prop('value','تغییر').removeClass('btn-success').addClass('btn-warning');
            $('.collapse').collapse('show');
            $('html, body').animate({
                scrollTop: $("#create").offset().top
            }, 500);
        }
    </script>
@endsection