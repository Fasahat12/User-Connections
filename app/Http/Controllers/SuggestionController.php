<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Request as UserRequest;

class SuggestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id, $offset)
    {

        $users = DB::table('users')
            ->leftJoin('requests', function ($join) use ($id) {
                $join->on('users.id', '=', 'requests.receiver_id')
                    ->where('requests.sender_id', '=', $id);
            })
            ->leftJoin('requests as received_requests', function ($join) use ($id) {
                $join->on('users.id', '=', 'received_requests.sender_id')
                    ->where('received_requests.receiver_id', '=', $id);
            })
            ->leftJoin('connections', function ($join) use ($id) {
                $join->on('users.id', '=', 'connections.first_user')
                    ->where('connections.second_user', '=', $id);
            })
            ->leftJoin('connections as second_connections', function ($join) use ($id) {
                $join->on('users.id', '=', 'second_connections.second_user')
                    ->where('second_connections.first_user', '=', $id);
            })
            ->whereNull('requests.id')
            ->whereNull('received_requests.id')
            ->whereNull('connections.id')
            ->whereNull('second_connections.id')
            ->where('users.id', '!=', $id)
            ->select('users.*')
            ->offset($offset)
            ->limit(10)
            ->get();

        $allUsers = DB::table('users')
            ->leftJoin('requests', function ($join) use ($id) {
                $join->on('users.id', '=', 'requests.receiver_id')
                    ->where('requests.sender_id', '=', $id);
            })
            ->leftJoin('requests as received_requests', function ($join) use ($id) {
                $join->on('users.id', '=', 'received_requests.sender_id')
                    ->where('received_requests.receiver_id', '=', $id);
            })
            ->leftJoin('connections', function ($join) use ($id) {
                $join->on('users.id', '=', 'connections.first_user')
                    ->where('connections.second_user', '=', $id);
            })
            ->leftJoin('connections as second_connections', function ($join) use ($id) {
                $join->on('users.id', '=', 'second_connections.second_user')
                    ->where('second_connections.first_user', '=', $id);
            })
            ->whereNull('requests.id')
            ->whereNull('received_requests.id')
            ->whereNull('connections.id')
            ->whereNull('second_connections.id')
            ->where('users.id', '!=', $id)
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
