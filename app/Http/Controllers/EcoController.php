<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Ecotrack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EcoController extends Controller
{

    public function index(){
        $ecotrackers = Ecotrack::paginate(10);
        return view('backend.tracker.index', compact('ecotrackers'));

    }

    public function store(Request $request)
    {
        // Check if the user has already submitted today
        if (session('form_submitted_today')) {
            return redirect()->back()->with('error', 'You have already submitted the form today.');
        }

        // Proceed with storing the submission
        $this->validate($request, [
            'name' => 'required|string',
            'task_name' => 'required|string',
            'task_description' => 'required|string',
            'date' => 'required|date',
            'task' => 'required|array',
            'task.*' => 'string',
        ]);

        $existingSubmission = Ecotrack::where('name', $request->input('name'))
            ->whereDate('created_at', Carbon::today())
            ->first();

        if ($existingSubmission) {
            return redirect()->back()->with('error', 'You have already submitted the form today.');
        }

        $ecotrackers = new Ecotrack();
        $ecotrackers->name = $request->input('name');
        $ecotrackers->task_name = $request->input('task_name');
        $ecotrackers->task_description = $request->input('task_description') ?? 'No task description provided';
        $ecotrackers->date = $request->input('date');
        $ecotrackers->tasks = json_encode($request->input('task'));

        $ecotrackers->save();

        // Set session variable to mark form submission for today
        Session::put('form_submitted_today', true);

        // Check if the user already exists in the database
        $user = Ecotrack::where('name', $request->input('name'))->first();
        if ($user) {
            // Update user's answer count and last answered date
            $user->answer_count++;
            $user->last_answered_date = Carbon::today();
            $user->save();
        } else {
            // Create a new user record and set answer count to 1
            $newUser = new Ecotrack();
            $newUser->name = $request->input('name');
            $newUser->answer_count = 1;
            $newUser->last_answered_date = Carbon::today();
            $newUser->save();
        }

        return redirect()->route('ecotracker')->with('success', 'Form submitted successfully!');
    }

    public function show(Request $request,$id)
    {
        $ecotrackers=Ecotrack::find($id);
        if($ecotrackers){
            $ecotrackers->read_at=\Carbon\Carbon::now();
            $ecotrackers->save();
            return view('backend.tracker.show', compact('ecotrackers'));
        }
        else{
            return back();
        }
    }

    public function destroy($id)
    {
        $ecotrackers=Ecotrack::find($id);
        $status=$ecotrackers->delete();
        if($status){
            request()->session()->flash('success','Deleted Eco-track Data Successfully!');
        }
        else{
            request()->session()->flash('error','Error occurred please try again.');
        }
        return back();
    }
}
