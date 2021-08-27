<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;

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
        $ownerId = Auth::id();
        $shops = Shop::where('owner_id', $ownerId)->get();

        return view('owner.shops.index', compact('shops'));
    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {
        $owner = Owner::findOrFail($id);

        $owner->name = $request->name;
        $owner->email = $request->email;
        $owner->password = Hash::make($request->password);
        $owner->save();

        return redirect()
        ->route('admin.owners.index')
        ->with(['message' =>'オーナー情報を更新しました', 'status' => 'info']);

    }

}
