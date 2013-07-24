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
        $this->assertEquals(4, count($states));
        $this->assertEquals(array('requested', 'accepted', 'canceled', 'deleted'), $states);

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

        $this->assertEquals('requested', $dummy->getState());
        $this->assertTrue($dummy->isRequested());
        $this->assertTrue($dummy->canAccepted());
        $this->assertTrue($dummy->canCanceled());
        $this->assertFalse($dummy->canDeleted());

        $this->assertTrue($dummy->transitionCanceled());
        $this->assertTrue($dummy->isCanceled());
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
