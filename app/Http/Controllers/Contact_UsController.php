<?php

namespace App\Http\Controllers;

use App\Lib\Wordpress;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;

class Contact_UsController extends BaseController
{
    public function index()
    {
        $wordpress = new Wordpress();
        $wordpress->Token();
        $token = session('wp_token');
        $response = Http::withToken($token)->withHeaders([
            'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36'
        ])->get(env('URL_WP') . '/wp-json/custom/v1/contact-messages');

        if ($response->successful()) {
            $messages = $response->json();
            return view('contact-us.index', compact('messages'));
        } else {
            return response()->json(['error' => 'Gagal ambil data dari WordPress'], 500);
        }
    }
}
