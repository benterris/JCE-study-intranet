<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InterventionsCandidatesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InterventionsCandidatesTable Test Case
 */
class InterventionsCandidatesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\InterventionsCandidatesTable
     */
    public $InterventionsCandidates;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.interventions_candidates',
        'app.interventions',
        'app.teacher',
        'app.candidated_interventions',
        'app.volunteer',
        'app.candidates'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('InterventionsCandidates') ? [] : ['className' => 'App\Model\Table\InterventionsCandidatesTable'];
        $this->InterventionsCandidates = TableRegistry::get('InterventionsCandidates', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->InterventionsCandidates);

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
