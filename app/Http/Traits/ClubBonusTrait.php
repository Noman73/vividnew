<?php
namespace App\Http\Traits;
use DB;
use App\Models\ClubBonus;
trait ClubBonusTrait{
    
	public function GetClubBonus($id){
        return ClubBonus::where('user_id',$id)->sum('amount');
	}
}