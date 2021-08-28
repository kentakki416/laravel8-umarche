<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use Illuminate\Support\Facades\Storage;
use InterventionImage;
use App\Http\Requests\UploadImageRequest;
use App\Services\ImageService;

class ShopController extends Controller
{
    // ログインしているかの確認を初期化時に必ず確認するため
    public function __construct()
    {
        $this->middleware('auth:owners');

        //shopControllerにのみ働くmiddlewareを定義
        $this->middleware(function($request, $next) {
            $id = $request->route()->parameter('shop'); //shopのid取得 [Route::get('edit/{shop}・・・')]の {shop}に該当
            if(!is_null($id)) { 
                $shopsOwnerId = Shop::findOrFail($id)->owner->id;
                $shopId = (int)$shopsOwnerId; //キャスト 文字列→数値
                $ownerId = Auth::id();
                if ($shopId !== $ownerId) {
                    abort(404);
                }
            }
            return $next($request);
        
        });
    }

    public function index()
    {
        // phpinfo();

        $shops = Shop::where('owner_id', Auth::id())->get();

        return view('owner.shops.index', compact('shops'));
    }

    public function edit($id)
    {
        $shop = Shop::findOrFail($id);
        
        return view('owner.shops.edit', compact('shop'));

    }

    public function update(UploadImageRequest $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'information' => 'required|string|max:1000',
            'is_selling' => 'required'
        ]);
        // リサイズなしversion
        // $imageFile = $request->image;
        // if (!is_null($imageFile) && $imageFile->isValid()) {
        //     Storage::putFile('public/shops', $imageFile);
        // }

        // return redirect()->route('owner.shops.index');

        //リサイズあり
        $imageFile = $request->image;
        if(!is_null($imageFile) && $imageFile->isValid()) {
            $fileNameToStore = ImageService::upload($imageFile, 'shops');
        }

        $shop = Shop::findOrFail($id);
        $shop->name = $request->name;
        $shop->information = $request->information;
        $shop->is_selling = $request->is_selling;
        if(!is_null($imageFile) && $imageFile->isValid()){
            $shop->filename = $fileNameToStore;
        }

        $shop->save();

        return redirect()->route('owner.shops.index')->with(['message' => '店舗情報を更新しました',
        'status' => 'info']);

    }

}
