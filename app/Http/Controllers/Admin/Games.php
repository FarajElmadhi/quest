<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\GamesDataTable;
use Carbon\Carbon;
use App\Models\Game;

use App\Http\Controllers\Validations\GamesRequest;
// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.32]
// Copyright Reserved  [it v 1.6.32]
class Games extends Controller
{

	public function __construct() {

		$this->middleware('AdminRole:games_show', [
			'only' => ['index', 'show'],
		]);
		$this->middleware('AdminRole:games_add', [
			'only' => ['create', 'store'],
		]);
		$this->middleware('AdminRole:games_edit', [
			'only' => ['edit', 'update'],
		]);
		$this->middleware('AdminRole:games_delete', [
			'only' => ['destroy', 'multi_delete'],
		]);
	}

	

            /**
             * Baboon Script By [it v 1.6.32]
             * Display a listing of the resource.
             * @return \Illuminate\Http\Response
             */
            public function index(GamesDataTable $games)
            {
               return $games->render('admin.games.index',['title'=>trans('admin.games')]);
            }


            /**
             * Baboon Script By [it v 1.6.32]
             * Show the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function create()
            {
            	
               return view('admin.games.create',['title'=>trans('admin.create')]);
            }

            /**
             * Baboon Script By [it v 1.6.32]
             * Store a newly created resource in storage.
             * @param  \Illuminate\Http\Request  $request
             * @return \Illuminate\Http\Response Or Redirect
             */
            public function store(GamesRequest $request)
            {
                $data = $request->except("_token", "_method");
            			  		$games = Game::create($data); 
                $redirect = isset($request["add_back"])?"/create":"";
                return redirectWithSuccess(aurl('games'.$redirect), trans('admin.added')); }

            /**
             * Display the specified resource.
             * Baboon Script By [it v 1.6.32]
             * @param  int  $id
             * @return \Illuminate\Http\Response
             */
            public function show($id)
            {
        		$games =  Game::find($id);
        		return is_null($games) || empty($games)?
        		backWithError(trans("admin.undefinedRecord"),aurl("games")) :
        		view('admin.games.show',[
				    'title'=>trans('admin.show'),
					'games'=>$games
        		]);
            }


            /**
             * Baboon Script By [it v 1.6.32]
             * edit the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function edit($id)
            {
        		$games =  Game::find($id);
        		return is_null($games) || empty($games)?
        		backWithError(trans("admin.undefinedRecord"),aurl("games")) :
        		view('admin.games.edit',[
				  'title'=>trans('admin.edit'),
				  'games'=>$games
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
				foreach (array_keys((new GamesRequest)->attributes()) as $fillableUpdate) {
					if (!is_null(request($fillableUpdate))) {
						$fillableCols[$fillableUpdate] = request($fillableUpdate);
					}
				}
				return $fillableCols;
			}

            public function update(GamesRequest $request,$id)
            {
              // Check Record Exists
              $games =  Game::find($id);
              if(is_null($games) || empty($games)){
              	return backWithError(trans("admin.undefinedRecord"),aurl("games"));
              }
              $data = $this->updateFillableColumns(); 
              Game::where('id',$id)->update($data);
              $redirect = isset($request["save_back"])?"/".$id."/edit":"";
              return redirectWithSuccess(aurl('games'.$redirect), trans('admin.updated'));
            }

            /**
             * Baboon Script By [it v 1.6.32]
             * destroy a newly created resource in storage.
             * @param  $id
             * @return \Illuminate\Http\Response
             */
	public function destroy($id){
		$games = Game::find($id);
		if(is_null($games) || empty($games)){
			return backWithSuccess(trans('admin.undefinedRecord'),aurl("games"));
		}
               
		it()->delete('game',$id);
		$games->delete();
		return redirectWithSuccess(aurl("games"),trans('admin.deleted'));
	}


	public function multi_delete(){
		$data = request('selected_data');
		if(is_array($data)){
			foreach($data as $id){
				$games = Game::find($id);
				if(is_null($games) || empty($games)){
					return backWithError(trans('admin.undefinedRecord'),aurl("games"));
				}
                    	
				it()->delete('game',$id);
				$games->delete();
			}
			return redirectWithSuccess(aurl("games"),trans('admin.deleted'));
		}else {
			$games = Game::find($data);
			if(is_null($games) || empty($games)){
				return backWithError(trans('admin.undefinedRecord'),aurl("games"));
			}
                    
			it()->delete('game',$data);
			$games->delete();
			return redirectWithSuccess(aurl("games"),trans('admin.deleted'));
		}
	}
            

}