<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UploadImageRequest;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage;


class ImageController extends Controller
{

       // ログインしているかの確認を初期化時に必ず確認するため
        public function __construct()
        {
            $this->middleware('auth:owners');
    
            //shopControllerにのみ働くmiddlewareを定義
            $this->middleware(function($request, $next) {
                $id = $request->route()->parameter('image'); 
                if(!is_null($id)) { 
                    $imagesOwnerId = Image::findOrFail($id)->owner->id;
                    $imageId = (int)$imagesOwnerId; //キャスト 文字列→数値
                    if ($imageId !== Auth::id()) {
                        abort(404);
                    }
                }
                return $next($request);
            
            });
        }

    public function index()
    {
        $images = Image::where('owner_id', Auth::id())->orderBy('updated_at', 'desc')->paginate(20);

        return view('owner.images.index', compact('images'));
    }


    public function create()
    {
        return view('owner.images.create');
    }


    public function store(UploadImageRequest $request)
    {
        //複数画像がアップロードされる可能性があるのでfile('files')で配列として格納
        $imageFiles = $request->file('files');
        if (!is_null($imageFiles)) {
            foreach($imageFiles as $imageFile) {
                $fileNameToStore = ImageService::upload($imageFile, 'products');
                Image::create([
                    'owner_id' => Auth::id(),
                    'filename' => $fileNameToStore,
                ]);
            }
        }

        return redirect()->route('owner.images.index')
        ->with(['message' => '画像登録を実施しました。','status' => 'info']);
    }


    public function edit($id)
    {
        $image = Image::findOrFail($id);
        return view('owner.images.edit', compact('image'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'string|max:50'
        ]);

        $image = Image::findOrFail($id);
        $image->title = $request->title;
        $image->save();

        return redirect()->route('owner.images.index')->with(['message' => '画像情報を更新しました',
        'status' => 'info']);

    }


    public function destroy($id)
    {
            $image = Image::findOrFail($id);
            $filePath = 'public/products/'.$image->filename;

            //publicのstorageフォルダの画像を削除
            if(Storage::exists($filePath)) {
                Storage::delete($filePath);
            }

            Image::findOrFail($id)->delete();
            return redirect()->route('owner.images.index')->with(['message'=>' 画像を削除しました', 'status' => 'alert']);
        
    }
}
