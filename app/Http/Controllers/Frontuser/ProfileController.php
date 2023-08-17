<?php

namespace App\Http\Controllers\Frontuser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use DB;
class ProfileController extends Controller
{
    public function __construct(){
    	$this->middleware('auth:fuser');
    }
    public function Profile(){
       $vp=Invoice::where('fuser_id',auth()->user()->id)->sum('vp');
       if($vp>=10 and  $vp<20){
           $package="Rising";
       }elseif($vp>=20 and $vp<50){
           $package="Basic";
       }elseif($vp>=50){
           $package="Professional";
       }else{
           $package="Inactive";
       }
     	return view('frontend.profile.profile',compact('vp','package'));
    }
}
