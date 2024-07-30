<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data Pesanan.xls");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Test</title>
</head>
<body>
    <table>
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
                    {{ $order->total_price_with_ppn }}
                </td>
                <td>
                    {{ $order->order_time }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>