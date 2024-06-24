@extends('layout.customer')

@section('content')
    <livewire:customer-checkout order_code="{{ $order_code }}"/>
@endsection