<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Genre;
use App\Models\Favorite;
use App\Models\Reservation;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\ReservationRequest;
use Illuminate\Support\Facades\Auth;


class ReseController extends Controller
{
    //飲食店一覧ページ
    public function index(Request $request){
        // クエリビルダーでショップをフィルタリング
        $query = Shop::query();

        // 地域のフィルター
        if ($request->filled('area')) {
            $query->where('area_id', $request->input('area'));
        }

        // ジャンルのフィルター
        if ($request->filled('genre')) {
            $query->where('genre_id', $request->input('genre'));
        }

        // キーワード検索
        if ($request->filled('word')) {
            $query->where('name', 'like', '%' . $request->input('word') . '%');
        }

        // データ取得
        // リレーションを使って関連データも取得する
        $shops = $query->with('area', 'genre')->get();

        $areas = Area::all();
        $genres = Genre::all();

        $user = Auth::user();
        $favorites = Favorite::where('user_id', $user->id)->pluck('shop_id')->toArray();

        return view('shop_all', compact('shops', 'areas', 'genres', 'favorites'));
    }

    //飲食店詳細ページ
    public function detail($shop_id) {
        $shop = Shop::findOrFail($shop_id);
    
        return view('shop_detail', compact('shop'));
    }

    //マイページ
    public function mypage() {

        $user = Auth::user();
        $reservations = Reservation::where('user_id', $user->id)->with('shop')->get();
        $favorites = Favorite::where('user_id', $user->id)->with('shop')->get();

        return view('mypage', compact('reservations', 'favorites'));
    }

    //予約完了ページ
    public function done() {
        return view('done'); 
    }

    //予約追加
    public function store(ReservationRequest $request) {
        $user = Auth::user();

        $reservation = new Reservation();
        $reservation->user_id = auth()->id();
        $reservation->shop_id = $request->input('shop_id');
        $reservation->reservation_date = $request->input('reservation_date');
        $reservation->reservation_time = $request->input('reservation_time');
        $reservation->reservation_num = $request->input('reservation_num');
        $reservation->status = "予約";

        $reservation->save();

        return redirect()->route('reservation.done');
    }

    //予約削除
    public function delete(Request $request) {
        $reservation = Reservation::findOrFail($request->id);
        $reservation->delete();
        return back();
    }

    //お気に入り登録
    public function create(Request $request) {
        $user = Auth::user();

        $existingFavorite = Favorite::where('shop_id', $request->shop_id)
                                    ->where('user_id', $user->id)
                                    ->first();

        if ($existingFavorite) {
            return back();
        }

        $favorite = new Favorite;
        $favorite->shop_id = $request->shop_id;
        $favorite->user_id = $user->id;
        $favorite->save();

        return back();
    }

    //お気に入り削除
    public function destroy(Request $request, $id) {
        $favorite = Favorite::where('shop_id', $id)
                            ->where('user_id', Auth::id())
                            ->first();

        if ($favorite) {
            $favorite->delete();
        }

        return back();
    }
    
}
