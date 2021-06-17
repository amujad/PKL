<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7;
use Illuminate\Http\Request;
use App\Models\Pengiriman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use  Carbon\Carbon;
use Response;
use PDF;

class PengirimanController extends Controller
{
    public function getPengiriman(Request $request){
        $pengiriman= Pengiriman::firstWhere('no_perkara',$request->nomor);
        if(!empty($pengiriman)){
            if($pengiriman->status == 'Terkirim'){
                $client = new Client();
                $api_key = "38ac20b32485a81e812b39a58743b65ad32a079e7bd0ecf9d30bf34457c16e98";
                $url = 'https://api.binderbyte.com/v1/track?api_key='.$api_key.'&courier=pos&awb='.$pengiriman->resi;
                try{
                    $result = $client->request('GET', $url, [
                        'verify'  => false,
                    ]);
                    $result = json_decode($result->getBody());
                } catch(ClientException $e){
                    $result = '{}';
                    $result = json_decode($result);
                    $result->response = Psr7\Message::toString($e->getResponse());  
                    $result->resi = $pengiriman->resi;     
                }
                
                $result->status = $pengiriman->status;
            }
            else if($pengiriman->status == 'Terproses'){
                $result = '{}';
                $result = json_decode($result);
                $result->status = $pengiriman->status;
                $result->no_akta = $pengiriman->no_akta;
                $result->tgl_akta = $pengiriman->tanggal_akta;
            }
            else{
                $result = '{}';
                $result = json_decode($result);
                $result->status = $pengiriman->status;
            }
        }else{
            $result = '{}';
            $result = json_decode($result);
            $result->status = 'kosong';
        }
        
        return Response::json($result);
    }

    public function createNoReg(){
        $count = Pengiriman::whereMonth('created_at',Carbon::now()->month)->whereYear('created_at',Carbon::now()->year)->count();
        $count += 1;
        $kode = sprintf("%03d", $count);
        $noReg = "16154311".date('y').date('m').$kode;
        return $noReg;
    }
    
    public function createUPos(Request $request){
        $request->validate([
            'pos_id'        => 'required',
            'pemilik'       => 'required',
            'noPerkara'     => 'required',
            'alRumah'       => 'required',
            'alPengiriman'  => 'required',
            'hp'            => 'required',
        ]);
        $pengiriman = new Pengiriman(); 
        $noreg = $this->createNoReg();
        $pengiriman->no_register = $noreg;
        $pengiriman->pos_id = $request->pos_id;
        $pengiriman->status = 'Diproses';
        $pengiriman->pemilik = $request->pemilik;
        $pengiriman->no_perkara = $request->noPerkara;
        $pengiriman->alamat_rumah = $request->alRumah;
        $pengiriman->alamat_pengirim = $request->alPengiriman;
        $pengiriman->hp = $request->hp;

        $pengiriman->save();

        return redirect()->back()->with('success','Penambahan pengiriman baru berhasil')->with('pdf',$pengiriman->no_register);
    }

    public function createPDF($id){
        $pengiriman = Pengiriman::firstWhere('no_register',$id);
        
        $user = Auth::user();
        $pdf = PDF::loadview('skPeniriman',compact('user','pengiriman'));
        $pdf->setPaper('A4');
        
        return $pdf->stream('SK-Pengiriman-'.$pengiriman->no_register.'.pdf');
    }


    public function createUAdmin(Request $request){
        $request->validate([
            'pos'       => 'required',
            'status'    => 'required',
            'pemilik'       => 'required',
            'noPerkara'     => 'required',
            'alRumah'       => 'required',
            'alPengiriman'  => 'required',
            'hp'            => 'required',
            'noAkta'        => 'required_if:status,Terproses,Terkirim',
            'tglAkta'       => 'required_if:status,Terproses,Terkirim',
            'resi'          => 'required_if:status,Terkirim',
        ]);
        $pengiriman = new Pengiriman();

        $pengiriman->no_register = $this->createNoReg();
        $pengiriman->pos_id = $request->pos;
        $pengiriman->status = $request->status;
        $pengiriman->pemilik = $request->pemilik;
        $pengiriman->no_perkara = $request->noPerkara;
        $pengiriman->alamat_rumah = $request->alRumah;
        $pengiriman->alamat_pengirim = $request->alPengiriman;
        $pengiriman->hp = $request->hp;

        if($request->status == 'Terproses' || $request->status == 'Terkirim'){
            $pengiriman->no_akta = $request->noAkta;
            $pengiriman->tanggal_akta = $request->tglAkta;
            if($request->status == 'Terkirim'){
                $pengiriman->resi = $request->resi;
                $pengiriman->tanggal_terkirim = Carbon::now();
            }
        }

        $pengiriman->save();

        
        return redirect()->back()->with('success','Penambahan pengiriman baru berhasil');
    }

    public function update(Request $request){
        $request->validate([
            'id'            => 'required',
            'pos'           => 'required',
            'status'        => 'required',
            'pemilik'       => 'required',
            'noPerkara'     => 'required',
            'alRumah'       => 'required',
            'alPengiriman'  => 'required',
            'hp'            => 'required',
            'noAkta'        => 'required_if:status,Terproses,Terkirim',
            'tglAkta'       => 'required_if:status,Terproses,Terkirim',
            'resi'          => 'required_if:status,Terkirim',
        ]);
        $pengiriman = Pengiriman::find($request->id);
        $pengiriman->pos_id = $request->pos;
        $pengiriman->status = $request->status;
        $pengiriman->pemilik = $request->pemilik;
        $pengiriman->no_perkara = $request->noPerkara;
        $pengiriman->alamat_rumah = $request->alRumah;
        $pengiriman->alamat_pengirim = $request->alPengiriman;
        $pengiriman->hp = $request->hp;

        if($request->status == 'Terproses' || $request->status == 'Terkirim'){
            $pengiriman->no_akta = $request->noAkta;
            $pengiriman->tanggal_akta = $request->tglAkta;
            if($request->status == 'Terkirim'){
                $pengiriman->resi = $request->resi;
                $pengiriman->tanggal_terkirim = Carbon::now();
            }
        }

        $pengiriman->update();

        return redirect()->back()->with('success','Edit data pengiriman berhasil');

    }
    public function update2(Request $request){
        $request->validate([
            'id'            => 'required',
            'pemilik'       => 'required',
            'noPerkara'     => 'required',
            'alRumah'       => 'required',
            'alPengiriman'  => 'required',
            'hp'            => 'required',
            'resi'          => Rule::requiredIf(function() use($request){
                                $kirim = Pengiriman::find($request->id);
                                return $kirim->status == 'Terkirim';
                             }),
        ]);
        $pengiriman = Pengiriman::find($request->id);
        $pengiriman->pemilik = $request->pemilik;
        $pengiriman->no_perkara = $request->noPerkara;
        $pengiriman->alamat_rumah = $request->alRumah;
        $pengiriman->alamat_pengirim = $request->alPengiriman;
        $pengiriman->hp = $request->hp;
        if($pengiriman->status == 'Terkirim'){
            $pengiriman->resi = $request->resi;
        }

        $pengiriman->update();

        return redirect()->back()->with('success','Edit data pengiriman berhasil');

    }

    public function dataAkta(Request $request){
        $request->validate([
            'id'            => 'required',
            'noAkta'        => 'required',
            'tglAkta'       => 'required',
        ]);
        $pengiriman = Pengiriman::find($request->id);
        $pengiriman->no_akta = $request->noAkta;
        $pengiriman->tanggal_akta = $request->tglAkta;
        $pengiriman->status = 'Terproses'; 
        
        $pengiriman->update();
        return redirect()->back()->with('success','Data akta berhasil ditambahkan');
    }

    public function editAkta(Request $request){
        $request->validate([
            'id'            => 'required',
            'noAkta'        => 'required',
            'tglAkta'       => 'required',
        ]);
        $pengiriman = Pengiriman::find($request->id);
        $pengiriman->no_akta = $request->noAkta;
        $pengiriman->tanggal_akta = $request->tglAkta;
        
        $pengiriman->update();
        return redirect()->back()->with('success','Pengeditan Data Akta berhasil');
    }

    public function resi(Request $request){
        $request->validate([
            'id'            => 'required',
            'resi'        => 'required',
        ]);
        $pengiriman = Pengiriman::find($request->id);
        $pengiriman->resi = $request->resi;
        if($pengiriman->status == 'Terproses'){
            $pengiriman->status = 'Terkirim';
            $pengiriman->tanggal_terkirim = Carbon::now();
        }
        $pengiriman->update();
        return redirect(route('terkirim'))->with('success','Resi pengiriman berhasil ditambahkan')->with('noreg',$pengiriman->no_register);
    }

    public function destroy(Request $request){
        $request->validate([
            'posId' => 'required',
        ]);
        $kirim = Pengiriman::find($request->posId);
        $kirim->delete();
        return redirect()->back()->with('success','Pengiriman berhasil dihapus');
    }

    public function whatsapp($reg){
        $kirim = Pengiriman::firstWhere('no_register',$reg);
        $noHp = $kirim->hp;
        if($noHp[0]=='0'){
            $noHp = substr($noHp,1);
            $noHp = '62'.$noHp;
        }
        else if($noHp[0]=='+'){
            $noHp = substr($noHp,1);
        }
        $pesan = "[NOTIFIKASI PENGIRIMAN AKTA]%0aAkta telah terkirim dengan detail:%0a%0aNOMOR PERKARA%0a".$kirim->no_perkara."%0a%0aRESI%0a".$kirim->resi."%0a%0aAnda dapat melacak pengiriman dengan cara buka https://www.posindonesia.co.id/id/tracking lalu masukan nomor resi ";
        return redirect()->away('https://web.whatsapp.com/send?phone='.$noHp.'&text='.$pesan);
        
    }

}
