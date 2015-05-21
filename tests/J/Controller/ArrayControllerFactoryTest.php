<?php

namespace J\Controller;

/**
 * Class ArrayControllerFactoryTest
 *
 * @package J\Controller
 */
class ArrayControllerFactoryTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var ArrayControllerFactory
     */
    private $factory;

    /**
     * @return void
     */
    public function setUp()
    {
        $controllers = new \ArrayObject([
            'func1' => true,
        ]);

        $this->factory = new ArrayControllerFactory($controllers);
    }

    /**
     * @test
     * @testdox canCreate returns true on existing controller
     */
    public function canCreateReturnsTrue()
    {
        $this->assertTrue($this->factory->canCreate('func1'));
    }

    /**
     * @test
     * @testdox canCreate returns false on non-existing controller
     */
    public function canCreateReturnsFalse()
    {
        $this->assertFalse($this->factory->canCreate('funcX'));
    }

    /**
     * @test
     * @testdox create returns proper controller
     */
    public function createReturnsController()
    {
        $this->assertTrue($this->factory->create('func1'));
    }
}
