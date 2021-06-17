@extends('adminlte::page')

@section('title', 'MejaIII')

@section('content_header')
<div class="container pt-0 pl-5 pr-5 pb-5">
<h1>Daftar Pengiriman</h1>
    <div class="card mt-3">
        <div class="card-body table-responsive">
        <table class="table table-paginate">
            <thead>
                <tr>
                    <th>No Register</th>
                    <th>No Perkara</th>
                    <th>Nama Pemilik</th>
                    <th>Alamat Pengiriman</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach($pengiriman as $kirim)
                <tr>
                    <td>{{$kirim->no_register}}</td>
                    <td>{{$kirim->no_perkara}}</td>
                    <td>{{$kirim->pemilik}}</td>
                    <td>{{$kirim->alamat_pengirim}}</td>
                    <td>{{$kirim->status}}</td>
                    <td>
                    @if($kirim->status == 'Diproses')
                        <button class="btn btn-sm btn-success btn-block" data-id="{{$kirim->id}}" data-toggle="modal" data-target='#modalAkta' onclick="plusAkta(this)">
                            <div class=row>
                            <span class="fas fa-plus fw col"></span>
                            </div>
                        </button>
                    @else
                        <button class="btn btn-sm btn-primary btn-block" data-id="{{$kirim->id}}" data-toggle="modal"  data-no="{{$kirim->no_akta}}" data-tgl="{{$kirim->tanggal_akta}}" data-target='#modalAkta' onclick="editAkta(this)">
                            <div class="row">
                            <span class="fas fa-edit fw col"></span>
                            </div>
                        </button>
                    @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
    <div class="modal fade" id="modalAkta" role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form_id" action="" method="post" class="needs-validation" novalidate>
                    @csrf <!-- {{ csrf_field() }} -->
                    <div class="modal-header">
                        <h5 class="modal-title" id='modal-title'></h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>    
                    </div>
                    <input type="hidden" id="id" name="id" val="">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="modal-body">
                        <div class="form-group" id="formNoAkta">
                            <label for="noAkta">Nomor Akta</label>
                            <input type="text" class="form-control" name="noAkta" id="noAkta" placeholder="Masukkan Nomor Akta" required>
                        </div>
                        <div class="form-group" id="formTglAkta">
                            <label for="tglAkta">Tanggal Akta</label>
                            <input type="date" class="form-control" name="tglAkta" id="tglAkta" placeholder="Masukkan Alamat Resi" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
                        <button id="submit" type="submit" class="btn btn-primary">Simpan</button> 
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    
@stop

@section('content')
@stop

@section('css')
@stop

@section('js')
<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
	$('.table-paginate').dataTable({
        "order": [[ 0, "desc" ]]
    });
 } );
</script>


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

<script>
    function plusAkta(btn){
        document.getElementById('form_id').classList.remove('was-validated');
        document.getElementById('form_id').action="{{route('dataAkta')}}";
        document.getElementById('modal-title').textContent="Menambahkan Data Akta";
        document.getElementById('form_id').reset();
        document.getElementById('id').value = btn.getAttribute('data-id');
        return false;
    }

    function editAkta(btn){
        document.getElementById('form_id').classList.remove('was-validated');
        document.getElementById('form_id').action = "{{route('editAkta')}}";
        document.getElementById('modal-title').textContent = "Edit Data Akta"
        document.getElementById('id').value = btn.getAttribute('data-id');
        document.getElementById('noAkta').value = btn.getAttribute('data-no');
        document.getElementById('tglAkta').value = btn.getAttribute('data-tgl')
    }
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