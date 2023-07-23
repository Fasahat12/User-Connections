<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Connection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Request as UserRequest;

class ConnectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id, $offset)
    {
        $userConnections = DB::table('users')
            ->join('connections', function ($join) use ($id) {
                $join->on('users.id', '=', DB::raw('CASE WHEN connections.first_user = ' . $id . ' THEN connections.second_user ELSE connections.first_user END'));
            })
            ->where(function ($query) use ($id) {
                $query->where('connections.first_user', '=', $id)
                    ->orWhere('connections.second_user', '=', $id);
            })
            ->select('users.id as user_id', 'connections.id', 'users.name', 'users.email')
            ->offset($offset)
            ->limit(10)
            ->get();

        $allConnections = DB::table('connections')
            ->where('first_user', $id)
            ->orWhere('second_user', $id)
            ->get();

        // Get the user IDs from the $userConnections result
        $userIds = $userConnections->pluck('user_id')->toArray();

        $commonConnectionCounts = [];

        foreach ($userIds as $userId) {
            $countCommonlyConnectedUsers = DB::table('connections as c1')
                ->join('connections as c2', function ($join) use ($id, $userId) {
                    $join->on('c1.first_user', '=', 'c2.first_user')
                        ->where('c1.second_user', '=', $id)
                        ->where('c2.second_user', '=', $userId)
                        ->orOn('c1.first_user', '=', 'c2.second_user')
                        ->where('c2.first_user', '=', $userId)
                        ->where('c1.second_user', '=', $id)
                        ->orOn('c1.second_user', '=', 'c2.second_user')
                        ->where('c1.first_user', '=', $id)
                        ->where('c2.first_user', '=', $userId)
                        ->orOn('c1.second_user', '=', 'c2.first_user')
                        ->where('c1.first_user', '=', $id)
                        ->where('c2.second_user', '=', $userId);
                })
                ->count();

            $commonConnectionCounts[] = $countCommonlyConnectedUsers;
        }


        return ['users' => $userConnections, 'count' => count($allConnections), 'commonConnectionCounts' => $commonConnectionCounts];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestId = $request->request_id;
        $userRequest = UserRequest::findOrFail($requestId);

        $connection = Connection::create([
            'first_user' => $userRequest->sender_id,
            'second_user' => $userRequest->receiver_id
        ]);

        $userRequest->delete();

        return $connection;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $userId, $offset)
    {
        $users = DB::table('connections as c1')
            ->join('connections as c2', function ($join) use ($id, $userId) {
                $join->on('c1.first_user', '=', 'c2.first_user')
                    ->where('c1.second_user', '=', $id)
                    ->where('c2.second_user', '=', $userId)
                    ->orOn('c1.first_user', '=', 'c2.second_user')
                    ->where('c2.first_user', '=', $userId)
                    ->where('c1.second_user', '=', $id)
                    ->orOn('c1.second_user', '=', 'c2.second_user')
                    ->where('c1.first_user', '=', $id)
                    ->where('c2.first_user', '=', $userId)
                    ->orOn('c1.second_user', '=', 'c2.first_user')
                    ->where('c1.first_user', '=', $id)
                    ->where('c2.second_user', '=', $userId);
            })
            ->select('c1.first_user as user1', 'c1.second_user as user2', 'c2.first_user as user3', 'c2.second_user as user4')
            ->get();

            // return $users;

        $ids = [];
        foreach ($users as $user) {

            if ($user->user1 != $id && $user->user1 != $userId) {
                $ids[] = $user->user1;
                continue;
            } else if ($user->user2 != $id && $user->user2 != $userId) {
                $ids[] = $user->user2;
                continue;
            } else if ($user->user3 != $id && $user->user3 != $userId) {
                $ids[] = $user->user3;
                continue;
            } else if ($user->user4 != $id && $user->user4 != $userId) {
                $ids[] = $user->user4;
                continue;
            }
        }

        //return $ids;

        $users  = User::whereIn('id', $ids)
                    ->offset($offset)
                    ->limit(10)
                    ->get();

        return ['users' => $users, 'count' => count($users)];
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
        return Connection::destroy($id);
    }
}
