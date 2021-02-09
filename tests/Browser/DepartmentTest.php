<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
class DepartmentTest extends DuskTestCase
{
    protected $controller = 'DepartmentController';
    public function testViewWithPermissions()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(1))
                ->visit(action($this->controller . '@index'))
                ->assertSee('DEPARTMENTS AND BUDGETS');
        });
    }

    public function testShowWithPermissions()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(1))
                ->visit(action($this->controller . '@show', array('id' => 1)))
                ->assertSee('ADD DEPARTMENT');
        });
    }

    public function testEditWithPermissions()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(1))
                ->visit(action($this->controller . '@edit', array('id' => 1)))
                ->assertSee('ADD DEPARTMENT')
                ->click('.save_form')
                ->assertSee('DEPARTMENTS AND BUDGETS');
        });
    }

    public function testDeleteWithPermissions()
    {

    }
}
