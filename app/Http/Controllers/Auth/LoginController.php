<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\CartItem;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;
    // protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        $sessionCart = $request->session()->get('cart', []);

        foreach ($sessionCart as $item) {
            $fruitId = $item['fruit_id'];
            $quantity = $item['quantity'];

            $existing = CartItem::where('user_id', $user->id)
                ->where('fruit_id', $fruitId)
                ->first();

            if ($existing) {
                $existing->quantity += $quantity;
                $existing->save();
            } else {
                CartItem::create([
                    'user_id'  => $user->id,
                    'fruit_id' => $fruitId,
                    'quantity' => $quantity,
                ]);
            }
        }

        $request->session()->forget('cart');

        return redirect()->intended('/');
    }

}
