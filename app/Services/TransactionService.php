<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;

class TransactionService
{
    protected $baseUrl;
    protected $username;
    protected $password;
    protected $token;

    public function __construct()
    {
        $this->baseUrl = 'http://192.168.1.2:91';
        $this->username = 'admin';
        $this->password = '@2024Sam';
    }

    /**
     * Authenticate and retrieve JWT token.
     */
    public function authenticate()
    {
        $response = Http::post("{$this->baseUrl}/jwt-api-token-auth/", [
            'username' => $this->username,
            'password' => $this->password,
        ]);

        if ($response->successful()) {
            $this->token = $response->json('token');
            return $this->token;
        }

        throw new \Exception('Authentication failed: ' . $response->body());
    }

    /**
     * Fetch transactions using the JWT token.
     */
     public function getTransactions($perPage = 10, $page = 1)
     {
         if (!$this->token) {
             $this->authenticate();
         }

         $response = Http::withToken($this->token)
             ->get("{$this->baseUrl}/iclock/api/transactions/");

         if ($response->successful()) {
             $transactions = $response->json('data');
             $total = $response->json('count');  // Assuming API returns the total count of transactions

             // Create a LengthAwarePaginator instance to paginate the data
             return new LengthAwarePaginator(
                 array_slice($transactions, ($page - 1) * $perPage, $perPage), // Slice the data for current page
                 $total, // Total number of items (count from API)
                 $perPage, // Items per page
                 $page, // Current page
                 ['path' => url()->current()] // For pagination links
             );
         }

         throw new \Exception('Failed to fetch transactions: ' . $response->body());
     }

     protected function getHeaders()
     {
         return [
             'Content-Type' => 'application/json',
             'Authorization' => "JWT {$this->token}"
         ];
     }

    public function getEmployees($perPage = 10, $page = 1)
    {
        $response = Http::withHeaders($this->getHeaders())
            ->get("{$this->baseUrl}/personnel/api/employees/");


        if ($response->successful()) {
            $transactions = $response->json('data');
            $total = $response->json('count');  // Assuming API returns the total count of transactions

            // Create a LengthAwarePaginator instance to paginate the data
            return new LengthAwarePaginator(
                array_slice($transactions, ($page - 1) * $perPage, $perPage), // Slice the data for current page
                $total, // Total number of items (count from API)
                $perPage, // Items per page
                $page, // Current page
                ['path' => url()->current()] // For pagination links
            );
        }

    }
    public function getEmployee($id)
    {
        $response = Http::withHeaders($this->getHeaders())
            ->get("{$this->baseUrl}/personnel/api/employees/{$id}/");

        return $response->json();
    }

    public function createEmployee($data)
    {
        $response = Http::withHeaders($this->getHeaders())
            ->post("{$this->baseUrl}/personnel/api/employees/", $data);

        return $response->json();
    }

    public function updateEmployee($id, $data)
    {
        $response = Http::withHeaders($this->getHeaders())
            ->put("{$this->baseUrl}/personnel/api/employees/{$id}/", $data);

        return $response->json();
    }

    public function deleteEmployee($id)
    {
        return Http::withHeaders($this->getHeaders())
            ->delete("{$this->baseUrl}/personnel/api/employees/{$id}/");
    }

    public function adjustArea($employees, $areas)
    {
        $response = Http::withHeaders($this->getHeaders())
            ->post("{$this->baseUrl}/personnel/api/employees/adjust_area/", [
                'employees' => $employees,
                'areas' => $areas
            ]);

        return $response->json();
    }

    public function adjustDepartment($employees, $department)
    {
        $response = Http::withHeaders($this->getHeaders())
            ->post("{$this->baseUrl}/personnel/api/employees/adjust_department/", [
                'employees' => $employees,
                'department' => $department
            ]);

        return $response->json();
    }

}
