<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\Position;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('role');
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
