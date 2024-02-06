<?php

namespace App\Http\Controllers;

use App\Models\Startup;
use App\Models\StartupVotes;
use Illuminate\Http\Request;

class StartupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Startup::orderBy('name', 'ASC');

        $sectors = Startup::distinct('sector')->orderBy('sector', 'ASC')->get('sector');

        if ($request->filled('funding')) {
            $range = explode('|', $request->get('funding'));
            $query->whereBetween('fund_value', [$range[0], $range[1]]);
        }

        if ($request->filled('sector'))
            $query->where(['sector' => $request->get('sector')]);

        if ($request->filled('s')) {
            $query->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->get('s') . '%');
                $query->orWhere('description', 'like', '%' . $request->get('s') . '%');
                $query->orWhere('founders', 'like', '%' . $request->get('s') . '%');
            });
        }

        $startups = $query->with('votes')->paginate(15);

        return view('home')->with(['startups' => $startups, 'sectors' => $sectors]);
    }

    public function vote(Request $request)
    {
        sleep(0.5);
        $vote = new StartupVotes();
        $vote->user_id = auth()->id();
        $vote->startup_id = $request->get('id');
        $response = $vote->save();

        if ($response)
            return response()->json(['status' => 'Success'], 200);

        return response()->json(['status' => 'There was an error'], 500);
    }

    public function unvote(Request $request)
    {
        sleep(0.5);
        $vote = StartupVotes::where(['user_id' => auth()->id(), 'startup_id' => $request->get('id')]);
        $response = $vote->delete();
        if ($response)
            return response()->json(['status' => 'Success'], 200);

        return response()->json(['status' => 'There was an error'], 500);

    }
}
