<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// Auto Models By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.32]
// Copyright Reserved  [it v 1.6.32]
class Question extends Model {
	use SoftDeletes;
	protected $dates = ['deleted_at'];

protected $table    = 'questions';
protected $fillable = [
		'id',
		'admin_id',
        'question',
        'category_id',

        'correct',
        'wrong1',
        'wrong2',
        'wrong3',
        'question_type',

		'created_at',
		'updated_at',
		'deleted_at',
	];

	/**
    * category_id relation method
    * @param void
    * @return object data
    */
   public function category_id(){
      return $this->hasOne(\App\Models\Category::class,'id','category_id');
   }

 	/**
    * Static Boot method to delete or update or sort Data
    * @param void
    * @return void
    */
   protected static function boot() {
      parent::boot();
      // if you disable constraints should by run this static method to Delete children data
         static::deleting(function($question) {
			//$question->category_id()->delete();
         });
   }
		
}
