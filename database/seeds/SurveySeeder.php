<?php

use Illuminate\Database\Seeder;
use MattDaneshvar\Survey\Models\Survey;

class SurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $survey = Survey::create(['name' => 'Cat Population Survey', 'settings' => ['accept-guest-entries' => true]]);

        $survey->questions()->create([
            'content' => 'How many cats do you have?',
            'type' => 'number',
            'rules' => ['numeric', 'min:0']
        ]);

        $survey->questions()->create([
            'content' => 'What\'s the name of your first cat',
        ]);

        $survey->questions()->create([
            'content' => 'Would you want a new cat?',
            'type' => 'radio',
            'options' => ['Yes', 'Oui']
        ]);
    }
}
