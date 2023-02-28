<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Http\Requests\StoreCartItemRequest;
use App\Http\Requests\UpdateCartItemRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Resources\CartItemResource;

class CartItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cartItems = CartItemResource::collection(Auth::user()->cartItems()->get())->toArray($request);
        
        return Inertia::render('CartItems/List', [
            'cartItems' => $cartItems,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartItemRequest $request, Product $product)
    {
        $item = CartItem::where('user_id', Auth::user()->id)->where('product_id', $product->id)->first();
        if ($item) {
            $item->quantity++;
            $item->save();
            return;
        }

        $item = new CartItem();
        $item->user()->associate(Auth::user()->id);
        $item->product()->associate($product->id);
        $item->quantity = 1;
        $item->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartItem $cartItem)
    {
        if ($cartItem->quantity > 1) {
            $cartItem->quantity--;
            $cartItem->save();
            return;
        }

        $cartItem->delete();
    }
}
