@extends('adminlte::page')

@section('title', 'admin')

@section('content_header')
    <h1 class="container">Manajemen Users</h1>
@stop

@section('content')
    <div class="card container">
        <div class="card-header">
            <div class="btn btn-sm btn-info" data-toggle='modal' data-target='#modalUser' onclick="newUser()">
                <span class="fas fa-plus fa-fw"></span>User Baru
            </div>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
            <table class="table table-hover table-paginate">
                <thead>
                    <tr>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>No Hp</th>
                        <th>Email</th>
                        <th>Tipe User</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    @if($user == auth::user())
                        @continue
                    @endif
                    <tr>
                        <td>{{$user->NIP}}</td>
                        <td>{{$user->nama}}</td>
                        <td>{{$user->username}}</td>
                        <td>{{$user->hp}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->user_type}}</td>
                        <td>
                            <div class="row">
                                <button class="btn btn-primary btn-sm col" data-toggle="modal" data-target='#modalUser' data-id="{{$user->id}}" 
                                data-NIP="{{$user->NIP}}" data-nama="{{$user->nama}}" data-usname="{{$user->username}}" data-hp="{{$user->hp}}" 
                                data-mail="{{$user->email}}" data-tipe="{{$user->user_type}}" onclick="editUser(this)">
                                    <span class="fas fa-edit"></span>
                                </button>
                                
                                <button class="btn btn-secondary btn-sm col" data-toggle="modal" data-target="#reset" data-id="{{$user->id}}" onclick="reset(this)">
                                    <span class="fas fa-undo"></span>
                                </button>

                                <button id="btnDel" class="btn btn-danger btn-sm col" data-toggle="modal" data-target="#deleteUser" data-id="{{$user->id}}" onclick="delUser(this)">
                                    <span class="fas fa-trash"></span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>

        <div class="modal fade" id="modalUser" role="dialog" tabindex="-1">
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
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukkan Nama" required>
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" name="username" id="username" placeholder="Masukkan Username"required>
                            </div>
                            <div class="form-group">
                                <label for="NIP">NIP</label>
                                <input type="text" class="form-control" name="NIP" id="NIP" placeholder="Masukkan NIP" required>
                            </div>
                            <div class="form-group">
                                <label for="hp">Nomor Hp</label>
                                <input type="text" class="form-control" name="hp" id="hp" placeholder="Masukkan Nomor Hp"required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Masukkan Email" required>
                            </div>
                            <label>Tipe User</label>
                            <div class="form-group row container">
                                <div class="form-check col-sm-2">
                                    <input type="radio" class="form-check-input" onclick="isUserPos();" name="userType" id="userAdmin" value="admin" checked>
                                    <label for="form-check-label">Admin</label>
                                </div>
                                <div class="form-check col-sm-4">
                                    <input type="radio" class="form-check-input" onclick="isUserPos();" name="userType" id="userMejaIII" value="mejaIII">
                                    <label for="form-check-label">Petugas Meja III</label>
                                </div>
                                <div class="form-check col-sm">
                                    <input type="radio" class="form-check-input" onclick="isUserPos();" name="userType" id="userPos" value="pos">
                                    <label for="form-check-label">Petugas Pos</label>
                                </div>
                            </div>
                            <div class="form-group" id="kantorPos" style="display:none;">
                                <label for="alamatPos">Alamat Kantor Pos</label>
                                <input type="text" class="form-control" name="alamatPos" id="alamatPos" placeholder="Masukkan Alamat Kantor Pos">
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

        <div class="modal fade" id="deleteUser" role="dialog" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Menghapus User</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>    
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin untuk menghapus user ini?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
                        <form action="{{route('delete')}}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" id="userId" name="userId" val="">
                        <button type="submit" class="btn btn-danger">Hapus</button> 
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="reset" role="dialog" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Reset Password User</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>    
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin untuk mereset password user ini?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batalkan</button>
                        <form action="{{route('reset')}}" method="post">
                        @csrf
                        <input type="hidden" id="idReset" name="idReset" val="">
                        <button type="submit" class="btn btn-warning">Reset</button> 
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


<script type="text/javascript" charset="utf-8">
    $(document).ready(function() {
	$('.table-paginate').dataTable({
        "order": [[ 0, "desc" ]]
    });
 } );
</script>

<script>
    window.onload = function(){
        document.getElementById('kantorPos').style.display='none';
    }
    function isUserPos(){
        if(document.getElementById('userPos').checked){
            document.getElementById('kantorPos').style.display='block';
            document.getElementById('alamatPos').value="";
            document.getElementById('alamatPos').setAttribute("required","");
        }
        else{
            document.getElementById('kantorPos').style.display='none';
            document.getElementById('alamatPos').removeAttribute("required");
        }
    }
    function delUser(btn){
        var id = btn.getAttribute('data-id');
        document.getElementById('userId').value=id;
    }
    function reset(btn){
        var id = btn.getAttribute('data-id');
        document.getElementById('idReset').value=id;
    }
    function newUser(){
        document.getElementById('form_id').classList.remove('was-validated');
        document.getElementById('form_id').action="{{route('newUser')}}";
        document.getElementById('modal-title').textContent="Menambahkan User Baru";
        document.getElementById('form_id').reset();
        isUserPos();
        return false;
    }

    function editUser(btn){
        document.getElementById('form_id').classList.remove('was-validated');
        var id = btn.getAttribute('data-id');
        document.getElementById('modal-title').textContent="Edit Data User"
        document.getElementById('form_id').action="{{route('update')}}"
        document.getElementById('id').value=id
        document.getElementById('nama').value=btn.getAttribute('data-nama');
        document.getElementById('username').value=btn.getAttribute('data-usname');
        document.getElementById('NIP').value=btn.getAttribute('data-NIP');
        document.getElementById('hp').value=btn.getAttribute('data-hp');
        document.getElementById('email').value=btn.getAttribute('data-mail');
        if(btn.getAttribute('data-tipe')=='mejaIII'){
            document.getElementById('userMejaIII').checked=true;
            isUserPos()
        }
        else if(btn.getAttribute('data-tipe')=='pos'){
            document.getElementById('userPos').checked=true;
            isUserPos();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            })
            $.ajax({
                type: "POST",
                url:"{{route('getPos')}}",
                data: {"user_id" : btn.getAttribute('data-id')},
                dataType:'json',
                success: function(data){
                    document.getElementById('alamatPos').value = data.alamat_kantor_pos
                },
                error:function(data){
                    console.log(data)
                }
            }) 
        }
        else{
            document.getElementById('userAdmin').checked=true;
            isUserPos()
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