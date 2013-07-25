<?php
/**
 * \Esampaio\StateMachine\Tests\StateMachineTest
 *
 * @category Test
 * @package  StateMachine
 * @author   Eduardo Sampaio <eduardo@esampaio.com>
 * @license  MIT <http://choosealicense.com/licenses/mit/>
 * @link     http://esampaio.github.io/state-machine
 */
namespace Esampaio\StateMachine\Tests;

use Esampaio\StateMachine\StateMachine;
use Esampaio\StateMachine\States;
use Esampaio\StateMachine\Transition;
use Esampaio\StateMachine\Reader;
use Esampaio\StateMachine\Tests\DummyClass;
use Esampaio\StateMachine\Tests\DummyClassTrait;

/**
 * Class to enable StateMachine
 *
 * @category Class
 * @package  StateMachine
 * @author   Eduardo Sampaio <eduardo@esampaio.com>
 * @license  MIT <http://choosealicense.com/licenses/mit/>
 * @link     http://esampaio.github.io/state-machine
 */
class StateMachineTest extends \PHPUnit_Framework_TestCase
{
    protected $dummyClass = '\Esampaio\StateMachine\Tests\DummyClass';
    protected $dummyClassTrait = '\Esampaio\StateMachine\Tests\DummyClassTrait';

    /**
     * Returns the Annotation Reader for the DummyClass
     *
     * @return \Esampaio\StateMachine\Reader
     */
    protected function getReader()
    {
        return new Reader($this->dummyClass);
    }

    /**
     * Test the DummyClass annotations
     *
     * @return void
     */
    public function testAnnotations()
    {
        $reader = $this->getReader();

        $states = $reader->getStates();
        $this->assertEquals(5, count($states));
        $this->assertEquals(array('requested', 'accepted', 'canceled', 'deleted', 're_requested'), $states);

        $transitions = $reader->getTransitions();
        $this->assertEquals(3, count($transitions));
        $this->assertEquals(2, count($transitions['requested']));
        $this->assertTrue(in_array('deleted', $transitions['canceled']));
    }

    /**
     * Test the DummyClass annotations
     *
     * @return void
     */
    public function testStateMachine()
    {
        $dummy = new $this->dummyClass;

        $this->performTests($dummy);
    }

    /**
     * Test the DummyClass annotations using Trait
     *
     * @return void
     */
    public function testStateMachineTrait()
    {
        $dummy = new $this->dummyClassTrait;

        $this->performTests($dummy);
    }

    /**
     * Performs the class test suite on the passed object
     *
     * @param object $dummy Object to perform the test suite
     *
     * @return void
     */
    public function performTests($dummy)
    {
        $this->assertEquals('requested', $dummy->getState());
        $this->assertTrue($dummy->isRequested());
        $this->assertTrue($dummy->canAccepted());
        $this->assertTrue($dummy->canCanceled());
        $this->assertFalse($dummy->canDeleted());

        $this->assertTrue($dummy->transitionCanceled());
        $this->assertTrue($dummy->isCanceled());
        $this->assertTrue($dummy->canReRequested());
        $this->assertEquals('canceled', $dummy->getState());

        // $mock = $this->getMock(
        //     $this->dummyClass,
        //     array('beforeCanceled', 'afterCanceled')
        // );

        // $mock->expects($this->once())
        //     ->method('beforeCanceled');

        // $mock->expects($this->once())
        //     ->method('afterCanceled');

        // $this->assertTrue($mock->transitionCanceled());
        // $this->assertTrue($mock->isCanceled());
        // $this->assertEquals('canceled', $mock->getState());
    }
}
