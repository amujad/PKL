@extends('adminlte::page')

@section('title', 'Ganti Password')

@section('content_header')
    <div class="container pt-0 pl-5 pr-5 pb-5">
    <h1>Ganti Password</h1>
        <div class="card mt-3">
            <div class="card-body container">
            <form id="form_id" action="{{route('ganti-password')}}" method="post" class="needs-validation" novalidate>
                @csrf <!-- {{ csrf_field() }} -->
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="form-group">
                    <label for="pwDulu">Password Saat ini</label>
                    <input type="password" class="form-control" name="pwDulu" id="pwDulu" placeholder="Masukan password saat ini" required>
                    <div class="invalid-feedback"></div>
                </div> 
             
                <div class="form-group">
                    <label for="pwBaru">Password Baru (Minimal 8 Karakter)</label>
                    <input type="password" class="form-control" name="pwBaru" id="pwBaru" placeholder="Masukan password baru" required>
                    <div class="invalid-feedback"></div>
                </div>
               
                <div class="form-group">
                    <label for="kPwBaru">Konfirmasi Password Baru</label>
                    <input type="password" class="form-control" name="kPwBaru" id="kPwBaru" placeholder="Konfirmasi dengan memasukan password baru" required>
                    <div class="invalid-feedback"></div>
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
    @php
        session()->forget('success');    
    @endphp  
</script>
@endif
@if(session()->has('error'))
<script>
    Swal.fire("Error","{{ session('error') }}","error")
    @php
        session()->forget('error');    
    @endphp  
</script>
@endif
@stop