<div>
    {{-- @dd($order_years) --}}
    <div class="card p-3">
        <h4 class="fw-bold card-header">Tabel Laporan Pesanan</h4>
        <div class="row px-4 col-3">
            <button class="btn btn-dark mt-3" wire:click="excel()">Export Ke Excel</button>
        </div>
        <div class="row px-4 mt-3">
            <div class="col-4 mb-3">
                <label for="exampleFormControlSelect1" class="form-label">Pilih Tahun</label>
                <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example" wire:model.live="selected_year">
                  <option value="" selected>-</option>
                  @foreach($order_years as $year)
                  <option value="{{ $year->year }}">{{ $year->year }}</option>
                  @endforeach
                </select>
            </div>
            <div class="col-4 mb-3">
                <label for="exampleFormControlSelect1" class="form-label">Pilih Bulan</label>
                <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example" wire:model.live="selected_month">
                  <option value="" selected>-</option>
                  @foreach($order_months as $month)
                  <option value="{{ $month->month }}">{{ $month->month }}</option>
                  @endforeach
                </select>
            </div>
            <div class="col-4 mb-3">
                <label for="exampleFormControlSelect1" class="form-label">Pilih Tanggal</label>
                <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example" wire:model.live="selected_day">
                  <option value="" selected>-</option>
                  @foreach($order_days as $day)
                  <option value="{{ $day->day }}">{{ $day->day }}</option>
                  @endforeach
                </select>
            </div>
        </div>
        <div class="row px-4">
            <div class="col-4">
                {{-- @dd($total) --}}
                {{ "Rp " . number_format($total[0]->total, 0, ",", ".") }}
            </div>
            <div class="col-4 offset-4">
                <div class="input-group input-group-merge">
                    <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                    <input wire:model.live="search" type="text" class="form-control" placeholder="Cari Data Pesanan"/>
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
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>
                            {{ $order->order_code }} <br>
                            {{ $order->customer_name }}
                        </td>
                        <td>
                            {{ "Rp " . number_format($order->total_price_with_ppn, 0, ",", ".") }}
                        </td>
                        <td>
                            {{ $order->order_time }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- <div class="row px-4 mt-4">{{ $logs->links(data: ['scrollTo' => false]) }}</div> --}}
    </div>
</div>
