<?php

namespace App\Jobs;

use App\Models\Decision;
use App\Services\DecisionService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckDecisionMajorityJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $decisionId;

    public function __construct(int $decisionId)
    {
        $this->decisionId = $decisionId;
    }

    public function handle(DecisionService $service)
    {
        $decision = Decision::find($this->decisionId);
        if (!$decision) return;
        $service->calculateMajority($decision);
    }
}
