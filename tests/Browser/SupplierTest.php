<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
class SupplierTest extends DuskTestCase
{
    protected $controller = 'SupplierController';
    public function testViewWithPermissions()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(1))
                ->visit(action($this->controller . '@index'))
                ->assertSee('SUPPLIERS');
        });
    }

    public function testShowWithPermissions()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(1))
                ->visit(action($this->controller . '@show', array('id' => 1)))
                ->assertSee('VIEW SUPPLIER');
        });
    }

    public function testEditWithPermissions()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(1))
                ->visit(action($this->controller . '@edit', array('id' => 1)))
                ->assertSee('ADD NEW SUPPLIER')
                ->click('.save_form')
                ->assertSee('SUPPLIERS');
        });
    }

    public function testDeleteWithPermissions()
    {

    }
}
