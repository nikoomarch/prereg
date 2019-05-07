@extends('layouts.app')

@section('content')
<div class="container">
    <div class="justify-content-center">
        @if(\Illuminate\Support\Facades\Auth::user()->courses()->count()!=0)
            <div class=" row alert alert-danger">شما قبلا انتخاب واحد کرده اید!</div>
        @else
            @if($errors->any())
                <div class=" row alert alert-danger"><strong>خطا:</strong>&nbsp;{{$errors->first()}}</div>
            @endif
            <form action="{{route('store')}}" method="post">
                @csrf
                <p>آقای/خانم {{\Illuminate\Support\Facades\Auth::user()->fullName}} لطفا <strong> حداکثر 18 واحد</strong> انتخاب کنید.</p>
                <div class="row">
                    @foreach($courses as $course)
                        <div class="col-3 mb-4">
                            <input type="checkbox" name="course[]" value="{{$course->id}}"> {{$course->name}} ({{$course->unit}} واحد)
                        </div>
                    @endforeach
                </div>
                <input type="submit" class=" btn btn-success btn-block" value="ثبت">
            </form>
        @endif
    </div>
</div>
@endsection
