<?php
namespace App\Services;
use App\Models\File;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class GroupService{
    public function getgroupscreatedbythisuser()
    {
        try {


            if (Auth::user()->is_admin) {
                $groups = Group::query()->orderBy("id", "desc")
                    ->paginate(5);;

            } else {

                $groups = Auth::user()->creator_groups()->orderBy("id", "desc")
                    ->paginate(5);;
            }


            return view('group.index', compact('groups'));
        }catch (Exception $ex){//LockTimeoutException
            return $ex->getMessage();//\response()->json(['success'=>$ex->getMessage()]);
        }
    }
    public function getgroupcreatepage()
    {
        try {


            return view('group.create');
        }
        catch (Exception $ex){//LockTimeoutException
            return $ex->getMessage();//\response()->json(['success'=>$ex->getMessage()]);
        }
    }
    public function addnewgroup(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:groups'],
            'description' => ['required'],

        ]);
        try {


            $group = Group::create([
                'name' => $request->name,
                'description' => $request->description,
                'creator_id' => Auth::user()->id,

            ]);
//       $user=User::query()->where('is_admin','=',1)->get();
            $group->users()->attach([Auth::user()->id, 1]);


            return redirect()->route('group.index')
                ->with('message', 'Group created successfully.');
        }
        catch (Exception $ex){//LockTimeoutException
            return $ex->getMessage();//\response()->json(['success'=>$ex->getMessage()]);
        }
    }
    public function edityourgroup(Group $group)
    {
        try {


            if ($group->creator_id == Auth::user()->id)
                return view('group.edit', compact('group'));
            abort(403);

        } catch (Exception $ex){//LockTimeoutException
            return $ex->getMessage();//\response()->json(['success'=>$ex->getMessage()]);
        }
    }
    public function updategroupinfo(Request $request, Group $group)
    {
        if($group->creator_id ==Auth::user()->id) {
            $request->validate([
                'name' => ['required', 'string', 'max:255', 'unique:groups,name,' . $group->id],
                'description' => ['required'],
            ]);
            try {


                $group->update([
                    'name' => $request->name,
                    'description' => $request->description,
                ]);


                return redirect()->route('group.index')
                    ->with('message', 'Group updated successfully.');
            }
            catch (Exception $ex){//LockTimeoutException
                return $ex->getMessage();//\response()->json(['success'=>$ex->getMessage()]);
            }
        }
        else
            abort(403);
    }
    public function getallgroupsforthisuser($id)
    {
        //user_id
        try {


            $user = User::query()->find($id);
            $groups = $user->groups()->distinct()->orderBy("id", "desc")
                ->paginate(5);;

            return view('admin.user.groups', compact('groups', 'user'));

        }
        catch (Exception $ex){//LockTimeoutException
            return $ex->getMessage();//\response()->json(['success'=>$ex->getMessage()]);
        }
    }

    public function deletegroup($id)
    {
//group_id
 $massage='';
        try {


        $group= Group::query()->where('id',$id);
        $files=$group->first()->files()->where('owner_id','!=',null)->get(['file_name']);
        if($files->isEmpty()) {
            $group->delete();
            $massage='group deleted successfully';

        }

        else {
            $massage = 'you cant delete this group because this group has locked files !!! ';
        }
            return $massage;
    } catch (Exception $ex){//LockTimeoutException
            return $ex->getMessage();//\response()->json(['success'=>$ex->getMessage()]);
        }
    }

    public function addnewuserstothegrouppage($id)
    {
        // group_id
        try {


            $users = User::query()->get()->all();

            return view('group.addusers', compact('id', 'users'));

        }catch (Exception $ex){//LockTimeoutException
            return $ex->getMessage();//\response()->json(['success'=>$ex->getMessage()]);
        }
    }
    public function addnewusertothisgroup(Request $request,$id)
    {
//group_id
        $request->validate([

            'users' => ['required']
        ]);
        try {

            if(is_string($request->users)) {
                $users = array_map('intval', explode(',', $request->users));
            }
            else
                $users = $request->users;
            $group = Group::query()->where('id', '=', $id)->first();

            $group->users()->detach($users);
            $group->users()->attach($users);
//    $users=$group->users()->distinct()->orderBy("id", "desc")
//        ->paginate(5);;
            return redirect()->route('group.users', $id);

        }
        catch (Exception $ex){//LockTimeoutException
            return $ex->getMessage();//\response()->json(['success'=>$ex->getMessage()]);
        }

    }
    public function addnewfilesgrouppage($id)
    {
        //group_id
        try {


            $files = Auth::user()->files()->get();

            return view('group.addfiles', compact('id', 'files'));

        }
        catch (Exception $ex){//LockTimeoutException
            return $ex->getMessage();//\response()->json(['success'=>$ex->getMessage()]);
        }
    }
    public function addnewfilestothisgroup(Request $request,$id){
//group_id

        $request->validate([

            'files'=>['required']
        ]);
        try {

            if(is_string($request['files'])) {
                $files = array_map('intval', explode(',', $request['files']));
            }
            else
                $files = $request['files'];
            $group = Group::query()->where('id', '=', $id)->first();
            $group->files()->detach($files);
            $group->files()->attach($files);
//    $users=$group->users()->distinct()->orderBy("id", "desc")
//        ->paginate(5);;
            return redirect()->route('user.group.files', $id);
        } catch (Exception $ex){//LockTimeoutException
            return $ex->getMessage();//\response()->json(['success'=>$ex->getMessage()]);
        }
    }
    public function getallgroupfiles($id)
    {
//grroup_id

//        $group=[];
        try {


            $group = Group::query()->where('id', '=', $id)->first();
            $value = Cache::remember('files', $seconds = 3, function () use (&$id, &$group, &$data) {

                $data = $group->files()->orderBy("id", "desc")
                    ->paginate(5);
                return $data;
            });

            $data = $value;


            return view('group.files', compact('group', 'data'));

        }
        catch (Exception $ex){//LockTimeoutException
            return $ex->getMessage();//\response()->json(['success'=>$ex->getMessage()]);
        }
    }
    public function deletefilefromthisgroup(Request $request,$id){
        try {
//request->group
            $massage='';
            $data = File::query()->where('id', $id);

            $owner=$data->value('owner_id');
            $creator=$data->value('user_id');

            if($creator==Auth::user()->id) {
                if ($owner == null || $owner == Auth::user()->id) {
                    $data->first()->groups()->detach($request->group);
                    $massage='file deleted successfully from this group';

                }
                else{
                    $massage='this file is locked ';
                }


            } else {
                $massage='you cant delete this file it is not yours !!!';


            }
            return $massage;

        }
        catch (Exception $ex){
            return $ex->getMessage();
        }
        //return \response()->json(['success'=>"files have been deleted!"]);
    }
    public function deleteuserfromthisgroup(Request $request,$id)
    {
        //group_id
        try {
$massage='';

            $group = Group::query()->where('id', '=', $request->group)->first();
            $files1 = $group->files()->where('owner_id', '=', $id)->get();
            $files2 = $group->files()->where('user_id', '=', $id)->where('owner_id', '!=',null )
                ->get();

            if ($files1->isEmpty()&&$files2->isEmpty()) {
                $group->users()->detach($id);
                $files=File::query()->where('user_id','=',$id)->get('id');
                $group->files()->detach($files);
                $massage='user deleted successfully';

            }
else{
    $massage='you cant delete this user because there is files locked by this user in this group or
     there is files for this user in this group and this files are locked !!!';
}

return $massage;

        }
        catch (Exception $ex){
            return $ex->getMessage();
        }
    }




}
