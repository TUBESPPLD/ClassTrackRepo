<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginAdminTest extends DuskTestCase
{
    /**
     * Test user login as admin.
     */
    public function test_admin_can_login_successfully(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login?role=admin')
                    ->type('email', 'admin@classtrack.test')
                    ->type('password', 'password')
                    ->press('Masuk')
                    ->waitForLocation('/admin/dashboard', 10)
                    ->assertPathIs('/admin/dashboard')
                    ->assertSee('Admin ClassTrack');
        });
    }
}
