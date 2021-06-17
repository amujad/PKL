<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\pos;
use App\Models\Pengiriman;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function user()
    {
        $users = User::all();
        return view('home',compact('users'));
    }

    public function pengiriman(){
        $Pengiriman = Pengiriman::all();
        $pos = pos::all();
        return view('pengirimanAdmin', compact('Pengiriman','pos'));
    }

    public function pos(){
        $user = Auth::user();
        $pengiriman = Pengiriman::where('pos_id', $user->pos->id)->orderBy('updated_at','DESC')->get();
        return view('pos.index',compact('user','pengiriman'));
    }

    public function kirimBaru(){
        return view('pos.new');
    }

    public function terkirim(){
        $user = Auth::user();
        $pengiriman = Pengiriman::where(['pos_id'=> $user->pos->id, 'status' => 'Terproses'])->orderBy('updated_at','DESC') ->get();
        return view('pos.terkirim', compact('pengiriman'));
    }

    public function terkirimII($noreg){
        $pengiriman = Pengiriman::where('no_register',$noreg)->get();
        return view('pos.terkirim', compact('pengiriman'));
    }

    public function mejaIII(){
        $pengiriman = Pengiriman::all();
        return view('mejaIII.index',compact('pengiriman'));
    }

    public function statusMejaIII($status){
        $pengiriman = Pengiriman::where('status', $status)->orderBy('updated_at','DESC')->get();
        return view('mejaIII.index',compact('pengiriman'));
    }
    

    public function profile(){
        return view('editProfile');
    }

    public function gantiPw(){
        return view('gantipw');
    }

    public function dashboardPos(){
        $status = ['Diproses','Terproses','Terkirim'];
        $mintaKirimByBulan = Pengiriman::selectRaw('year(created_at) year, monthname(created_at) month, count(*) data')
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->get();
        $kirimByBulan = Pengiriman::selectRaw('year(tanggal_terkirim) year, monthname(tanggal_terkirim) month, count(*) data')
                ->whereNotNull('tanggal_terkirim')
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->get();
        $kirimByStatus = Pengiriman::selectRaw('status, count(*) data')
                ->groupBy('status')
                ->orderByRaw('FIELD(status,"Diproses","Terproses","Terkirim")')
                ->get();
        return view('dashboard', compact('kirimByBulan','kirimByStatus','mintaKirimByBulan'));
    }

    public function dashboardAdmin(){
        $userByType = User::selectRaw('user_type,count(*) data')->groupBy('user_type')->get();
        $status = ['Diproses','Terproses','Terkirim'];
        $mintaKirimByBulan = Pengiriman::selectRaw('year(created_at) year, monthname(created_at) month, count(*) data')
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->get();
        $kirimByBulan = Pengiriman::selectRaw('year(tanggal_terkirim) year, monthname(tanggal_terkirim) month, count(*) data')
                ->whereNotNull('tanggal_terkirim')
                ->groupBy('year', 'month')
                ->orderBy('year', 'desc')
                ->get();
        $kirimByStatus = Pengiriman::selectRaw('status, count(*) data')
                ->groupBy('status')
                ->orderByRaw('FIELD(status,"Diproses","Terproses","Terkirim")')
                ->get();
        return view('dashboard', compact('userByType','kirimByBulan','mintaKirimByBulan','kirimByStatus'));
    }
    
}
