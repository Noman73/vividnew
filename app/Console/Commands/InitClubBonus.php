<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ClubLevel;
use DB;
use App\Models\Invoice;
class InitClubBonus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'club:initClubBonus';

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
      $today=strtotime(date("d.m.Y"));
      $before3month=strtotime(date("d.m.Y",strtotime("-8 month")));
      $query="SELECT x.ref_id,x.created_at,count(x.ref_id) from
      (SELECT max(fusers.user_created_at) created_at,fusers.reffer_id ref_id,fusers.id,fusers.username,fusers.name,fusers.reffer_id,count(fusers.reffer_id) FROM fusers
      inner join invoices on invoices.fuser_id =fusers.id
      where fusers.user_created_at > :before3month and fusers.user_created_at < :today
      group by fusers.id  having sum(invoices.vp)>=180 order by fusers.user_created_at desc) x
      left join club_levels on x.ref_id=club_levels.user_id
      where club_levels.user_id is null
      group by x.ref_id having count(x.ref_id)>=3 order by x.created_at asc";
        $data=DB::select($query,['before3month'=>$before3month,'today'=>$today]);
        info($data);
        foreach($data as $user){
            $vp=Invoice::where('fuser_id',$user->ref_id)->sum('vp');
            if($vp>=180){
                $club_level=new ClubLevel;
                $club_level->user_id=$user->ref_id;
                $club_level->level=1;
                $club_level->save();
            }
        }
        return 0;
    }
}
