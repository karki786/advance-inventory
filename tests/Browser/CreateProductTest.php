<?php

namespace Tests\Browser;

use App\StorageLocation;
use App\User;
use Tests\DuskTestCase;

class CreateProductTest extends DuskTestCase
{

    /**
     * @var FakerGenerator
     */
    protected $faker;
    protected $controller = 'ProductController';

    /**
     * Setup faker
     */
    public function setUp()
    {
        parent::setUp();
        $this->faker = \Faker\Factory::create();
    }

    private function getRandomBinLocation()
    {
        return StorageLocation::inRandomOrder()->first()->binCode;
    }


    public function testViewWithPermissions()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(1))
                ->visit(action($this->controller . '@index'))
                ->assertSee('PRODUCTS');
        });
    }

    public function testShowWithPermissions()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(1))
                ->visit(action($this->controller . '@show', array('id' => 1)))
                ->assertSee('VIEW PRODUCT');
        });
    }

    public function testEditWithPermissions()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(1))
                ->visit(action($this->controller . '@edit', array('id' => 1)))
                ->click('.save_form')
                ->assertSee('PRODUCTS');
        });
    }

    public function testDeleteWithPermissions()
    {

    }


    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function ($browser) {
            $browser->loginAs(User::find(1))
                ->visit('/product/create')
                ->type('productName', $this->faker->word)
                ->select('usesMultipleStorage', '1')
                ->click('#select2-locsChoice-container')
                ->type('.select2-search__field', $this->getRandomBinLocation())
                ->keys('.select2-search__field', ['{enter}'])
                ->click('#select2-locsChoice-container')
                ->type('.select2-search__field', $this->getRandomBinLocation())
                ->keys('.select2-search__field', ['{enter}'])
                ->click('#select2-locsChoice-container')
                ->type('.select2-search__field', $this->getRandomBinLocation())
                ->keys('.select2-search__field', ['{enter}'])
                ->click('.remove_location')
                ->assertSee('Add Product');
        });
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@locsChoice' => '.locs'
        ];
    }
}
