<?php
/**
 * Reflection is used to get the type hints of the injected classes constructor and thus
 * the injected class does not need to care if di is used or not. This requires that all
 * constructor arguments have a type hint and this limits the injection support to only
 * classes. Only one instance per class is created per Injector and is then reused.
 *
 * Usage:
 *
 *  class Bar {}
 *
 *  class Foo {
 *      public function __construct(Bar $bar) {}
 *  }
 *
 *  $injector = new \Di\Injector();
 *
 *  $foo = $injector->get('Foo');
 */

require_once('Injector.php');
