<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Program;
use App\Models\Circuit;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;


class AdminController extends Controller
{


    public function index()
    {
      $users = User::latest()->get();
      $user_count = $users->count();
      return view('admin/pages/index',['users'=>$users,'user_count'=>$user_count]);
    }


}

