<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Play;
use Validator;
use Illuminate\Support\Str;
use App\Models\Game;
use App\Models\Online;
use App\Models\Question;


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
            $one = Online::where('token1', $data['token'])->where('ans1', 1)->get();
            $two = Online::where('token2', $data['token'])->where('ans2', 1)->get();
            $level = 0;
            $coins = 100;
            if($one){
                $level += $one->count() ;
                $coins += 5 * $one->count();
            }
            if($two){
                $level += $two->count() ;
                $coins += 5 * $two->count();

            }

            $Play->level =  "$level";

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
        if ($chekIsBinding) {
            $chekIsBinding->game_id = $chekIsBinding->time;
            return successResponseJson([
                "message" => '1',
                "data" => [$chekIsBinding]
            ]);
        } else {
            $player = Play::where('token', '!=', $token)->where('played', 1)->where('is_now', 0)->select($this->selectColumns)->first();
            if ($player) {
                $game = $this->creatGame();

                $player2 = Play::where("token", $token);

                $this->updatePlayer($player2, '0', '1', $player->token, $game->id);
                $updatePlay = $this->updatePlayer($player, '0', '1', $token, $game->id);


                $player->game_id = "$game->id";

                $token1 = $token;
                $token2 = $player->token;

                $quests = $this->getQuestionByToken($token1, $token2);
                foreach($quests as $q){
                    Online::create([
                        'token1' => $token1,
                        'token2' => $token2,
                        'quest_id' => "$q->id",
                        'ans1' => "0",
                        'ans2' => '0',
                        'winner' =>'0',
                        'game_id' =>"$game->id"
    
    
                    ]);


                }
        
                return successResponseJson([
                    'token1'=> $token1,
                    'token2'=> $token2,
                    "message" => "",
                    "data" => [$player]
                ]);


                

            } else {

                $player = Play::where("token", $token)->select($this->selectColumns)->first();
                $updatePlayer = $this->updatePlayer($player, '1', '0', "0", "0");



                return successResponseJson([
                    'message' => '9',
                    'data' => [$player]
                ]);
            }
        }
    }


    public function creatGame()
    {
        $game = Game::create([
            'steps' => 0,
            'steps_all' => 5,
            'time' => 50,
            'status' => 'online'

        ]);
        return $game;
    }


    public function getQuestionByToken($token1, $token2)
    {
        $ones = Online::where('token1', $token1)->orWhere('token2', $token1)->select('quest_id')->get();
        $twoes = Online::where('token1', $token2)->orWhere('token2', $token2)->select('quest_id')->get();

        $q1 = array();
        $q2 = array();
        if ($ones) {
            foreach ($ones as $one) {


                array_push($q1, $one->quest_id);
            }
        }
        if ($twoes) {
            foreach ($twoes as $two) {


                array_push($q2, $two->quest_id);
            }
        }

        $questions = Question::whereNotIn('id', $ones)->whereNotIn('id', $twoes)->inRandomOrder()->take(5)->get();
        if ($questions->count() == 5) {
            return $questions;
            // return successResponseJson([
            //     "data" => $questions
            // ]);
        } else {
            $randQuestions = Question::inRandomOrder()->take(5)->get();
            // return successResponseJson([
            //     "data" => $randQuestions
            // ]);
            return $randQuestions;

        }
    }
    public function updatePlayer($player, $played, $is_now, $user_id = '0', $time)
    {
        $create =  $player->update([
            'played' => $played,
            'is_now' => $is_now,
            'time' => '0',
            'user_id' => $user_id,
            'time'=> "$time"

        ]);

        return $create;
    }
}
