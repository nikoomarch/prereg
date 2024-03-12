@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card border-info mt-3">
            <div class="card-header text-center">
                لیست دانشجویان
                <span class="font-weight-bold">{{request('gender') == 'M'? 'مرد':'زن'}}</span>
                <span>ورودی ترم </span><span class="font-weight-bold">{{$entranceTerm->code}}</span>
                @if(count(request()->get('courses',[])))
                    <span>که دروس (</span>
                    <span class="font-weight-bold">
                        {{implode(' - ', $courses->pluck('name')->toarray())}}
                    </span>
                    <span>) را انتخاب کرده اند.</span>
                @else
                    <span>که انتخاب واحد کرده اند.</span>
                @endif
            </div>
            <div class="card-body">
                <table class="table table-hover mt-3">
                    <thead class="thead-light">
                    <th scope="col">شماره دانشجویی</th>
                    <th scope="col">نام</th>
                    <th scope="col">نام خانوادگی</th>
                    <th scope="col">مشاهده لیست دروس</th>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <th scope="row">{{$user->username}}</th>
                            <td>{{$user->name}}</td>
                            <td>{{$user->family}}</td>
                            <td>
                                <a class="btn btn-info pointer" onclick="courses('{{$user->id}}','{{$user->name . " " . $user->family}}')">مشاهده</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$users->withQueryString()->links()}}
            </div>
        </div>
        <div class="modal fade" id="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-hover">
                            <thead class="table-info">
                                <th scope="col">#</th>
                                <th scope="col">نام درس</th>
                            </thead>
                            <tbody id="table-body">
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        let selection_id = {{request('selection_id')}};
        function courses(id, full_name) {
            NProgress.start();
            axios({
                method: 'GET',
                url: `/report/courses/${id}?selection_id=${selection_id}`,
            }).then(function (res) {
                let body = '';
                let data = res.data;
                data.forEach(function (element, key) {
                    body += `<tr>
                                <td>${++key}</td>
                                <td>${element.name}</td>
                            </tr>`
                });
                $('#modal-title').text(`لیست دروس انتخاب شده ی ${full_name}`);
                $('#table-body').html(body);
                $('#modal').modal('show');
                NProgress.done();
            })
        }
    </script>
@endsection
