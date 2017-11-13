<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BenevolesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BenevolesTable Test Case
 */
class BenevolesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BenevolesTable
     */
    public $Benevoles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.benevoles'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Benevoles') ? [] : ['className' => 'App\Model\Table\BenevolesTable'];
        $this->Benevoles = TableRegistry::get('Benevoles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Benevoles);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
