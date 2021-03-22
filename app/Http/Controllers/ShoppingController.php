<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\CodeTemplate;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShoppingController extends Controller
{
    public function index(Request $request)
    {
        $data = [];
        $total = 0;
        $listProductsInCart = [];
        $ids = $request->session()->get('products');
        if ($ids) {
            $listProductsInCart = CodeTemplate::findMany(array_keys($ids));
            foreach ($listProductsInCart as $product) {
                $total = $total + $product->getValue() * $ids[$product->getId()];
            }
        }
        $data['title'] = 'Cart';
        $data['productsInCart'] = $listProductsInCart;
        $data['quantities'] = $ids;
        $data['total'] = $total;

        return view('cart.index')->with('data', $data);
    }

    public function add_one($id, Request $request)
    {
        $products = $request->session()->get('products');
        $products[$id] = 1;
        $request->session()->put('products', $products);

        return back();
    }

    public function add(Request $request)
    {
        $id = $request->input('id');
        $quantity = $request->input('quantity');
        $products = $request->session()->get('products');
        $products[$id] = $quantity;
        $request->session()->put('products', $products);

        return redirect()->route('cart.index');
    }

    public function removeAll(Request $request)
    {
        $request->session()->forget('products');

        return back();
    }

    public function removeItem($id, request $request)
    {
        $products = $request->session()->get('products');
        unset($products[$id]);
        $request->session()->put('products', $products);

        return back();
    }

    public function buy(Request $request)
    {
        if (! Auth::check()) {
            return redirect()->route('login')->withErrors([__('messages.please_log_in')]);
        }
        $data = [];
        $data['title'] = 'Buy';
        $order = new Order();
        $order->setUserId(Auth::user()->id);
        $order->setTotal(0);
        $order->save();

        $total = 0;
        $ids = $request->session()->get('products');
        if ($ids) {
            $listProductsInCart = CodeTemplate::findMany(array_keys($ids));
            foreach ($listProductsInCart as $product) {
                $item = new Item();
                $item->setSubTotal(0);
                $item->setQuantity($ids[$product->getId()]);
                $item->setCodeTemplateId($product->getId());
                $item->setOrderId($order->getId());
                $item->save();

                $codes = Code::where(['code_template_id' => $product->getId(), 'used' => 0])->take($item->getQuantity())->get();
                if (count($codes) < $item->getQuantity()) {
                    $item->delete();
                    $order->delete();

                    return redirect()->route('cart.index')->withErrors([__('messages.insufficient_stock')]);
                }
                foreach ($codes as $code) {
                    $code->setItemId($item->getId());
                    $code->setUsed(1);
                    $code->save();
                }
                $item->setSubTotal($product->getValue() * $item->getQuantity());

                $item->save();
                $total = $total + $item->getSubTotal();
            }
        }

        $order->setTotal($total);
        if ($total > 0) {
            $order->save();
        } else {
            $order->delete();

            return redirect()->route('cart.index')->withErrors([__('messages.no_items_in_cart')]);
        }

        $request->session()->forget('products');

        $payment_data = [];
        $payment_data["callback"] = view('cart.buy')->with('data', $data);
        $payment_data[""];

        return redirect()->route('payhistory.create', $payment_data);


    }
}
