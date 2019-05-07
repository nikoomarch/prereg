@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            @if($errors->any())
                <div class=" row alert alert-danger"><strong>خطا:</strong>&nbsp;{{$errors->first()}}</div>
            @endif
            <form action="{{route('confirm')}}" method="post">
                @csrf
                <p> آقای/خانم {{$user->fullName}} از انتخاب دروس زیر اطمینان دارید؟</p>
                <ul>
                    @foreach($courses as $course)
                        <li>
                            <input type="hidden" name="course[]" value="{{$course->id}}"> {{$course->name}}
                        </li>
                    @endforeach
                </ul>
                <p>مجموع واحد: {{$courses->sum('unit')}}</p>
                <input type="submit" class=" btn btn-success" value="تایید نهایی">
                <a class="btn btn-warning" href="{{route('course.register')}}">بازگشت به مرحله قبل</a>
            </form>
        </div>
    </div>
@endsection
