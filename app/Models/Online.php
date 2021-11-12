<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

// Auto Models By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.32]
// Copyright Reserved  [it v 1.6.32]
class Online extends Model {

protected $table    = 'onlines';
protected $fillable = [
		'id',
		'admin_id',
        'token1',
        'token2',
        'quest_id',
        'ans1',
        'ans2',
        'winner',
        'game_id',
		'created_at',
		'updated_at',
	];

 	/**
    * Static Boot method to delete or update or sort Data
    * @param void
    * @return void
    */
   protected static function boot() {
      parent::boot();
      // if you disable constraints should by run this static method to Delete children data
         static::deleting(function($online) {
         });
   }
		
}
