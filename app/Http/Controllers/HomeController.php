<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Group;
use App\Models\GroupUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class
HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
//        $data=User::query()->find(Auth::user()->id)->groups()->get();
//        $data1=File::join($data,'files.user_id', '=', $data->pivot->user_id);
//        $data1 = File::query()->join('groupusers',
//            'files.user_id', '=', 'groupusers.user_id')
//             ->join('files.user_id','=',Auth::user()->id)
//            ->get(['files.*', 'groupusers.group_id']);
//        $data=User::query()->find(Auth::user()->id)->groups()->get()->only('group_id');
//        $data2=Group::query()->whereIn()
        //$data=$data1->groups()->get();
//return $data;

        //File::query()->orderBy("id", "desc")->get()->all();
        if(Auth::user()->is_admin)
            $data=File::query()->orderBy("id", "desc")->paginate(5);
        else {
//            $data1 = GroupUser::query()->where('user_id', '=', Auth::user()->id)->get('group_id');
//            $data2 = GroupUser::query()->whereIn('group_id', $data1)->distinct()->get('user_id');
//            $data = File::query()->whereIn('user_id', $data2)->orderBy("id", "desc")
//                ->paginate(5);
            $data = File::query()->where('user_id','=', Auth::user()->id)->orderBy("id", "desc")
                ->paginate(5);
        }


        return view('home')->with(['data'=>$data]);
    }
}
