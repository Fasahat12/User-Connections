<?php

namespace App\Http\Controllers;

use App\Models\Request;
use App\Models\Connection;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $id = auth()->id();

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
            ->offset(0)
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
            
        $suggestionCount = count($allUsers);
        $sentRequestCount = count(Request::where('sender_id', $id)->get());
        $receivedRequestCount = count(Request::where('receiver_id', $id)->get());
        $connectionCount = count(Connection::where('first_user', $id)->orWhere('second_user', $id)->get());

        return view('home', [
                                'users' => $users,
                                'suggestionCount' => $suggestionCount,
                                'sentRequestCount' => $sentRequestCount,
                                'receivedRequestCount' => $receivedRequestCount,
                                'connectionCount' => $connectionCount
                    ]);
    }
}
