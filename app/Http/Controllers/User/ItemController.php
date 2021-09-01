<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Models\Stock;
use App\Models\PrimaryCategory;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;

class ItemController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:users');

        //shopControllerにのみ働くmiddlewareを定義
        $this->middleware(function($request, $next) {
            $id = $request->route()->parameter('item'); 
            if(!is_null($id)) { 
                $itemId = Product::availableItems()->where('products.id', $id)->exists();
                if (!$itemId) {
                    abort(404);
                }
            }
            return $next($request);
        
        });
    }


    public function index(Request $request)
    {

        Mail::to('test@example.com')->send(new TestMail());
        
        $products = Product::availableItems()->selectCategory($request->category ?? '0')
        ->searchKeyword($request->keyword)->sortOrder($request->sort)->paginate($request->pagination ?? '20');

        $categories = PrimaryCategory::with('secondary')->get();
    
        return view('user.index', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = product::findOrFail($id);
        $quantity = Stock::where('product_id', $product->id)
        ->sum('quantity');

        if($quantity > 9) {
            $quantity = 9;
        }

        return view('user.show', compact('product', 'quantity'));
    }
}
