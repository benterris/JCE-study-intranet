<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LyceesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LyceesTable Test Case
 */
class LyceesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LyceesTable
     */
    public $Lycees;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.lycees',
        'app.interventions'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Lycees') ? [] : ['className' => 'App\Model\Table\LyceesTable'];
        $this->Lycees = TableRegistry::get('Lycees', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Lycees);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
