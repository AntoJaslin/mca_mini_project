<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('role');
    } 

    public function index(Request $request)
    {

        

        if ($request->ajax()) {
            $q_product = Product::select('*')
                            ->orderByDesc('id');
            return Datatables::of($q_product)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                        $btn = '<div data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-sm btn-icon btn-outline-success mr-2 edit editProduct">Edit</div>';
                        $btn = $btn.' <div data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-sm btn-icon btn-outline-danger mr-2 deleteProduct">Delete</div>';
 
                         return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $products = Product::select('*')->orderBy('id')->get();
        $categories = Category::select('*')->orderBy('id')->get();
        $data = [
            'categories' => $categories
        ];
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

        return view('admin.products.list', $data);
    }

    public function create()
    {
        //
        $categories = Category::select('*')->orderBy('id')->get();
        $data = [
            'categories' => $categories
        ];
        return view('admin.products.create', $data);
    }

    public function store(Request $request)
    {
        $message;
        $path = '';
        if ($request->hasFile('image')) {
            $validatedData = $request->validate([
                'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
                // 'country' => 'required|gt:0',
                // 'order_no' => 'required|gt:0'
            ]);
            
            $image = $request->file('image');
            $name = 'product_'.time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path().'/images/products';
            $image->move($destinationPath, $name);
            $image_name = $name;
            $path = 'images/products/'.$name;
        }
        if($request->product_id == '' ) {
            $message = 'Product created successfully!';
        } else {
            $message = 'Product updated successfully!';
        }
        Product::updateOrCreate(['id' => $request->product_id],
                [
                 'name' => $request->name,
                 'category_id' => $request->category_id,
                 'author' => $request->author,
                 'publisher' => $request->publisher,
                 'binding' => $request->binding,
                 'release' => $request->release,
                 'language' => $request->language,
                 'price' => $request->price,
                 'image' => $path
                //  'description' => $request->description,
                //  'isActive' => $request->status,
                ]);        

        return response()->json(['success'=>$message]);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $product = Product::find($id);
        //return response()->json($product);
        $categories = Category::select('*')->orderBy('id')->get();
        $data = [
            'product' => $product,
            'categories' => $categories
        ];
        return view('admin.products.edit', $data);

    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        Product::find($id)->delete();

        return response()->json(['success'=>'Product Deleted Successfully!']);
    }
    
    public function getTopMenuCategories()
    {
        $top_menu_categories = Product::where('position', '=', 2)->get();

        return response()->json($top_menu_categories);
    }

}
