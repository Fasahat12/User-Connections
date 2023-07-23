<?php

namespace App\Http\Controllers;

use App\Models\Request;
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
        $userId = auth()->id();

        $users = DB::table('users')
            ->leftJoin('requests', function ($join) use ($userId) {
                $join->on('users.id', '=', 'requests.receiver_id')
                    ->where('requests.sender_id', '=', $userId);
            })
            ->whereNull('requests.id')
            ->where('users.id', '!=', $userId)
            ->select('users.*')
            ->limit(10)
            ->get();

        $allUsers = DB::table('users')
                ->leftJoin('requests', function ($join) use ($userId) {
                    $join->on('users.id', '=', 'requests.receiver_id')
                        ->where('requests.sender_id', '=', $userId);
                })
                ->whereNull('requests.id')
                ->where('users.id', '!=', $userId)
                ->select('users.*')
                ->get();
            
        $suggestionCount = count($allUsers);
        $sentRequestCount = count(Request::where('sender_id', auth()->id())->get());

        return view('home', [
                                'users' => $users,
                                'suggestionCount' => $suggestionCount,
                                'sentRequestCount' => $sentRequestCount
                    ]);
    }
}
