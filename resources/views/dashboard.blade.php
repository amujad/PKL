@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 class="container">Dashboard</h1>
@stop

@section('content')
<div class="container">
    @if(Auth::user()->user_type == 'admin')
    <div class="row">
        @foreach($userByType as $ubt)
        <div class="col-lg-4 col">
            @if($ubt->user_type == 'admin')
            <div class="small-box bg-purple">
            @elseif($ubt->user_type == 'pos')
            <div class="small-box bg-maroon">
            @else
            <div class="small-box bg-green">
            @endif
                <div class="inner">
                    <h3>{{$ubt->data}}</h3>
                    <p>User {{$ubt->user_type}}</p>
                </div>
                <div class="icon">
                    @if($ubt->user_type == 'admin')
                    <i class="fas fa-fw fa-users-cog"></i>
                    @elseif($ubt->user_type == 'pos')
                    <i class="fas fa-fw fa-user-tag"></i>
                    @else
                    <i class="fas fa-fw fa-users"></i>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <div class="row">
        @foreach($kirimByStatus as $kbs)
        <div class="col-lg-4 col">
            @if($kbs->status == 'Diproses')
            <div class="small-box bg-danger">
            @elseif($kbs->status == 'Terproses')
            <div class="small-box bg-info">
            @else
            <div class="small-box bg-olive">
            @endif
                <div class="inner">
                    <h3>{{$kbs->data}}</h3>
                    <p>Pengiriman {{$kbs->status}}</p>
                </div>
                <div class="icon">
                    @if($kbs->status == 'Diproses')
                    <i class="fas fa-fw fa-spinner"></i>
                    @elseif($kbs->status == 'Terproses')
                    <i class="fas fa-fw fa-envelope"></i>
                    @else
                    <i class="fas fa-fw fa-envelope-open"></i>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row">
        <div class="col-lg-6 col">
            <div class="card shadow-sm ">
                <div class="card-header">
                    <h3 class="card-title">Permintaan Pengiriman Per Bulan</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-paginate table-hover">
                            <thead>
                                <tr>
                                    <th>Tahun</th>
                                    <th>Bulan</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mintaKirimByBulan as $mkbb)
                                <tr>
                                    <td>{{$mkbb->year}}</td>
                                    <td>{{$mkbb->month}}</td>
                                    <td>{{$mkbb->data}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Pengiriman Terkirim Per Bulan</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-paginate table-hover">
                            <thead>
                                <tr>
                                    <th>Tahun</th>
                                    <th>Bulan</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kirimByBulan as $kbb)
                                <tr>
                                    <td>{{$kbb->year}}</td>
                                    <td>{{$kbb->month}}</td>
                                    <td>{{$kbb->data}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
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
@stop
