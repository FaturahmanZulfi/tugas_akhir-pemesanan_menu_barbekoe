<div class="card px-4 py-3">

    <form wire:submit="createNewOrder">
        <div class="mb-3">
            <label class="form-label" for="customer_name">Nama</label>
            <input wire:model="customer_name" type="text"
                class="form-control @error('customer_name') is-invalid @enderror" id="customer_name"
                placeholder="Masukkan Nama Anda" />
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
        <div class="row" wire:poll.keep-alive.100ms>
            <div class="row my-2">
                <div class="col-lg-8 col-lg-8">
                    <label class="form-label">Pilih Menu</label>@error('menu_id')<span
                        style="font-size:13px;color:#fc3f1f">{{ $message }}</span>@enderror
                </div>
                <div class="col-lg-4 col-lg-4">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                        <input wire:model.live="search" type="text" class="form-control" placeholder="Cari Menu" />
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($menus as $menu)
                <div class="col-md-6 col-lg-4 col-sm-6 mb-5">
                    <div class="card">
                        <img class="card-img-top" style="object-fit:contain" height="150px"
                            src="{{ asset('storage/'.$menu->picture) }}" />
                        <div class="card-body" style="width: 100%;">
                            <div class="row">
                                <div class="col-1">
                                    @if($menu->stock >= 1)
                                    <input class="form-check-input" type="checkbox" id="checkbox{{ $menu->id }}"
                                        onclick="updateQty({{ $menu->id }})" />
                                    @else

                                    @endif
                                </div>
                                <div class="col-10">
                                    <label class="form-check-label" style="display: block;"
                                        for="checkbox{{ $menu->id }}">
                                        {{ $menu->menu.' ('.$menu->stock.')' }} <br>
                                        <small class="text-muted ms-1">{{ $menu->price }}</small>
                                    </label>
                                </div>
                            </div>
                            @if($menu->stock >= 1)
                            <div class="row">
                                <label for="qty{{ $menu->id }}" class="col-md-5 col-form-label">Qty</label>
                                <div class="col-md-7">
                                    <input class="form-control" max="{{ $menu->stock }}"
                                        wire:model="menu_id.{{ $menu->id }}" type="number" id="qty{{ $menu->id }}"
                                        onload="updateCheckbox({{ $menu->id }}, {{ $menu->stock }})"
                                        oninput="updateCheckbox({{ $menu->id }}, {{ $menu->stock }})" />
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
        <button type="submit" class="btn btn-primary me-2">Checkout</button>
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">
            Batal
        </button>
    </form>

    <div class="buy-now">
        <button data-bs-toggle="offcanvas" data-bs-target="#cartOffcanvas" class="btn btn-dark btn-buy-now" style="-webkit-box-shadow: 3px 3px 39px -3px rgba(0,0,0,0.75);
-moz-box-shadow: 3px 3px 39px -3px rgba(0,0,0,0.75);
box-shadow: 3px 3px 39px -3px rgba(0,0,0,0.75);"><i class="bx bx-cart fs-4 lh-0"></i></button>
    </div>

    <div class="offcanvas offcanvas-end border-3" tabindex="-1" id="cartOffcanvas" aria-labelledby="offcanvasEndLabel"
        data-bs-scroll="true" data-bs-backdrop="false" style="z-index:20000000" wire:ignore.self>
        <div class="offcanvas-header">
            <h5 id="offcanvasEndLabel" class="offcanvas-title">Keranjang</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body mx-0 flex-grow-0">
            <form wire:submit="createNewOrder">
                <div class="mb-3">
                    <label class="form-label" for="customer_name">Nama</label>
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
                    <label class="form-label" for="table_number">Nomor Meja </label>
                    <input wire:model="table_number" type="number"
                        class="form-control @error('table_number') is-invalid @enderror" id="table_number"
                        placeholder="Masukkan Nomor Meja" />
                    @error('table_number')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="row" wire:poll.keep-alive.100ms>
                    <div class="row">
                        <label class="form-label col-4">Menu</label>
                    </div>
                    @if($selected_menu)
                    <div class="row">
                        @foreach($selected_menu as $menu)
                        <div class="col-md-12 col-lg-12 mb-3">
                            <div class="card">
                                <div class="card-body" style="width: 100%;">
                                    <div class="row">
                                        <div class="col-4">
                                            <img style="object-fit:contain" height="50px"
                                    src="{{ asset('storage/'.$menu['picture']) }}" />
                                        </div>
                                        <div class="col-8">
                                            <label class="form-check-label" style="display: block;">
                                                {{ $menu['menu'].' ('.$menu['stock'].')' }} <br>
                                                <small class="text-muted ms-1">{{ $menu['price'] }}</small>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <label for="qty{{ $menu['id'] }}" class="col-md-3 col-form-label">Qty</label>
                                        <div class="col-md-9">
                                            <input class="form-control" max="{{ $menu['stock'] }}"
                                        wire:model="menu_id.{{ $menu['id'] }}" type="number" id="qty{{ $menu['id'] }}"
                                        onload="updateCheckbox({{ $menu['id'] }}, {{ $menu['stock'] }})"
                                        oninput="updateCheckbox({{ $menu['id'] }}, {{ $menu['stock'] }})" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    
                    @endif
                </div>
                <button type="submit" class="btn btn-primary me-2">Checkout</button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">
                    Batal
                </button>
            </form>
        </div>
    </div>

    <script>

        function updateQty(menuId) {
            var checkbox = document.getElementById('checkbox' + menuId);
            var qtyInput = document.querySelectorAll('#qty' + menuId);

            if (checkbox.checked) {
                if (qtyInput[0].value == '' || qtyInput[1].value == '') {
                    @this.incrementQty(menuId);
                }
            } else {
                @this.decrementQty(menuId);
            }

            @this.updateCart();
        }

        function updateCheckbox(menuId, menuStock) {
            var qtyInput = document.querySelectorAll('#qty' + menuId);
            var checkbox = document.getElementById('checkbox' + menuId);

            // if (qtyInput[0].value != '') {
            //     qtyInput[1].value = qtyInput[0].value;
            // }

            // if (qtyInput[1].value != '') {
            //     qtyInput[0].value = qtyInput[1].value;
            // }

            if (qtyInput[0].value == '') {
                checkbox.checked = false;
            } else {
                checkbox.checked = true;
            }

            if (qtyInput[0].value <= 0) {
                qtyInput[0].value = '';
            }

            if (qtyInput[0].value > menuStock) {
                qtyInput[0].value = menuStock;
            }

            if (qtyInput[1]) {
                if (qtyInput[1].value > menuStock) {
                    qtyInput[1].value = menuStock;
                }
            }

            @this.updateCart();
        }

        window.addEventListener('resetCheckBoxes', (event) => {
            menu_id = event.detail.menus;
            Object.keys(menu_id).forEach(key => {
                var checkbox = document.getElementById('checkbox' + key);
                checkbox.checked = false;
            });
        })

        window.addEventListener('uncheckboxes', (event) => {
            id = event.detail.id;
            var checkbox = document.getElementById('checkbox' + id);
            checkbox.checked = false;
        })
    </script>
</div>