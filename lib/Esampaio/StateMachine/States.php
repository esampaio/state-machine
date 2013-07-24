<?php
/**
 * \Esampaio\StateMachine\States
 *
 * @category Util
 * @package  StateMachine
 * @author   Eduardo Sampaio <eduardo@esampaio.com>
 * @license  MIT <http://choosealicense.com/licenses/mit/>
 * @link     http://esampaio.github.io/state-machine
 */
namespace Esampaio\StateMachine;

/**
 * Annotation to add states to the StateMachine
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
 *   @Attribute("states", type = "array")
 * })
 */
class States
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
        $this->states = $values['states'];
    }
}
