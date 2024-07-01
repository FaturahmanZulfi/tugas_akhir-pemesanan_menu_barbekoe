<div>
    <form wire:submit="login" id="formAuthentication">
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
        <div class="mb-3 form-password-toggle">
            <div class="d-flex justify-content-between">
                <label class="form-label" for="password">Password</label>
            </div>
            <div class="input-group input-group-merge">
                <input wire:model="password" type="password"
                        class="form-control @error('password') is-invalid @enderror" id="password"
                        placeholder="Masukkan Password" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        <div class="mb-3">
            <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
        </div>
    </form>
</div>