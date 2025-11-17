<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Decision;
use App\Models\Signature;
use App\Jobs\CheckDecisionMajorityJob;
use Illuminate\Http\Request;

class SignatureController extends Controller
{
    public function sign(Request $request, Decision $decision)
    {
        $ownerId = $request->input('owner_id');
        $signature = $decision->signatures()->where('owner_id', $ownerId)->first();
        if (!$signature) return response()->json(['message' => 'Signature record not found'],404);
        $signature->update(['signed' => true, 'signed_at' => now()]);

        // dispatch majority check
        CheckDecisionMajorityJob::dispatch($decision->id);

        return response()->json(['message' => 'Signed']);
    }
}
