<div>
    <div class="card p-3">
        <h4 class="fw-bold card-header">Tabel Log</h4>
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
                    <input wire:model.live="search" type="text" class="form-control" placeholder="Cari Data Log"/>
                </div>
            </div>
        </div>
        <div class="table-responsive mt-4 mx-2">
            <table class="table table-borderless" wire:poll.keep-alive.100ms>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Akses Level</th>
                        <th>Aksi</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logs as $log)
                    <tr>
                        <td>{{ $log->user->username }}</td>
                        <td>{{ $log->user->level->level }}</td>
                        <td>{{ $log->action }}</td>
                        <td>{{ $log->time }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row px-4 mt-4">{{ $logs->links(data: ['scrollTo' => false]) }}</div>
    </div>
</div>
