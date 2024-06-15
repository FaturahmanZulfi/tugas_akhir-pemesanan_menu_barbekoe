<div>
    <div class="card p-3">
        <h4 class="fw-bold card-header">Tabel User</h4>
        <di class="row px-4">
            <div class="">
                <button wire:click="rset()" class="col-lg-2 col-md-3 col-sm-4 btn btn-primary" type="button"
                    data-bs-toggle="offcanvas" data-bs-target="#createMenu">
                    Tambah Menu
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
                    <input wire:model.live="search" type="text" class="form-control" placeholder="Cari Menu" />
                </div>
            </div>
        </div>
        <div class="table-responsive mt-4 mx-2">
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th>Menu</th>
                        <th>Gambar</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($menus as $menu)
                    <tr>
                        <td>{{ $menu->menu }}</td>
                        <td class="text-center"><img src="{{ asset('storage/'.$menu->picture) }}" height="100px"></td>
                        <td>{{ $menu->category->category }}</td>
                        <td>{{ $menu->price }}</td>
                        <td>{{ $menu->stock }}</td>
                        <td>
                            <button wire:click="getMenu({{ $menu->id }})" class="btn btn-warning" type="button"
                                data-bs-toggle="offcanvas" data-bs-target="#updateMenu">
                                Ubah
                            </button>
                            <button wire:click="getMenu({{ $menu->id }})" class="btn btn-danger" type="button"
                                data-bs-toggle="offcanvas" data-bs-target="#deleteMenu">
                                Hapus
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row px-4 mt-4">{{ $menus->links(data: ['scrollTo' => false]) }}</div>
    </div>

    {{-- insert menu modal --}}
    <div wire:ignore.self class="offcanvas offcanvas-end border-3" data-bs-scroll="true" data-bs-backdrop="false"
        tabindex="-1" id="createMenu" aria-labelledby="offcanvasTopLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasTopLabel" class="offcanvas-title">Tambah Data Menu</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form wire:submit="createNewMenu" action="">
                <div class="mb-3">
                    <label class="form-label" for="menu">Nama Menu</label>
                    <input wire:model="menu" type="text" class="form-control @error('menu') is-invalid @enderror"
                        id="menu" placeholder="Masukkan Menu" />
                    @error('menu')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="harga">Harga</label>
                    <input wire:model="price" type="text" class="form-control @error('price') is-invalid @enderror"
                        id="harga" placeholder="Masukkan Harga" />
                    @error('price')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Kategori</label>
                    <select wire:model="category_id" id="category" class="form-select">
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->category }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="stock">Stok</label>
                    <input wire:model="stock" type="text" class="form-control @error('stock') is-invalid @enderror"
                        id="stock" placeholder="Masukkan Stok" />
                    @error('stock')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="formFile" class="form-label">Gambar Menu</label>
                    <br>
                    @if($picture)
                        <img height="70px" class="mb-2" src="{{ $picture->temporaryUrl() }}" alt="">
                    @endif
                    <div wire:loading wire:target="picture" class="demo-inline-spacing">
                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                          <span class="visually-hidden">Loading...</span>
                        </div>
                        Sedang Upload Gambar
                      </div>
                    <input wire:model="picture" accept="image/jpeg, image/png"
                        class="form-control @error('picture') is-invalid @enderror" type="file" id="formFile" />
                    @error('picture')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">
                    Batal
                </button>
            </form>
        </div>
    </div>

    {{-- update user modal --}}
    <div wire:ignore.self class="offcanvas offcanvas-end border-3" data-bs-scroll="true" data-bs-backdrop="false"
        tabindex="-1" id="updateMenu" aria-labelledby="offcanvasTopLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasTopLabel" class="offcanvas-title">Ubah Data User</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form wire:submit="updateMenu" action="">
                <div class="mb-3">
                    <label class="form-label" for="menu">Nama Menu</label>
                    <input wire:model="menu" type="text" class="form-control @error('menu') is-invalid @enderror"
                        id="menu" placeholder="Masukkan Menu" />
                    @error('menu')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="harga">Harga</label>
                    <input wire:model="price" type="text" class="form-control @error('price') is-invalid @enderror"
                        id="harga" placeholder="Masukkan Harga" />
                    @error('price')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Kategori</label>
                    <select wire:model="category_id" id="category" class="form-select">
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->category }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="stock">Stok</label>
                    <input wire:model="stock" type="text" class="form-control @error('stock') is-invalid @enderror"
                        id="stock" placeholder="Masukkan Stok" />
                    @error('stock')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="formFile" class="form-label">Gambar Menu</label>
                    <br>
                    @if($picture)
                        <img height="70px" class="mb-2" src="{{ $picture->temporaryUrl() }}" alt="">
                    @else
                        <img height="70px" class="mb-2" src="{{ asset('storage/'.$oldPicture) }}" alt="">
                    @endif
                    <div wire:loading wire:target="picture" class="demo-inline-spacing">
                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                          <span class="visually-hidden">Loading...</span>
                        </div>
                        Sedang Upload Gambar
                      </div>
                    <input wire:model="picture" accept="image/jpeg, image/png"
                        class="form-control @error('picture') is-invalid @enderror" type="file" id="formFile" />
                    @error('picture')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">
                    Batal
                </button>
            </form>
        </div>
    </div>

    {{-- delete user modal --}}
    <div wire:ignore.self class="offcanvas offcanvas-end border-3" data-bs-scroll="true" data-bs-backdrop="false"
        tabindex="-1" id="deleteMenu" aria-labelledby="offcanvasTopLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasTopLabel" class="offcanvas-title">Yakin Ingin Hapus Menu Ini ?</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form wire:submit="deleteMenu" action="">
                <div class="mb-3">
                    <label class="form-label" for="menu">Nama Menu</label>
                    <input wire:model="menu" type="text" class="form-control @error('menu') is-invalid @enderror"
                        id="menu" placeholder="Masukkan Menu" disabled/>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="harga">Harga</label>
                    <input wire:model="price" type="text" class="form-control"
                        id="harga" placeholder="Masukkan Harga" disabled/>
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Kategori</label>
                    <select wire:model="category_id" id="category" class="form-select" disabled>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->category }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="stock">Stok</label>
                    <input wire:model="stock" type="text" class="form-control"
                        id="stock" placeholder="Masukkan Stok" disabled/>
                </div>
                <div class="mb-3">
                    <label for="formFile" class="form-label">Gambar Menu</label>
                    <br>
                    <img height="70px" class="mb-2" src="{{ asset('storage/'.$oldPicture) }}" alt="">
                    <input wire:model="picture" accept="image/jpeg, image/png"
                        class="form-control" type="file" id="formFile" disabled/>
                </div>
                <button type="submit" class="btn btn-danger me-2" @if($menu_id == 0) disabled @endif>Hapus</button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">
                    Batal
                </button>
            </form>
        </div>
    </div>


</div>