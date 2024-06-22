<div>
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
                    <label class="form-label">Pilih Menu</label>@error('menu_id')<span style="font-size:13px;color:#fc3f1f">{{ $message }}</span>@enderror
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
        <button type="submit" class="btn btn-primary me-2">Checkout</button>
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">
            Batal
        </button>
    </form>

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
