@extends('layouts.app')
@section('title')
    گزارش
@endsection
@section('content')
    <div class="container">
        <div class="card border-info">
            <div class="card-header bg-info text-white">جستجو در گزارش</div>
            <div class="card-body">
                <form method="GET" action="{{route('report.index')}}">
                    <div class="row justify-content-center">
                        <label class="col-form-label">انتخاب درس</label>
                        <div class="col-3">
                            <select multiple name="courses[]" id="courses" class="form-control">
                                @foreach($courses as $course)
                                    <option value="{{$course->id}}"
                                            @if(collect(app('request')->input('courses'))->contains($course->id)) selected @endif >{{$course->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="col-form-label">انتخاب ترم</label>
                        <div class="col-3">
                            <select name="selection_id" id="selection_id" class="form-control">
                                @foreach($selections as $selection)
                                    <option value="{{$selection->id}}"
                                            @if($defaultSelection->id == $selection->id) selected @endif >{{$selection->term}}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="submit" value="مشاهده گزارش" class="btn btn-outline-primary">
                    </div>
                </form>
            </div>
        </div>
        <div class="card border-info mt-3">
            <div class="card-body">
                <table class="table table-hover table-bordered mt-3">
                    <thead class="thead-light">
                    <th scope="col">ترم ورودی</th>
                    <th scope="col">برادران (تعداد)</th>
                    <th scope="col">خواهران (تعداد)</th>
                    </thead>
                    <tbody>
                    @foreach($termsRegisteredCount as $report)
                        <tr>
                            <th scope="row">{{$report->entranceTerm->code}}</th>
                            <td>
                                {{$report->Male}}
                                @if($report->Male != 0)
                                    <a href="{{route('report.students',['gender'=>'M','entrance_term'=>$report->entranceTerm->id,'courses'=>request('courses'),'selection_id'=>$defaultSelection->id])}}"
                                       class="btn btn-primary mx-2" target="_blank">مشاهده</a>
                                @endif
                            </td>
                            <td>
                                {{$report->Female}}
                                @if($report->Female != 0)
                                    <a href="{{route('report.students',['gender'=>'F','entranceTerm'=>$report->entranceTerm,'courses'=>app('request')->input('courses'),'selection_id' => $defaultSelection->id])}}"
                                       class="mx-2 btn btn-primary" target="_blank">مشاهده</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <tr class="table-success">
                        <td>مجموع</td>
                        <td>{{$termsRegisteredCount->sum('Male')}}</td>
                        <td>{{$termsRegisteredCount->sum('Female')}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @if(app('request')->input('courses') == null)
            <div class="card border-info mt-3">
                <div class="card-header bg-info text-white">تراکم انتخاب دروس</div>
                <div class="card-body">
                    <div class="row p-1 justify-content-around">
                        <div class="col-5 border border-success rounded">
                            <p class="text-center">برادران</p>
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                <th scope="col">#</th>
                                <th scope="col">نام درس</th>
                                <th scope="col">تعداد انتخاب</th>
                                </thead>
                                <tbody>
                                @foreach($menCoursesDensity as $density)
                                    <tr>
                                        <td>{{++$loop->index}}</td>
                                        <td>{{$density->course->name}}</td>
                                        <td>{{$density->total}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-5 border border-danger rounded">
                            <p class="text-center">خواهران</p>
                            <table class="table table-bordered table-hover border-info">
                                <thead class="thead-light">
                                <th scope="col">#</th>
                                <th scope="col">نام درس</th>
                                <th scope="col">تعداد انتخاب</th>
                                </thead>
                                <tbody>
                                @foreach($womenCoursesDensity as $density)
                                    <tr>
                                        <td>{{++$loop->index}}</td>
                                        <td>{{$density->course->name}}</td>
                                        <td>{{$density->total}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="card border-info mt-3">
                <div class="card-header bg-info text-white">دروس هم رخداد</div>
                <div class="card-body">
                    <div class="row p-1 justify-content-around">
                        <div class="col-5 border border-success rounded">
                            <p class="text-center">برادران</p>
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                <th scope="col">#</th>
                                <th scope="col">نام درس</th>
                                <th scope="col">تعداد انتخاب</th>
                                </thead>
                                <tbody>
                                @foreach($menCoOccurredCourses as $course)
                                    <tr>
                                        <td>{{++$loop->index}}</td>
                                        <td>{{$course->course->name}}</td>
                                        <td>{{$course->total}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-5 border border-danger rounded">
                            <p class="text-center">خواهران</p>
                            <table class="table table-bordered table-hover border-info">
                                <thead class="thead-light">
                                <th scope="col">#</th>
                                <th scope="col">نام درس</th>
                                <th scope="col">تعداد انتخاب</th>
                                </thead>
                                <tbody>
                                @foreach($womenCoOccurredCourses as $course)
                                    <tr>
                                        <td>{{++$loop->index}}</td>
                                        <td>{{$course->course->name}}</td>
                                        <td>{{$course->total}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('#courses').select2({theme: 'bootstrap4'})
        })
    </script>
@endsection
