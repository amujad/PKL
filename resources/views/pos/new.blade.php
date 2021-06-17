@extends('adminlte::page')

@section('title', 'Pos')

@section('content_header')
    <div class="container pt-0 pl-5 pr-5 pb-5">
    <h1>Pengiriman Baru</h1>
        <div class="card mt-3">
            <div class="card-body container">
            <form id="form_id" action="{{route('createByPos')}}" method="post" class="needs-validation" novalidate>
                @csrf <!-- {{ csrf_field() }} -->
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="pos_id" value="{{Auth::user()->pos->id}}">
                <div class="row">
                    <div class="form-group col-6">
                        <label for="pemilik">Nama Pemilik</label>
                        <input type="text" class="form-control" name="pemilik" id="pemilik" placeholder="Masukkan Nama Pemilik" required>
                    </div>
                    <div class="form-group col-3">
                        <label for="noPerkara">Nomor Perkara</label>
                        <input type="text" class="form-control" name="noPerkara" id="noPerkara" placeholder="Masukkan Nomor Perkara" required>
                    </div>
                    <div class="form-group col-3">
                        <label for="hp">Nomor Hp Pemilik</label>
                        <input type="text" class="form-control" name="hp" id="hp" placeholder="Masukkan Nomor Hp Pemilik" required>
                    </div>
                </div>
                <div class="row">
                <div class="form-group col-6">
                    <label for="alRumah">Alamat Rumah</label>
                    <input type="text" class="form-control" name="alRumah" id="alRumah" placeholder="Masukkan Alamat Rumah" required>
                </div>
                <div class="form-group col-6">
                    <label for="alPengiriman">Alamat Pengiriman</label>
                    <input type="text" class="form-control" name="alPengiriman" id="alPengiriman" placeholder="Masukkan Alamat Pengiriman" required>
                </div>
                </div>
                <button id="submit" type="submit" class="btn btn-success">Simpan</button> 
            </form>
            </div>
        </div>
    </div>
@stop

@section('content')
@stop

@section('css')
@stop

@section('js')
<script>
(function () {
  'use strict'
  var forms = document.querySelectorAll('.needs-validation')

  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
        }
        form.classList.add('was-validated')
      }, false)
    })
})()
</script>

@if(session()->has('success'))
<script>
    Swal.fire("Sukses","{{ session('success') }}","success")
    window.onload = function(){
        let newTab = window.open();
        newTab.location.href = ("{{route('pdf',['id' => session('pdf')])}}");
    }
    @php
        session()->forget('success');
        session()->forget('noreg');      
    @endphp  
</script>
@endif
@stop