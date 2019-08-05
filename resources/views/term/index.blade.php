@extends('layouts.app')
@section('content')
    <div class="container">
        <a class="btn btn-primary mb-3 col-2" data-toggle="collapse" href="#create" role="button" aria-expanded="false" aria-controls="create">
            ثبت
        </a>
        <div class="collapse" id="create">
            <div class="card card-body">
                <form action="{{route('term.store')}}" method="POST" id="form">
                    @csrf
                    <div class="form-group row">
                        <label class="text-left col-sm-2 col-form-label">کد</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" id="code" value="{{old('code')}}" >
                            @error('code')
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
            <td>کد</td>
            </thead>
            <tbody>
            @foreach($terms as $term)
                <tr id="term-{{$term->code}}">
                    <td>{{$term->code}}</td>
                    <td><a class="btn btn-danger" onclick="del({{$term->code}})">حذف</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$terms->links()}}
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
                        'url': `/term/${id}`
                    }).then(function (response) {
                        $(`#term-${id}`).remove();
                    }).catch(function (error) {
                        console.log(error);
                    })
                }
            })
        }
    </script>
@endsection