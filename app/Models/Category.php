<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Carbon\Carbon;

// Auto Models By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.32]
// Copyright Reserved  [it v 1.6.32]
class Category extends Model {
   use HasFactory;

	use SoftDeletes;
	protected $dates = ['deleted_at'];

protected $table    = 'categories';

 //  return created_at date format readable ---->
 public function getCreatedAtAttribute($value)
 {
     $date = Carbon::parse($value);
     return $date->format('Y-m-d H:i:s');
 }

//  return updated_at date format readable ---->
 public function getUpdatedAtAttribute($value)
 {
     $date = Carbon::parse($value);
     return $date->format('Y-m-d H:i:s');
 }
protected $fillable = [
		'id',
		'admin_id',
        'category_name',
        'status',
		'created_at',
		'updated_at',
		'deleted_at',
	];

 	/**
    * Static Boot method to delete or update or sort Data
    * @param void
    * @return void
    */
   protected static function boot() {
      parent::boot();
      // if you disable constraints should by run this static method to Delete children data
         static::deleting(function($category) {
         });
   }
		
}
