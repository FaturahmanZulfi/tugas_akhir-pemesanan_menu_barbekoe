<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        *{
            font-family: calibri
        }
    </style>
</head>
<body>
    <div style="width:100%">
        <div class="card">
            <div class="card-body">
              <h5 class="card-title">BARBEKOE COFFEE AND RESTO</h5>
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
              <table width="100%">
              @foreach ($menus as $menu) 
                <tr>
                    <td>
                {{ $menu->menu->menu }} {{ $menu->qty }}x
            </td>
            <td>
                {{ "Rp " . number_format($menu->total_price, 0, ",", ".") }}
            </td>
                </tr>
              @endforeach
              <tr><td colspan="2"><hr></td></tr>
                <tr>
                    <td></td>
                    <td>
              <div class="row">
                  <span class="card-text offset-6 col-6">
                      {{ "Rp " . number_format($order['total_price'], 0, ",", ".") }}
                  </span>
              </div>
            </td>
            </tr>
              <div>
                <tr>
                    <td>
                    <span class="card-text col-6">
                        Ppn {{ $order['ppn'] }}%
                    </span>
                    </td>
                    <td>
                    <span class="card-text col-6">
                        {{ "Rp " . number_format($order['total_price']*$order['ppn']/100, 0, ",", ".") }}
                    </span>
                    </td>
                </tr>
              </div>
              <tr><td colspan="2"><hr></td></tr>
              <div class="row mt-2">
                <tr><td>
                  <span>
                      Total
                  </span>
                </td><td>
                  <span>
                      {{ "Rp " . number_format($order['total_price_with_ppn'], 0, ",", ".") }}
                  </span>
                </td></tr>
              </div>
            </table>
            </div>
          </div>
      </div>
</body>
</html>