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

    protected Decision $decision;

    public function __construct(Decision $decision)
    {
        $this->decision = $decision;
    }

    public function handle(DecisionService $service)
    {
        $res = $service->evaluateMajority($this->decision);
        // update decision status based on majority
        $this->decision->status = $res['passed'] ? 'kabul' : 'reddedildi';
        $this->decision->save();
    }
}

