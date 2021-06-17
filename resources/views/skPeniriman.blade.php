<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <style>
        @page { margin: 50px; }
            h5{
            font-size:16px;
            font-weight:normal;   
            margin:10px
            }
            .t1, tr, td{
            border: 1px solid black;            
            border-collapse: collapse;
            text-indent: 10px;
            table-layout: fixed;
            }

            .t1 tr {
                line-height:15px
            }

            .t1 td{
                padding:10px
            }

            ol {
            margin: 0;
            padding-left: 20px;
            padding-top:0;
            }
            ol.p{
                padding:0
            }
            .r2{
            border:none; 
            }
        </style>
    </head>
    <body>
        <h5 style="text-align: center;">SURAT KUASA PENGAMBILAN DAN PENGIRIMAN</h5>
        <h5  style="text-align: center;">AKTA CERAI SERTA SALINAN PUTUSAN/SALINAN PENETAPAN</h5>
        <p>Pada hari ini {{\Carbon\Carbon::parse(today())->isoFormat('dddd')}} Tanggal {{\Carbon\Carbon::parse(today())->isoFormat('D MMMM Y')}} saya yang bertanda tangan dibawah ini</p>
        <table class="t1" style="width:705px">
            <tr class="r1">
                <td style="width:28%" >Nama</td>
                <td>{{$pengiriman->pemilik}}</td>
            </tr>
            <tr>
                <td>Alamat Rumah</td>
                <td>{{$pengiriman->alamat_rumah}}</td>
            </tr>
            <tr>
                <td>Alamat Pengiriman</td>
                <td>{{$pengiriman->alamat_pengirim}}</td>
            </tr>
            <tr>
                <td>No.HP</td>
                <td>{{$pengiriman->hp}}</td>
            </tr>
            <tr>
                <td>Nomor Perkara</td>
                <td>{{$pengiriman->no_perkara}}</td>
            </tr>
        </table>
        Selanjutnya disebut Pihak I<br><br>
        <table class="t1" style="width:705px">
            <tr>
                <td style="width:28%">Nama</td>
                <td>{{$user->nama}}</td>
            </tr>
            <tr>
                <td>NIP</td>
                <td>{{$user->NIP}}</td>
            </tr>
            <tr>
                <td>Alamat Kantor Pos</td>
                <td>{{$user->pos->alamat_kantor_pos}}</td>
            </tr>
            <tr>
                <td>HP</td>
                <td>{{$user->hp}}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>Petugas Kantor POS Kebumen di Pengadilan Agama Kebumen</td>
            </tr>
        </table>
        Selanjutnya disebut Pihak II<br>
        <p style="text-align:justify;line-height:1.6; margin-bottom:0;">Dengan ini Pihak I membri kuasa kepada Pihak II untuk pengambilan dan mengirimkan Akta Cerai serta
        Salinan Putusan/Penetapan di Pengadilan Agama Kebumen dengan kesepakatan bersama sebagai berikut:</p>
        <ol style="text-align:justify line-height:1.6;">
        <li style=line-height:1.6;text-align:justify>Pihak II mengirimkan kepada Pihak I sesusai <b>nama dan alamat</b> yang telah disepakati dan semua biaya yang timbul
        untuk pengambilan Akta Cerai dan atau Salinan Putusan ditanggung oleh Pihak I</li>
        <li style=line-height:1.6;text-align:justify>Apabila dalam 3x(Tiga Kali) Proses antar Pihak I tidak ada di tempat, maka dokumen akan kembali ke Kantor Pengadilan Agama Kebumen</li>
        <li style=line-height:1.6;text-align:justify>Jika dalam proses antar Akta Cerai dan Salinan Putusan/Penetapan hilang, maka Pihak II akan membantu sampai terbitnya duplikat Akta Cerai
        dan akan diganti sesuai Nilai Pertanggungan Harga Barang (NPHB) atau Kompensasi yaitu Rp 2.000.000,- (dua juta rupiah);</li> 
        </ol>
        <p style="margin-top:0; padding-left:3rem; line-height:1.6;">&emsp;Demikian Surat Kuasa ini saya buat untuk dipergunakan sebagaimana mestinya</p>
        
        <table style="width:705px">
            <tr class="r2">
                <td style="border:none; text-indent: 0px;">Pihak II<br>Yang Menerima Kuasa:</td>
                <td style="border:none;text-indent: 120px;">Pihak I<p style="margin:0">Yang Memberi Kuasa:</p></td>
            </tr>
            <tr class="r2">
                <td class="r2"></td>
                <td class="r2" style="opacity:0.6; text-indent:50px; font-size:15px;"><p>Materai 6.000</p></td>
            </tr >
            <tr class="r2">
                <td class="r2" style="margin:0;padding-top:15px">......................................</td>
                <td class="r2"><p style="margin:0;text-indent: 120px; padding-top:15px">......................................</td>
            </tr>
            <tr class="r2">
                <td class="r2">*) Coret yang tidak perlu <br>**)Pihak I harap melampirkan FC KTP</td>
                <td class="r2"></td>
            </tr>
        </table>
    </body>
</html>