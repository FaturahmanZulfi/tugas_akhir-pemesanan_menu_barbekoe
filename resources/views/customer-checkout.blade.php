@extends('layout.customer')

@section('content')
    <div>
        <div class="col-md-6 col-lg-6 col-sm-12 offset-lg-3 offset-md-3 mb-3">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Checkout Pesanan</h5>
                <div class="row">
                    <span class="card-text">
                        Nama Pemesan : {{ $order_detail->customer_name }}
                    </span>
                </div>
                <div class="row">
                    <span class="card-text">
                        Kode Pesanan : {{ $order['order_code'] }}
                    </span>
                </div>
                <div class="row">
                    <span class="card-text">
                        Nomor Meja : {{ $order_detail->table_number }}
                    </span>
                </div>
                <div class="row">
                    <span class="card-text">
                        Waktu Pesan : {{ $order_detail->order_time }}
                    </span>
                </div>
                <div class="row">
                    <span class="card-text">
                        Status Pesanan : {{ $order_detail->status->status }}
                    </span>
                </div>
                <div class="row">
                    <span class="card-text">
                        Menu :
                    </span>
                </div>
                
                @php
                    $total = 0;
                @endphp
                @foreach ($menus as $menu) 
                    <div class="row ">
                        <span class="card-text col-6">
                            {{ $menu->menu->menu }} {{ $menu->qty }}x
                        </span>
                        <span class="card-text col-6">
                            {{ $menu->total_price }}
                        </span>
                    </div>
                @endforeach
                <div class="row"><hr></div>
                <div class="row">
                    <span class="card-text offset-6 col-6">
                        {{ $order['total_price'] }}
                    </span>
                </div>
                <div class="row">
                    <span class="card-text col-6">
                        Ppn {{ $order['ppn'] }}%
                    </span>
                    <span class="card-text col-6">
                        {{ $order['total_price']*$order['ppn']/100 }}
                    </span>
                </div>
                <div class="row"><hr></div>
                <div class="row mt-2">
                    <span class="card-text col-6">
                        Total
                    </span>
                    <span class="card-text col-6">
                        {{ $order['total_price_with_ppn'] }}
                    </span>
                </div>
                <a href="javascript:void(0)" class="btn btn-outline-primary mt-3">Go somewhere</a>
              </div>
            </div>
          </div>
    </div>
@endsection