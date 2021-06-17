@extends('adminlte::page')

@section('title', 'Pos')

@section('content_header')
    <div class="container pt-0 pl-5 pr-5 pb-5">
    <h1>Pengiriman Terkirim</h1>
        <div class="card mt-3">
            <div class="card-body container">
            <form id="form_id" action="{{route('terkirimResi')}}" method="post" class="needs-validation" novalidate>
                @csrf <!-- {{ csrf_field() }} -->
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div form-group>
                <label for="id">Pengiriman (No Register - Pemilik - No Perkara)</label>
                <select class="form-control" name="id" id="id" required>
                    @foreach($pengiriman as $kirim)
                    <option value="{{$kirim->id}}">{{$kirim->no_register}} - {{$kirim->pemilik}} - {{$kirim->no_perkara}}</option>
                    @endforeach
                </select>
                </div>
                <div class="form-group mt-2">
                    <label for="resi">Resi</label>
                    <input type="text" class="form-control" name="resi" id="resi" placeholder="Masukkan Resi" required>
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
        newTab.location.href = ("{{route('wa',['reg' => session('noreg')])}}");
    }
    @php
        session()->forget('success');
        session()->forget('noreg');      
    @endphp  

</script>
@endif
@stop