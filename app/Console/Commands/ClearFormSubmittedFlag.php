<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Session;

class ClearFormSubmittedFlag extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'form:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear the form submitted flag for the day.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Session::forget('form_submitted_today');
        $this->info('Form submitted flag cleared.');
    }
}
