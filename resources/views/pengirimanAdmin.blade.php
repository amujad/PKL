@extends('adminlte::page')

@section('title', 'admin')

@section('content_header')
    <h1>Manajemen Pengiriman</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="btn btn-sm btn-info" data-toggle='modal' data-target='#modalKirim' onclick="newKirim()">
                <span class="fas fa-plus fa-fw"></span>Pengiriman Baru
            </div>
        </div>
        <div class="card-body">
        <div class="table-responsive">
        <table class="table table-hover table-paginate  ">
                <thead>
                    <tr>
                    <th>Nomor Register</th>
                    <th>Nomor Perkara</th>
                    <th>Pemilik</th>
                    <th>Alamat Pengiriman</th>
                    <th>No Hp Pemilik</th>
                    <th>Petugas Pos</th>
                    <th>Status</th>
                    <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Pengiriman as $kirim)
                    <tr>
                    <td>{{$kirim->no_register}}</td>
                    <td>{{$kirim->no_perkara}}</td>
                    <td>{{$kirim->pemilik}}</td>
                    <td>{{$kirim->alamat_pengirim}}</td>
                    <td>{{$kirim->hp}}</td>
                    <td>{{$kirim->pos->user->nama}}</td>
                    <td>{{$kirim->status}}</td>
                    <td>
                        <div class="row">
                            <button class="btn btn-primary btn-sm col-6" data-toggle="modal" data-target='#modalKirim' data-kirim="{{$kirim}}" onclick="editKirim(this)">
                                <span class="fas fa-edit"></span>
                            </button>
                            <button id="btnDel" class="btn btn-danger btn-sm col-6" data-toggle="modal" data-target="#deleteKirim" data-id="{{$kirim->id}}" onclick="delKirim(this)">
                                <span class="fas fa-trash"></span>
                            </button>
                        </div></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
                                <div class="form-group col-4">
                                    <label for="noPerkara">Nomor Perkara</label>
                                    <input type="text" class="form-control" name="noPerkara" id="noPerkara" placeholder="Masukkan Nomor Perkara" required>
                                </div>
                                <div class="form-group col-4">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control" onchange="isStatus()">
                                        <option value="Diproses">Diproses</option>
                                        <option value="Terproses">Telah Diproses</option>
                                        <option value="Terkirim">Terkirim</option>
                                    </select>
                                </div>
                                <div class="form-group col-4">
                                    <label for="pos">Petugas Pos</label>
                                    <select name="pos" id="pos" class="form-control">
                                        @foreach($pos as  $tpos)
                                        <option value="{{$tpos->id}}">{{$tpos->user->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row" >
                                <div class="form-group col-4" style="display:none;" id="formNoAkta">
                                    <label for="noAkta">Nomor Akta</label>
                                    <input type="text" class="form-control" name="noAkta" id="noAkta" placeholder="Masukkan Nomor Akta">
                                </div>
                                <div class="form-group col-4" style="display:none;" id="formTglAkta">
                                    <label for="tglAkta">Tanggal Akta</label>
                                    <input type="date" class="form-control" name="tglAkta" id="tglAkta" placeholder="Masukkan Alamat Resi">
                                </div>
                                <div class="form-group col-4" style="display:none;" id="formResi">
                                    <label for="resi">Resi</label>
                                    <input type="text" class="form-control" name="resi" id="resi" placeholder="Masukkan Resi">
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
                            <button id="delUser" type="submit" class="btn btn-primary">Simpan</button> 
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteKirim" role="dialog" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Menghapus Data Pengiriman</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>    
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin untuk menghapus pengiriman ini?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
                        <form action="{{route('deleteKirim')}}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" id="posId" name="posId" val="">
                        <button type="submit" class="btn btn-danger">Hapus</button> 
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
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

<script>
    function newKirim(){
        document.getElementById('form_id').classList.remove('was-validated');
        document.getElementById('form_id').action="{{route('createByAdmin')}}";
        document.getElementById('modal-title').textContent="Menambahkan Pengiriman";
        document.getElementById('form_id').reset();
        document.getElementById('formNoAkta').style.display = 'none';
        document.getElementById('formTglAkta').style.display = 'none';
        document.getElementById('formResi').style.display = 'none';
        return false;
    }

    function isStatus(){
        var val = document.getElementById('status').value;
        if(val == "Diproses"){
            document.getElementById('formNoAkta').style.display = 'none';
            document.getElementById('formTglAkta').style.display = 'none';
            document.getElementById('formResi').style.display = 'none';
            document.getElementById('noAkta').value='';
            document.getElementById('tglAkta').value='';
            document.getElementById('resi').value='';
            document.getElementById('noAkta').removeAttribute('required');
            document.getElementById('tglAkta').removeAttribute('required');
            document.getElementById('resi').removeAttribute('required');
            
        }
        else if(val == "Terproses"){
            document.getElementById('formNoAkta').style.display = 'block';
            document.getElementById('formTglAkta').style.display = 'block';
            document.getElementById('formResi').style.display = 'none'
            document.getElementById('noAkta').setAttribute('required','');
            document.getElementById('tglAkta').setAttribute('required','');
            document.getElementById('resi').removeAttribute('required');
            document.getElementById('resi').value='';
        }
        else{
            document.getElementById('formNoAkta').style.display = 'block';
            document.getElementById('formTglAkta').style.display = 'block';
            document.getElementById('formResi').style.display = 'block'
            document.getElementById('noAkta').setAttribute('required','');
            document.getElementById('tglAkta').setAttribute('required','');
            document.getElementById('resi').setAttribute('required','');
        }
    }

    function editKirim(btn){
        document.getElementById('form_id').classList.remove('was-validated');
        document.getElementById('form_id').action = "{{route('updateKirim')}}";
        document.getElementById('modal-title').textContent = "Edit Data Pengiriman"
        document.getElementById('formNoAkta').style.display = 'none';
        document.getElementById('formTglAkta').style.display = 'none';
        document.getElementById('formResi').style.display = 'none';
        var pos = btn.getAttribute('data-kirim');
        var tpos = JSON.parse(pos);
        document.getElementById('id').value = tpos.id;
        document.getElementById('status').value = tpos.status;
        document.getElementById('pemilik').value = tpos.pemilik;
        document.getElementById('noPerkara').value = tpos.no_perkara;
        document.getElementById('alRumah').value = tpos.alamat_rumah;
        document.getElementById('hp').value = tpos.hp;
        document.getElementById('alPengiriman').value = tpos.alamat_pengirim;
        var pos = document.getElementById('pos');
        var opts = pos.options;
        for (var opt, j = 0; opt = opts[j]; j++) {
            if (opt.value == tpos.pos_id) {
            pos.selectedIndex = j;
            break;
            }
        }
        if(tpos.status == 'Terproses' || tpos.status == 'Terkirim'){
            document.getElementById('formNoAkta').style.display = 'block';
            document.getElementById('formTglAkta').style.display = 'block';
            document.getElementById('noAkta').value = tpos.no_akta;
            document.getElementById('tglAkta').value = tpos.tanggal_akta;
            if(tpos.status == 'Terkirim'){
                document.getElementById('formResi').style.display = 'block'
                document.getElementById('resi').value = tpos.resi;
            }
            
        }


    }

    function delKirim(btn){
        var id = btn.getAttribute('data-id');
        document.getElementById('posId').value=id;
    }
</script>

<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
	$('.table-paginate').dataTable({
        "order": [[ 0, "desc" ]]
    });
 } );
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
