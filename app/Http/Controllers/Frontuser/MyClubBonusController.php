<?php

namespace App\Http\Controllers\Frontuser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClubBonus;
use DataTables;
class MyClubBonusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:fuser');
    }
    public function index()
    {
        if (request()->ajax()){
            $get = ClubBonus::with('user')->where('user_id',auth()->user()->id)->get();
            return DataTables::of($get)
                ->addIndexColumn()
                ->addColumn('action', function ($get) {
                    return "X";
                })
                ->addColumn('name',function ($get){
                    return $get->user->name;
                })
                ->addColumn('username',function ($get){
                    return $get->user->username;
                })
                ->rawColumns(['action'])->make(true);
        }
        return view('frontend.club_bonus.my_club_bonus');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
