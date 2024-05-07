<?php

namespace App\Http\Controllers;



use App\Models\Ecotrack;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class EcoController extends Controller
{

        public function store(Request $request)
            {
                // Validate the form inputs
                $validatedData = $request->validate([
                    'task' => 'required|array',
                    'task.*' => 'string',
                    'name' => 'string|required',
                    'task_name' => 'string|required',
                    'task_description' => 'string|required',
                    'date' => 'string|required',
                ]);

                // Check if the form has already been submitted today
                if (Session::has('form_submitted_today')) {
                    return redirect()->back()->withErrors(['message' => 'You have already submitted the form today.']);
                }

                // Create a new Ecotrack instance and populate it with form data
                $ecotrackers = new Ecotrack();
                $ecotrackers->name = $validatedData['name'];
                $ecotrackers->task_name = $validatedData['task_name'];
                $ecotrackers->task_description = $validatedData['task_description'];
                $ecotrackers->date = $validatedData['date'];
                $ecotrackers->tasks = json_encode($validatedData['task']); // Assuming tasks are stored as JSON

                // Save the Ecotrack instance to the database
                $ecotrackers->save();

                // Set session value to mark that the form has been submitted today
                Session::put('form_submitted_today', true);

                return redirect()->back()->with('success', 'Form submitted successfully!');
            }

}


