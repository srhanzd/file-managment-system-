<?php
namespace App\Services;
use App\Models\File;
use App\Models\Group;
use App\Models\Report_event;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FileService{
    public function getuserfiles()
    {
        try {


            if (Auth::user()->is_admin)
                $data = File::query()->orderBy("id", "desc");//->paginate(5);
            else {

                $data = File::query()->where('user_id', '=', Auth::user()->id)->orderBy("id", "desc")
                    ;//->paginate(5);
            }


            return view('home')->with(['data' => $data->paginate(5),'number_of_files'=>$data->count()]);

        }
        catch (\Exception $exception){
            return  $exception->getMessage();
        }
    }
    public function save(Request $request)
    {
        try {


            // upload file
            $massage = '';
            $dt = Carbon::now();
            $folder_name = 'upload';
            $date_time = $dt;//->toDayDateTimeString();
            \Storage::disk('local')->makeDirectory($folder_name, 0775, true); //creates directory
            if ($request->hasFile('fileupload')) {
                $number_of_files = config('userfilesnumber.number');
                $number_of_files_for_this_user = File::query()->where('user_id', '=', Auth::user()->id)->get()->count();
                $total = $number_of_files_for_this_user + count($request->fileupload);
                if ($total <= $number_of_files) {
                  //  $i = 1;
                    foreach ($request->fileupload as $file) {
//                        if ($i > $number_of_files) {
//                            $massage = $massage . " we upload " . $number_of_files . " files for you you cant upload more  !!!  " . ",";
//                            break;
//
//                        }
//
//                        $i++;
                        $destinationPath = $folder_name . '/';
                        $file_name = '(' . Auth::user()->name . ')' . $file->getClientOriginalName(); //Get file original name
                        $update_file1 = File::query()->where('file_name', '=', $file_name);
                        $update_file2 = File::query()->where('file_name', '=', $file->getClientOriginalName());

//                return $update_file->get();
//                    ->where('owner_id', [null,Auth::user()->id]) ;
                        // return $update_file->get();

                        if ($update_file1->get()->isEmpty() && $update_file2->get()->isEmpty()) {
                            $upload_tbl = [
                                'file_name' => $file_name,
                                'path' => $destinationPath . $file_name,
                                'datetime' => $date_time,
                                'user_id' => Auth::user()->id,

                            ];
                            File::query()->insert($upload_tbl);
                            \Storage::disk('local')->put($folder_name . '/' . $file_name, file_get_contents($file->getRealPath()));
                        } else {
                            $massage = $massage . $file->getClientOriginalName() . " this file is in our system   !!!  " . ",";

                        }
//                    else {
//                        $owner = $update_file->value('owner_id');
////                          ->whereNull('owner_id')
////                           ->orWhere('owner_id','=',Auth::user()->id)->first();
//                        //return $owner;
////                       if($owner==null||$owner
//                        if ($owner == Auth::user()->id) {
//
//                            DB::transaction(function () use (&$massage, &$update_file, &$file, &$folder_name) {
//                                $modify = Report_event::query()->create([
//                                    'owner_id' => Auth::user()->id,
//                                    'file_id' => $update_file->value('id'),
//                                    'user_name' => Auth::user()->name,
//                                    'file_name' => $file->getClientOriginalName(),
//                                    'event' => 'modify',
//                                    'event_datetime' => Carbon::now(),
//                                    'upload_date' => $update_file->value('datetime'),
//
//                                ]);
//                                $modify->save();
//                                $massage = $massage . $file->getClientOriginalName() . "   has been modified successfully   !!!  " . ",";
//
//                                \Storage::disk('local')->put($folder_name . '/' . $file->getClientOriginalName(), file_get_contents($file->getRealPath()));
//
//                            });
//                        } elseif ($owner == null) {
//                            $massage = $massage . $file->getClientOriginalName() . "  is free and needs to be locked by you to modify it   !!!  " . ",";
//                        } else {
//                            $massage = $massage . $file->getClientOriginalName() . " is locked by another user  !!!   " . ",";
//                        }
//                    }

                        //  return $number_of_files_for_this_user;

                    }
                }
                else{
                    $massage = $massage . " you cant have more than " . $number_of_files . " files for you   !!!  " . ",";

                }
            }

            if ($massage == '') {
                $massage='files uploaded successfully ';

            }
            return $massage;
        }  catch (\Exception $exception){
            return  $exception->getMessage();
        }

    }
    public function modifyfile(Request $request)
    {
        try {


            // upload file
            $massage = '';
            $dt = Carbon::now();
            $folder_name = 'upload';
            $date_time = $dt;//->toDayDateTimeString();
            \Storage::disk('local')->makeDirectory($folder_name, 0775, true); //creates directory
            if ($request->hasFile('fileupload')) {
                foreach ($request->fileupload as $file) {
                    $destinationPath = $folder_name . '/';

                    $modify_file = File::query()->where('file_name', '=', $file->getClientOriginalName())
                        ->first();


                    //return $modify_file->get();

                    if ($modify_file == null) {
                        $massage = $massage . $file->getClientOriginalName() . " is not in our system !!!   " . ",";
                    }
                    else if ($modify_file != null) {
                        if($request->group!=null)
                        $file_group = $modify_file->groups()->where('group_id', '=', $request->group);

                        if ($request->group!=null&&$file_group->get()->isEmpty())
                            $massage = $massage . $file->getClientOriginalName() . " is not in this group !!!   " . ",";


                        else {
                            $owner = $modify_file->owner_id;


//                          ->whereNull('owner_id')
//                           ->orWhere('owner_id','=',Auth::user()->id)->first();
                            //return $owner;
//                       if($owner==null||$owner
                            if ($owner == Auth::user()->id) {
                                //return $modify_file['datetime'];
                                DB::transaction(function () use (&$massage, &$modify_file, &$file, &$folder_name) {
                                    $modify = Report_event::query()->create([
                                        'owner_id' => Auth::user()->id,
                                        'file_id' => $modify_file['id'],
                                        'user_name' => Auth::user()->name,
                                        'file_name' => $file->getClientOriginalName(),
                                        'event' => 'modify',
                                        'event_datetime' => Carbon::now(),
                                        'upload_date' => $modify_file['datetime'],

                                    ]);
                                    $modify->save();
                                    $massage = $massage . $file->getClientOriginalName() . "   has been modified successfully   !!!  " . ",";

                                    \Storage::disk('local')->put($folder_name . '/' . $file->getClientOriginalName(), file_get_contents($file->getRealPath()));

                                });
                            } elseif ($owner == null) {
                                $massage = $massage . $file->getClientOriginalName() . "  is free and needs to be locked by you to modify it   !!!  " . ",";
                            } else {
                                $massage = $massage . $file->getClientOriginalName() . " is locked by another user  !!!   " . ",";
                            }
                        }
                    }


                }
            }

            return $massage;
        }
        catch (Exception $ex){//LockTimeoutException
            return $ex->getMessage();
        }
    }

    public function downloadfile($id){
        try {

//
            $data = File::query()->where('id', $id);
            // return \response()->json(['success'=>$data]);
            //
            $owner=$data->value('owner_id');
            if ($owner==null||$owner==Auth::user()->id) {
                $file = storage_path("app/" . $data->value('path'));

                //  return $owner;

                return \Illuminate\Support\Facades\Response::download($file);
//                    return \response()->download($file);
            }
            else{
                return redirect()->back()->with('message', 'this file is locked or deleted by another user');

            }
            //here if we delete deleteFileAfterSend he will store the downloaded file in public_path in the public folder
        } catch (Exception $ex){//LockTimeoutException
            return redirect()->back()->with('message', 'this file is locked or deleted by another user');
        }
    }
    public function lock_files(Request $request){

        $massage='';
        if(is_string($request->ids)) {
            $ids = array_map('intval', explode(',', $request->ids));
        }
        else
            $ids = $request->ids;

        //DB::transaction(function () use ($ids) {
//            $lock = Cache::lock('filelock',10,Auth::id())->block(1);
//            DB::table('files')->whereIn('id',$ids)->lockForUpdate()->lock(true);
        // if($lock->owner()==Auth()->user()->id){
//                $lock->release();
        //}
//        foreach ($files as $key => $value) {

        try {

            if ($request->group_id!=null) {

                $group=Group::query()->where('id','=',$request->group_id)->first();

                $fileingroup=$group->files()->whereIn('file_id',$ids);

                if($fileingroup->count()!=count($ids)){
                    $massage=$massage.'one or more of this files is deleted from this group !!! ';
                    return $massage;
                }
            }
            $files_lock= File::query()->whereIn('id',$ids)->
            where('owner_id','!=',null);
            if($files_lock->count()!=0){
                $massage=$massage.$files_lock->get('file_name').' are locked or deleted  !!! ';

                   return $massage;
            }
            DB::transaction(function () use (&$files_lock, &$ids,&$massage) {


//                    $count=$files_id.containsEqual($ids)->count();

//                    if($files_id.containsEqual($ids)){
//
//                    }

                $files_id= File::query()->whereIn('id',$ids)->
                where('owner_id','=',null);
                if($files_id->count()!=count($ids)){
//                        $files_lock= File::query()->whereIn('id',$ids)->
//                        where('owner_id','!=',null);

                    $massage=$massage.$files_lock->get('file_name').' are locked or deleted  !!! ';


                }
                else {
                    $files_id->lockForUpdate();
                    $files_id->update(['owner_id' => Auth::user()->id]);
                    foreach ($files_lock->get(['id','file_name','datetime']) as  $key => $value) {
                        $lock= Report_event::query()->create([
                            'owner_id' => Auth::user()->id,
                            'file_id' =>$value['id'] ,
                            'user_name' => Auth::user()->name,
                            'file_name' => $value['file_name'],
                            'event' => 'lock',
                            'event_datetime' => Carbon::now(),
                            'upload_date' => $value['datetime'],


                        ]);
                        $lock->save();
                    }
                    $massage=$massage.$files_lock->get('file_name').'  have been locked !!! ';

                }
                //here for the reports
                //create table for the  reports
                ///

            });

//                $file = storage_path("app/" . $value->path);
//                $lock = new LockableFile($file, 'w+');
//                $i = $lock->getExclusiveLock(true) ;

            return $massage;
        }
        catch (Exception $ex){//LockTimeoutException
            return $ex->getMessage(); //\response()->json(['success'=>$ex->getMessage()]);
        }
//            $i=chown($file,Auth::id() );
//            chmod($file,0600);
//            $fileinstorage = fopen($file,"w+");
//            flock($fileinstorage,LOCK_UN);
        //if (!flock($fileinstorage,LOCK_EX)) {
//            $would_block = 1;
//            $i = flock($fileinstorage, LOCK_EX, $would_block);
        // }
        //  }

        //  });



    }
    public function unlock_files(Request $request){
        if(is_string($request->ids)) {
            $ids = array_map('intval', explode(',', $request->ids));
        }
        else
            $ids = $request->ids;
        $massage='';

        //DB::transaction(function () use ($ids) {
//            $lock = Cache::lock('filelock',10,Auth::id())->block(1);
//            DB::table('files')->whereIn('id',$ids)->lockForUpdate()->lock(true);
        // if($lock->owner()==Auth()->user()->id){
//                $lock->release();
        //}
//        foreach ($files as $key => $value) {

        try {

            $files_unlock= File::query()->whereIn('id',$ids)->
            where('owner_id','=',Auth::user()->id);
            if($files_unlock->count()==0){

                $massage='files are locked or deleted by another user or free !!! ';
            }
            DB::transaction(function () use (&$files_unlock, &$ids,&$massage) {


//                    $count=$files_id.containsEqual($ids)->count();

//                    if($files_id.containsEqual($ids)){
//
//                    }

                $files_err= File::query()->whereIn('id',$ids)->
                whereNull('owner_id')->
                orWhere('owner_id','!=',Auth::user()->id);


                if($files_err->count()!=0&&$files_unlock->count()!=0){

// laravel model
//                        $files_unlock= File::query()->whereIn('id',$ids)->
//                        where('owner_id','=',Auth::user()->id);
                    $file_err_names=$files_err->get('file_name');
                    $files_unlock->lockForUpdate();
                    foreach ($files_unlock->get(['id','file_name','datetime']) as  $key => $value) {
                        $unlock= Report_event::query()->create([
                            'owner_id' => Auth::user()->id,
                            'file_id' =>$value['id'] ,
                            'user_name' => Auth::user()->name,
                            'file_name' => $value['file_name'],
                            'event' => 'unlock',
                            'event_datetime' => Carbon::now(),
                            'upload_date' => $value['datetime'],


                        ]);
                        $unlock->save();
                    }

                    $files_unlock->update(['owner_id' => null]);
                    $massage='files unlocked successfully but'.$file_err_names .' are locked or deleted or free  !!! ';
                }
                elseif($files_err->count()==0&&$files_unlock->count()==count($ids)){

                    $files_unlock->lockForUpdate();
                    foreach ($files_unlock->get(['id','file_name','datetime']) as  $key => $value) {
                        $unlock= Report_event::query()->create([
                            'owner_id' => Auth::user()->id,
                            'file_id' =>$value['id'] ,
                            'user_name' => Auth::user()->name,
                            'file_name' => $value['file_name'],
                            'event' => 'unlock',
                            'event_datetime' => Carbon::now(),
                            'upload_date' => $value['datetime'],


                        ]);
                        $unlock->save();
                    }
                    $massage=$files_unlock->get('file_name').'unlocked successfully ';
                    $files_unlock->update(['owner_id' => null]);



                }

                //here for the reports
                //create table for the  reports
                ///

            });

//                $file = storage_path("app/" . $value->path);
//                $lock = new LockableFile($file, 'w+');
//                $i = $lock->getExclusiveLock(true) ;

            return $massage;
        }
        catch (Exception $ex){//LockTimeoutException
            return $ex->getMessage();//\response()->json(['success'=>$ex->getMessage()]);
        }
//            $i=chown($file,Auth::id() );
//            chmod($file,0600);
//            $fileinstorage = fopen($file,"w+");
//            flock($fileinstorage,LOCK_UN);
        //if (!flock($fileinstorage,LOCK_EX)) {
//            $would_block = 1;
//            $i = flock($fileinstorage, LOCK_EX, $would_block);
        // }
        //  }

        //  });



    }
    public function getfilehistory($id){
        try {


            $file = File::query()->find($id);
            $events = $file->report_events()->orderBy("id", "desc")
                ->paginate(5);
            return [$file, $events];

        } catch (Exception $ex){//LockTimeoutException
            return $ex->getMessage();//\response()->json(['success'=>$ex->getMessage()]);
        }
    }
    public function deleteselectedfiles(Request $request){
        $massage='';
        try {
            if(is_string($request->ids)) {
                  $ids = array_map('intval', explode(',', $request->ids));
                     }
            else
            $ids = $request->ids;
            $deletefile = File::query()->whereIn('id', $ids)
                ->whereNull('owner_id')
                ->orWhere('owner_id','=',Auth::user()->id);

            //return \response()->json(['success'=>$deletefile->get()]);
            if($deletefile->get()->isEmpty()){
                $massage='files are locked or deleted  !!! ';
            }
            //->get();
            $deletecount=$deletefile->count();

            $delete=$deletefile->get();
            foreach ($delete as $file) {
                if ($file->value('owner_id')==null||$file->value('owner_id')==Auth::user()->id) {
                    \Storage::disk('local')->delete('upload' . '/' . $file->file_name);
                    $file->delete();
                    $massage=$massage.' , '.$file->file_name.'  have been deleted';
                }
            }
            //$files = $deletefile->delete();
            if($deletecount!=count($ids)){
                $lockedfile = File::query()->whereIn('id', $ids)
                    ->whereNotNull('owner_id')
                    ->orWhere('owner_id','!=',Auth::user()->id);
                 $massage=$massage.' , '.$lockedfile->get('file_name').' are locked or deleted  !!! !!! ';
            }
          return $massage;
        }
        catch (Exception $ex){//LockTimeoutException
            return $ex->getMessage();
        }
        //return \response()->json(['success'=>"files have been deleted!"]);
    }





}
