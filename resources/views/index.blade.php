@extends('layout.customer')

@section('content')
<div class="row">
    <div class="col-12 mb-4 order-0">
        <img src="/assets/home/coffee.png" alt="">
      <div class="" style="background-image: 'assets/home/coffee.png' ">
        <div class="d-flex row">
          <div class="col-12">
            <h1 class="text-center text-dark" style="font-family:incosolata;font-size:80px"><b>NO<br/>WORDS<br/>BUT<br/>COFFEE</b></h1>
          </div>
          {{-- <div class="col-6">
            <img
                src="assets/img/home/coffee.png"
                width="30%"
                alt="Coffee"
                data-app-dark-img="illustrations/man-with-laptop-dark.png"
                data-app-light-img="illustrations/man-with-laptop-light.png"
              />
          </div> --}}
        </div>
      </div>
    </div>
  </div>
  <hr>
  <div class="row mt-5 mb-3">
    <div class=" mb-4 mb-lg-0">
        <div class="card-body">
          <figure class="text-center">
            <blockquote class="blockquote">
              <p class="mb-0">Setiap cangkir kopi adalah perjalanan baru dalam dunia rasa, mengungkapkan keajaiban yang tak terduga.</p>
            </blockquote>
            <figcaption class="blockquote-footer">
              <cite title="Source Title">Someone</cite>
            </figcaption>
          </figure>
        </div>
      </div>
  </div>
  <hr>
  <div class="row">
    <h6>Menu Menu Kami : </h6>
    <div class="row px-4">
        @foreach ($menus as $menu)
        <div class="col-lg-3 col-md-4 col-sm-12">
            <div class="card mb-3">
                <div class="text-center"><img src="{{ asset('storage/'.$menu->picture) }}" alt="Card image cap" height="150px"/></div>
                <div class="card-body">
                <h5 class="card-title">{{ $menu->menu }}</h5>
                </div>
            </div>
        </div>
        @endforeach
    </div>
  </div>
    <div class="buy-now">
        <a href="/scan" class="btn btn-dark btn-buy-now" style="-webkit-box-shadow: 3px 3px 39px -3px rgba(0,0,0,0.75);
        -moz-box-shadow: 3px 3px 39px -3px rgba(0,0,0,0.75);
        box-shadow: 3px 3px 39px -3px rgba(0,0,0,0.75);">
            Pesan Sekarang
        </a>
    </div>
    {{-- @livewire('menus-list') --}}
@endsection 