<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FAQController extends Controller
{
    public function index()
    {
        $faqs = [
            ['question' => 'How are your coconuts harvested?', 'answer' => 'Our coconuts are harvested sustainably by local farmers in tropical regions.'],
            ['question' => 'Are your coconuts organic?', 'answer' => 'Yes, we source organic coconuts from certified farms.'],
            ['question' => 'What is the shelf life of your coconuts?', 'answer' => 'Coconuts typically have a shelf life of about 2-3 months if stored properly.'],
            // Add more FAQs as needed
        ];

        return view('frontend.pages.faqs', compact('faqs'));
    }
}