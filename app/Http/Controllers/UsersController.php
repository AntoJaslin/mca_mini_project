<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('role');
    } 

    public function index(Request $request)
    {
        
        // $data = [
        //     'count_user' => User::latest()->count(),
        //     'count_category' => Category::latest()->count(),
        //     'count_sub_category' => SubCategory::latest()->count(),
        //     'menu'       => 'menu.v_menu_admin',
        //     'content'    => 'content.view_user',
        //     'title'    => 'Table User'
        // ];

        if ($request->ajax()) {
            $q_user = User::select('*')->where('role','=', '2')->orderByDesc('created_at');
            return Datatables::of($q_user)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                        // $btn = '<div data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-sm btn-icon btn-outline-success mr-2 edit editUser">Edit</div>';
                        // $btn = $btn.' <div data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-sm btn-icon btn-outline-danger r-2 deleteUser">Delete</div>';
                        $btn = '<div data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-sm btn-icon btn-outline-danger r-2 deleteUser">Delete</div>';
 
                         return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        // return view('layouts.v_template',$data);
        return view('admin.users.list');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        User::updateOrCreate(['id' => $request->user_id],
                [
                 'name' => $request->name,
                 'email' => $request->email,
                 'level' => $request->level,
                 'password' => Hash::make($request->password),
                 'role' => $request->role
                ]);        

        return response()->json(['success'=>'User Saved Successfully!']);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $User = User::find($id);
        return response()->json($User);

    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        User::find($id)->delete();

        return response()->json(['success'=>'Customer Deleted Successfully!']);
    }
}
