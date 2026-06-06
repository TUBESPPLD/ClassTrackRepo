<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginGuruTest extends DuskTestCase
{
    public function test_guru_can_login_successfully(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login?role=guru')
                    ->type('email', 'guru2@classtrack.test')
                    ->type('password', 'password')
                    ->press('Masuk')
                    ->waitForLocation('/guru/dashboard', 10)
                    ->assertPathIs('/guru/dashboard');
        });
    }
}
