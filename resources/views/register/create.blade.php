@extends('layouts.app')

@section('content')
<div class="container">
    <div class="justify-content-center">
        @if($errors->any())
            <div class=" row alert alert-danger"><strong>خطا:</strong>&nbsp;{{$errors->first()}}</div>
        @endif
        <form action="{{route('register.store')}}" method="post">
            @csrf
            <p class="text-center size" style="font-size: 18px;"> لطفا <strong> حداکثر 18 واحد</strong> انتخاب کنید و در انتها دکمه <span class="text-success">ثبت</span> را فشار دهید</p>
            <div class="row">
                @foreach($courses as $course)
                    <div class="col-3 mb-4">
                        <input type="checkbox" name="course[]" value="{{$course->id}}"> {{$course->name}} ({{$course->unit}} واحد)
                    </div>
                @endforeach
            </div>
            <input type="submit" class=" btn btn-success btn-block" value="ثبت">
        </form>
    </div>
</div>
@endsection
