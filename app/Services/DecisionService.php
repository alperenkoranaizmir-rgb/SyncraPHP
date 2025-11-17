<?php

namespace App\Services;

use App\Models\Decision;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class DecisionService
{
    /**
     * Evaluate majority for a decision using owner share_percent.
     * Returns array with totals and whether passed (50+1 rule).
     */
    public function evaluateMajority(Decision $decision): array
    {
        $projectId = $decision->project_id;

        // total shares across owners for the project (sum of owner_unit.share_percent)
        $totalShares = (float) DB::table('owner_unit')
            ->join('units', 'owner_unit.unit_id', '=', 'units.id')
            ->where('units.project_id', $projectId)
            ->sum('owner_unit.share_percent');

        // signed shares for this decision (sum of owner_unit.share_percent for owners who signed)
        $signedShares = (float) DB::table('signatures')
            ->join('owner_unit', 'signatures.owner_id', '=', 'owner_unit.owner_id')
            ->join('units', 'owner_unit.unit_id', '=', 'units.id')
            ->where('signatures.decision_id', $decision->id)
            ->where('signatures.signed', true)
            ->where('units.project_id', $projectId)
            ->sum('owner_unit.share_percent');

        // Avoid division by zero
        $percentage = $totalShares > 0 ? ($signedShares / $totalShares) * 100.0 : 0.0;

        // 50% + epsilon: require strictly greater than 50
        $passed = $percentage > 50.0;

        return [
            'decision_id' => $decision->id,
            'project_id' => $projectId,
            'total_shares' => $totalShares,
            'signed_shares' => $signedShares,
            'percentage' => $percentage,
            'passed' => $passed,
        ];
    }

    /**
     * Alternative calculation based on unit/owner counts and mark tamamlandi
     */
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
