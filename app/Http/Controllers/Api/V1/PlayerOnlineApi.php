<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Play;
use Validator;
use Illuminate\Support\Str;

use App\Http\Controllers\ValidationsApi\V1\PlayerRequest;
// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.32]
// Copyright Reserved  [it v 1.6.32]
class PlayerOnlineApi extends Controller
{
    protected $selectColumns = [
        "id",
        "user_id",
        "token",
        "played",
        "level",
        "coins",
        "time",
        "is_now"
    ];


    public function arrWith()
    {
        return [];
    }


    public function getUserAndToken(PlayerRequest $request)
    {

        $data = $request->except("_token");
        if ($data['type'] == 'new') {
            $token = Str::random(40);
            $data['token'] = $token;
            $Play = Play::create($data);
            $Play = Play::with($this->arrWith())->find($Play->id, $this->selectColumns);
            return successResponseJson([
                "message" => 'created',

                "data" => [$Play]
            ]);
        } elseif ($data['type'] == 'old') {

            $Play = Play::where('token', $data['token'])->select($this->selectColumns)->first();
            if (!empty($Play)) {
                return successResponseJson([
                    "message" => 'userinfo',
                    "data" => [$Play]
                ]);
            } else {
                $token = Str::random(40);
                $data['token'] = $token;
                $Play = Play::create($data);
                $Play = Play::with($this->arrWith())->find($Play->id, $this->selectColumns);
                return successResponseJson([
                    "message" => 'created',

                    "data" => [$Play]
                ]);
            }
        } elseif ($data['type'] == '') {


            $Play = Play::create($data);

            $Play = Play::with($this->arrWith())->find($Play->id, $this->selectColumns);
            return successResponseJson([
                "message" => 'created',

                "data" => $Play
            ]);
        }
    }

    /**
     * Baboon Api Script By [it v 1.6.32]
     * update a newly created resource in storage.
     * @return \Illuminate\Http\Response
     */
    public function updateFillableColumns()
    {
        $fillableCols = [];
        foreach (array_keys((new PlayerRequest)->attributes()) as $fillableUpdate) {
            if (!is_null(request($fillableUpdate))) {
                $fillableCols[$fillableUpdate] = request($fillableUpdate);
            }
        }
        return $fillableCols;
    }




    public function checkUserOnline(PlayerRequest $request)
    {
        $token = $request->token;
        $chekIsBinding = Play::where('user_id', $token)->where('is_now', 1)->where('played', 0)->select($this->selectColumns)->first();
if($chekIsBinding){

    return successResponseJson([
        "message" => '1',
        "data" => [$chekIsBinding]
    ]);

}else{
        $player = Play::where('token', '!=', $token)->where('played', 1)->where('is_now', 0)->select($this->selectColumns)->first();
        if ($player) {
            Play::where("token", $token)->update([
                'played' => 0,
                'is_now' => 1,
                'user_id' => $player->token
            ]);
            $player->update([
                'played' => 0,
                'is_now' => 1,
                'user_id' => $token

            ]);
            return successResponseJson([
                "message" => '2',
                "data" => [$player]
            ]);
        } else {

            Play::where("token", $token)->update([
                'played' => 1,
                'is_now' => 0
            ]);

            return successResponseJson([
                'message'=> '0',
                'data' => [null]
            ]);
        }
    }
}
}
