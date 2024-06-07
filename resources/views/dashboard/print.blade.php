@php
use App\Models\User;

// Mengambil data pengguna dengan ID 2
$guru = User::find(2);
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Raport</title>
    <style>
        /* Mengatur gaya dasar untuk body */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
    
        /* Mengatur gaya untuk elemen letterhead */
        .letterhead {
            width: 100%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px; /* Menambahkan padding samping */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    
        /* Mengatur gaya untuk elemen header */
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding: 10px; /* Menambahkan padding samping */
            margin-bottom: 20px;
        }
    
        .header img {
            max-height: 100px;
            margin-bottom: 10px;
        }
    
        .header h1,
        .header h2,
        .header p {
            margin: 0;
        }
    
        .header h1 {
            font-size: 24px;
        }
    
        .header h2 {
            font-size: 20px;
        }
    
        /* Mengatur gaya untuk konten utama */
        .content {
            font-size: 16px;
            line-height: 1.5;
            padding: 0 20px; /* Menambahkan padding samping */
        }
    
        /* Mengatur gaya untuk tabel */
        table {
            width: 100%;
            border: 1px solid #aaa;
            border-collapse: collapse;
        }
    
        table th,
        table td {
            border: 1px solid #aaa;
            padding: 10px;
            text-align: left;
        }
    
        /* Mengatur lebar kolom pada tabel */
        table th:nth-child(2),
        table td:nth-child(2) {
            width: 20%; /* Lebar kolom "Aspek" */
        }
    
        table th:nth-child(3),
        table td:nth-child(3) {
            width: 50%; /* Lebar kolom "Poin Penilaian" */
        }
    
        /* Mengatur gaya untuk kolom tanda tangan */
        .signature {
            text-align: right;
            margin-top: 50px;
            font-size: 18px; /* Menambah ukuran font */
            padding: 0 20px; /* Menambahkan padding samping */
        }
    
        .signature p {
            margin: 20px 0;
        }
    
        /* Mengatur gaya untuk footer */
        .footer {
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            text-align: center;
            font-size: 14px;
            color: #777;
            padding: 0 20px; /* Menambahkan padding samping */
        }
    </style>
    
</head>
<body>
    <div class="letterhead">
        <div class="header">
            <img src="" alt="Logo">
            <h1>TK Islam Hasanuddin</h1>
            <h2>RAPORT SISWA</h2>
            <p>Alamat: Jl. Brotojoyo Bar. II No.26, Semarang</p>
            <p>Telepon: 0821 3486 3529 | Email: tk.islamhasanuddin@gmail.com</p>
        </div>

        <div class="content">
            <p style="font-size: 16px; font-weight: bold;"><span>Nama Anak : </span> {{$biodata->nama}}</p>
            <p style="font-size: 16px; font-weight: bold;"><span>NISN : </span> {{$biodata->nisn}}</p>

            @if (count($nilai) > 0 && !empty($nilai[0]))
            <p style="font-size: 16px; font-weight: bold;"><span>Semester : </span> {{ $nilai[0]->semester }}</p>
            <p style="font-size: 16px; font-weight: bold;"><span>Tahun Ajaran : </span> {{ $nilai[0]->awal_ajaran }}/{{ $nilai[0]->akhir_ajaran }}</p>
            @endif

            @if (count($nilai) > 0)
            @php $i = 0; @endphp
            <table>
                <thead>
                    <tr>
                        <th scope="col">NO</th>
                        <th scope="col">Aspek</th>
                        <th scope="col">Poin Penilaian</th>
                        <th scope="col">Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($nilai as $item)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $item->nama_aspek }}</td>
                        <td style="max-width: 150px; text-overflow: wrap;">{{ $item->nama_poin }}</td>
                        <td>
                            {{ $item->nilai === 'mb' ? 'Mulai Berkembang' : ($item->nilai === 'bsh' ? 'Berkembang Sesuai Harapan' : ($item->nilai === 'bsb' ? 'Berkembang Sangat Baik' : '-')) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif

            <h3>Catatan Wali Kelas</h3>
            <p>.....................................................................................................................................................</p>
            <p>.....................................................................................................................................................</p>
            <p>.....................................................................................................................................................</p>
            <p>.....................................................................................................................................................</p>
            <p>......................................................................................................................................................</p>
        </div>

        <?php
        // Tentukan timezone
        date_default_timezone_set('Asia/Jakarta');

        // Ambil tanggal saat ini
        $hari = date('d');
        $bulan = date('m');
        $tahun = date('Y');

        // Array nama bulan dalam bahasa Indonesia
        $nama_bulan = array(
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        );

        // Konversi bulan ke teks
        $bulan_teks = $nama_bulan[$bulan];

        // Format tanggal lengkap
        $tanggal = $hari . ' ' . $bulan_teks . ' ' . $tahun;
        ?>

        <div class="content">
            <p>Tanggal: <?php echo $tanggal; ?></p>
            <p>Hormat kami,</p>
            <p>Wali Kelas</p>
            <p></p>
            <p></p>
            <p></p>
            <p></p>
            <p>{{ $guru->nama }}</p>       <!-- Menampilkan nama guru dengan ID 2 -->
        </div>

        <div class="signature">
            <p>Kepala Sekolah</p>
            <p></p>
            <p></p>
            <p></p>
            <p></p>
            <p>MOMENTRI MENTI</p>
        </div>

        <div class="footer">
            <p>&copy; 2024 TK Islam Hasanuddin. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
