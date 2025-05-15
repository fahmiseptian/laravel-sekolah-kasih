<?php

namespace App\Http\Controllers;

use App\Lib\Wordpress;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;

class InformationController extends BaseController
{
    function index()
    {
        $wordpress = new Wordpress();
        $token = $wordpress->Token();

        $informasiPendaftaran = Http::withToken($token)->withHeaders([
            'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36'
        ])->get(env('URL_WP') . '/wp-json/custom/v1/informasi-pendaftaran');
        $registration = $informasiPendaftaran->json();

        $informasiSekolah = Http::withToken($token)->withHeaders([
            'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36'
        ])->get(env('URL_WP') . '/wp-json/custom/v1/informasi-sekolah');
        $schoolinfo = $informasiSekolah->json();

        return view('info.index', compact('registration', 'schoolinfo'));
    }
}
