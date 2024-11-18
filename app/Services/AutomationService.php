<?php

namespace App\Services;

use App\Models\Action;
use App\Models\Client;
use App\Models\Condition;
use App\Models\Geofence;
use App\Models\Sale;
use Illuminate\Support\Facades\Http;
use Kutia\Larafirebase\Facades\Larafirebase;

class AutomationService
{
    public function sendNotification($title, $subtitle, $image, $url)
    {
        return Larafirebase::withTitle('Test Title')
            ->withBody('Test body')
            ->withImage('https://firebase.google.com/images/social.png')
            ->withIcon('https://seeklogo.com/images/F/firebase-logo-402F407EE0-seeklogo.com.png')
            ->withSound('default')
            ->withClickAction('https://www.google.com')
            ->withPriority('high')
            ->withAdditionalData([
                'color' => '#rrggbb',
                'badge' => 1,
            ])
            ->sendNotification(env('FIREBASE_TOKEN'));

        // Or
        return Larafirebase::fromArray(['title' => 'Test Title', 'body' => 'Test body'])->sendNotification(env('FIREBASE_TOKEN'));
    }


    public function sendMessage()
    {
        return Larafirebase::withTitle('Test Title')
            ->withBody('Test body')
            ->sendMessage(env('FIREBASE_TOKEN'));

        // Or
        return Larafirebase::fromArray(['title' => 'Test Title', 'body' => 'Test body'])->sendMessage(env('FIREBASE_TOKEN'));
    }


    // Controller method to evaluate conditions and execute actions
    public function evaluateConditionsAndExecuteActions()
    {
        // Retrieve conditions
        $conditions = Condition::all();

        // Loop through conditions
        foreach ($conditions as $condition) {
            $evaluated = $this->evaluateCondition($condition);

            if ($evaluated) {
                // Retrieve actions associated with the condition
                $actions = Action::where('condition_id', $condition->id)->get();

                // Execute actions
                foreach ($actions as $action) {
                    $this->executeAction($action);
                }
            }
        }
    }

    // Method to evaluate a single condition
    private function evaluateCondition($condition)
    {
        // Deserialize JSON condition
        $conditionData = json_decode($condition->condition, true);

        // Evaluate condition against your data
        // Example: Check if delivery status equals "Pending"
        $rowField = $conditionData['row']['Field'];
        $operator = $conditionData['operator'];
        $value = $conditionData['value'];
        $deliveryStatus = '';

        // Retrieve data from your system
        // Example: $deliveryStatus = getData($rowField);

        // Evaluate condition
        switch ($operator) {
            case 'When':
                return $deliveryStatus === $value;
                // Add more cases for other operators if needed
            default:
                return false;
        }
    }

    // Method to execute a single action
    private function executeAction($action)
    {
        // Execute action based on action type
        // Example: Send SMS
        // Example: Update database fields
    }
}
