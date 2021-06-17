<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\pos;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Response;
use Illuminate\Support\Facades\Auth;



class UserController extends Controller
{
    private string $defaultPassword = "indrakila42";

    public function store(Request $request){
        $request->validate([
            'nama'      => 'required',
            'username'  => 'required',
            'NIP'       => 'required',
            'hp'        => 'required',
            'email'     => 'required|email',
            'userType'  => 'required',
            'alamatPos' => 'required_if:userType,pos'
        ]);

        $newUser = new User;
        
        $newUser->nama = $request->nama;
        $newUser->username = $request->username;
        $newUser->NIP = $request->NIP;
        $newUser->hp = $request->hp;
        $newUser->email = $request->email;
        $newUser->email_verified_at = now();
        $newUser->user_type = $request->userType;
        $newUser->password = Hash::make($this->defaultPassword);
        $newUser->remember_token = Str::random(10);

        $newUser->save();

        if($request->userType == "pos"){
            $NU = User::firstWhere("NIP",$request->NIP);

            $newUPos = new pos;
            $newUPos->user_id = $NU->id;
            $newUPos->alamat_kantor_pos = $request->alamatPos;

            $newUPos->save();
        }

        return redirect()->back()->with('success','User baru berhasil ditambahkan');
        
    }

    public function update(Request $request){
        $user = User::find($request->id);

        $request->validate([
            'nama'      => 'required',
            'username'  => 'required',
            'NIP'       => 'required',
            'hp'        => 'required',
            'email'     => 'required|email',
            'userType'  => 'required',
            'alamatPos' => 'required_if:userType,pos'
        ]);

        $user->nama = $request->nama;
        $user->username = $request->username;
        $user->NIP = $request->NIP;
        $user->hp = $request->hp;
        $user->email = $request->email;
        if($user->usertype == 'pos' && $user->user_type != $request->userType){
            $pos = pos::firstWhere('user_id',$request->id);
            $pos->delete();
        }
        else if($user->usertype != 'pos' &&  $request->userType == 'pos'){
            $pos = new pos;
            $pos->user_id = $user->id;
            $pos->alamat_kantor_pos = $request->alamatPos;
            $pos->save();
        }
        else if($user->usertype == 'pos' && $user->user_type == $request->userType){
            $pos = pos::firstWhere('user_id',$request->id);
            $pos->alamat_kantor_pos = $request->alamatPos;
            $pos->update();
        }
        $user->user_type = $request->userType;
       
        $user->update();

        return redirect()->back()->with('success','Pengeditan data user berhasil');
    }

    public function destroy(Request $request){
        $request->validate([
            'userId' => 'required',
        ]);
        $user = User::find($request->userId);
        if($user->user_type == 'pos'){
            $pos = pos::firstWhere('user_id',$request->userId);
            $pos->delete();
        }
        $user->delete();
        return redirect()->back()->with('success','User berhasil terhapus');
    }
    
    public function getPos(Request $request){
        $pos = pos::firstWhere('user_id',$request->user_id);
        return Response::json($pos);
    }

    public function resetPw(Request $request){
        $request->validate([
            'idReset' => 'required',
        ]);
        $user = User::find($request->idReset);
        $user->password = Hash::make($this->defaultPassword);
        
        $user->update();

        return redirect()->back()->with('success','Password berhasil tereset');
    }

    public function profile(Request $request){
        $request->validate([
            'nama'      => 'required',
            'username'  => 'required',
            'NIP'       => 'required',
            'hp'        => 'required',
            'email'     => 'required|email',
        ]);

        $user = Auth::user();
       
        $user->nama = $request->nama;
        $user->username = $request->username;
        $user->NIP = $request->NIP;
        $user->hp = $request->hp;
        $user->email = $request->email;
        $user->email_verified_at = now();

        $user->update();

        return redirect()->back()->with('success','Edit profile berhasil dilakukan');
    }

    public function gantiPw(Request $request){
        $request->validate([
            'pwDulu'  => 'required',
            'pwBaru'  => 'required',
            'kPwBaru' => 'required',
        ]);
        $user = Auth::user();
        if(!Hash::check($request->pwDulu,$user->password)){
            return back()->with('error','Password Saat ini yang dimasukan salah');
        }
        else if($request->pwBaru != $request->kPwBaru){
            return back()->with('error','Password baru dan Konfirmasi Password yang dimasukan tidak sama');
        }
        else if(strlen($request->pwBaru)<8){
            return back()->with('error','Password baru harus minimal 8 Karakter');
        }
        else{
            $user->password = Hash::make($request->pwBaru);
            $user->update();
            return redirect()->back()->with('success','Penggantian password berhasil dilakukan');
        }
    }
}
