<?php
/**
 * \Esampaio\StateMachine\Tests\DummyClass
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
/**
 * Dummy class for tests
 *
 * @category Class
 * @package  StateMachine
 * @author   Eduardo Sampaio <eduardo@esampaio.com>
 * @license  MIT <http://choosealicense.com/licenses/mit/>
 * @link     http://esampaio.github.io/state-machine
 *
 * @States(states = {"requested", "accepted", "canceled", "deleted"})
 * @Transition(state = "requested", transitions = {"accepted", "canceled"})
 * @Transition(state = "accepted", transitions = {"deleted"})
 * @Transition(state = "canceled", transitions = {"deleted"})
 */
class DummyClass extends StateMachine
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setState('requested');
    }
}
