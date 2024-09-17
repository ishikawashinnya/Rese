<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;
use App\Models\User;
use App\Models\Reservation;
use App\Models\Representative;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Requests\ShopFormRequest;
use Illuminate\Support\Facades\Storage;

class RepresentativeController extends Controller
{
    public function create() {

        $areas = Area::all();
        $genres = Genre::all();

        return view('representative.create_shop', compact('areas', 'genres'));
    }

    public function store(ShopFormRequest $request) {
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

        return redirect()->back()->with('success', '店舗情報が作成されました');
    }

    public function edit($id) {
        $representative = Representative::findOrFail($id);
        $shop = Shop::findOrFail($representative->shop_id);
        $user = User::findOrFail($representative->user_id);
        $areas = Area::all();
        $genres = Genre::all();

        return view('representative.edit_shop', compact('shop','representative', 'user', 'areas', 'genres'));
    }

    public function update(ShopFormRequest $request, $id) {
        $shop = Shop::findOrFail($id);

        $shop->name = $request->input('name');
        $shop->area_id = $request->input('area_id');
        $shop->genre_id = $request->input('genre_id');
        $shop->address = $request->input('address');
        $shop->description = $request->input('description');

        if($request->hasFile('image_url')) {
            if ($shop->image_url) {
                Storage::delete('public/shop_images/' . $shop->image_url);
            }

            $file = $request->file('image_url');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/shop_images', $filename);
            $shop->image_url = $filename;
        }

        $shop->save();

        return redirect()->back()->with('success', '店舗情報が更新されました');
    }

    public function reservationList() {
        $user = Auth::user();

        $representative = Representative::where('user_id', $user->id)->firstOrFail();
        $shop = Shop::findOrFail($representative->shop_id);
        $reservations = Reservation::where('shop_id', $shop->id)->paginate(10);

        foreach ($reservations as $reservation) {
            $reservation->reservation_time = Carbon::parse($reservation->reservation_time)->format('H:i');
        }
        
        return view('representative.reservation_list', compact('shop', 'reservations'));
    }
}
