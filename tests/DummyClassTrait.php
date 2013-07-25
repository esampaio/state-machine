<?php
/**
 * \Esampaio\StateMachine\Tests\DummyClassTrait
 *
 * @category Test
 * @package  StateMachine
 * @author   Eduardo Sampaio <eduardo@esampaio.com>
 * @license  MIT <http://choosealicense.com/licenses/mit/>
 * @link     http://esampaio.github.io/state-machine
 */
namespace Esampaio\StateMachine\Tests;

use Esampaio\StateMachine\Traits\StateMachine;
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
 * @States(states = {"requested", "accepted", "canceled", "deleted", "re_requested"})
 * @Transition(state = "requested", transitions = {"accepted", "canceled"})
 * @Transition(state = "accepted", transitions = {"deleted"})
 * @Transition(state = "canceled", transitions = {"deleted", "re_requested"})
 */
class DummyClassTrait
{
    use StateMachine;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setState('requested');
    }
}

