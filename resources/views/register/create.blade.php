@extends('layouts.app')

@section('content')
<div class="container">
    <div class="justify-content-center">
        @if($errors->any())
            <div class=" row alert alert-danger"><strong>خطا:</strong>&nbsp;{{$errors->first()}}</div>
        @endif
        <form action="{{route('register.store')}}" method="post">
            @csrf
            <p class="text-center size" style="font-size: 18px;"> لطفا <strong> حداکثر {{$selection->max}} واحد</strong> انتخاب کنید و در انتها دکمه <span class="text-success">ثبت</span> را فشار دهید</p>
            @if(count($registeredCourses) != 0)
                <p>شما قبلا درس های زیر را انتخاب کرده اید:</p>
            @endif
            <div class="row">
                @foreach($courses as $course)
                    <div class="col-4 shadow p-3 mb-3 mx-1 bg-white rounded" style="max-width: 32%; padding-right: 4px !important; padding-left: 4px !important;">
                        <div class="form-check">
                            <label class="form-check-label form-check-toggle">
                                <input class="form-check-input" type="checkbox" name="courses[]" value="{{$course->id}}" @if(collect(old('course'))->contains($course->id) or $registeredCourses->find($course->id)) checked @endif>
                                <span>{{$course->name}} ({{$course->unit}} واحد)</span>
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row justify-content-center">
                <input type="submit" class=" btn btn-success" value="ثبت">
            </div>
        </form>
    </div>
</div>
@endsection
