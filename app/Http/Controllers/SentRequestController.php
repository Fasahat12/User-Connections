<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Request as UserRequest;

class SentRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id, $offset)
    {
        $users = DB::table('users')
        ->join('requests', 'users.id', '=', 'requests.receiver_id')
        ->where('requests.sender_id', '=', $id)
        ->selectRaw('users.*, requests.id as request_id')
        ->offset($offset)
        ->limit(10)
        ->get();

        $allUsers = DB::table('users')
        ->join('requests', 'users.id', '=', 'requests.receiver_id')
        ->where('requests.sender_id', '=', $id)
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
        $request->validate([
            'sender_id' => 'required',
            'receiver_id' => 'required'
        ]);


        return UserRequest::create([
            'sender_id' => $request->sender_id,
            'receiver_id' => $request->receiver_id
        ]);
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
        return UserRequest::destroy($id);
    }
}
