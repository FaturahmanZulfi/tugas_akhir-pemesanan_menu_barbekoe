@extends('layout/navs')

@section('content')
    @if(Auth::user()->level_id == 3)
        @livewire('orders-table')
    @elseif(Auth::user()->level_id == 4 || Auth::user()->level_id == 5)
        @livewire('orders-to-prepare')
    @elseif(Auth::user()->level_id == 6)
        @livewire('orders-to-deliver')
    @endif
@endsection