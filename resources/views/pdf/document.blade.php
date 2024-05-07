<html>

<head>
    <title>{{ $title }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        * {
            margin: 0;
            letter-spacing: 0px;

        }

        .page-break {
            page-break-after: always;
        }

        h1 .title {
            font-weight: 900;
            border-bottom: 3px solid #000000;
            border-spacing: 3px;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            text-align: center;
        }
        tr td{
            font-size: 14px;
        }
    </style>
</head>

<body>
    <header style="width: 100%;  padding: 30px 30px 0px 30px; ">
        <table class="margin-left:30px;">
            <tr style="width: 150px;">
                <td>
                    <img src="{{ public_path('images/logo/logo-dark.png') }}" alt="Logo" width="100"
                        style="max-width: 100%; height: auto; display: block;">
                </td>
                <td style="max-width: 600px; margin: 0 auto; text-align: center;">
                    <h1 style="color: #333333; margin: 0;">Dinas Kesehatan Kabupaten Bantaeng</h1>
                    <p style="color: #666666; margin: 10px 0;">Puskesmas Desa Karassing</p>
                    <p style="color: #666666; margin: 10px 0;">Telepon: 123-456-7890 | Email: info@perusahaan.com</p>
                </td>
            </tr>
        </table>
        <hr style="width: 94%;">
    </header>
    <h1 style="margin-top: 0px;">
        <span style=" width : 300px ;border-bottom: 3px solid #000000; border-spacing: 3px;">
            {{ $title }}</span>
    </h1>
    <h4>No: {{ $nomor }}</h4>

    <table style="margin-left: 60px; margin-top:30px;">
        <thead>
            <tr>
                <td style="padding: 6px 2px; font-weight:700;" colspan="2">Dengan Ini Menyatakan Bahwa.</td>
            </tr>
            <tr>
                <td style="padding: 6px 2px; font-weight:700;">Nama </td>
                <td style="padding: 6px 2px; font-weight:700;"> : {{ $data['nama_balita'] }}</td>
            </tr>
            <tr>
                <td style="padding: 6px 2px; font-weight:700;">Tempat/Tanggal Lahir </td>
                <td style="padding: 6px 2px; font-weight:700;"> :
                    {{ $data['tempat_lahir'] }}/ {{ $data['tgl_lahir'] }}</td>
            </tr>
            <tr>
                <td style="padding: 6px 2px; font-weight:700;">Nama Wali/Orang Tua </td>
                <td style="padding: 6px 2px; font-weight:700;"> : {{ $data['nama_orang_tua'] }}</td>
            </tr>
            <tr>
                <td style="padding: 6px 2px; font-weight:700;">Alamat Wali/Orang Tua </td>
                <td style="padding: 6px 2px; font-weight:700;"> : {{ $data['alamat_orang_tua'] }}</td>
            </tr>
            <tr>
                <td style="padding: 6px 2px; font-weight:700;">No. Telpon Wali/Orang Tua </td>
                <td style="padding: 6px 2px; font-weight:700;"> : {{ $data['no_telpon_orang_tua'] }}</td>
            </tr>

            <tr>
                <td colspan="2" style="padding: 6px 2px; font-weight:700;">Telah Mendapatkan Lima Imunisasi Dasar
                    Lengkap (LIL).</td>
            </tr>
        </thead>


    </table>
    {{-- TABEL imunisasi --}}

    <table style="margin-left: 60px;margin-bottom: 10px; margin-top:10px; border: #000;" border="1" cellspacing="0">
        <thead>
            <tr>
                <th style="padding: 3px 10px;" colspan="2">Catatan Pemberian Imunisasi</th>
            </tr>
            <tr>
                <th style="padding: 3px 10px;">Antigen</th>
                <th style="padding: 3px 10px;">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($namaImunisasi as $key => $item)
                <tr>
                    <td style="padding: 3px 10px;">{{ $item }}</td>
                    <td style="padding: 3px 10px;">
                        @if ($data['jenis_imunisasi'][$key] === 'true' || $data['jenis_imunisasi'][$key] === true)
                        <span style="color: rgb(8, 153, 56)">Selesai</span>
                        @else
                        <span style="color: rgb(207, 7, 7)">Belum</span>

                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table style="margin-left: 60px;">
        <tr>
            <td colspan="2" style="padding: 6px 2px; font-weight:700;">Demikian Surat Digunakan Sebagaimana
                Mestinya</td>
        </tr>
    </table>

    {{-- TTD --}}
    <div style="width:100%; padding: 0px 0px; ">
        <table style="position: absolute; right:150px; bottom:270px; margin-top: 30px;">
            <tr>
                <td style="font-weight: 700; padding: 4px 0px;"> Desa Karassing, {{ date('j F Y') }}</td>
            </tr>
            <tr>
                <td style="font-weight: 700; padding: 20px 0px;"></td>
            </tr>
            <tr>
                <td style="font-weight: 700; padding: 20px 0px;"></td>
            </tr>
            <tr>
                <td style="font-weight: 700; padding: 4px 0px;">
                    <hr>
                </td>
            </tr>
            <tr>
                <td style="font-weight: 700; padding: 4px 0px;"> NIP: </td>
            </tr>
        </table>
    </div>

</body>

</html>
