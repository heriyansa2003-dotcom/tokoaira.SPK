<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan SPK - Prioritas Pengadaan Stok - Toko Aira</title>
    <style>
        /* Reset & Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', sans-serif;
            color: #333;
            background-color: #fff;
            line-height: 1.6;
            font-size: 13px;
        }

        /* Container dengan Margin 2cm Presisi */
        .container {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding-top: 20mm;    /* Margin Atas 2cm */
            padding-bottom: 20mm; /* Margin Bawah 2cm */
            padding-left: 20mm;   /* Margin Kiri 2cm */
            padding-right: 20mm;  /* Margin Kanan 2cm */
            background: white;
            position: relative;
        }

        /* Header Section */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #2c3e50;
        }

        .company-info h1 {
            font-size: 24px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 5px;
            letter-spacing: 0.5px;
        }

        .company-info p {
            font-size: 11px;
            color: #666;
            margin: 2px 0;
            line-height: 1.4;
        }

        .report-title {
            text-align: right;
            font-size: 12px;
            color: #666;
        }

        .report-title .title {
            font-size: 16px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
        }

        /* Info Section */
        .info-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 25px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }

        .info-group {
            font-size: 12px;
        }

        .info-group .label {
            color: #666;
            font-weight: 500;
            margin-bottom: 3px;
        }

        .info-group .value {
            color: #2c3e50;
            font-weight: 600;
        }

        /* Criteria Section */
        .criteria-section {
            margin-bottom: 25px;
            padding: 15px;
            background-color: #f0f7ff;
            border-left: 4px solid #2c3e50;
            border-radius: 4px;
        }

        .criteria-section h4 {
            font-size: 13px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .criteria-list {
            font-size: 11px;
            line-height: 1.8;
        }

        .criteria-list li {
            margin-bottom: 5px;
            color: #555;
        }

        /* Table Section */
        .table-section {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        thead {
            background-color: #2c3e50;
            color: white;
        }

        th {
            padding: 12px 8px;
            text-align: left;
            font-weight: 600;
            font-size: 12px;
            border: none;
        }

        th.text-center { text-align: center; }
        th.text-right { text-align: right; }

        td {
            padding: 10px 8px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 12px;
        }

        tbody tr:hover { background-color: #f5f5f5; }
        tbody tr:last-child td { border-bottom: 2px solid #2c3e50; }

        td.text-center { text-align: center; }
        td.text-right { text-align: right; }

        .rank-1 { background-color: #fff3cd; font-weight: 600; }
        .rank-2 { background-color: #e2e3e5; font-weight: 500; }
        .rank-3 { background-color: #ffe4b5; font-weight: 500; }

        .status-urgent { color: #dc3545; font-weight: 600; }
        .status-high { color: #fd7e14; font-weight: 600; }
        .status-medium { color: #0dcaf0; font-weight: 600; }
        .status-low { color: #6c757d; }

        /* Footer Section (Tanda Tangan Kanan & Mencegah Terpisah Halaman) */
        .footer-section {
            margin-top: 40px;
            display: flex;
            justify-content: flex-end;
            page-break-inside: avoid; /* Mencegah blok tanda tangan terpisah antar halaman */
        }

        .signature-box {
            text-align: center;
            font-size: 12px;
            width: 250px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .signature-box .date {
            margin-bottom: 5px;
        }

        .signature-box .role {
            font-weight: 600;
            margin-bottom: 60px;
            color: #2c3e50;
        }

        .signature-box .name {
            font-weight: 600;
            color: #2c3e50;
            border-top: 1px solid #333;
            padding-top: 5px;
            display: inline-block;
            width: 180px;
        }

        /* Footer Info */
        .footer-info {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            color: #999;
            text-align: center;
        }

        /* Print Specific Styles */
        @media print {
            @page {
                size: A4;
                margin: 20mm; /* Pengaturan Margin 2cm di level @page untuk printer */
            }
            
            body {
                background-color: #fff;
            }

            .container {
                width: 100%;
                margin: 0;
                padding: 0; /* Reset padding karena sudah dihandle @page margin */
                box-shadow: none;
            }

            .no-print {
                display: none !important;
            }
            
            .footer-section {
                page-break-inside: avoid;
            }
        }

        /* Screen Display */
        @media screen {
            .container {
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                margin: 20px auto;
            }

            .no-print {
                background: #f8f9fa;
                padding: 15px;
                text-align: center;
                border-bottom: 1px solid #ddd;
                margin-bottom: 20px;
                border-radius: 4px;
            }

            .btn {
                padding: 10px 24px;
                cursor: pointer;
                border: none;
                border-radius: 4px;
                font-weight: 600;
                margin: 0 8px;
                text-decoration: none;
                display: inline-block;
                font-size: 13px;
                transition: all 0.3s ease;
            }

            .btn-print { background: #3498db; color: white; }
            .btn-back { background: #95a5a6; color: white; }
        }
    </style>
</head>
<body>
    <div class="no-print">
        <button onclick="window.print()" class="btn btn-print">
            <i class="bi bi-printer"></i> CETAK LAPORAN
        </button>
        <button onclick="window.close()" class="btn btn-back">
            <i class="bi bi-x-circle"></i> TUTUP
        </button>
    </div>

    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="company-info">
                <h1>TOKO AIRA SRC</h1>
                <p>Jl. Poros Trans Sulawesi, Lingk Bambaloka, Kelurahan Baras</p>
                <p>Kec. Baras, Kab. Pasangkayu, Provinsi Sulawesi Barat</p>
                <p>Telp/WA: +62 878-3164-2368</p>
            </div>
            <div class="report-title">
                <div class="title">LAPORAN SPK - PRIORITAS PENGADAAN</div>
                <p><strong>Tanggal:</strong> {{ date('d/m/Y') }}</p>
                <p><strong>Waktu:</strong> {{ date('H:i') }}</p>
            </div>
        </div>

        <!-- Info Section -->
        <div class="info-section">
            <div class="info-group">
                <div class="label">Total Produk Teranalisis:</div>
                <div class="value">{{ count($priorities) }} Item</div>
            </div>
            <div class="info-group">
                <div class="label">Kategori Filter:</div>
                <div class="value">{{ $categoryId ? ($categories->find($categoryId)->name ?? 'Tidak Ditemukan') : 'Semua Kategori' }}</div>
            </div>
            <div class="info-group">
                <div class="label">Metode Analisis:</div>
                <div class="value">Analytic Hierarchy Process (AHP)</div>
            </div>
            <div class="info-group">
                <div class="label">Skor Rata-rata:</div>
                <div class="value">{{ number_format($statistics['avg_score'] * 100, 1) }}%</div>
            </div>
        </div>

        <!-- Criteria Section -->
        <div class="criteria-section">
            <h4>Kriteria Penilaian Prioritas Pengadaan:</h4>
            <ul class="criteria-list">
                <li><strong>Volume Penjualan (63.7%):</strong> Memprioritaskan barang yang paling sering terjual (fast-moving items)</li>
                <li><strong>Stok Minimum (25.8%):</strong> Memprioritaskan barang yang stoknya mendekati atau di bawah batas minimum</li>
                <li><strong>Harga Satuan (10.5%):</strong> Memprioritaskan barang dengan nilai investasi tinggi untuk optimalisasi modal</li>
            </ul>
        </div>

        <!-- Table Section -->
        <div class="table-section">
            <table>
                <thead>
                    <tr>
                        <th class="text-center" width="6%">Rank</th>
                        <th width="20%">Nama Barang</th>
                        <th class="text-center" width="12%">Kategori</th>
                        <th class="text-center" width="10%">Stok Saat Ini</th>
                        <th class="text-center" width="10%">Stok Minimum</th>
                        <th class="text-center" width="10%">Volume Penjualan</th>
                        <th class="text-right" width="12%">Harga Satuan</th>
                        <th class="text-center" width="8%">Skor</th>
                        <th class="text-center" width="12%">Prioritas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($priorities as $index => $item)
                    <tr @if($index == 0) class="rank-1" @elseif($index == 1) class="rank-2" @elseif($index == 2) class="rank-3" @endif>
                        <td class="text-center">
                            @if($index == 0)
                                <strong>🥇 1</strong>
                            @elseif($index == 1)
                                <strong>🥈 2</strong>
                            @elseif($index == 2)
                                <strong>🥉 3</strong>
                            @else
                                {{ $index + 1 }}
                            @endif
                        </td>
                        <td><strong>{{ $item['name'] }}</strong></td>
                        <td class="text-center">{{ $item['category_name'] }}</td>
                        <td class="text-center {{ $item['stock'] <= $item['min_stock'] ? 'status-urgent' : '' }}">
                            {{ $item['stock'] }} {{ $item['unit'] }}
                        </td>
                        <td class="text-center">{{ $item['min_stock'] }} {{ $item['unit'] }}</td>
                        <td class="text-center">{{ $item['sales_frequency'] }}x</td>
                        <td class="text-right">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                        <td class="text-center"><strong>{{ number_format($item['score'] * 100, 1) }}%</strong></td>
                        <td class="text-center">
                            @if($item['priority'] == 'Sangat Tinggi')
                                <span class="status-urgent">SANGAT TINGGI</span>
                            @elseif($item['priority'] == 'Tinggi')
                                <span class="status-high">TINGGI</span>
                            @elseif($item['priority'] == 'Sedang')
                                <span class="status-medium">SEDANG</span>
                            @else
                                <span class="status-low">RENDAH</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center" style="padding: 20px;">
                            Tidak ada data produk untuk dianalisis.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer Section (Blok Tanda Tangan) -->
        <div class="footer-section">
            <div class="signature-box">
                <div class="date">Bambaloka, {{ date('d/m/Y') }}</div>
                <div class="role">Pemilik Toko</div>
                <div class="name">Rusli</div>
            </div>
        </div>

        <!-- Footer Info -->
        <div class="footer-info">
            Dokumen ini dicetak secara otomatis oleh Sistem Inventaris Toko Aira pada {{ date('d/m/Y H:i') }}
        </div>
    </div>
</body>
</html>
