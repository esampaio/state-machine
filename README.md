# State Machine

A dead simple State Machine PHP package.

## Installation

To install, just add this to your composer.json:

````json
"require": {
    "esampaio/state-machine":"master"
}
````

## Usage

### PHP version 5.3

If you are running PHP 5.3 you need to inherit the StateMachine class:

````php
<?php

use Esampaio\StateMachine\StateMachine;

class MyClass extends StateMachine
{
````

### PHP version 5.4

If you are running PHP version 5.4, just use the Trait:
````php
use Esampaio\StateMachine\Tratis\StateMachine;

class MyClass
{
    use StateMachine;
````

### Annotations

To add your possible states and transitions, use the following annotations:
````php
use Esampaio\StateMachine\Traits\StateMachine;
use Esampaio\StateMachine\States;
use Esampaio\StateMachine\Transition;

/**
 * @States(states = {"requested", "approved", "rejected"})
 * @Transition(state = "requested", transitions = {"approved", "rejected"})
 */
class MyClass
{
    use StateMachine;
````

### Magic!

The following methods will be created for each state:
````php
$foo->isRequested(); // Check if foo's current state equals "requested"
$foo->canApproved(); // Check if foo's current state allows transition to "approved"
$foo->transitionRejected(); // Transitions current foo's state to "rejected"
````

Two methods are triggered when a transition happens, you may implement them if you want:
````php
$foo->beforeRejected(); // Triggered before foo's state is changed into "rejected"
$foo->afterRejected(); // Triggered after foo's state is changed into "rejected"
````

Check the source code and/or tests to understand it better.

## Contributing

1. Fork it
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Commit your changes (`git commit -am 'Added some feature'`)
4. Push to the branch (`git push origin my-new-feature`)
5. Create new Pull Request
