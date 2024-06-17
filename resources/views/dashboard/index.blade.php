@extends('layout.admin.main')
@section('content')
    @switch(Auth::user()->role)
        @case(1)
            @include('dashboard.superadmin')
        @break

        @case(2)
            @include('dashboard.admin')
        @break
    @endswitch
@endsection
