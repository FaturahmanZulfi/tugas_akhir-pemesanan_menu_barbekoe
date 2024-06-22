<div>
    <div class="card p-3">
        <h4 class="fw-bold card-header">Tabel Pesanan</h4>
        <di class="row px-4">
            <div class="row mb-2">
                <button wire:click="getPpn()" type="button" class="col-lg-2 col-md-3 col-sm-6 btn btn-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#ppnModal">
                    Ppn : {{ $used_ppn }}%
                </button>
            </div>
            <div class="row">
                <button wire:click="rset()" class="col-lg-3 col-md-4 col-sm-5 btn btn-primary" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#createOrder">
                    Tambah Pesanan
                </button>
            </div>
        </di>
        <div class="row px-4 mt-3">
            <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                <div class="row">
                    <div class="col-3">
                        <select wire:model.live="perPage" id="perPage" class="form-select col-3">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                    <div class="col-6 mt-2">
                        <label for="perPage" class="form-label">Data Per Halaman</label>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 offset-lg-3 offset-md-2">
                <div class="input-group input-group-merge">
                    <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                    <input wire:model.live="search" type="text" class="form-control" placeholder="Cari User"/>
                </div>
            </div>
        </div>
        <div class="table-responsive mt-4 mx-2">
            <table class="table table-borderless" wire:poll.keep-alive.100ms>
                <thead>
                    <tr>
                        <th>Data Pelanggan</th>
                        <th>Total Bayar</th>
                        <th>Waktu Pesan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>
                            {{ $order->order_code }} <br>
                            {{ $order->customer_name }} <br>
                            {{ $order->table_number }}
                        </td>
                        <td>
                            {{ $order->withPpnOrder->total_price_with_ppn }}
                        </td>
                        <td>
                            {{ $order->order_time }}
                        </td>
                        <td>{{ $order->status->status }}</td>
                        <td>
                            <button wire:click="getOrder('{{ $order->order_code }}')" class="btn btn-warning" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#updateOrder">
                                Ubah
                            </button>
                            <button wire:click="getOrder('{{ $order->order_code }}')" class="btn btn-danger" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#deleteOrder">
                                Hapus
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row px-4 mt-4">{{ $orders->links(data: ['scrollTo' => false]) }}</div>
    </div>

    {{-- update ppn modal --}}
    <div wire:ignore.self class="offcanvas offcanvas-end border-3" data-bs-scroll="true" data-bs-backdrop="false"
        tabindex="-1" id="ppnModal" aria-labelledby="offcanvasTopLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasTopLabel" class="offcanvas-title">Ubah Ppn ?</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form wire:submit="updatePpn">
                <div class="mb-3">
                    <label class="form-label" for="ppn">Ppn</label>
                    <input wire:model="ppn" type="number"
                        class="form-control @error('ppn') is-invalid @enderror" id="ppn"
                        placeholder="Masukkan Ppn Baru" />
                    @error('ppn')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-dark me-2">Simpan</button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">
                    Batal
                </button>
            </form>
        </div>
    </div>

    {{-- insert order modal --}}
    <div wire:ignore.self class="offcanvas offcanvas-end border-3" data-bs-scroll="true" data-bs-backdrop="false"
        tabindex="-1" id="createOrder" aria-labelledby="offcanvasTopLabel" style="width: 60%">
        <div class="offcanvas-header">
            <h5 id="offcanvasTopLabel" class="offcanvas-title">Tambah Data Pesanan</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form wire:submit="createNewOrder">
                <div class="mb-3">
                    <label class="form-label" for="customer_name">Nama Pemesan</label>
                    <input wire:model="customer_name" type="text"
                        class="form-control @error('customer_name') is-invalid @enderror" id="customer_name"
                        placeholder="Masukkan Nama Pemesan" />
                    @error('customer_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="table_number">Nomor Meja</label>
                    <input wire:model="table_number" type="number"
                        class="form-control @error('table_number') is-invalid @enderror" id="table_number"
                        placeholder="Masukkan Nomor Meja" />
                    @error('table_number')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status Pesanan</label>
                    <select wire:model="status_id" id="status" class="form-select">
                        @foreach($statuses as $status)
                        <option value="{{ $status->id }}">{{ $status->status }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row" wire:poll.keep-alive.100ms>
                    <div class="row">
                        <label class="form-label col-4">Pilih Menu</label>@error('menu_id')<span style="font-size:13px;color:#fc3f1f">{{ $message }}</span>@enderror
                    </div>
                    <div class="row">
                    @foreach($menus as $menu)
                    <div class="col-md-6 col-lg-4 mb-5">
                        <div class="card">
                            <img class="card-img-top" style="object-fit:contain" height="150px"
                                src="{{ asset('storage/'.$menu->picture) }}" />
                            <div class="card-body" style="width: 100%;">
                                <div class="row">
                                    <div class="col-1">
                                        @if($menu->stock >= 1)
                                            <input class="form-check-input" type="checkbox" id="checkbox{{ $menu->id }}" onclick="updateQty({{ $menu->id }})"/>
                                        @else

                                        @endif
                                    </div>
                                    <div class="col-10">
                                        <label class="form-check-label" style="display: block;" for="checkbox{{ $menu->id }}"> 
                                            {{ $menu->menu.' ('.$menu->stock.')' }} <br>
                                            <small class="text-muted ms-1">{{ $menu->price }}</small>
                                        </label>
                                    </div>
                                </div>
                                @if($menu->stock >= 1)
                                <div class="row">
                                    <label for="qty{{ $menu->id }}" class="col-md-5 col-form-label">Qty</label>
                                    <div class="col-md-7">
                                        <input class="form-control" max="{{ $menu->stock }}" wire:model="menu_id.{{ $menu->id }}" type="number" id="qty{{ $menu->id }}" onload="updateCheckbox({{ $menu->id }}, {{ $menu->stock }})" oninput="updateCheckbox({{ $menu->id }}, {{ $menu->stock }})"/>
                                    </div>
                                </div>
                                @else

                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                    </div>
                </div>
                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">
                    Batal
                </button>
            </form>
        </div>
    </div>

    {{-- update order modal --}}
    <div wire:ignore.self class="offcanvas offcanvas-end border-3" data-bs-scroll="true" data-bs-backdrop="false"
        tabindex="-1" id="updateOrder" aria-labelledby="offcanvasTopLabel" style="width: 60%">
        <div class="offcanvas-header">
            <h5 id="offcanvasTopLabel" class="offcanvas-title">Ubah Data Pesanan</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form wire:submit="updateOrder">
                <div class="mb-3">
                    <label class="form-label" for="customer_name">Nama Pemesan</label>
                    <input wire:model="customer_name" type="text"
                        class="form-control @error('customer_name') is-invalid @enderror" id="customer_name"
                        placeholder="Masukkan Nama Pemesan" disabled/>
                    @error('customer_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="table_number">Nomor Meja</label>
                    <input wire:model="table_number" type="number"
                        class="form-control @error('table_number') is-invalid @enderror" id="table_number"
                        placeholder="Masukkan Nomor Meja" disabled/>
                    @error('table_number')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status Pesanan</label>
                    <select wire:model="status_id" id="status" class="form-select">
                        @foreach($statuses as $status)
                        <option value="{{ $status->id }}">{{ $status->status }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    <div class="row">
                        <label class="form-label col-4">Menu</label>@error('menu_id')<span style="font-size:13px;color:#fc3f1f">{{ $message }}</span>@enderror
                    </div>
                    <div class="row mb-2">
                        <small>Total Harga : {{ $total_price }}, Dengan Pajak {{ $used_ppn }}% : {{ $total_price_with_ppn }}</small>
                    </div>
                    <div class="row">
                    @foreach($menus as $menu)
                    <div class="col-md-6 col-lg-4 mb-5" id="menuCard{{ $menu->id }}">
                        <div class="card">
                            <img class="card-img-top" style="object-fit:contain" height="150px"
                                src="{{ asset('storage/'.$menu->picture) }}" />
                            <div class="card-body" style="width: 100%;">
                                <div class="row">
                                        <label class="form-check-label" style="display: block;" for="checkbox{{ $menu->id }}"> 
                                            {{ $menu->menu }} <br>
                                            <small class="text-muted ms-1">{{ $menu->price }}</small>
                                        </label>
                                </div>
                                <div class="row">
                                    <label for="qty{{ $menu->id }}" class="col-md-5 col-form-label">Qty</label>
                                    <div class="col-md-7">
                                        <input class="form-control" max="{{ $menu->stock }}" wire:model="menu_id.{{ $menu->id }}" type="number" id="qty{{ $menu->id }}" oninput="updateCheckbox({{ $menu->id }}, {{ $menu->stock }})" disabled/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    </div>
                </div>
                <button type="submit" class="btn btn-warning me-2">Ubah</button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">
                    Batal
                </button>
            </form>
        </div>
    </div>

    {{-- delete order modal --}}
    <div wire:ignore.self class="offcanvas offcanvas-end border-3" data-bs-scroll="true" data-bs-backdrop="false"
        tabindex="-1" id="deleteOrder" aria-labelledby="offcanvasTopLabel" style="width: 60%">
        <div class="offcanvas-header">
            <h5 id="offcanvasTopLabel" class="offcanvas-title">Hapus Data Pesanan Ini ?</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form wire:submit="deleteOrder">
                <div class="mb-3">
                    <label class="form-label" for="customer_name">Nama Pemesan</label>
                    <input wire:model="customer_name" type="text"
                        class="form-control @error('customer_name') is-invalid @enderror" id="customer_name"
                        placeholder="Masukkan Nama Pemesan" disabled/>
                    @error('customer_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="table_number">Nomor Meja</label>
                    <input wire:model="table_number" type="number"
                        class="form-control @error('table_number') is-invalid @enderror" id="table_number"
                        placeholder="Masukkan Nomor Meja" disabled/>
                    @error('table_number')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status Pesanan</label>
                    <select wire:model="status_id" id="status" class="form-select" disabled>
                        @foreach($statuses as $status)
                        <option value="{{ $status->id }}">{{ $status->status }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    <div class="row">
                        <label class="form-label col-4">Menu</label>@error('menu_id')<span style="font-size:13px;color:#fc3f1f">{{ $message }}</span>@enderror
                    </div>
                    <div class="row mb-2">
                        <small>Total Harga {{ $total_price }}</small>
                    </div>
                    <div class="row">
                    @foreach($menus as $menu)
                    <div class="col-md-6 col-lg-4 mb-5" id="menuCard{{ $menu->id }}">
                        <div class="card">
                            <img class="card-img-top" style="object-fit:contain" height="150px"
                                src="{{ asset('storage/'.$menu->picture) }}" />
                            <div class="card-body" style="width: 100%;">
                                <div class="row">
                                        <label class="form-check-label" style="display: block;" for="checkbox{{ $menu->id }}"> 
                                            {{ $menu->menu }} <br>
                                            <small class="text-muted ms-1">{{ $menu->price }}</small>
                                        </label>
                                </div>
                                <div class="row">
                                    <label for="qty{{ $menu->id }}" class="col-md-5 col-form-label">Qty</label>
                                    <div class="col-md-7">
                                        <input class="form-control" max="{{ $menu->stock }}" wire:model="menu_id.{{ $menu->id }}" type="number" id="qty{{ $menu->id }}" oninput="updateCheckbox({{ $menu->id }}, {{ $menu->stock }})" disabled/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    </div>
                </div>
                <button type="submit" class="btn btn-danger me-2">Hapus</button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">
                    Batal
                </button>
            </form>
        </div>
    </div>

    <script>
        
        function updateQty(menuId) {
            var checkbox = document.getElementById('checkbox' + menuId);
            var qtyInput = document.getElementById('qty' + menuId);
    
            if (checkbox.checked) {
                if (qtyInput.value == '') {
                    @this.incrementQty(menuId);
                }
            }else{
                @this.decrementQty(menuId);
            }
        }
        
        function updateCheckbox(menuId, menuStock) {
            var qtyInput = document.getElementById('qty' + menuId);
            var checkbox = document.getElementById('checkbox' + menuId);
    
            if (qtyInput.value > 0) {
              checkbox.checked = true;
            } else {
              checkbox.checked = false;
            }
    
            if (qtyInput.value <= 0) {
              qtyInput.value = '';
            }
    
            if (qtyInput.value > menuStock) {
                qtyInput.value = menuStock;
            }
        }

        window.addEventListener('resetCheckBoxes', (event) => {
            menu_id = event.detail.menus;
            Object.keys(menu_id).forEach(key => {
                var checkbox = document.getElementById('checkbox' + key);
                checkbox.checked =false;
            });
        })
    </script>
    
</div>