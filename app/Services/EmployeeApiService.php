<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;

class EmployeeApiService
{
    protected $baseUrl;
    protected $token;

    public function __construct()
    {
        $this->baseUrl = config('services.attendance_api.url');
        $this->token = config('services.attendance_api.token');
    }

    protected function getHeaders()
    {
        return [
            'Content-Type' => 'application/json',
            'Authorization' => "JWT {$this->token}"
        ];
    }

    public function getEmployees($params = [])
    {
        dd(1);
        $response = Http::withHeaders($this->getHeaders())
            ->get("{$this->baseUrl}/personnel/api/employees/", $params);

        return $response->json();


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
