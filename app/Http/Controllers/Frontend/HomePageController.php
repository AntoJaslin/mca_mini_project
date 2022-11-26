<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\Position;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Session;


class HomePageController extends Controller
{
    public function __construct()
    {
        
    } 

    public function showHomePage(Request $request) {

        $categories = Category::select('*')->orderByDesc('id')->get();
        $products = Product::select('*')->orderByDesc('id')->get();
        $data = [
            'categories' => $categories,
            'products' => $products
        ];
        return view('index', $data);
    }

    public function showCartPage(Request $request) {

        $categories = Category::select('*')->orderByDesc('id')->get();
        $products = array();
        $cartCount = 0;

        if(Session::has('cart')) {
            $products = Session::get('cart');
            $cartCount = count($products);
        }
        
        $data = [
            'categories' => $categories,
            'products' => $products,
            'cartCount' => $cartCount
        ];
        return view('cart', $data);
    }

    public function addCart(Request $request) {
        if ($request->ajax()) {
            $productId = $request->product_id;
            $product = Product::find($productId);
            if(!empty($product)) {
                
                if(Session::has('cart')) {
                    $cart = Session::get('cart');
                    array_push($cart, $product);
                    Session::put('cart', $cart);
                } else {
                    $cart = array();
                    array_push($cart, $product);
                    Session::put('cart', $cart);
                }
                // $cart->push();
                
                return response()->json(['code' => 200, 'success'=>'Cart Item has added successfully!']);
            } else {
                return response()->json(['code' => 404, 'error'=>'Cart Item not found!']);
            }
            
            
        }
        
        
    }

    public function createOrder(Request $request) {
        if ($request->ajax()) {
            // $productId = $request->product_id;
            // $product = Product::find($productId);
            $order_id = 'DLS_'.mt_rand(1111,9999);
            $user = Session::get('customer-user');
            Order::updateOrCreate(['order_id' => $request->order_id],
                [
                 'user_id' => $user->id,
                 'price' => $request->total,
                 'products' => $request->products,
                 'status' => 'in-progress',
                ]);    
            Session::forget('cart');
            return response()->json(['code' => 200, 'success'=>'Order has created successfully!']);
            
        }
    }

    public function registerUser(Request $request) {
        $user = User::updateOrCreate(['id' => $request->user_id],
                [
                 'name' => $request->user_name,
                 'email' => $request->user_email,
                 'password' => $request->user_password,
                 'role' => 2,
                 'is_active' => 1,
                ]);        
        if(!empty($user)) {
            Session::flash('signup-success', 'Signed up successfully!');
            return view('app.login');
        } else {
            return response()->json(['error'=>'Something went wrong!']);
        }
        

    }

    public function loginUser(Request $request) {
        $user_email = $request->user_email;
        $user_password = $request->user_password;
        $user = User::where('email', '=', $user_email)->where('role', '=', 2)->first();
        // return response()->json(['error'=>'Something went wrong!', 'user'=> $user]);
        if(!empty($user) && $user != null) {
            if($user->password == $user_password) {
                Session::put('customer-user', $user);
                session()->flash('signin-success', 'Signed in successfully!');
                return redirect('/');
            } else {
                session()->flash('signin-failed', 'Password missmatch!');
                // return view('app.login');
                return back()
                        ->withErrors(
                            [
                                'user_password' => 'User email not verified!',
                            ],
                        )->withInput();
            }
            
        } else {
            session()->flash('signin-failed', 'No user found!');
            // return view('app.login');
            return back()
                        ->withErrors(
                            [
                                'user_email' => 'User email not verified!',
                            ],
                        )->withInput();
        }
        

    }

    public function logoutUser() {
        if(Session::has('customer-user')) {
            Session::forget('customer-user');
        }
        return redirect('/');
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $q_category = Category::select('*')
                            ->orderByDesc('id');
            return Datatables::of($q_category)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                        $btn = '<div data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-sm btn-icon btn-outline-success mr-2 edit editCategory">Edit</div>';
                        $btn = $btn.' <div data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-sm btn-icon btn-outline-danger mr-2 deleteCategory">Delete</div>';
 
                         return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $categories = Category::select('*')->orderByDesc('id')->get();
        // $positions = Position::select("*")->get();
        // $data = [
        //     'count_user' => User::latest()->count(),
        //     'count_category' => Category::latest()->count(),
        //     'count_sub_category' => SubCategory::latest()->count(),
        //     'menu'       => 'menu.v_menu_admin',
        //     'content'    => 'content.view_category',
        //     'title'    => 'Categories',
        //     'categories' => $categories,
        //     'name'=> 'pradeepa'
        // ];

        return view('admin.categories.list');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $message;
        if($request->category_id == '' ) {
            $message = 'Category created successfully!';
        } else {
            $message = 'Category updated successfully!';
        }
        Category::updateOrCreate(['id' => $request->category_id],
                [
                 'name' => $request->name,
                 'description' => $request->description,
                 'isActive' => $request->status,
                ]);        

        return response()->json(['success'=>$message]);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return response()->json($category);

    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        Category::find($id)->delete();

        return response()->json(['success'=>'Category Deleted Successfully!']);
    }
    
    public function getTopMenuCategories()
    {
        $top_menu_categories = Category::where('position', '=', 2)->get();

        return response()->json($top_menu_categories);
    }

}
