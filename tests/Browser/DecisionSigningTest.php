<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DecisionSigningTest extends DuskTestCase
{
    /** @test */
    public function admin_can_sign_a_decision_flow()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin')
                    ->assertSee('Dashboard');
            // Further steps require seeded data and auth; this is a stub for E2E test.
        });
    }
}
