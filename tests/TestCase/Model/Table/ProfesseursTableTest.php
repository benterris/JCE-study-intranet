<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProfesseursTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProfesseursTable Test Case
 */
class ProfesseursTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ProfesseursTable
     */
    public $Professeurs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.professeurs'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Professeurs') ? [] : ['className' => 'App\Model\Table\ProfesseursTable'];
        $this->Professeurs = TableRegistry::get('Professeurs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Professeurs);

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
