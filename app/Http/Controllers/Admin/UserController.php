<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\CustomerProduct;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::orderBy('id', 'DESC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                   ->addColumn('online', function ($row) {
                    if ($row->isOnline())
                          $online = "<span class='badge badge-success'>Online</span>";
                            else
                          $online= "<span class='badge badge-danger'>Offline</span>";

                    return $online;
                })
                ->addColumn('image', function ($row) {
                    if ($row->image)
                        $image = '<img width="100px" src="' . $row->image . '" />';
                    else
                        $image = '<img width="100px" src="https://via.placeholder.com/150" />';

                    return $image;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="View" class="view view_btn btn btn-success mr-1 btn-sm viewItem">View</a>';
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-warning btn-sm editItem"><i class="fa fa-pencil-alt"></i></a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteItem"><i class="fa fa-trash"></i></a>';
    
                    return $btn;
                })
                ->rawColumns(['image','online','action'])
                ->make(true);
        }

        return view('admin/pages/user');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $image = $request->image ? $this->uploadImage($request, 'product_hidden_image', 'image') :  $request->image_hidden; //upload file

        if(!$request->Item_id)
        {
        $is_found = User::where('email',$request->email)->first();
        if($is_found)
        {
           return response()->json(['success' => 'User found with same email']);
        }
        }
        if($request->Item_id)
        {
            $user = User::find($request->Item_id);
            $request->password ? $pass = bcrypt($request->password) : $pass = $user->password;
        }
        else
        {
            $pass = bcrypt($request->password);
        }
        $details = [
            'company_name' => $request->company_name,
            'phoneno'=>$request->phoneno,
            'image'=>$image,
            'username' => $request->username,
            'email' => trim($request->email),
            'password' => $pass,
            'status'=> $request->status=='on' ? 1 : 0,
        ];
        $user_data = User::updateOrCreate(['id' => $request->Item_id], $details);
        if($user_data)
        {
            $user = User::where('email',trim($request->email))->first();
             $user->createToken($user->email)->accessToken;

            return response()->json(['success' => 'Customer Updated successfully.']);
        }
        else
        {
            return response()->json(['error' => 'Customer was not updated.']);
        }
    }

    public function show($id)
    {
        //
    }



    public function edit($id)
    {
        $item = User::find($id);
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $fileArray = array('image');
        $item = User::find($id);
        if($item->image != null)
        {
            $this->deleteImage($item, $fileArray);
        }

        User::find($id)->delete();
        return response()->json(['success' => 'Customer deleted successfully.']);
    }
    protected function uploadImage($requests, $hiddenname, $filename)
    {

        if (isset($requests)) {

            if ($files = $requests->file($filename)) {
                $ran = rand(1000, 9999);
                $destinationPath = public_path() . '/assets/images/user'; // upload path
                $deletefile = $destinationPath . '/' . $requests->$hiddenname;
                File::delete($deletefile);
                $upImage = date('YmdHis') . $ran . "." . $files->getClientOriginalExtension(); //name convert to unique
                $files->move($destinationPath, $upImage);  // upload image
                return $upImage;
            } else {
                $upImage = $requests->$hiddenname;
                return $upImage;
            }
        } else {
            $upImage = $requests->$hiddenname;
            return $upImage;
        }

    }

    protected function deleteImage($queryObj, $files)
    {

        foreach ($files as $file) {
            $deletefile = $queryObj->$file;
            $destinationPath = public_path() . '/assets/images/category'; // upload path
            $deletefile = $destinationPath . '/' . basename($deletefile);
            File::delete($deletefile);
        }

    }

}


