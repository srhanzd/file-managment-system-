<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Group;
use App\Models\User;

use App\Services\GroupService;
use App\Services\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use function redirect;
use function view;

class GroupController extends Controller
{
    private  $groupService;
    function __construct(GroupService $groupService)
    {
        $this->groupService=$groupService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {

        $response=$this->groupService->getgroupscreatedbythisuser();
         return $response;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $response=$this->groupService->getgroupcreatepage();
         return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {


            $response= $this->groupService->addnewgroup($request);
        return $response;


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
//    public function show(Group $group)
//    {
//        return view('admin.group.edit', compact('group'));
//    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Group $group)

    {

        $response= $this->groupService->edityourgroup($group);
        return $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Group $group)
    {

        $response= $this->groupService->updategroupinfo($request,$group);
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    ////////////////////////////////////////////////////////
    public function getusergroup($id){
        //user_id

        $response= $this->groupService->getallgroupsforthisuser($id);
        return $response;


    }
/////////////////////////////////////////////////////////////////
    public function delete($id)
    {
//group_id

        $response= $this->groupService->deletegroup($id);
        return redirect()->back()->with('message', $response);


         }
    public function addusersgroup($id){
       // group_id

        $response= $this->groupService->addnewuserstothegrouppage($id);
        return $response;

    }
    public function storeusersgroup(Request $request,$id){
//group_id

        $response= $this->groupService->addnewusertothisgroup($request,$id);
        return $response;
    }
    public function usergroupfilesadd($id){
        //group_id

        $response= $this->groupService->addnewfilesgrouppage($id);
        return $response;

    }
    public function storefilesgroup(Request $request,$id){
//group_id

$response= $this->groupService->addnewfilestothisgroup($request,$id);
        return $response;
    }
    public function getusergroupfiles($id){
//group_id

        $response= $this->groupService->getallgroupfiles($id);
        return $response;
    }

    /////////////////////////////////////////////////////////////////////
    public function deletefilegroup(Request $request,$id){
//request->group

        $response= $this->groupService->deletefilefromthisgroup($request,$id);
             return redirect()->back()->with('message', $response);
    }
    public function deleteusersgroup(Request $request,$id){
        //group_id

$response= $this->groupService->deleteuserfromthisgroup($request,$id);
        return redirect()->back()->with('message',$response );
    }

}
