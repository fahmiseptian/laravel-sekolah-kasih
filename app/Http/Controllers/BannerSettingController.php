<?php

namespace App\Http\Controllers;

use App\Lib\Wordpress;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class BannerSettingController extends BaseController
{
    function index()
    {
        $wordpress = new Wordpress();
        $wordpress->Token();
        $token = session('wp_token');

        $response = Http::withToken($token)->withHeaders([
            'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36'
        ])->get(env('URL_WP') . '/wp-json/custom/v1/banners');

        return view('banner.index', ['banner' => $response->json()]);
    }
    function deleteBanner($index)
    {
        $wordpress = new Wordpress();
        $wordpress->Token();
        $token = session('wp_token');

        $response = Http::withToken($token)
            ->withHeaders([
                'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36'
            ])
            ->post(env('URL_WP') . "/wp-json/custom/v1/banners-delete", [
                'index' => $index
            ]);

        if ($response->successful()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Banner successfully removed'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to remove banner'
            ], $response->status());
        }
    }
    public function addBanner(Request $request)
    {
        $direct_url = $request->directUrl;

        if ($request->hasFile('imageFile')) {
            // Jika file diunggah
            $file = $request->file('imageFile');
            $path = $file->store('public/banners');
            $image = Storage::url($path);
            $image_url = env('APP_URL') . $image;
        } else if ($request->imageUrl) {
            $image_url = $request->imageUrl;
        } else {
            return response()->json(['error' => 'No image provided.'], 400);
        }

        $newBanner = [
            ['image_url' => $image_url, 'direct_link' => $direct_url]
        ];

        $wordpress = new Wordpress();
        $wordpress->Token();
        $token = session('wp_token');

        $old = Http::withToken($token)->withHeaders([
            'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36'
        ])->get(env('URL_WP') . '/wp-json/custom/v1/banners');

        $banners = $old->json() ?? [];

        // Tambahkan banner baru
        $banners[] = $newBanner[0];

        $response = Http::withToken($token)
            ->withHeaders([
                'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36'
            ])
            ->post(env('URL_WP') . '/wp-json/custom/v1/banners', [
                'banners' => $banners
            ]);

        return response()->json(['success' => true, 'message' => 'Banner added successfully.', 'data' => $banners]);
    }
}
