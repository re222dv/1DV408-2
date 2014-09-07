<?php

namespace Di;


/**
 * Use Injector to get instances of a class. Only one instance per class is
 * created per Injector and is then reused. If you want to bind a class to
 * a specific instance, use bindToInstance($class, $instance)
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
class Injector {
    /**
     * @var array An assoc array with class => instance of all currently instantiated objects
     */
    private $instances = [];
    /**
     * @var array All classes that are currently instantiating so that circular dependencies can
     *            be detected.
     */
    private $instantiating = [];

    /**
     * Instances a new object from the specified class.
     *
     * @param string $class
     * @throws \Exception If a circular dependency is detected
     * @return object
     */
    private function instanceClass($class) {
        if (in_array($class, $this->instantiating)) {
            throw new \Exception('Circular dependency detected');
        }
        $this->instantiating[] = $class;

        $reflection = new \ReflectionClass($class);
        $constructor = $reflection->getConstructor();

        if ($constructor != null) {
            $parameters = $constructor->getParameters();
            $arguments = [];
            foreach ($parameters as $parameter) {
                $arguments[] = $this->get($parameter->getClass()->name);
            }
            $instance = $reflection->newInstanceArgs($arguments);
        } else {
            $instance = $reflection->newInstanceWithoutConstructor();
        }
        $this->instances[$class] = $instance;
        $this->instantiating = [];

        return $instance;
    }

    /**
     * Bind a class to a specific instance so that it's injected instead
     * of a newly created one.
     *
     * @param string $class
     * @param object $instance
     */
    public function bindToInstance($class, $instance) {
        $this->instances[$class] = $instance;
    }

    /**
     * Get an instance of a class and if there is no one cached, create
     * a new one.
     *
     * @param string $class
     * @return object
     */
    public function get($class) {
        if (isset($this->instances[$class])) {
            return $this->instances[$class];
        }

        return $this->instanceClass($class);
    }
}
