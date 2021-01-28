<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\Pengiriman;
use Response;

class PengirimanController extends Controller
{
    public function getPengiriman(Request $request){
        $client = new Client();
        $api_key = "67ad2c647d38367edff1d1ee0b3307aee5bf9130fa76f667d9e23b59c3e1672e";
        $pengiriman= Pengiriman::where('nomor',$request->nomor)->first();
        $url = 'https://api.binderbyte.com/v1/track?api_key='.$api_key.'&courier=pos&awb='.$pengiriman->resi;
        $response = $client->request('GET', $url, [
            'verify'  => false,
        ]);
        $responseBody = json_decode($response->getBody());
        return Response::json($responseBody);
    }
}
