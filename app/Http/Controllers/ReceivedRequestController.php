<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReceivedRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id, $offset)
    {
        $users = DB::table('users')
        ->join('requests', 'users.id', '=', 'requests.sender_id')
        ->where('requests.receiver_id', '=', $id)
        ->select('users.*')
        ->offset($offset)
        ->limit(10)
        ->get();

        $allUsers = DB::table('users')
        ->join('requests', 'users.id', '=', 'requests.sender_id')
        ->where('requests.receiver_id', '=', $id)
        ->get();
        
        $count = count($allUsers);

        return [ 'users' => $users, 'count' => $count ];
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
