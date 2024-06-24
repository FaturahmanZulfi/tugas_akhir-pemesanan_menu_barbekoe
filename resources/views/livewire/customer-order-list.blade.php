<div>
    @php
        $i = 0
    @endphp
    @if($orders)
        @foreach ($orders_detail as $order_detail)
            <div class="card mb-4">
                <div class="card-body">
                <h5 class="card-title">{{ $order_detail->customer_name }}</h5>
                <div class="card-subtitle text-muted mb-1">{{ $orders[$i]["order_code"] }}</div>
                <span class="card-text">
                    {{ "Rp " . number_format($orders[$i]["total_price_with_ppn"], 0, ",", ".")  }}
                </span><br/>
                {{ $order_detail->status->status }}<br/><br/>
                <a href="checkout/{{ $orders[$i]["order_code"] }}" class="card-link">Checkout</a>
                </div>
            </div>
            @php
                $i++;
            @endphp
        @endforeach
    @else
        <h5 class="text-center mt-5">Belum Ada Pesanan</h5>
    @endif

    <div class="buy-now">
        <a href="pesan" class="btn btn-primary btn-buy-now" style="-webkit-box-shadow: 3px 3px 39px -3px rgba(0,0,0,0.75);
-moz-box-shadow: 3px 3px 39px -3px rgba(0,0,0,0.75);
box-shadow: 3px 3px 39px -3px rgba(0,0,0,0.75);">Buat Pesanan Baru</a>
    </div>
</div>
