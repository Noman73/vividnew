<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ClubBonus;
use App\Models\ClubLevel;
class ClubBonusLevel3 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'club:level3';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $last_counter=ClubLevel::max('counter3');
        if($last_counter<5){
            $last_counter=5;
        }
        $count=ClubLevel::where('level',3)->where('status',0)->count();
        if(($last_counter*5) <= $count){
            $level3=ClubLevel::where('level',3)->take(($last_counter*5)/5)->get();
            foreach($level3 as $lev){
                $bonus=new ClubBonus;
                $bonus->user_id=$lev->user_id;
                $bonus->amount=5000;
                $bonus->level=4;
                $bonus->save();
                if($bonus){
                    $clvl=ClubLevel::where('user_id',$lev->user_id)->first();
                    $clvl->level=4;
                    $clvl->counter3=($last_counter*5);
                    $clvl->save();
                }
            }
        }
        return 0;
    }
}
