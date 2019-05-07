@extends('layouts.app')
@section('script')
    @if(!is_null($state))
        <script>
            Swal.fire("موفقیت آمیز", "با تشکر از شما", "success");
        </script>
    @endif
@endsection