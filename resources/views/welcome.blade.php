@extends('adminlte::master')

@section('title','SIMOPA')

<style>
body{ height:100vh; margin:0; }

header{ min-height:50px;}
footer{ min-height:50px; background:lightgrey; }

/* Trick */
body{ 
  display:flex; 
  flex-direction:column; 
}

footer{
  margin-top:auto; 
}

html {
    background: gray;
}

#icon{
        display:block;
}

#icon2{
        display:block;
}

@media (max-width:60rem){
    #icon{
        display:none;
    }
    #icon2{
        display:none;
    }
}

.card{
  transition: all 0.2s linear;
}

.hidden {
    display: none;
}

.visuallyhidden {
    opacity: 0;
}
.modal {
    display:    none;
    position:   fixed;
    z-index:    1000;
    top:        0;
    left:       0;
    height:     100%;
    width:      100%;
    background: rgba( 255, 255, 255, .8 ) 
                asset('images/ajax-loader.gif')
                50% 50% 
                no-repeat;
    opacity: 0.80;
    -ms-filter: progid:DXImageTransform.Microsoft.Alpha(Opacity = 80);
    filter: alpha(opacity = 80);
}

body.loading .modal {
    overflow: hidden;   
}
body.loading .modal {
    display: block;
}
</style>
@section('body')
<div class="relative flex items-top justify-center min-h-screen" style="background-color:mediumseagreen ">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="mt-8 overflow-hidden shadow sm:rounded-lg card">
            <div class="grid grid-cols-1 md:grid-cols-2 ">
                <div class="flex items-center container mt-3">
                    <table style="width:100%;" class="mb-4">
                        <tr>
                            <td>     
                                <h1 class="mb-0" style="font-size:4rem;">SIMOPA</h1>
                                <h3 class="mt-0">Sistem Monitoring Pengiriman Akta</h3>
                            </td>
                            <td class="text-right">
                                <img src="{{asset('images/logo.png')}}" alt="#" style="height:150px">
                            </td>
                        </tr>
                    </table>
                </div>
                <form id="lacak" class="input-group container rounded mb-4">
                    <input type="search"aria-label="Search" id="nomorCari" class="form-control mb-2 mt-2 " placeholder="Masukkan nomor perkara" required>
                    <button class="btn btn-success mb-2 mt-2" id="submit" value="cari">
                        <i class="fas fa-search"></i>
                    </button>
                </form> 
            </div>
        </div>
    </div>
    <div style="min-height:321px">
        <div class="container mt-3 p-3 card hidden visuallyhidden" id="card" style="max-width:60rem; text-align:center;">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 icon" id="icon"></div>
                    <div class="col-lg-6">
                        <h3 id="judul" ></h3>
                        <h5 id="pesan" ></h5>
                    </div>
                    <div class="col-lg-3 icon" id="icon2"></div>
                </div>
                <div class="mt-3 container table-responsive">
                    <table class="table table-hover container hidden" id="table">
                        <thead>
                            <tr>
                                <th style="min-width:100px">Tanggal</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody id="dataTable">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>    
</div>
<footer>
    <div class="container" >
        <div class="row justify-content-between">
            <p class="mt-3 col">SIMOPA : Sistem Monitoring Pengiriman Akta</p>
        </div>
    </div>
</footer>
<div class="modal"><!-- Place at bottom of page --></div>
@stop
@section('adminlte_js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script script type="text/javascript" charset="utf-8">
    $(document).ready(function(){
        $("#submit").click(function (e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            e.preventDefault()
            var formData = {
                nomor: jQuery('#nomorCari').val()
            };
            var state = jQuery('#submit').val();
            var type = "POST";
            var ajaxurl = '/cari';
            $.ajax({
                type: type,
                url: ajaxurl,
                data: formData,
                dataType: 'json',
                beforeSend: function(){
                    $('body').addClass("loading");
                },
                success: function (data) {
                    console.log(data);
                    $('#table').addClass('hidden');
                    let card = document.getElementById('card');
                    card.classList.add('visuallyhidden');    
                    card.addEventListener('transitionend', function(e) {
                        card.classList.add('hidden');
                    });
                    if(data.status == 'kosong'){
                        Swal.fire("Perkara Tidak Ditemukan","Nomor perkara yang Anda masukan tidak ditemukan. Harap masukan nomor perkara yang benar","error");
                    }
                    else{ 
                        if(data.status == 'Diproses'){
                            $('#judul').text("Akta Diproses");
                            $('#pesan').text("Akta Anda sedang dalam tahap pemrosesan. Harap tunggu akta diproses sebelum akta dikirimkan.");
                            $('#icon').html('<span class="fas fa-6x fa-spinner"></span>');
                            $('#icon2').html('<span class="fas fa-6x fa-spinner"></span>');
                        }
                        else if(data.status == 'Terproses'){
                            $('#judul').text("Akta Telah Terpores");
                            $('#pesan').text("Akta Anda telah tercetak dan siap untuk dikirimkan");
                            $('#icon').html('<span class="fas fa-6x fa-envelope"></span>');
                            $('#icon2').html('<span class="fas fa-6x fa-envelope"></span>');
                        }
                        else{
                            $('#judul').text("Akta Dalam Pengiriman");
                            if(data.hasOwnProperty('response')){
                                $('#pesan').text("Akta Anda dalam Pengiriman. Untuk melacak pengiriman buka ");
                                $('#pesan').append("<a href='https://www.posindonesia.co.id/id/tracking' target='_blank'>link<a> dan masukkan no resi : " + data.resi);
                            }
                            else{
                                $('#pesan').text("Akta Anda dalam Pengiriman. Dibawah ini detail dari pelacakan pengiriman");
                                $.each(data.data.history, function(i, item){
                                    $('#table').removeClass('hidden');
                                    $('#dataTable').append('<tr>');
                                    $('#dataTable').append('<td>'+item.date+'</td>');
                                    $('#dataTable').append('<td>'+item.desc+'<td>');
                                    $('#dataTable').append('</tr>');
                                });
                            }
                            $('#icon').html('<span class="fas fa-6x fa-truck"></span>');
                            $('#icon2').html('<span class="fas fa-6x fa-truck"></span>');
                        }
                        card.classList.add('visuallyhidden');    
                        card.addEventListener('transitionend', function(e) {
                            card.classList.add('hidden');
                        }, {
                            capture: true,
                            once: false,
                            passive: false
                        });
                        //Animation
                        if(card.classList.contains('hidden')){
                            card.classList.remove('hidden');
                            setTimeout(function(){
                                card.classList.remove('visuallyhidden')
                            },20);
                        }
                        //endAnimation
                    }
                },
                error: function (data) {
                    Swal.fire("Terjadi Kesalahan","Maaf terjasi kesalahan pada web.","error");
                }, 
                complete:function(data){
                    $('body').removeClass("loading");
                }
            });
        });
    });
</script>
<script>
    $body = $(document.body);
    $(document).on({
        ajaxStart: function() { $body    },
        ajaxStop: function() { $body.removeClass("loading"); }    
    });
</script>
@stop
