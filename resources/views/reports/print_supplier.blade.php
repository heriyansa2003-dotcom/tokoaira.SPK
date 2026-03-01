<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Pemesanan Barang - {{ $supplier->name }}</title>
    <style>
        /* Reset & Base Styles */
        * {
            box-sizing: border-box;
        }
        body { 
            font-family: 'Courier New', Courier, monospace; 
            color: #000; 
            line-height: 1.2;
            margin: 0;
            padding: 0;
            background-color: #fff;
            font-size: 12px;
        }
        
        .nota-container {
            width: 100%;
            max-width: 100%;
            margin: 0 auto;
            padding: 15px;
        }

        .header { 
            text-align: center; 
            margin-bottom: 10px; 
            border-bottom: 2px double #000; 
            padding-bottom: 5px; 
        }
        .header h1 { 
            margin: 0; 
            text-transform: uppercase; 
            font-size: 20px;
            letter-spacing: 1px;
        }
        .header p { 
            margin: 1px 0; 
            font-size: 11px;
        }

        .nota-title {
            text-align: center;
            text-decoration: underline;
            font-weight: bold;
            font-size: 14px;
            margin: 8px 0;
            text-transform: uppercase;
        }

        .info { 
            margin-bottom: 10px; 
            width: 100%;
        }
        .info-table {
            width: 100%;
            font-size: 11px;
            border-collapse: collapse;
        }
        .info-table td {
            vertical-align: top;
            padding: 1px 0;
        }

        .content table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 5px; 
        }
        .content th { 
            border: 1px solid #000; 
            padding: 5px 3px; 
            text-align: center; 
            font-size: 11px;
            text-transform: uppercase;
            background-color: #f0f0f0;
        }
        .content td { 
            border: 1px solid #000; 
            padding: 4px 3px; 
            font-size: 11px; 
        }
        .total-row td {
            font-weight: bold;
            border-top: 2px solid #000;
        }

        .footer { 
            margin-top: 20px; 
            width: 100%;
        }
        .signature-table {
            width: 100%;
        }
        .signature-box {
            text-align: center;
            width: 40%;
        }
        .signature-space {
            height: 40px;
            border-bottom: 1px solid #000;
            width: 80%;
            margin: 10px auto;
        }

        .note-footer {
            margin-top: 15px; 
            font-size: 9px; 
            font-style: italic; 
            text-align: center; 
            border-top: 1px dashed #ccc; 
            padding-top: 3px;
        }

        /* CSS UNTUK TAMPILAN BROWSER (NON-PDF) */
        @media screen {
            .no-print { 
                background: #f8f9fa; 
                padding: 15px; 
                text-align: center; 
                border-bottom: 1px solid #ddd;
                margin-bottom: 10px;
            }
            .btn {
                padding: 8px 20px; 
                cursor: pointer; 
                border: none; 
                border-radius: 4px; 
                font-weight: bold;
                margin: 0 5px;
                text-decoration: none;
                display: inline-block;
                text-transform: uppercase;
            }
            .btn-print { background: #007bff; color: white; }
            .btn-back { background: #6c757d; color: white; }
        }

        /* CSS UNTUK PRINT BROWSER */
        @media print {
            .no-print { display: none !important; }
            @page { margin: 0.5cm; }
        }
    </style>
</head>
<body>
    {{-- Hanya tampilkan navigasi jika BUKAN sedang di-generate sebagai PDF oleh dompdf --}}
    @if(!isset($isPdf) || !$isPdf)
    <div class="no-print">
        <button onclick="window.print()" class="btn btn-print">CETAK NOTA</button>
        <button onclick="window.close()" class="btn btn-back">KEMBALI</button>
    </div>
    @endif

    <div class="nota-container">
        <div class="header">
            <h1>TOKO AIRA SRC</h1>
            <p>Jl. Poros Trans Sulawesi, Lingk Bambaloka, Kelurahan Baras</p>
            <p>Kec. Baras, Kab. Pasangkayu, Provinsi Sulawesi Barat</p>
            <p>Telp/WA: +62 878-3164-2368</p>
        </div>

        <div class="nota-title">NOTA PEMESANAN BARANG</div>

        <div class="info">
            <table class="info-table">
                <tr>
                    <td width="12%">Supplier</td>
                    <td width="38%">: <strong>{{ $supplier->name }}</strong></td>
                    <td width="15%">No. Nota</td>
                    <td width="35%">: ORD/{{ date('Ymd') }}/{{ str_pad($supplier->id, 3, '0', STR_PAD_LEFT) }}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>: {{ $supplier->address }}</td>
                    <td>Tanggal</td>
                    <td>: {{ date('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td>TELP/WA</td>
                    <td>: {{ $supplier->phone }}</td>
                    <td>Waktu</td>
                    <td>: {{ date('H:i') }}</td>
                </tr>
            </table>
        </div>

        <div class="content">
            <table>
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="45%">Nama Barang</th>
                        <th width="15%">Harga Satuan</th>
                        <th width="15%">Jumlah</th>
                        <th width="20%">Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @forelse($products as $product)
                    <tr>
                        <td align="center">{{ $no++ }}</td>
                        <td>{{ $product->name }}</td>
                        <td align="right">Rp {{ number_format($product->order_price, 0, ',', '.') }}</td>
                        <td align="center">
                            {{ $product->order_qty }} {{ $product->order_unit }}
                        </td>
                        <td align="right">
                            Rp {{ number_format($product->subtotal, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" align="center" style="padding: 15px;">Tidak ada data barang.</td>
                    </tr>
                    @endforelse
                    
                    @if($products->count() > 0)
                    <tr class="total-row">
                        <td colspan="4" align="right">TOTAL KESELURUHAN</td>
                        <td align="right">Rp {{ number_format($totalPrice, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="footer">
            <table class="signature-table">
                <tr>
                    <td class="signature-box">
                        <p>Diterima Oleh,</p>
                        <p>Supplier</p>
                        <div class="signature-space"></div>
                        <p>( {{ $supplier->name }} )</p>
                    </td>
                    <td width="20%"></td>
                    <td class="signature-box">
                        <p>Hormat Kami,</p>
                        <p>Pemilik Toko</p>
                        <div class="signature-space"></div>
                        <p>( Rusli )</p>
                    </td>
                </tr>
            </table>
        </div>
        
        <div class="note-footer">
            * Nota otomatis Sistem Inventaris Toko Aira - Dicetak pada {{ date('d/m/Y H:i') }}
        </div>
    </div>
</body>
</html>
