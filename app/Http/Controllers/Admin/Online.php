<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\OnlineDataTable;
use Carbon\Carbon;
use App\Models\Online;

use App\Http\Controllers\Validations\OnlineRequest;
// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.32]
// Copyright Reserved  [it v 1.6.32]
class Online extends Controller
{

	public function __construct() {

		$this->middleware('AdminRole:online_show', [
			'only' => ['index', 'show'],
		]);
		$this->middleware('AdminRole:online_add', [
			'only' => ['create', 'store'],
		]);
		$this->middleware('AdminRole:online_edit', [
			'only' => ['edit', 'update'],
		]);
		$this->middleware('AdminRole:online_delete', [
			'only' => ['destroy', 'multi_delete'],
		]);
	}

	

            /**
             * Baboon Script By [it v 1.6.32]
             * Display a listing of the resource.
             * @return \Illuminate\Http\Response
             */
            public function index(OnlineDataTable $online)
            {
               return $online->render('admin.online.index',['title'=>trans('admin.online')]);
            }


            /**
             * Baboon Script By [it v 1.6.32]
             * Show the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function create()
            {
            	
               return view('admin.online.create',['title'=>trans('admin.create')]);
            }

            /**
             * Baboon Script By [it v 1.6.32]
             * Store a newly created resource in storage.
             * @param  \Illuminate\Http\Request  $request
             * @return \Illuminate\Http\Response Or Redirect
             */
            public function store(OnlineRequest $request)
            {
                $data = $request->except("_token", "_method");
            			  		$online = Online::create($data); 
                $redirect = isset($request["add_back"])?"/create":"";
                return redirectWithSuccess(aurl('online'.$redirect), trans('admin.added')); }

            /**
             * Display the specified resource.
             * Baboon Script By [it v 1.6.32]
             * @param  int  $id
             * @return \Illuminate\Http\Response
             */
            public function show($id)
            {
        		$online =  Online::find($id);
        		return is_null($online) || empty($online)?
        		backWithError(trans("admin.undefinedRecord"),aurl("online")) :
        		view('admin.online.show',[
				    'title'=>trans('admin.show'),
					'online'=>$online
        		]);
            }


            /**
             * Baboon Script By [it v 1.6.32]
             * edit the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function edit($id)
            {
        		$online =  Online::find($id);
        		return is_null($online) || empty($online)?
        		backWithError(trans("admin.undefinedRecord"),aurl("online")) :
        		view('admin.online.edit',[
				  'title'=>trans('admin.edit'),
				  'online'=>$online
        		]);
            }


            /**
             * Baboon Script By [it v 1.6.32]
             * update a newly created resource in storage.
             * @param  \Illuminate\Http\Request  $request
             * @return \Illuminate\Http\Response
             */
            public function updateFillableColumns() {
				$fillableCols = [];
				foreach (array_keys((new OnlineRequest)->attributes()) as $fillableUpdate) {
					if (!is_null(request($fillableUpdate))) {
						$fillableCols[$fillableUpdate] = request($fillableUpdate);
					}
				}
				return $fillableCols;
			}

            public function update(OnlineRequest $request,$id)
            {
              // Check Record Exists
              $online =  Online::find($id);
              if(is_null($online) || empty($online)){
              	return backWithError(trans("admin.undefinedRecord"),aurl("online"));
              }
              $data = $this->updateFillableColumns(); 
              Online::where('id',$id)->update($data);
              $redirect = isset($request["save_back"])?"/".$id."/edit":"";
              return redirectWithSuccess(aurl('online'.$redirect), trans('admin.updated'));
            }

            /**
             * Baboon Script By [it v 1.6.32]
             * destroy a newly created resource in storage.
             * @param  $id
             * @return \Illuminate\Http\Response
             */
	public function destroy($id){
		$online = Online::find($id);
		if(is_null($online) || empty($online)){
			return backWithSuccess(trans('admin.undefinedRecord'),aurl("online"));
		}
               
		it()->delete('online',$id);
		$online->delete();
		return redirectWithSuccess(aurl("online"),trans('admin.deleted'));
	}


	public function multi_delete(){
		$data = request('selected_data');
		if(is_array($data)){
			foreach($data as $id){
				$online = Online::find($id);
				if(is_null($online) || empty($online)){
					return backWithError(trans('admin.undefinedRecord'),aurl("online"));
				}
                    	
				it()->delete('online',$id);
				$online->delete();
			}
			return redirectWithSuccess(aurl("online"),trans('admin.deleted'));
		}else {
			$online = Online::find($data);
			if(is_null($online) || empty($online)){
				return backWithError(trans('admin.undefinedRecord'),aurl("online"));
			}
                    
			it()->delete('online',$data);
			$online->delete();
			return redirectWithSuccess(aurl("online"),trans('admin.deleted'));
		}
	}
            

}