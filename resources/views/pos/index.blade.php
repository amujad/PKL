@extends('adminlte::page')

@section('title', 'Pos')

@section('content_header')
<h1 class="container">Tugas Pengiriman</h1>
    <div class="container">
        <div class="card mt-3">
            <div class="card-body">
            <table class="table table-paginate table-responsive">
                <thead>
                    <tr>
                        <th>No Register</th>
                        <th>No Perkara</th>
                        <th>Nama Pemilik</th>
                        <th>Alamat Pengiriman</th>
                        <th>No Hp</th>
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
                        <td>{{$kirim->hp}}</td>
                        <td>{{$kirim->status}}</td>
                        <td>
                        @if($kirim->status == 'Diproses')
                            <div class=row>
                                <a href="{{route('pdf',[$kirim->no_register])}}" class="button btn-sm btn-info col-6" target="_blank">
                                    <span class="fas fa-print fw"></span>
                                </a>
                                <button class="btn btn-sm btn-primary col-6" data-toggle="modal" data-target='#modalKirim' data-kirim="{{$kirim}}" onclick="editKirim(this)">
                                    <span class="fas fa-edit fw "></span>
                                </button>
                            </div>
                        @elseif($kirim->status == 'Terproses')
                            <div class="row">
                            <a href="{{route('terkirimII',[$kirim->no_register])}}" class="button btn-sm btn-dark col-6">
                                <span class="fas fa-envelope fw"></span>
                            </a>
                            <button class="btn btn-sm btn-primary col-6" data-toggle="modal" data-target='#modalKirim' data-kirim="{{$kirim}}" onclick="editKirim(this)">
                                    <span class="fas fa-edit fw "></span>
                            </button>
                            </div>
                        @elseif($kirim->status == 'Terkirim')
                            <div class="row">
                            <a href="{{route('wa',[$kirim->no_register])}}" class="button btn-sm btn-success col-6" target="_blank">
                                <span class="fab fa-whatsapp fw"></span>
                            </a>    
                            
                            <button class="btn btn-sm btn-primary col-6" data-toggle="modal" data-target='#modalKirim' data-kirim="{{$kirim}}" onclick="editKirim(this)">
                                    <span class="fas fa-edit fw "></span>
                            </button>    
                            </div>
                        @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalKirim" role="dialog" tabindex="-1">
            <div class="modal-dialog modal-lg">
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
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="pemilik">Nama Pemilik</label>
                                    <input type="text" class="form-control" name="pemilik" id="pemilik" placeholder="Masukkan Nama Pemilik" required>
                                </div>
                                <div class="form-group col-6">
                                    <label for="hp">Nomor Hp Pemilik</label>
                                    <input type="text" class="form-control" name="hp" id="hp" placeholder="Masukkan Nomor Hp Pemilik" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="alRumah">Alamat Rumah</label>
                                <input type="text" class="form-control" name="alRumah" id="alRumah" placeholder="Masukkan Alamat Rumah" required>
                            </div>
                            <div class="form-group">
                                <label for="alPengiriman">Alamat Pengiriman</label>
                                <input type="text" class="form-control" name="alPengiriman" id="alPengiriman" placeholder="Masukkan Alamat Pengiriman" required>
                            </div>
                            
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="noPerkara">Nomor Perkara</label>
                                    <input type="text" class="form-control" name="noPerkara" id="noPerkara" placeholder="Masukkan Nomor Perkara" required>
                                </div>
                                <div class="form-group col-6" style="display:none;" id="formResi">
                                    <label for="resi">Resi</label>
                                    <input type="text" class="form-control" name="resi" id="resi" placeholder="Masukkan Resi" >
                                </div>
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
    function editKirim(btn){
        document.getElementById('form_id').classList.remove('was-validated');
        document.getElementById('form_id').action = "{{route('updateKirim')}}";
        document.getElementById('modal-title').textContent = "Edit Data Pengiriman"
        document.getElementById('formResi').style.display = 'none';
        var pos = btn.getAttribute('data-kirim');
        var tpos = JSON.parse(pos);
        document.getElementById('id').value = tpos.id;
        document.getElementById('pemilik').value = tpos.pemilik;
        document.getElementById('noPerkara').value = tpos.no_perkara;
        document.getElementById('alRumah').value = tpos.alamat_rumah;
        document.getElementById('hp').value = tpos.hp;
        document.getElementById('alPengiriman').value = tpos.alamat_pengirim;
        if(tpos.status == 'Terkirim'){
            document.getElementById('formResi').style.display = 'block'
            document.getElementById('resi').value = tpos.resi;
            document.getElementById('resi').setAttribute('required','');
        }
        else{
            document.getElementById('formResi').style.display = 'none'
            document.getElementById('resi').value = "";
            document.getElementById('resi').removeAttribute('required');
        }
            
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