<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\QuestionsDataTable;
use Carbon\Carbon;
use App\Models\Question;

use App\Http\Controllers\Validations\QuestionsRequest;
// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.32]
// Copyright Reserved  [it v 1.6.32]
class Questions extends Controller
{

	public function __construct() {

		$this->middleware('AdminRole:questions_show', [
			'only' => ['index', 'show'],
		]);
		$this->middleware('AdminRole:questions_add', [
			'only' => ['create', 'store'],
		]);
		$this->middleware('AdminRole:questions_edit', [
			'only' => ['edit', 'update'],
		]);
		$this->middleware('AdminRole:questions_delete', [
			'only' => ['destroy', 'multi_delete'],
		]);
	}

	

            /**
             * Baboon Script By [it v 1.6.32]
             * Display a listing of the resource.
             * @return \Illuminate\Http\Response
             */
            public function index(QuestionsDataTable $questions)
            {
               return $questions->render('admin.questions.index',['title'=>trans('admin.questions')]);
            }


            /**
             * Baboon Script By [it v 1.6.32]
             * Show the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function create()
            {
            	
               return view('admin.questions.create',['title'=>trans('admin.create')]);
            }

            /**
             * Baboon Script By [it v 1.6.32]
             * Store a newly created resource in storage.
             * @param  \Illuminate\Http\Request  $request
             * @return \Illuminate\Http\Response Or Redirect
             */
            public function store(QuestionsRequest $request)
            {
                $data = $request->except("_token", "_method");
            			  		$questions = Question::create($data); 

			return successResponseJson([
				"message" => trans("admin.added"),
				"data" => $questions,
			]);
			 }

            /**
             * Display the specified resource.
             * Baboon Script By [it v 1.6.32]
             * @param  int  $id
             * @return \Illuminate\Http\Response
             */
            public function show($id)
            {
        		$questions =  Question::find($id);
        		return is_null($questions) || empty($questions)?
        		backWithError(trans("admin.undefinedRecord"),aurl("questions")) :
        		view('admin.questions.show',[
				    'title'=>trans('admin.show'),
					'questions'=>$questions
        		]);
            }


            /**
             * Baboon Script By [it v 1.6.32]
             * edit the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function edit($id)
            {
        		$questions =  Question::find($id);
        		return is_null($questions) || empty($questions)?
        		backWithError(trans("admin.undefinedRecord"),aurl("questions")) :
        		view('admin.questions.edit',[
				  'title'=>trans('admin.edit'),
				  'questions'=>$questions
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
				foreach (array_keys((new QuestionsRequest)->attributes()) as $fillableUpdate) {
					if (!is_null(request($fillableUpdate))) {
						$fillableCols[$fillableUpdate] = request($fillableUpdate);
					}
				}
				return $fillableCols;
			}

            public function update(QuestionsRequest $request,$id)
            {
              // Check Record Exists
              $questions =  Question::find($id);
              if(is_null($questions) || empty($questions)){
              	return backWithError(trans("admin.undefinedRecord"),aurl("questions"));
              }
              $data = $this->updateFillableColumns(); 
              Question::where('id',$id)->update($data);

              $questions = Question::find($id);
              return successResponseJson([
               "message" => trans("admin.updated"),
               "data" => $questions,
              ]);
			}

            /**
             * Baboon Script By [it v 1.6.32]
             * destroy a newly created resource in storage.
             * @param  $id
             * @return \Illuminate\Http\Response
             */
	public function destroy($id){
		$questions = Question::find($id);
		if(is_null($questions) || empty($questions)){
			return backWithSuccess(trans('admin.undefinedRecord'),aurl("questions"));
		}
               
		it()->delete('question',$id);
		$questions->delete();
		return redirectWithSuccess(aurl("questions"),trans('admin.deleted'));
	}


	public function multi_delete(){
		$data = request('selected_data');
		if(is_array($data)){
			foreach($data as $id){
				$questions = Question::find($id);
				if(is_null($questions) || empty($questions)){
					return backWithError(trans('admin.undefinedRecord'),aurl("questions"));
				}
                    	
				it()->delete('question',$id);
				$questions->delete();
			}
			return redirectWithSuccess(aurl("questions"),trans('admin.deleted'));
		}else {
			$questions = Question::find($data);
			if(is_null($questions) || empty($questions)){
				return backWithError(trans('admin.undefinedRecord'),aurl("questions"));
			}
                    
			it()->delete('question',$data);
			$questions->delete();
			return redirectWithSuccess(aurl("questions"),trans('admin.deleted'));
		}
	}
            

}