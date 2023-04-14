<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ClubLevel;
use App\Models\ClubBonus;
class ClubBonusLevel2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'club:level2';

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
        $last_counter=ClubLevel::max('counter2');
        if($last_counter<5){
            $last_counter=5;
        }
        $count=ClubLevel::where('level',2)->where('status',0)->count();
        info('count-'.$count);
        info(($last_counter*5).'minus-'.((($last_counter*5)/5 ==1 ? 0 :($last_counter*5)/5)));
        if(($last_counter*5) <= $count){
            $level1=ClubLevel::where('level',2)->take(($last_counter*5)/5)->get();
            foreach($level1 as $lev){
                $bonus=new ClubBonus;
                $bonus->user_id=$lev->user_id;
                $bonus->amount=1500;
                $bonus->level=2;
                $bonus->save();
                if($bonus){
                    $clvl=ClubLevel::where('user_id',$lev->user_id)->first();
                    $clvl->level=3;
                    $clvl->counter2=($last_counter*5);
                    $clvl->save();
                }
            }
        }
        return 0;
    }
}
