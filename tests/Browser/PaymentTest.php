<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
class PaymentTest extends DuskTestCase
{
    protected $controller = 'PaymentController';
    public function testViewWithPermissions()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(1))
                ->visit(action($this->controller . '@index'))
                ->assertSee('INVOICE PAYMENTS');
        });
    }

    public function testShowWithPermissions()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(1))
                ->visit(action($this->controller . '@show', array('id' => 1)))
                ->assertSee('PAYMENT DETAILS');
        });
    }

    public function testEditWithPermissions()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(1))
                ->visit(action($this->controller . '@edit', array('id' => 1)))
                ->assertSee('CREATE PAYMENT')
                ->click('.save_form')
                ->assertSee('INVOICE PAYMENTS');
        });
    }

    public function testDeleteWithPermissions()
    {

    }
}
