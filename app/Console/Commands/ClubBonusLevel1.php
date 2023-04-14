<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ClubLevel;
use App\Models\ClubBonus;
class ClubBonusLevel1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'club:level1';

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
        $last_counter=ClubLevel::max('counter1');
        if($last_counter==0){
            $last_counter=1;
        }
        $count=ClubLevel::where('level',1)->where('status',0)->count();
        if(5 <= $count){
            $level1=ClubLevel::where('level',1)->take(5)->get();
            foreach($level1 as $lev){
                $bonus=new ClubBonus;
                $bonus->user_id=$lev->user_id;
                $bonus->amount=500;
                $bonus->level=1;
                $bonus->save();
                if($bonus){
                    $clvl=ClubLevel::where('user_id',$lev->user_id)->first();
                    $clvl->level=2;
                    $clvl->counter1=0;
                    $clvl->save();
                }
            }
        }
        return 0;
    }
}
