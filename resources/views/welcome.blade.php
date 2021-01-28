@extends('adminlte::master')

@section('title','SIMOPA')

@section('body')
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="p-6">
                        <div class="flex items-center container">
                            <div class="pt-5 pt-lg-0">
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
                        </div>
                        <form id="lacak" class="input-group container rounded ">
                            <input type="search"aria-label="Search" id="nomorCari" class="form-control mb-2 mt-2 " placeholder="Masukkan nomor perkara" />
                            <button class="btn btn-success mb-2 mt-2" id="submit" value="cari">
                                <i class="fas fa-search"></i>
                            </button>
                        </form> 
                    </div>
                    <table id="list">
                        <tr>
                            <td id="titleNama"></td>
                            <td id="nama"></td>
                        </tr>
                        <tr>
                            <td id="titleResi"></td>
                            <td id="resi"></td>
                        </tr>
                    </table>   
                </div>
            </div>
        </div>
    </div>
    <script>
        jQuery(document).ready(function(){
            $("#submit").click(function (e) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    }
                });
                e.preventDefault();
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
                    success: function (data) {
                        console.log(data);
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });
        });
    </script>
@stop
