<?php

namespace App\Services ;
use App\Models\File;
use App\Models\Group;
use App\Models\Report_event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService{
    public function getallusers()
    {
        try {


            $users = User::query()->orderBy("id", "desc")
                ->paginate(5);;


            return view('admin.user.index', compact('users'));
        }
        catch (Exception $ex){
            return $ex->getMessage();
        }
    }
public function getusercreatepage()
{
    //$groups=Group::query()->get()->all();
    try {


        return view('admin.user.create');//,compact('groups'));
    }
    catch (Exception $ex){
        return $ex->getMessage();
    }
    }
    public function addnewuser(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed'],
            // 'groups'=>['required']
        ]);
        try {


            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $public = Group::query()->where('name', '=', 'public')->get('id');
            $user->groups()->attach($public);
            return redirect()->route('user.index')
                ->with('message', 'User created successfully.');
        }
        catch (Exception $ex){
            return $ex->getMessage();
        }
    }
    public function getusereditpage(User $user)
    {
        // $groups=Group::query()->get()->all();
        try {


            return view('admin.user.edit', compact('user'));//,'groups'));
        }
        catch (Exception $ex){
            return $ex->getMessage();
        }
    }
  public function updateuser(Request $request,  User $user)
  {
      $request->validate([
          'name' => ['required', 'string', 'max:255', 'unique:users,name,' . $user->id],
          'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
          'password' => ['nullable', 'confirmed'],
          // 'groups'=>['required']
      ]);
      try {


          $user->update([
              'name' => $request->name,
              'email' => $request->email,
          ]);
          if ($request->password) {
              $user->update([
                  'password' => Hash::make($request->password),
              ]);
          }
//        $user->groups()->detach();
//        $user->groups()->attach($request->groups);

          return redirect()->route('user.index')
              ->with('message', 'User updated successfully.');
      }
      catch (Exception $ex){
          return $ex->getMessage();
      }
    }
    public function deleteuser(Request $request)
    {
        try {


            $ids = $request->ids;
            DB::transaction(function () use ( &$ids) {
                $files_unlock= File::query()->whereIn('owner_id',$ids);
                $files_unlock->lockForUpdate();
                    $files_unlock->update(['owner_id' => null]);
                $users = User::query()->whereIn('id', $ids)->delete();
            });



return "Users have been deleted!";

        }
        catch (Exception $ex){
            return $ex->getMessage();
        }
    }
    public function getallthegroupusers($id)
    {
        try {


            $group = Group::query()->find($id);
            $users = $group->users()->distinct()->orderBy("id", "desc")
                ->paginate(5);;

            return view('group.users', compact('users', 'group'));
        }
        catch (Exception $ex){
            return $ex->getMessage();
        }
    }
    public function userhistory($id)
    {
        try {


            $user = User::query()->find($id);
            $events = $user->report_events()->orderBy("id", "desc")
                ->paginate(5);

            return view('admin.user.events', compact('user', 'events'));
        }
        catch (Exception $ex){
            return $ex->getMessage();
        }
    }



}
