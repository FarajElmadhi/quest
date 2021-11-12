<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Admin\Player;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Online;
use App\Models\Play;
use App\Models\Game;
use App\Models\Question;
use Illuminate\Support\Facades\DB;



class OnlineNowApi extends Controller
{




    public function checkAnsware(Request $request)
    {

        $ans = $request->ans; // 0 : no answare,  1:true, 2:false
        $token = $request->token;
        $player = Play::where("token", $token)->first();
        $quest_id = $request->quest_id;
        $game_id = $request->game_id;
        $game = Game::find($game_id);
      

        $online = Online::where('token1', $token)->where('quest_id', $quest_id)->where('game_id', $game_id)->orderBy('id', 'DESC')->first();

        if ($online) {
            $online->update(['ans1' => $ans,]);

            return $this->onlineInfo($ans, $online->ans2, $game);
         
        } else {

            $online2 = Online::where('token2', $token)->where('quest_id', $quest_id)->where('game_id', $game_id)->orderBy('id', 'DESC')->first();
            if ($online2) {
                $online2->update(['ans2' => $ans,]);
                return $this->onlineInfo($ans, $online2->ans1, $game);

            }
            
            else {

          
                Online::create([
                    'token1' => $token,
                    'token2' => $player->user_id,
                    'quest_id' => $quest_id,
                    'ans1' => $ans,
                    'ans2' => '0',
                    'game_id' =>$game_id


                ]);
                $game->update([
                    'steps' => $game->steps + 1
                ]);
                if($game->steps == $game->steps_all){
                    $p = Play::where('user_id', $token)->orWhere('token',$token);
                    $p->update([
                            'is_now'=> "0",
                            'user_id'=>"0",
                            'time'=>"0",
                            'played'=>"0",
                    ]);
                }
                return $this->onlineInfo($ans, '0', $game);
            }
        }
    }

  




    public function onlineInfo($ans1, $ans2, $game)
    {

        $success =  successResponseJson([

            'me' => $ans1,
            'o' => $ans2,
            'game_id' => $game->id,
            'steps' => $game->steps,
            'steps_all' => $game->steps_all,
            'time' => $game->time,
            'status' => $game->status,
            'game_id' =>$game->id,
        ]);

        return $success;
    }

    public function getQuestionByGameId(Request $request)
    {
        $id = $request->game_id;


        $ones = Online::where('game_id', $id)->get();

        
        $q1 = array();
        if ($ones) {
            foreach ($ones as $one) {
                array_push($q1, $one->quest_id);
            }
        }
        $questions = Question::whereIn('id', $q1)->get();

        // foreach($ones as $one){
        //     $quests += Question::where('id', $one->quest_id);

        // }
            return successResponseJson([
                "data" => $questions
            ]);
        
    }

   public function resetGameApi(Request $r){
       $id = $r->game_id;
       Play::where('time', $id)
       ->update([
               'is_now'=> "0",
               'user_id'=>"0",
               'time'=>"0",
               'played'=>"0",
       ]);
       return successResponseJson([
        'api rest done'
    ]); 

   }


    protected $selectColumns = [
        "id",
        "token1",
        "token2",
        "quest_id",
        "ans1",
        "ans2",
        "winner",
        "game_id",

    ];
}
