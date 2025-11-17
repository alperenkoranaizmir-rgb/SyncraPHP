<?php

namespace App\Services;

use App\Models\Decision;
use App\Models\Signature;
use Illuminate\Support\Facades\Config;

class DecisionService
{
    public function calculateMajority(Decision $decision): array
    {
        $basis = Config::get('consensus.basis', 'unit');

        if ($basis === 'owner') {
            $total = $decision->project->owners()->count();
        } else {
            $total = $decision->project->total_units ?: $decision->project->units()->count();
        }

        $required = (int) floor($total / 2) + 1;
        $signedCount = $decision->signatures()->where('signed', true)->count();

        if ($signedCount >= $required && $decision->status !== 'tamamlandi') {
            $decision->status = 'tamamlandi';
            $decision->save();
            // audit & events can be fired here
        }

        return ['total' => $total, 'required' => $required, 'signed' => $signedCount];
    }
}
