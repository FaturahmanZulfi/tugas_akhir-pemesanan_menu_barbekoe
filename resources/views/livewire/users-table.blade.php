<div>
    <div class="card p-3">
        <h4 class="fw-bold card-header">Tabel User</h4>
        <di class="row px-4">
            <div class="">
                <button wire:click="rset()" class="col-lg-2 col-md-3 col-sm-4 btn btn-primary" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#createUser">
                    Tambah User
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
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Akses Level</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key => $user)
                    <tr>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->level->level }}</td>
                        <td>
                            <button wire:click="getUser({{ $user->id }})" class="btn btn-warning" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#updateUser">
                                Ubah
                            </button>
                            <button wire:click="getUser({{ $user->id }})" class="btn btn-danger" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#deleteUser">
                                Hapus
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row px-4 mt-4">{{ $users->links(data: ['scrollTo' => false]) }}</div>
    </div>

    {{-- insert user modal --}}
    <div wire:ignore.self class="offcanvas offcanvas-end border-3" data-bs-scroll="true" data-bs-backdrop="false"
        tabindex="-1" id="createUser" aria-labelledby="offcanvasTopLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasTopLabel" class="offcanvas-title">Tambah Data User</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form wire:submit="createNewUser" action="">
                <div class="mb-3">
                    <label class="form-label" for="username">Username</label>
                    <input wire:model="username" type="text"
                        class="form-control @error('username') is-invalid @enderror" id="username"
                        placeholder="Masukkan Username" />
                    @error('username')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">Password</label>
                    <input wire:model="password" type="text"
                        class="form-control @error('password') is-invalid @enderror" id="password"
                        placeholder="Masukkan Password" />
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="level" class="form-label">Akses Level</label>
                    <select wire:model="level_id" id="level" class="form-select">
                        @foreach($levels as $level)
                        <option value="{{ $level->id }}">{{ $level->level }}</option>
                        @endforeach
                    </select>
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
        tabindex="-1" id="updateUser" aria-labelledby="offcanvasTopLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasTopLabel" class="offcanvas-title">Ubah Data User</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form wire:submit="updateUser" action="">
                <div class="mb-3">
                    <label class="form-label" for="username">Username</label>
                    <input wire:model="username" type="text"
                        class="form-control @error('username') is-invalid @enderror" id="username"
                        placeholder="Masukkan Username" />
                    @error('username')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">Password</label>
                    <input wire:model="password" type="text"
                        class="form-control @error('password') is-invalid @enderror" id="password"
                        placeholder="Masukkan Password" />
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="level" class="form-label">Akses Level</label>
                    <select wire:model="level_id" id="level" class="form-select">
                        @foreach($levels as $level)
                        <option value="{{ $level->id }}">{{ $level->level }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-warning m-2">Simpan Perubahan</button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">
                    Batal
                </button>
            </form>
        </div>
    </div>

    {{-- delete user modal --}}
    <div wire:ignore.self class="offcanvas offcanvas-end border-3" data-bs-scroll="true" data-bs-backdrop="false"
        tabindex="-1" id="deleteUser" aria-labelledby="offcanvasTopLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasTopLabel" class="offcanvas-title">Yakin Ingin Hapus User Ini ?</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form wire:submit="deleteUser" action="">
                <div class="mb-3">
                    <label class="form-label" for="username">Username</label>
                    <input wire:model="username" type="text"
                        class="form-control" id="username"
                        placeholder="Masukkan Username" disabled/>
                </div>
                <div class="mb-3">
                    <label for="level" class="form-label">Akses Level</label>
                    <select wire:model="level_id" id="level" class="form-select" disabled>
                        @foreach($levels as $level)
                        <option value="{{ $level->id }}">{{ $level->level }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-danger m-2" @if($user_id == 0) disabled @endif>Hapus User</button>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="offcanvas">
                    Batal
                </button>
            </form>
        </div>
    </div>


</div>