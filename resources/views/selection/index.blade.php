@extends('layouts.app')
@section('content')
    <div class="container">
         <div class="card card-body">
            <form action="{{route('selection.store')}}" method="POST" id="form">
                @csrf
                <input type="hidden" name="_method" value="PUT" disabled>
                <input type="hidden" name="field_id" value="{{Auth::user()->field_id}}">
                <div class="form-group row justify-content-center">
                    <label class="text-left col-form-label">ترم ها</label>
                    <div class="col-md-3">
                        <select class="form-control @error('terms') is-invalid @enderror" name="terms[]" multiple="multiple">
                            @foreach($terms as $term)
                                <option value="{{$term->code}}" @if($selection!= null and collect($selection->terms)->contains($term->code)) selected @endif>{{$term->code}}</option>
                            @endforeach
                        </select>
                        @error('term_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <label class="text-left col-form-label">تاریخ شروع</label>
                    <div class="col-md-2 mb-4">
                        <input type="text" class="form-control @error('startDate') is-invalid @enderror" id="startDate" value="@isset($selection) {{$selection->startDate}} @endisset" />
                        <input type="hidden" name="startDate" id="startDateAlt">
                        @error('startDate')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <label class="text-left col-form-label">تاریخ پایان</label>
                    <div class="col-md-2 mb-4">
                        <input type="text" class="form-control @error('endDate') is-invalid @enderror" id="endDate" value="@isset($selection) {{$selection->endDate}} @endisset"/>
                        <input type="hidden" name="endDate" id="endDateAlt">
                        @error('endDate')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <label class="text-left col-form-label">حداکثر تعداد واحد</label>
                    <div class="col-md-2 mb-4">
                        <input type="text" class="form-control @error('max') is-invalid @enderror" name="max" id="max" value="@isset($selection) {{$selection->max}} @endisset"/>
                        @error('max')
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
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('#startDate').pDatepicker({
                autoClose: true,
                format: 'YYYY/MM/DD',
                altField: '#startDateAlt',
                altFormat: 'X',
                toolbox: {
                    calendarSwitch: {
                        enabled: false
                    }
                },
                initialValueType: 'gregorian'
            });
            $('#endDate').pDatepicker({
                autoClose: true,
                format: 'YYYY/MM/DD',
                altField: '#endDateAlt',
                altFormat: 'X',
                toolbox: {
                    calendarSwitch: {
                        enabled: false
                    }
                },
                initialValueType: 'gregorian'
            });
            $('select[name="terms[]"]').select2({dir: 'rtl'});
        });
    </script>
@endsection