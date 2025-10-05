<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\FruitType;
use App\Models\Fruit;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderDetail;

class Cms extends Controller
{

    // show the admin login form
    public function showLoginForm()
    {
        Log::info("Inside Admin dashboard page");
        // echo "<pre>"; print_r($data);exit;

        // If already logged in, redirect to the dashboard
        if(Auth::check() && Auth::user()->user_type==1)
            return redirect('cms/dashboard');
        
        // Otherwise show login page
        return view('cms.login');
    }

    //handle login submission
    public function login(Request $request)
    {
        \Log::info("Checking admin user credentials");

        $credentials = $request->only('email', 'password');

        // Step 1: check email/password
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            // Step 2: check user type
            if (Auth::user()->user_type == 1) {
                \Log::info("Valid admin user credentials");
                return redirect()->intended('/cms/dashboard');
            } else {
                \Log::warning("User tried to login but is not admin: " . Auth::user()->email);

                // logout immediately since user is not admin
                Auth::logout();

                return back()->withErrors([
                    'email' => 'You are not authorized to access the admin area.',
                ]);
            }
        }

        // wrong email/password
        \Log::info("Invalid email/password for admin login!");
        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ]);
    }

    private function checkAdminLogin()
    {
        // $sessionData = session()->all();
        // echo "<pre>"; print_r($sessionData);exit;
        Log::info("Inside login check method");
        if (!Auth::check() || Auth::user()->user_type != 1) {
            return redirect('cms/login');
        }
        return null; // explicitly return nothing if check passes
    }

    public function dashboard()
    {
        if ($redirect = $this->checkAdminLogin()) {
            return $redirect; // return redirect response if set
        }
        Log::info("Inside Admin dashboard page");
        // echo "<pre>"; print_r($data);exit;
        return view('cms.dashboard');
    }

    public function users()
    {
        if ($redirect = $this->checkAdminLogin()) {
            return $redirect;
        }
        Log::info("Inside users page");
        $data['users'] = User::get()->toArray();
        // echo "<pre>"; print_r($data);exit;
        return view('cms.users', $data);
    }

    //Start - Code Fruit Types
    public function fruitTypes()
    {
        if ($redirect = $this->checkAdminLogin()) {
            return $redirect;
        }
        Log::info("Inside Admin fruitTypes method");
        $data['fruit_types'] = FruitType::getFruitTypes();
        // echo "<pre>"; print_r($data);exit;
        return view('cms.fruit_types', $data);
    }

    public function addFruitType(Request $request)
    {
        Log::info("Inside Admin addFruitType method");
        $newFruitType = trim($request->input('fruitType'));
        $typeImage = null;

        $request->validate([
            'fruitType' => 'required|string|max:255',
            'typeImg' => 'nullable|file|max:2048|mimes:jpg,png,webp'
        ]);

        if(!empty($newFruitType)) {
            if (FruitType::where('type_name', $newFruitType)->exists()) {
                return redirect('cms/fruit-types')
                    ->with('error', 'Fruit Type '.$newFruitType.' already exists');
            }
            else {
                if($request->hasFile('typeImg')) {
                    Log::info("Attempting fruit type image upload");
                    $typeImgFile = $request->file('typeImg');
                    $typeImage = 'ti'.time().'.'.$typeImgFile->extension();
                    $typeImgFile->move(base_path('assets/uploads'), $typeImage);
                }

                FruitType::create([
                    'type_name' => $newFruitType,
                    'type_img' => $typeImage,
                ]);
                return redirect('cms/fruit-types')
                    ->with('success', 'Fruit Type has been added successfully');
            }
            
        }
        else {
            return redirect('cms/fruit-types')
                    ->with('error', 'No data to insert');
        }
    }

    public function editFruitType(Request $request)
    {
        // echo "<pre>"; print_r($_FILES);exit;
        Log::info("Inside Admin editFruitType method");
        $fruitType = trim($request->input('editFruitType'));
        $type_id = trim((int)$request->input('typeId'));
        $typeImage = null;
        
        $request->validate([
            'editFruitType' => 'required|string|max:255',
            'editTypeImg' => 'nullable|file|max:2048|mimes:jpg,png,webp'
        ]);

        if(!empty($fruitType)) {
            if($request->hasFile('editTypeImg')) {
                Log::info("Attempting fruit type image upload");
                $typeImgFile = $request->file('editTypeImg');
                $typeImage = 'ti'.time().'.'.$typeImgFile->extension();
                $typeImgFile->move(base_path('assets/uploads'), $typeImage);
            }

            FruitType::where('type_id', $type_id)->update([
                'type_name' => $fruitType,
                'type_img' => $typeImage,
            ]);
            return redirect('cms/fruit-types')
                ->with('success', 'Fruit Type has been updated successfully');
        }
        else {
            return redirect('cms/fruit-types')
                ->with('error', 'No data to update');
        }
    }

    public function deleteFruitType(Request $request)
    {
        Log::info("Inside Admin deleteFruitType method");
        $type_id = trim((int)$request->input('typeId'));
        Log::info("FruitType id: ".$type_id);
        if(!empty($type_id) && FruitType::where('type_id', $type_id)->exists()) {
            $fruitTypeData = FruitType::where('type_id', $type_id)->first();
            if(!empty($fruitTypeData->type_img)) {
                $filepath = base_path('assets/uploads/' . $fruitTypeData->type_img);
                if(file_exists($filepath) && is_file($filepath)) {
                    unlink($filepath);
                    Log::info("Deleting the typeimage ".$filepath);
                }
            }
            FruitType::where('type_id', $type_id)->delete();
            $jsonArr = [
                'status' => 'success',
                'message' => 'Fruit Type has been deleted successfully',
            ];
            return response()->json($jsonArr);
        }
        else {
            $jsonArr = [
                'status' => 'error',
                'message' => 'No data to delete',
            ];
            return response()->json($jsonArr);
        }
    }
    //End - Code Fruit Types

    //Start - Code Fruits
    public function fruits()
    {
        if ($redirect = $this->checkAdminLogin()) {
            return $redirect;
        }
        Log::info("Inside Admin fruits page");
        $data['fruit_types'] = FruitType::getFruitTypes();
        $data['fruits'] = Fruit::getFruits();
        // echo "<pre>"; print_r($data);exit;
        return view('cms.fruits', $data);
    }

    public function addFruit()
    {
        if ($redirect = $this->checkAdminLogin()) {
            return $redirect;
        }
        Log::info("Inside Admin addFruit page");
        $data['fruit_types'] = FruitType::getFruitTypes();
        // echo "<pre>"; print_r($data);exit;
        return view('cms.addfruit', $data);
    }

    public function addNewFruit(Request $request)
    {
        // echo "<pre>"; print_r($_POST);exit;
        Log::info("Inside Admin addNewFruit method");
        $request->validate([
            'fruitName'      => 'required|string|max:255',
            'fruitType' => 'required|integer',
            'fQuantity' => 'nullable|integer',
            'fPrice'    => 'required|integer',
            'fImage'    => 'nullable|file|max:2048|mimes:jpg,png,webp',
        ]);
        $newFruit = trim($request->input('fruitName'));
        $fruitType = (int) trim($request->input('fruitType'));
        $frFilename = null;

        if ($request->hasFile('fImage')) {
            Log::info("Attempting fruit image upload");
            $fr_file = $request->file('fImage');
            $frFilename = time() . '.' . $fr_file->extension();
            $fr_file->move(base_path('assets/uploads'), $frFilename);
        }

        if(!empty($newFruit) && !empty($fruitType)) {
            if (Fruit::where(['name'=>$newFruit, 'type_id'=>$fruitType])->exists()) {
                return redirect('cms/fruits')
                    ->with('error', 'Fruit '.$newFruit.' already exists');
            }
            else {
                Fruit::create([
                    'name'              => $newFruit,
                    'type_id'           => $fruitType,
                    'stock_quantity'    => (int) trim($request->input('fQuantity')),
                    'price'             => trim($request->input('fPrice')),
                    'description'       => trim($request->input('fDescr')),
                    'image'             => $frFilename,
                ]);
                return redirect('cms/fruits')
                    ->with('success', 'Fruit '.$newFruit.' has been added successfully');
            }
            
        }
    }

    public function editFruit(Request $request, $fid)
    {
        if ($redirect = $this->checkAdminLogin()) {
            return $redirect;
        }
        Log::info("Inside Admin editFruit page ".$fid);

        if(isset($_POST['fruitName']) && !empty(trim($_POST['fruitName']))) {
            $newFruit = trim($request->input('fruitName'));
            $fruitType = (int) trim($request->input('fruitType'));
            $frFilename = null;

            if ($request->hasFile('fImage')) {
                Log::info("Attempting fruit image upload");
                $fr_file = $request->file('fImage');
                $frFilename = time() . '.' . $fr_file->extension();
                $fr_file->move(base_path('assets/uploads'), $frFilename);
            }

            if(!empty($newFruit) && !empty($fruitType)) {
                $fUpdateData = [
                    'name'              => $newFruit,
                    'type_id'           => $fruitType,
                    'stock_quantity'    => (int) trim($request->input('fQuantity')),
                    'price'             => trim($request->input('fPrice')),
                    'description'       => trim($request->input('fDescr')),
                ];
                if(!empty($frFilename))
                    $fUpdateData['image'] = $frFilename;
                Fruit::where('fruit_id', $fid)->update($fUpdateData);
                return redirect('cms/editfruit/'.$fid)
                    ->with('success', 'Fruit '.$newFruit.' has been updated successfully');
            }
        }

        $data['fruit_types'] = FruitType::getFruitTypes();
        $data['fruit'] = Fruit::getFruitDetails($fid);
        // echo "<pre>"; print_r($data);exit;
        return view('cms.editfruit', $data);
    }

    public function deleteFruit(Request $request)
    {
        Log::info("Inside Admin deleteFruit method");
        $fruit_id = trim((int)$request->input('fruitId'));
        Log::info("Fruit id: ".$fruit_id);
        if(!empty($fruit_id) && Fruit::where('fruit_id', $fruit_id)->exists()) {
            $fruitData = Fruit::where('fruit_id', $fruit_id)->first();
            if(!empty($fruitData->image)) {
                $filepath = base_path('assets/uploads/' . $fruitData->image);
                if(file_exists($filepath) && is_file($filepath)) {
                    unlink($filepath);
                    Log::info("Deleting the image ".$filepath);
                }
            }
            Fruit::where('fruit_id', $fruit_id)->delete();
            Log::info("Deleted Fruit id: ".$fruit_id);
            $jsonArr = [
                'status' => 'success',
                'message' => 'Fruit has been deleted successfully',
            ];
            return response()->json($jsonArr);
        }
        else {
            $jsonArr = [
                'status' => 'error',
                'message' => 'No data to delete',
            ];
            return response()->json($jsonArr);
        }
    }

    public function orders()
    {
        if ($redirect = $this->checkAdminLogin()) {
            return $redirect;
        }
        Log::info("Inside orders page");
        $data['orders'] = Order::join('users', 'orders.uid', '=', 'users.id')->get()->toArray();
        // echo "<pre>"; print_r($data);exit;
        return view('cms.orders', $data);
    }

    public function orderDetails(Request $request, $oid)
    {
        if ($redirect = $this->checkAdminLogin()) {
            return $redirect;
        }
        Log::info("Inside orderDetails page");
        $data['order_data'] = Order::where(['order_id' => $oid])->first();
        if (!empty($data['order_data']['order_id'])) {
            // From DB
            $data['order_items'] = OrderDetail::join('fruits', 'fruits.fruit_id', '=', 'order_details.fid')->where('oid', $oid)->get()->toArray();
        } else {
            $data['odata_error'] = "Order data not found!";
        }
        // echo "<pre>"; print_r($data);exit;
        return view('cms.orderdetails', $data);
    }

}
