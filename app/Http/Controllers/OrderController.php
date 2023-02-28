<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\User;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CartItemResource;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use App\Notifications\OrderCreated;
use Illuminate\Support\Facades\Notification;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $items = Auth::user()->is_admin ? Order::orderBy('created_at', 'desc')->get() : Auth::user()->orders()->orderBy('created_at', 'desc')->get();
        $orders = OrderResource::collection($items)->toArray($request);

        return Inertia::render('Orders/List', [
            'orders' => $orders,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $collection = CartItemResource::collection(Auth::user()->cartItems()->get());

        $order = new Order();
        $order->user()->associate(Auth::user()->id);
        $order->items = $collection->toArray($request);
        $order->total = $collection->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });
        $order->save();

        Auth::user()->cartItems()->delete();

        $admins = User::where('is_admin', true)->get();
        foreach($admins as $key => $admin) {
            $admin->notify((new OrderCreated($order))->delay($key * 2));
        }

        return Redirect::route('orders.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
