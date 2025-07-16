<?php 

use PHPUnit\Framework\TestCase;

require_once __DIR__."/../src/Calculator.php";

class CalculatorTest extends TestCase
{
    private $calculator;

    protected function setUp():void
    {
        // Instanciation avant chaque test
        $this->calculator = new Calculator();
    }
    public function testAdd()
    {
        $this->assertEquals(7, $this->calculator->add(3,4));
    }
    public function testDivide()
    {
        $this->assertEquals(2, $this->calculator->divide(6,3));
    }
    public function testDivideByZero()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->calculator->divide(6,0);
    }
}