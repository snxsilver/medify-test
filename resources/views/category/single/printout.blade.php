<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .header {
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0 0 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            position: fixed;
            bottom: -20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>Data Master Item</h2>

        <table>
            <tr>
                <td width="20%">Nama Kategori</td>
                <td>{{ $category->nama }}</td>
            </tr>
            <tr>
                <td>Kode Kategori</td>
                <td>{{ $category->kode }}</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama Item</th>
                <th>Supplier</th>
                <th>Harga</th>
                <th>Laba</th>
                <th>Harga Jual</th>
            </tr>
        </thead>

        <tbody>
            @foreach($items as $index => $item)
                @php
                    $harga_jual = $item->harga_beli +
                        ($item->harga_beli * $item->laba / 100);
                @endphp

                <tr>
                    <td class="text-center">
                        {{ $index + 1 }}
                    </td>

                    <td>
                        {{ $item->nama }}
                    </td>

                    <td>
                        {{ $item->supplier }}
                    </td>

                    <td class="text-right">
                        {{ number_format($item->harga_beli, 0, ',', '.') }}
                    </td>

                    <td class="text-right">
                        {{ $item->laba }}%
                    </td>

                    <td class="text-right">
                        {{ number_format(round($harga_jual), 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada:
        {{ now()->format('d-m-Y H:i:s') }}
    </div>

</body>
</html>