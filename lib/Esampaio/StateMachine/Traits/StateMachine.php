<?php
/**
 * \Esampaio\StateMachine\StateMachine
 *
 * @category Util
 * @package  StateMachine
 * @author   Eduardo Sampaio <eduardo@esampaio.com>
 * @license  MIT <http://choosealicense.com/licenses/mit/>
 * @link     http://esampaio.github.io/state-machine
 */
namespace Esampaio\StateMachine\Traits;

use Esampaio\StateMachine\Reader;
/**
 * Trait to enable StateMachine
 *
 * @category Trait
 * @package  StateMachine
 * @author   Eduardo Sampaio <eduardo@esampaio.com>
 * @license  MIT <http://choosealicense.com/licenses/mit/>
 * @link     http://esampaio.github.io/state-machine
 */
trait StateMachine
{
    /**
     * @var string $state
     */
    protected $state;

    /**
     * @var \Esampaio\StateMachine\Reader $_reader
     */
    protected $_reader;

    /**
     * @var array $_states
     */
    protected $_states;

    /**
     * @var array $_transitions
     */
    protected $_transitions;

    /**
     * Set state
     *
     * @param string $state State
     *
     * @return boolean
     */
    protected function setState($state)
    {
        if (in_array($state, $this->getStates())) {
            $this->state = $state;

            return true;
        }

        return false;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Get states
     *
     * @return array
     */
    public function getStates()
    {
        if (!$this->_states) {
            $this->_states = $this->getReader()->getStates();
        }

        return $this->_states;
    }

    /**
     * Returns the possible transitions for a state
     *
     * @param string $state State
     *
     * @return array
     */
    public function getTransitions($state)
    {
        if (!$this->_transitions) {
            $this->_transitions = $this->getReader()->getTransitions();
        }

        return $this->_transitions[$state];
    }

    /**
     * Returns the annotation reader
     *
     * @return \Esampaio\StateMachine\Reader
     */
    public function getReader()
    {
        if (!$this->_reader) {
            $this->_reader = new Reader(get_class($this));
        }
        return $this->_reader;
    }

    /**
     * Uncamelizes the state functions
     *
     * @param string $value State name to camelize
     *
     * @return string
     */
    protected function uncamelize($value)
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $value, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = ($match == strtoupper($match)) ? strtolower($match) : lcfirst($match);
        }

        return implode('_', $ret);
    }

    /**
     * Implements the StateMachine methods
     *
     * Implements 3 different methods for each state:
     *   is<state>
     *   can<state>
     *   transition<state>
     *
     * Let's use the "Requested" and "Canceled" event as examples, 
     * you can go to "Canceled" from requested, but not the other way around,
     * the created methods would be (state = 'Requested')
     *   isRequested // true
     *   isCanceled // false
     *   canCanceled // true
     *   transitionCanceled // true and state = 'Canceled'
     *   isCanceled // true
     *   isRequested // false
     *   canRequested // false
     *
     * Each transition<state> also triggers two other methods that may be
     * implemented:
     *   before<state>
     *   after<state>
     *
     * As an example, when the transitionCanceled is executed, it would trigger
     * beforeCanceled, transition the state into "Canceled" and trigger
     * afterCanceled.
     *
     * @param string $name      Method called
     * @param array  $arguments Method arguments
     *
     * @return mixed
     **/
    public function __call($name, $arguments)
    {
        switch(true) {
            case preg_match('/^is(?P<state>.+)/', $name, $matches):
                $state = $this->uncamelize($matches['state']);
                return (in_array($state, $this->getStates()) && $this->getState() == $state);
                break;
            case preg_match('/^can(?P<state>.+)/', $name, $matches):
                $state = $this->uncamelize($matches['state']);
                return in_array($state, $this->getTransitions($this->getState()));
                break;
            case preg_match('/^transition(?P<state>.+)/', $name, $matches):
                $state = $this->uncamelize($matches['state']);
                $can = 'can' . $matches['state'];
                if ($this->$can()) {
                    $before = 'before' . $matches['state'];
                    $this->$before();
                    $result = $this->setState($state);
                    $after = 'after' . $matches['state'];
                    $this->$after();
                    return $result;
                }
                return false;
                break;
        }
    }
}

