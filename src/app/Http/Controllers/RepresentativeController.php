<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;
use App\Models\Reservation;
use App\Models\Representative;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Requests\CreateShopRequest;

class RepresentativeController extends Controller
{
    public function create() {
        $areas = Area::all();
        $genres = Genre::all();

        return view('representative.create_shop', compact('areas', 'genres'));
    }

    public function store(CreateShopRequest $request) {
        $shop = new Shop();
        $shop->name = $request->input('name');
        $shop->area_id = $request->input('area_id');
        $shop->genre_id = $request->input('genre_id');
        $shop->address = $request->input('address');
        $shop->description = $request->input('description');

        if ($request->hasFile('image_url')) {
            $image_url = $request->file('image_url')->store('shop_images', 'public');
            $shop->image_url = str_replace('shop_images/', '', $image_url); 
        }

        $shop->save();

        $representative = new Representative();
        $representative->shop_id = $shop->id;
        $representative->user_id = Auth::id();
        $representative->save();

        return redirect()->back()->with('success', '店舗情報が保存されました');
    }
}
