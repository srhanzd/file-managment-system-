<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Group;
use App\Models\Lock;
use App\Models\Modify;
use App\Models\Report_event;
use App\Models\UnLock;
use App\Services\FileService;
use App\Services\LogService;
use Exception;
use http\Client\Response;
use Illuminate\Contracts\Filesystem\LockTimeoutException;
use Illuminate\Filesystem\LockableFile;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\formBasic;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Scalar\String_;
use Ramsey\Uuid\Type\Integer;
use App\Http\Requests;
use ZipArchive;
use Illuminate\Support\Facades\Cache;
use function PHPUnit\Framework\containsEqual;


class FileController  extends Controller
{
   private $fileService;
    public function __construct(FileService $fileService)
    {
        $this->fileService=$fileService;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $response=$this->fileService->getuserfiles();
            return $response;
    }

    public function savefile(Request $request)
    {

        $response=$this->fileService->save($request);
        return  redirect()->back()->with('message', $response);
    }
    public function modifyfile(Request $request)
    {

        $response=$this->fileService->modifyfile($request);
        return redirect()->back()->header('s',$response)->with('message', $response);
    }
    public function deleteselectedfiles(Request $request){

        $response=$this->fileService->deleteselectedfiles($request);
        session()->flash('message', $response);
        return \response()->json(['success'=>$response]);
    }

    public function downloadfile($id){

        $response=$this->fileService->downloadfile($id);
        return $response;
    }

    /**
     * @throws \Illuminate\Contracts\Filesystem\LockTimeoutException
     */
    public function lock_files(Request $request){

        $response=$this->fileService->lock_files($request);
        session()->flash('message', $response);
        return \response()->json(['success'=>$response]);

    }




    public function unlock_files(Request $request){

        $response=$this->fileService->unlock_files($request);
        session()->flash('message', $response);
        return \response()->json(['success'=>$response]);
    }
    public function getfilehistory($id){

        $response=$this->fileService->getfilehistory($id);
        $file=$response[0];
        $events=$response[1];
        return view('file.events',compact('file','events'));

    }
}
