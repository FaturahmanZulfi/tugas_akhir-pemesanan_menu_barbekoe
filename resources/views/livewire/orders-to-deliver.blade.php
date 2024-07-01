<div>
    <div wire:poll.keep-alive.100ms>
        <div class="card mb-4">
            <div class="row px-4 py-3">
                <div class="mt-2 mb-2 col-lg-6 col-md-6 col-sm-12">
                    <button type="button" wire:click="changeCategory('makanan')" class="col-12 btn btn-outline-dark @if($category=="makanan") active @endif">
                        Makanan
                        <span class="badge">{{ $countmakanan }}</span>
                    </button>
                </div>
                <div class="mt-2 mb-2 col-lg-6 col-md-6 col-sm-12">
                    <button type="button" wire:click="changeCategory('minuman')" class="col-12 btn btn-outline-dark @if($category=="minuman") active @endif">
                        Minuman
                        <span class="badge">{{ $countminuman }}</span>
                    </button>
                </div>
            </div>
        </div>
        @foreach ($orders as $order)
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">{{ $order->customer_name }}</h5>
                <div class="card-subtitle text-muted mb-1">{{ $order->order_code }}</div>
                <span class="card-text">
                    Nomor Meja : {{ $order->table_number }}
                </span><br>
                <span>{{ $order->status }}</span>
                <span class="card-text">
                    {{ $order->order_time }}
                </span><br><br>
                <button wire:click="getOrder('{{ $order->order_code }}')"
                    class="btn btn-dark col-lg-3 col-md-4 col-sm-3" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#detailOffcanvas" aria-controls="offcanvasEnd">
                    Detail
                </button>
            </div>
        </div>
        @endforeach
    </div>

    <div wire:ignore.self class="offcanvas offcanvas-end border-3" data-bs-scroll="true" data-bs-backdrop="false"
        tabindex="-1" id="detailOffcanvas" aria-labelledby="offcanvasEndLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasEndLabel" class="offcanvas-title">Detail Pesanan</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            @if ($customer)
                <span>Nama : {{ $customer->customer_name }}</span><br />
                <span>Kode Pesanan : {{ $order_code }}</span><br />
                <span>Waktu Pesan : {{ $customer->order_time }}</span><br />
                <span>Nomor Meja : {{ $customer->table_number }}</span><br /><br />
            @endif
            <span>Pesanan :</span><br>
            @foreach($menus as $menu)
                <span class="text-bold">
                    {{ $menu->menu.' '.'x'.$menu->qty}}
                </span><br>
            @endforeach
            <br>
            <button wire:click="updateStatus()" wire:confirm="Pesanan Sudah Diantar ?" type="button"
                class="btn btn-dark mb-2 d-grid w-100">Pesanan Sudah Diantar</button>
            <button type="button" class="btn btn-outline-secondary d-grid w-100" data-bs-dismiss="offcanvas">
                Batal
            </button>
        </div>
    </div>
</div>