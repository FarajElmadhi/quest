<?php
/*
* To implement in admingroups permissions
* to remove CRUD from Validation remove route name
* CRUD Role permission (create,read,update,delete)
* [it v 1.6.32]
*/
return [
	"games"=>["create","read","update","delete"],
	"online"=>["create","read","update","delete"],
	"player"=>["create","read","update","delete"],
	"questions"=>["create","read","update","delete"],
	"categories"=>["create","read","update","delete"],
	"admins"=>["create","read","update","delete"],
	"admingroups"=>["create","read","update","delete"],
];