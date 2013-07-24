<?php
/**
 * \Esampaio\StateMachine\Transition
 *
 * @category Util
 * @package  StateMachine
 * @author   Eduardo Sampaio <eduardo@esampaio.com>
 * @license  MIT <http://choosealicense.com/licenses/mit/>
 * @link     http://esampaio.github.io/state-machine
 */
namespace Esampaio\StateMachine;

/**
 * Annotation to add possible transitions to the StateMachine
 *
 * @category Annotation
 * @package  StateMachine
 * @author   Eduardo Sampaio <eduardo@esampaio.com>
 * @license  MIT <http://choosealicense.com/licenses/mit/>
 * @link     http://esampaio.github.io/state-machine
 *
 * @Annotation
 * @Target("CLASS")
 * @Attributes({
 *   @Attribute("state", type = "string"),
 *   @Attribute("transitions", type = "array")
 * })
 */
class Transition
{
    /**
     * Class constructor
     *
     * @param array $values Available states
     *
     * @return void
     */ 
    public function __construct(array $values)
    {
        $this->state = $values['state'];
        $this->transitions = $values['transitions'];
    }
}

