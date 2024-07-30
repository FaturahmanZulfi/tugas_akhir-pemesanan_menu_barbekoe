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
                    Status Pesanan : {{ $order_status }}
                </span>
            </div>
            <div class="row">
                <span class="card-text">
                    Menu :
                </span>
            </div>
            <div class="mt-2"></div>
            @php
                $total = 0;
            @endphp
            @foreach ($menus as $menu) 
                <div class="row mb-2">
                    <span class="card-text col-6">
                        {{ $menu->menu->menu }} {{ $menu->qty }}x
                    </span>
                    <span class="card-text col-6">
                        {{ "Rp " . number_format($menu->total_price, 0, ",", ".") }}
                    </span>
                </div>
            @endforeach
            <div class="row"><hr></div>
            <div class="row">
                <span class="card-text offset-6 col-6">
                    {{ "Rp " . number_format($order['total_price'], 0, ",", ".") }}
                </span>
            </div>
            <div class="row">
                <span class="card-text col-6">
                    Ppn {{ $order['ppn'] }}%
                </span>
                <span class="card-text col-6">
                    {{ "Rp " . number_format($order['total_price']*$order['ppn']/100, 0, ",", ".") }}
                </span>
            </div>
            <div class="row"><hr></div>
            <div class="row mt-2">
                <span class="card-text col-6">
                    Total
                </span>
                <span class="card-text col-6">
                    {{ "Rp " . number_format($order['total_price_with_ppn'], 0, ",", ".") }}
                </span>
            </div>
            @if($order_status == "Belum Dibayar")
            <button type="button" class="btn btn-primary mt-3" id="pay-button">Bayar Sekarang</button>
            @endif
            <a href="/pesanan-saya" class="btn btn-warning mt-3">Pesanan Saya</a>
            @if ($order_status != "Belum Dibayar")
                <button class="btn btn-dark mt-3" wire:click="generatePdf()">Download Struk</button>
            @endif
          </div>
        </div>
      </div>

    @assets  
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    @endassets
    @script
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function(){
        // SnapToken acquired from previous step
        snap.pay("{{ $order['snap_token'] }}", {
            onSuccess: function(result){
                @this.updateStatus();
            },
            // Optional
            onPending: function(result){
                console.log(result);
                /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            },
            // Optional
            onError: function(result){
                console.log(result);
            /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            }
        });
        };
    </script>
    @endscript
</div>
