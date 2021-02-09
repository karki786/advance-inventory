<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
class StaffTest extends DuskTestCase
{
    protected $controller = 'StaffController';
    public function testViewWithPermissions()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(1))
                ->visit(action($this->controller . '@index'))
                ->assertSee('STAFF');
        });
    }

    public function testShowWithPermissions()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(1))
                ->visit(action($this->controller . '@show', array('id' => 1)))
                ->assertSee('VIEW STAFF DETAILS');
        });
    }

    public function testEditWithPermissions()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(1))
                ->visit(action($this->controller . '@edit', array('id' => 1)))
                ->assertSee('CREATE STAFF')
                ->click('.save_form')
                ->assertSee('STAFF');
        });
    }

    public function testDeleteWithPermissions()
    {

    }
}
