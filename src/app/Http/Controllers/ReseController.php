<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Genre;
use App\Models\Favorite;
use App\Models\Reservation;
use App\Models\Shop;
use App\Models\User;
use App\Models\Review;
use App\Models\Representative;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use App\Http\Requests\ReservationRequest;
use App\Http\Requests\ReviewRequest;
use Carbon\Carbon;



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

        if ($user) {
            $favorites = Favorite::where('user_id', $user->id)->pluck('shop_id')->toArray();
            
            return view('shop_all', compact('shops', 'areas', 'genres', 'favorites'));
        } else {
            return view('shop_all', compact('shops', 'areas', 'genres'));
        }
    }

    //飲食店詳細ページ
    public function detail($shop_id) {
        $shop = Shop::findOrFail($shop_id);

        $today = new \DateTime();
        $today->modify('+1 day');
        $minDate = $today->format('Y-m-d');

        $user = Auth::user();
        $postReview = false;
        $posted = false;
        $review = null;

        if($user) {
            $reservation = Reservation::where('user_id', $user->id)
                                      ->where('shop_id', $shop_id)
                                      ->first();

            if ($reservation && $reservation->status === '来店済み') {
                $postReview = true;
            }

            $review = Review::where('user_id', $user->id)
                            ->where('shop_id', $shop_id)
                            ->first();

            if ($review) {
                $posted = true;
            }
        }

        return view('shop_detail', compact('shop', 'minDate', 'postReview', 'posted', 'review'));
    }

    //マイページ
    public function mypage() {
        $user = Auth::user();


        if ($user->hasRole('admin')) {
            return view('admin.admin_mypage');
        } elseif ($user->hasRole('shop representative')) {
            $representative = Representative::where('user_id', $user->id)->first();
            $shop = $representative ? Shop::find($representative->shop_id) : null;

            return view('representative.representative_mypage', compact('representative', 'shop'));
        } else {
            $reservations = Reservation::where('user_id', $user->id)
                                       ->whereDate('reservation_date', '>=', Carbon::today())
                                       ->with('shop')->orderBy('reservation_date')
                                       ->get();

            foreach ($reservations as $reservation) {
                $reservation->reservation_time = Carbon::parse($reservation->reservation_time)->format('H:i');
            }

            $favorites = Favorite::where('user_id', $user->id)->with('shop')->get();

            return view('mypage', compact('reservations', 'favorites'));
        }
    }

    //予約完了ページ
    public function done() {
        return view('done'); 
    }

    //予約登録
    public function store(ReservationRequest $request) {
        $user = Auth::user();

        $reservation = new Reservation();
        $reservation->user_id = Auth::id();
        $reservation->shop_id = $request->input('shop_id');
        $reservation->reservation_date = $request->input('reservation_date');
        $reservation->reservation_time = Carbon::parse($request->input('reservation_time'))->format('H:i');
        $reservation->reservation_num = $request->input('reservation_num');
        $reservation->status = "予約";

        $reservation->save();

        return redirect()->route('reservation.done');
    }

    //予約変更
    public function edit($id) {
        $reservation = Reservation::findOrFail($id);
        $shop = Shop::findOrFail($reservation->shop_id);
        
        $today = new \DateTime();
        $today->modify('+1 day');
        $minDate = $today->format('Y-m-d');

        $reservation->reservation_time = Carbon::parse($reservation->reservation_time)->format('H:i');

        return view('reservation_edit', compact('reservation','shop', 'minDate'));
    }

    public function update(ReservationRequest $request, $id) {
        $reservation = Reservation::findOrFail($id);

        $reservation->update([
            'reservation_date' => $request->input('reservation_date'),
            'reservation_time' => Carbon::parse($request->input('reservation_time'))->format('H:i'),
            'reservation_num' => $request->input('reservation_num'),
        ]);

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

        $existingFavorite = Favorite::where('shop_id', $request->shop_id)->where('user_id', $user->id)->first();

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
        $favorite = Favorite::where('shop_id', $id)->where('user_id', Auth::id())->first();

        if ($favorite) {
            $favorite->delete();
        }

        return back();
    }

    //レビュー一覧ページ
    public function reviewList($shop_id) {
        $shop = Shop::findOrFail($shop_id);
        $reviews = Review::where('shop_id', $shop_id)->with('user')->paginate(10);
        $averageRating = Review::where('shop_id', $shop_id)->avg('rating');

        return view('reviews.reviews_list', compact('shop', 'reviews', 'averageRating'));
    }

    //レビュー投稿ページ
    public function createReview($shop_id) {
        $shop = Shop::findOrFail($shop_id);

        $user = Auth::user();
        $favorites = Favorite::where('user_id', $user->id)->pluck('shop_id')->toArray();

        return view('reviews.review', compact('shop', 'favorites'));
    }
    
    //レビュー登録
    public function storeReview(ReviewRequest $request, $shop_id) {
        $user = Auth::user();

        $oldReview = Review::where('user_id', $user->id)->where('shop_id', $shop_id)->first();

        if ($oldReview) {
            return redirect()->route('reviews.create', ['shop_id' => $shop_id])->with('error', '既にレビューを投稿されてます');
        }

        $image_url = null;
        if ($request->hasFile('image_url')) {
            $image_url = $request->file('image_url')->store('review_images', 'public');
        }

        Review::create([
            'user_id' => $user->id,
            'shop_id' => $shop_id,
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
            'image_url' => basename($image_url),
        ]);

        return redirect()->route('reviews.create', ['shop_id' => $shop_id])->with('success', 'レビューが投稿されました');
    }

    //レビュー更新
    public function editReview($shop_id) {
        $shop = Shop::findOrFail($shop_id);
        $user = Auth::user();
        $favorites = Favorite::where('user_id', $user->id)->pluck('shop_id')->toArray();

        $review = Review::where('user_id', $user->id)
                        ->where('shop_id', $shop_id)
                        ->first();

        return view('reviews.edit_review', compact('shop', 'review', 'favorites'));
    }

    public function updateReview(ReviewRequest $request, $shop_id) {
        $user = Auth::user();

        $review = Review::where('user_id', $user->id)
                        ->where('shop_id', $shop_id)
                        ->firstOrFail();

        
        if ($request->hasFile('image_url')) {
            if ($review->image_url) {
                Storage::disk('public')->delete('review_images/' . $review->image_url);
            }
            $image_url = $request->file('image_url')->store('review_images', 'public');
            $review->image_url = basename($image_url);
        }

        $review->update([
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
            'image_url' => $review->image_url, 
        ]);

        return redirect()->route('reviews.edit', ['shop_id' => $shop_id])->with('success', 'レビューが更新されました');
    }

    //レビュー削除
    public function destroyReview($shop_id) {
        $user = Auth::user();

        $review = Review::where('user_id', $user->id)
                        ->where('shop_id', $shop_id)
                        ->firstOrFail();

        if ($review->image_url) {
            Storage::disk('public')->delete('review_images/' . $review->image_url);
        }

        $review->delete();

        return redirect()->route('detail', ['shop_id' => $shop_id]);
    }

    //来店確認
    public function check($id){
        $reservation = Reservation::findOrFail($id);
        $reservation->status = '来店済み';
        $reservation->save();

        return view('representative.visit_check');
    }
}
