<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function create() {
        return view('admin.create_representative');
    }

    public function store(RegisterRequest $request) {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->assignRole('shop representative');

        return redirect()->route('admin.create')->with('success', '代表者が作成されました');
    }

    public function getUsers()
    {
        $users = User::paginate(10);

        return view('admin.user_list', compact('users'));
    }

    public function importPage() {
        return view('admin.csv_import');
    }

    public function importCsv(Request $request) {
        if ($request->hasFile('csvFile')) {
            $file = $request->file('csvFile');
            $path = $file->getRealPath();
            $fp = fopen($path, 'r');

            $validRows = [];
            $rowNumber = 0;

            fgetcsv($fp);

            try {
                while (($csvData = fgetcsv($fp)) !== FALSE) {
                    $rowNumber++;

                    if ($this->isRowEmpty($csvData)) {
                        continue;
                    }
                    $this->validateCsvData($csvData);
                    $validRows[] = $csvData;
                }
                fclose($fp);

                if (empty($validRows)) {
                    return redirect()->back()->withErrors(['csv_error' => 'CSVファイルに有効なデータがありません'])->withInput();
                }

                foreach ($validRows as $row) {
                    $this->insertCsvData($row);
                }

                return redirect()->back()->with('success', 'CSVファイルのインポートが完了しました');
            } catch (ValidationException $e) {
                fclose($fp);
                $errors = $e->errors();
                return redirect()->back()->withErrors($errors)->withInput();
            }
        } else {
            return redirect()->back()->withErrors(['csv_error' => 'CSVファイルが選択されていません。']);
        }
    }

    private function isRowEmpty($row)
    {
        return empty(array_filter($row, function ($value) {
            return !is_null($value) && trim($value) !== '';
        }));
    }

    public function validateCsvData($csvData) {
        $validator = Validator::make([
            '店舗名' => $csvData[0],
            'ジャンル' => $csvData[1],
            'エリア' => $csvData[2],
            '住所' => $csvData[3],
            '店舗説明' => $csvData[4],
            '画像URL' => $csvData[5],
        ], [
            '店舗名' => 'required|max:50',
            'ジャンル' => 'required|exists:genres,name',
            'エリア' => 'required|exists:areas,name',
            '住所' => 'required',
            '店舗説明' => 'required|max:400',
            '画像URL' => ['required', 'url', 'regex:/\.(jpg|png)$/i'],
        ], [
            '店舗名.required' => '店舗名を50文字以内で入力してください',
            '店舗名.max' => '店舗名を50文字以内で入力してください',
            'ジャンル.required' => 'ジャンルは「寿司」「焼肉」「居酒屋」「イタリアン」「ラーメン」のいずれかを入力してください',
            'ジャンル.exists' => 'ジャンルは「寿司」「焼肉」「居酒屋」「イタリアン」「ラーメン」のいずれかを入力してください',
            'エリア.required' => 'エリアは「東京都」「大阪府」「福岡県」のいずれかを入力してください',
            'エリア.exists' => 'エリアは「東京都」「大阪府」「福岡県」のいずれかを入力してください',
            '住所.required' => '住所を入力してください',
            '店舗説明.required' => '店舗説明を400文字以内で入力してください',
            '店舗説明.max' => '店舗説明を400文字以内で入力してください',
            '画像URL.required' => '画像URLは、「jpeg」「png」のみ使用可能です',
            '画像URL.url' => '画像URLは、「jpeg」「png」のみ使用可能です',
            '画像URL.regex' => '画像URLは、「jpeg」「png」のみ使用可能です',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            throw new ValidationException($validator, $errors);
        }
    }

    public function insertCsvData($csvData) {
        $shop = new Shop;

        // ジャンルIDを取得
        $genreName = $csvData[1];
        $genre = Genre::where('name', $genreName)->first();

        // エリアIDを取得
        $areaName = $csvData[2];
        $area = Area::where('name', $areaName)->first();

        $shop->name = $csvData[0]; // 店舗名
        $shop->genre_id = $genre->id; // ジャンル
        $shop->area_id = $area->id; // エリア
        $shop->address = $csvData[3]; // 住所
        $shop->description = $csvData[4]; // 店舗説明
        $shop->image_url = $csvData[5]; // 画像URL
        $shop->save();
    }

    public function downloadCsv() {
        $filePath = storage_path('app/public/template/csv_template.csv');

        if (!file_exists($filePath)) {
            return redirect()->back()->withErrors(['csv_error' => 'テンプレートファイルが見つかりません。']);
        }

        return response()->download($filePath, 'csv_template.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }
}
