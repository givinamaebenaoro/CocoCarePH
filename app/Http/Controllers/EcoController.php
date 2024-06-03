<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Ecotrack;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class EcoController extends Controller
{

    public function index(){
        $ecotrackers = Ecotrack::paginate(10);
        return view('backend.tracker.index', compact('ecotrackers'));
    }

    public function edit($id)
    {
        $ecotrackers=Ecotrack::find($id);
        return view('backend.tracker.edit', compact('ecotrackers'));
    }

    public function update(Request $request, $id)
{
    $ecotrackers = Ecotrack::find($id);
    $this->validate($request, [
        'status' => 'required|in:complete,failed'
    ]);

    // Assuming $order is supposed to be $ecotrackers, as it's not defined in your code snippet
    $data = $request->all();

    // Update the status
    $ecotrackers->status = $request->status;

    // Save the updated data
    $status = $ecotrackers->save();

    if ($status) {
        if ($request->status == 'complete') {
            // Flash the announcement message for the user's homepage
            $announcement = 'Congratulations! You have successfully completed a task.';
            session()->flash('announcement', $announcement);
        }
        request()->session()->flash('success', 'Successfully updated task status');
    } else {
        request()->session()->flash('error', 'Error while updating task status');
    }


    return redirect()->route('tracker.index');
}


public function store(Request $request)
{
    // Validate the request
    $this->validate($request, [
        'task' => 'required|array',
        'task.*' => 'string',
    ]);

    $user = Auth::user();
    $today = Carbon::today('Asia/Manila');

    // Check if the user has already submitted today
    $existingSubmission = Ecotrack::where('user_id', $user->id)
                                  ->whereDate('created_at', $today)
                                  ->first();

    if ($existingSubmission) {
        // If there is an existing submission for today, update it
        $existingSubmission->tasks = json_encode($request->input('task'));
        $existingSubmission->updated_at = Carbon::now('Asia/Manila');
        $existingSubmission->save();
        return redirect()->route('ecotracker')->with('success', 'Form updated successfully!');
    }

    // Get the last submission before today
    $lastSubmission = Ecotrack::where('user_id', $user->id)
                              ->orderBy('created_at', 'desc')
                              ->first();

    // Proceed with storing a new submission
    $ecotrackers = new Ecotrack();
    $ecotrackers->user_id = $user->id;
    $ecotrackers->tasks = json_encode($request->input('task'));
    $ecotrackers->created_at = Carbon::now('Asia/Manila');
    $ecotrackers->updated_at = Carbon::now('Asia/Manila');
    $ecotrackers->answer_count = 1;

    // Calculate consecutive days and update status
    if ($lastSubmission && $lastSubmission->created_at->diffInDays($today) == 1) {
        $ecotrackers->consecutive_days = $lastSubmission->consecutive_days + 1;
        $ecotrackers->answer_count = $lastSubmission->answer_count + 1;
    } else {
        $ecotrackers->consecutive_days = 1;
    }

    if ($ecotrackers->consecutive_days >= 30) {
        $ecotrackers->status = 'complete';
    } else {
        $ecotrackers->status = 'new';
    }

    $ecotrackers->last_completed_date = $today;

    // Save the new submission
    $ecotrackers->save();

    // Set session variable to mark form submission for today
    Session::put('form_submitted_today', true);

    return redirect()->route('ecotracker')->with('success', 'Form submitted successfully!');
}



public function showEcotracker()
{
    $user = Auth::user();

    // Check if the user is authenticated
    if (!$user) {
        return redirect()->route('login.form'); // Redirect to login if not authenticated
    }

    $today = Carbon::today();
    $startDate = $today->copy()->subDays(30);

    // Calculate progress count for the last 30 days
    $progressCount = Ecotrack::where('user_id', $user->id)
                             ->whereBetween('last_completed_date', [$startDate, $today])
                             ->count();

    // Calculate consecutive days completed
    $lastCompletedDate = Ecotrack::where('user_id', $user->id)
                                 ->where('status', 'complete')
                                 ->orderBy('last_completed_date', 'desc')
                                 ->first();

    $consecutiveDays = 0;
    if ($lastCompletedDate) {
        $lastDate = Carbon::parse($lastCompletedDate->last_completed_date);
        while ($lastDate->isSameDay($today) || $lastDate->diffInDays($today, false) == $consecutiveDays) {
            $consecutiveDays++;
            $lastDate = $lastDate->subDay();
        }
    }

    return view('frontend.pages.ecotracker', compact('user', 'progressCount', 'consecutiveDays'));
}

private function checkConsecutiveDays($userId)
{
    $today = now();
    $start = $today->copy()->subDays(30);
    $progressDays = Ecotrack::where('user_id', $userId)
                                ->whereBetween('date', [$start, $today])
                                ->orderBy('date')
                                ->pluck('date')
                                ->toArray();

    $consecutive = true;
    $previousDate = $start->copy()->subDay();

    foreach ($progressDays as $date) {
        if (!$previousDate->copy()->addDay()->isSameDay($date)) {
            $consecutive = false;
            break;
        }
        $previousDate = Carbon::parse($date);
    }

    if (!$consecutive) {
        Ecotrack::where('user_id', $userId)->delete();
    }
}

    public function show($id)
    {
        $ecotrackers=Ecotrack::find($id);
        $progressCount = $ecotrackers->answer_count;
        $consecutiveDays = $ecotrackers->consecutive_days;

        return view('backend.tracker.show', compact('ecotrackers', 'progressCount', 'consecutiveDays'));
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
