<?php
/**
 * \Esampaio\StateMachine\Reader
 *
 * @category Util
 * @package  StateMachine
 * @author   Eduardo Sampaio <eduardo@esampaio.com>
 * @license  MIT <http://choosealicense.com/licenses/mit/>
 * @link     http://esampaio.github.io/state-machine
 */
namespace Esampaio\StateMachine;

use Doctrine\Common\Annotations\AnnotationReader;
use Esampaio\StateMachine\States;
use Esampaio\StateMachine\Transition;

/**
 * Reader class of the StateMachine
 *
 * @category Class
 * @package  StateMachine
 * @author   Eduardo Sampaio <eduardo@esampaio.com>
 * @license  MIT <http://choosealicense.com/licenses/mit/>
 * @link     http://esampaio.github.io/state-machine
 */
class Reader
{
    private $_reader;
    private $_class;
    private $_statesClass = 'Esampaio\StateMachine\States';
    private $_transitionClass = 'Esampaio\StateMachine\Transition';

    /**
     * Class constructor
     *
     * @param string $class Class name to read annotations
     *
     * @return void
     */ 
    public function __construct($class)
    {
        $this->_reader = new AnnotationReader;
        $this->_class = new \ReflectionClass($class);
    }

    /**
     * Returns the possible StateMachine states
     *
     * @return false|array
     */
    public function getStates()
    {
        $annotation = $this->_reader->getClassAnnotation($this->_class, $this->_statesClass);

        if (null == $annotation) {
            return array();
        }

        return $annotation->states;
    }

    /**
     * Returns the possible StateMachine transitions
     *
     * @return false|array
     */
    public function getTransitions()
    {
        $annotations = $this->_reader->getClassAnnotations($this->_class);
        $transitions = array();

        foreach ($annotations as $annot) {
            if ($annot instanceof $this->_transitionClass) {
                $transitions[$annot->state] = $annot->transitions;
            }
        }

        return $transitions;
    }
}
