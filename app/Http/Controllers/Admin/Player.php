<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\PlayerDataTable;
use Carbon\Carbon;
use App\Models\Play;

use App\Http\Controllers\Validations\PlayerRequest;
// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.32]
// Copyright Reserved  [it v 1.6.32]
class Player extends Controller
{

	public function __construct() {

		$this->middleware('AdminRole:player_show', [
			'only' => ['index', 'show'],
		]);
		$this->middleware('AdminRole:player_add', [
			'only' => ['create', 'store'],
		]);
		$this->middleware('AdminRole:player_edit', [
			'only' => ['edit', 'update'],
		]);
		$this->middleware('AdminRole:player_delete', [
			'only' => ['destroy', 'multi_delete'],
		]);
	}

	

            /**
             * Baboon Script By [it v 1.6.32]
             * Display a listing of the resource.
             * @return \Illuminate\Http\Response
             */
            public function index(PlayerDataTable $player)
            {
               return $player->render('admin.player.index',['title'=>trans('admin.player')]);
            }


            /**
             * Baboon Script By [it v 1.6.32]
             * Show the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function create()
            {
            	
               return view('admin.player.create',['title'=>trans('admin.create')]);
            }

            /**
             * Baboon Script By [it v 1.6.32]
             * Store a newly created resource in storage.
             * @param  \Illuminate\Http\Request  $request
             * @return \Illuminate\Http\Response Or Redirect
             */
            public function store(PlayerRequest $request)
            {
                $data = $request->except("_token", "_method");
            			  		$player = Play::create($data); 
                $redirect = isset($request["add_back"])?"/create":"";
                return redirectWithSuccess(aurl('player'.$redirect), trans('admin.added')); }

            /**
             * Display the specified resource.
             * Baboon Script By [it v 1.6.32]
             * @param  int  $id
             * @return \Illuminate\Http\Response
             */
            public function show($id)
            {
        		$player =  Play::find($id);
        		return is_null($player) || empty($player)?
        		backWithError(trans("admin.undefinedRecord"),aurl("player")) :
        		view('admin.player.show',[
				    'title'=>trans('admin.show'),
					'player'=>$player
        		]);
            }


            /**
             * Baboon Script By [it v 1.6.32]
             * edit the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function edit($id)
            {
        		$player =  Play::find($id);
        		return is_null($player) || empty($player)?
        		backWithError(trans("admin.undefinedRecord"),aurl("player")) :
        		view('admin.player.edit',[
				  'title'=>trans('admin.edit'),
				  'player'=>$player
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
				foreach (array_keys((new PlayerRequest)->attributes()) as $fillableUpdate) {
					if (!is_null(request($fillableUpdate))) {
						$fillableCols[$fillableUpdate] = request($fillableUpdate);
					}
				}
				return $fillableCols;
			}

            public function update(PlayerRequest $request,$id)
            {
              // Check Record Exists
              $player =  Play::find($id);
              if(is_null($player) || empty($player)){
              	return backWithError(trans("admin.undefinedRecord"),aurl("player"));
              }
              $data = $this->updateFillableColumns(); 
              Play::where('id',$id)->update($data);
              $redirect = isset($request["save_back"])?"/".$id."/edit":"";
              return redirectWithSuccess(aurl('player'.$redirect), trans('admin.updated'));
            }

            /**
             * Baboon Script By [it v 1.6.32]
             * destroy a newly created resource in storage.
             * @param  $id
             * @return \Illuminate\Http\Response
             */
	public function destroy($id){
		$player = Play::find($id);
		if(is_null($player) || empty($player)){
			return backWithSuccess(trans('admin.undefinedRecord'),aurl("player"));
		}
               
		it()->delete('play',$id);
		$player->delete();
		return redirectWithSuccess(aurl("player"),trans('admin.deleted'));
	}


	public function multi_delete(){
		$data = request('selected_data');
		if(is_array($data)){
			foreach($data as $id){
				$player = Play::find($id);
				if(is_null($player) || empty($player)){
					return backWithError(trans('admin.undefinedRecord'),aurl("player"));
				}
                    	
				it()->delete('play',$id);
				$player->delete();
			}
			return redirectWithSuccess(aurl("player"),trans('admin.deleted'));
		}else {
			$player = Play::find($data);
			if(is_null($player) || empty($player)){
				return backWithError(trans('admin.undefinedRecord'),aurl("player"));
			}
                    
			it()->delete('play',$data);
			$player->delete();
			return redirectWithSuccess(aurl("player"),trans('admin.deleted'));
		}
	}
            

}