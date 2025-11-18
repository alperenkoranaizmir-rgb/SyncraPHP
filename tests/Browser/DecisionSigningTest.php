<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Project;
use App\Models\Decision;

class DecisionSigningTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function test_admin_can_sign_a_decision_flow()
    {
        // seed basic data
        $user = User::create(['name' => 'Dusk User', 'email' => 'dusk@example.com', 'password' => bcrypt('password')]);
        $project = Project::factory()->create(['name' => 'Dusk Project']);
        $decision = Decision::factory()->create(['project_id' => $project->id, 'title' => 'Dusk Decision']);

        // attach user to project
        $user->projects()->attach($project->id, ['gorev' => 'admin']);

        $this->browse(function (Browser $browser) use ($user, $project, $decision) {
            $browser->visit('/login')
                    ->type('email', $user->email)
                    ->type('password', 'password')
                    ->press('Login')
                    ->assertPathIs('/admin');

            $browser->visit(route('admin.projects.decisions.show', ['project' => $project->id, 'decision' => $decision->id]))
                    ->assertSee($decision->title)
                    ->press('.js-sign')
                    ->pause(500)
                    ->assertSee('İmzalandı');
        });
    }
}
