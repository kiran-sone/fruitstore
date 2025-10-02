<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\FruitType;
use App\Models\Fruit;
use App\Models\CartItem;

class Home extends Controller
{
    public function index()
    {
        Log::info("Inside landing page");
        $data['fruit_types'] = FruitType::getFruitTypes();
        // echo "<pre>"; print_r($data);exit;
        return view('home', $data);
    }

    private function checkUserLogin()
    {
        // $sessionData = session()->all();
        // echo "<pre>"; print_r($sessionData);exit;
        Log::info("Inside user login check method");
        if (!Auth::check() || Auth::user()->user_type != 0) {
            return redirect('/login');
        }
        return null; // explicitly return nothing if check passes
    }

    public function products(Request $request)
    {
        Log::info("Inside shop page");
        $ftid = $request->input('ft');
        $data['fruit_types'] = FruitType::getFruitTypes();
        $data['f_type'] = [];
        if(!empty($ftid)){
            $data['f_type'] = FruitType::getFruitType($ftid);
        }
        $data['fruits'] = Fruit::getFruits();
        // echo "<pre>"; print_r($data);exit;
        return view('shop', $data);
    }

    public function details(Request $request, $fname)
    {
        Log::info("Inside product details page");
        Log::info("fruit name in url: ".$fname);
        $data['f_data'] = [];
        $data['rel_products'] = [];
        
        if (isset($fname) && !empty(trim($fname))) {
            $data['f_data'] = Fruit::getFruitDetailsBySlug($fname);
            if (!empty($data['f_data']) && isset($data['f_data'][0]->type_id)) {
                $data['rel_products'] = Fruit::getFruitsByType($data['f_data'][0]->type_id);
                // fetch single cart item for this fruit
                $fid = $data['f_data'][0]->fruit_id;
                $cartItem = Auth::check()
                    ? CartItem::where('user_id', Auth::id())->where('fruit_id', $fid)->first()
                    : array_values(array_filter($request->session()->get('cart', []), fn($item) => $item['fruit_id'] == $fid))[0] ?? null;

                $data['cart_item'] = $cartItem; // will be null if not in cart
                $data['cartQty']   = $cartQty = isset($cartItem->quantity) ? $cartItem->quantity : 1;
                $data['inCart']    = $cartItem ? true : false;
                Log::info("cartQty: ".$cartQty);
            }
            else {
                // If no fruit found → 404
                abort(404, "Fruit not found");
            }
        }
        // echo "<pre>"; print_r($data);exit;
        return view('details', $data);
    }

    public function searchFruits(Request $request)
    {
        Log::info("Inside searchFruits method");
        DB::enableQueryLog();
        $fr_keyword = trim((string)$request->input('keyword'));
        $fruits = Fruit::select('fruit_id', 'name')->where('name', 'like', "%$fr_keyword%")->get()->toArray();
        $queries = DB::getQueryLog();
        Log::info("searchFruits SQL: ".json_encode($queries));
        // echo "<pre>"; print_r($fruits);exit;
        if(!empty($fruits)) {
            return response()->json($fruits);
        }
        else {
            return response()->json(array());
        }
    }

    public function addtocart(Request $request, $fid)
    {
        $product = Fruit::findOrFail($fid);
        $quantity = (int) $request->input('quantity', 1);

        if (Auth::check()) {
            // Logged-in: save directly to DB
            $cartItem = CartItem::where('user_id', Auth::id())
                ->where('fruit_id', $fid)
                ->first();
            if ($cartItem) {
                $cartItem->increment('quantity', $quantity);
            } 
            else {
                CartItem::create([
                    'user_id' => Auth::id(),
                    'fruit_id' => $fid,
                    'quantity' => $quantity,
                ]);
            }
        } 
        else {
            // Guest: save to session
            $cart = $request->session()->get('cart', []);
            $found=false;
            foreach ($cart as $ckey => $cvalue) {
                if($cvalue['fruit_id']==$fid){
                    $cart[$ckey]['fruit_id'] += $quantity;
                    $found=true;
                    break;
                }
            }

            if (!$found) {
                $cart[] = [
                    'cart_item_id' => null,   // no DB id yet
                    'user_id'      => null,   // guest user
                    'fruit_id'     => $fid,
                    'quantity'     => $quantity,
                ];
            }

            $request->session()->put('cart', $cart);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Product added to cart',
        ]);
    }

    public function cart(Request $request)
    {
        // $request->session()->flush();
        $data['SHIPPING_COST'] = env('SHIPPING_COST');

        if (Auth::check()) {
            // From DB
            $data['cart_items'] = CartItem::where('user_id', Auth::id())
                ->get()
                ->toArray();
        } else {
            // From session
            $data['cart_items'] = array_values($request->session()->get('cart', []));
        }

        // echo "<pre>"; print_r($data);exit;
        return view('cart', $data);
    }

    public function updatecart(Request $request)
    {
        Log::info("Inside updatecart function");
        $cartitems = $request->input('cartitems');
        $quantities = $request->input('quantity');
        $fruitIds = $request->input('fruitids');
        Log::info("cartitems: ".json_encode($cartitems));
        Log::info("quantities: ".json_encode($quantities));
        // echo "<pre>"; print_r($cartitems);exit;
        // dd($request->all());
        $affected = false;
        if(Auth::check()) {
            foreach ($cartitems as $itemkey => $itemid) {
                CartItem::where('cart_item_id', $itemid)
                ->update(['quantity' => $quantities[$itemkey]]);
                $affected = true;
            }
        }
        else {
            $cart = $request->session()->get('cart', []);
            foreach ($fruitIds as $findex => $fruitId) {
                $newQty = (int) ($quantities[$findex] ?? 1);

                // Update if fruit exists in cart
                foreach ($cart as &$item) {
                    if ($item['fruit_id'] == $fruitId) {
                        $item['quantity'] = $newQty; // update quantity
                        $affected = true;
                        break;
                    }
                }
            }

            $request->session()->put('cart', $cart);
        }

        if($affected)
            return redirect()->route('cart')
                         ->with('success', 'Items have been updated successfully!');
        else
            return redirect()->route('cart')
                         ->with('error', 'Something went wrong while updating!');
    }

    public function deletecartitem(Request $request)
    {
        Log::info("Inside deletecartitem function");
        $citem_id = $request->input('cartid'); //for logged in user
        $fid = $request->input('fid'); //for guest user
        if (Auth::check()) {
            Log::info("Deleting cartid from cart db: ".$citem_id);
            $deleted = CartItem::where('cart_item_id', '=', $citem_id)->delete();
        }
        else {
            Log::info("Deleting fruitid ".$fid." from cart session");
            $cart_items = array_values($request->session()->get('cart', []));
            foreach ($cart_items as $skey => $svalue) {
                if($svalue['fruit_id'] == $fid) {
                    unset($cart_items[$skey]);
                    $deleted = true;
                    break;
                }
            }
            $request->session()->put('cart', $cart_items);
            //$request->session()->forget('name');
        }

        if($deleted){
            Log::info("deleted cartid: ".$citem_id);
            return response()->json([
                'status'  => 'success',
                'message' => 'Item has been deleted!',
            ]);
            // return redirect()->route('cart')->with('success', 'Item has been deleted successfully!');
        }
        else {
            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong! It seems no items were deleted',
            ]);
            // return redirect()->route('cart')->with('error', 'Something went wrong while deleting!');
        }
    }

    public function checkout(Request $request)
    {
        if ($redirect = $this->checkUserLogin()) {
            return $redirect;
        }
        Log::info("Inside checkout page");
        // $sessionData = $request->session()->all();
        // echo "<pre>"; print_r($sessionData);exit;
        $data['SHIPPING_COST'] = env('SHIPPING_COST'); 
        Log::info("SHIPPING_COST: ".$data['SHIPPING_COST']);
        $data['cart_items'] = Auth::check() ? 
        CartItem::where('user_id', Auth::id())->with('Fruit')->get()->toArray() : 
        CartItem::where('session_id', $request->session()->getId())->with('Fruit')->get()->toArray();
        // echo "<pre>"; print_r($data);exit;
        return view('checkout', $data);
    }

    public function createorder(Request $request)
    {
        Log::info("Inside createorder function");
        $validated = $request->validate([
            'name1' => 'required',
            'name2' => 'required',
        ]);

        // henceforth order form is valid
        
    }

    public function versions()
    {
        echo "PHP: ".phpversion();
        echo "<br>Laravel: ".app()->version();
    }
}
