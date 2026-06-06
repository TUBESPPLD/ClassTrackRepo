<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * Test user login as admin.
     */
    public function test_admin_can_login_successfully(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')
                    ->waitForLocation('/login')
                    ->clickLink('Admin')
                    ->waitForText('Portal Admin')
                    ->pause(1000)
                    ->script([
                        "document.querySelector('input[name=\"email\"]').value = 'admin@classtrack.test';",
                        "document.querySelector('input[name=\"password\"]').value = 'password';"
                    ]);
            $browser->press('Masuk')
                    ->waitForLocation('/admin/dashboard', 10)
                    ->assertPathIs('/admin/dashboard')
                    ->assertSee('Admin ClassTrack');
        });
    }

    /**
     * Test user login as guru.
     */
    public function test_guru_can_login_successfully(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')
                    ->waitForLocation('/login')
                    ->clickLink('Guru')
                    ->waitForText('Portal Guru')
                    ->pause(1000)
                    ->script([
                        "document.querySelector('input[name=\"email\"]').value = 'guru2@classtrack.test';",
                        "document.querySelector('input[name=\"password\"]').value = 'password';"
                    ]);
            $browser->press('Masuk')
                    ->waitForLocation('/guru/dashboard', 10)
                    ->assertPathIs('/guru/dashboard');
        });
    }

    /**
     * Test user login as siswa.
     */
    public function test_siswa_can_login_successfully(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')
                    ->waitForLocation('/login')
                    ->clickLink('Siswa')
                    ->waitForText('Portal Siswa')
                    ->pause(1000)
                    ->script([
                        "document.querySelector('input[name=\"email\"]').value = 'siswa1@classtrack.test';",
                        "document.querySelector('input[name=\"password\"]').value = 'password';"
                    ]);
            $browser->press('Masuk')
                    ->waitForLocation('/siswa/dashboard', 10)
                    ->assertPathIs('/siswa/dashboard');
        });
    }

    /**
     * Test user login as wali (parent).
     */
    public function test_wali_can_login_successfully(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/logout')
                    ->waitForLocation('/login')
                    ->clickLink('Wali Murid')
                    ->waitForText('Portal Wali Murid')
                    ->pause(1000)
                    ->script([
                        "document.querySelector('input[name=\"email\"]').value = 'wali1@classtrack.test';",
                        "document.querySelector('input[name=\"password\"]').value = 'password';"
                    ]);
            $browser->press('Masuk')
                    ->waitForLocation('/wali/dashboard', 10)
                    ->assertPathIs('/wali/dashboard');
        });
    }
}
