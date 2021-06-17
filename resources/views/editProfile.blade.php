@extends('adminlte::page')

@section('title', 'Edit Profile')

@section('content_header')
    <div class="container pt-0 pl-5 pr-5 pb-5">
    <h1>Edit Profile</h1>
        <div class="card mt-3">
            <div class="card-body container">
            <form id="form_id" action="{{route('profile')}}" method="post" class="needs-validation" novalidate>
                @csrf <!-- {{ csrf_field() }} -->
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" name="nama" id="nama" value="{{Auth::user()->nama}}" required>
                    <div class="invalid-feedback">Harap isi form</div>
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="username" value="{{Auth::user()->username}}" required>
                    <div class="invalid-feedback">Harap isi form</div>
                </div>
                <div class="form-group">
                    <label for="NIP">NIP</label>
                    <input type="text" class="form-control" name="NIP" id="NIP"value="{{Auth::user()->NIP}}" required>
                    <div class="invalid-feedback">Harap isi form</div>
                </div>
                <div class="form-group">
                    <label for="hp">Nomor Hp</label>
                    <input type="text" class="form-control" name="hp" id="hp" value="{{Auth::user()->hp}}" required>
                    <div class="invalid-feedback">Harap isi form</div>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" value="{{Auth::user()->email}}" required>
                    <div class="invalid-feedback">Harap isi form</div>
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
@stop