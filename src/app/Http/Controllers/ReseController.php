<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Genre;
use App\Models\Favorite;
use App\Models\Reservation;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;

class ReseController extends Controller
{
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

        return view('shop_all', compact('shops', 'areas', 'genres'));
    }
}
