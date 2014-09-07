<?php

namespace Di\test;

use Di\Injector;

require(realpath(dirname(__FILE__)).'/../../../../vendor/autoload.php');
require_once(realpath(dirname(__FILE__)).'/../di.php');

class Tests extends \PHPUnit_Framework_TestCase {

    public function testSimpleInject() {
        $injector = new Injector();

        $foo = $injector->get('Di\test\Foo');

        $this->assertTrue($foo instanceof Foo);
        $this->assertTrue($foo->bar instanceof Bar);
    }

    public function testInjectBoundInstance() {
        $bar = new Bar();

        $injector = new Injector();
        $injector->bindToInstance('Di\test\Bar', $bar);

        $foo = $injector->get('Di\test\Foo');

        $this->assertTrue($bar === $foo->bar);
        $this->assertTrue($foo->bar instanceof Bar);
    }

    public function testInjectSameInstance() {
        $injector = new Injector();

        $foo = $injector->get('Di\test\Foo');
        $foo2 = $injector->get('Di\test\Foo');

        $this->assertTrue($foo === $foo2);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Circular dependency detected
     */
    public function testThrowOnCircularDependency() {
        $injector = new Injector();

        $injector->get('Di\test\Circular');
    }

    public function testAdvancedInject() {
        $injector = new Injector();

        $advanced = $injector->get('Di\test\Advanced');

        $this->assertTrue($advanced->bar instanceof Bar);
        $this->assertTrue($advanced->foo instanceof Foo);
        $this->assertTrue($advanced->foo->bar instanceof Bar);
        $this->assertTrue($advanced->bar === $advanced->foo->bar);
    }
}

class Bar {
}

class Foo {
    public $bar;

    public function __construct(Bar $bar) {
        $this->bar = $bar;
    }
}

class Advanced {
    public $bar;
    public $foo;

    public function __construct(Bar $bar, Foo $foo) {
        $this->bar = $bar;
        $this->foo = $foo;
    }
}

class Circular {
    public function __construct(Circular $circular) {
    }
}
