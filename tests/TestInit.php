<?php
/*
 * This file bootstraps the test environment.
 */
namespace Esampaio\StateMachine\Tests;

error_reporting(E_ALL | E_STRICT);

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/DummyClass.php";
require_once __DIR__ . "/DummyClassTrait.php";
require_once __DIR__ . "/../lib/Esampaio/StateMachine/StateMachine.php";
require_once __DIR__ . "/../lib/Esampaio/StateMachine/States.php";
require_once __DIR__ . "/../lib/Esampaio/StateMachine/Transition.php";
