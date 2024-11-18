<?php

namespace App\Jobs;

use App\Models\Loan;
use App\Services\LoanCalculatorService;
use App\Services\LoanService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PenaltyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $loanService;
    protected $loanCalcService;

    public function __construct()
    {
        $this->loanService = app(LoanService::class);
        $this->loanCalcService = app(LoanCalculatorService::class);
    }

    public function handle()
    {
        $overdueLoans = Loan::where('due_date', '<', now())
            ->where('balance', '>', 0)
            ->whereIn('status', ['Disbursed'])
            ->get();


        foreach ($overdueLoans as $loan) {
            if ($this->loanCalcService->shouldApplyPenalty($loan)) {
                $penaltyAmount = $this->loanCalcService->calculateLateFee($loan->id, Carbon::now());
                // dd($penaltyAmount, $loan->reference);
                $this->loanService->applyPenalty($loan, $penaltyAmount, 'Late');
            }
        }
    }
}
