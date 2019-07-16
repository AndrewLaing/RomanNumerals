<?php
namespace PhpNwSykes\Tests;

use PhpNwSykes\RomanNumeral;
use PHPUnit\Framework\TestCase;

class ValidMathOperationsTest extends TestCase
{
    public function testAddValueSet()
    {
        $roman = new RomanNumeral('XXV');
        $roman1 = new RomanNumeral('IV');
        $roman->add($roman1);
        $this->assertSame(29, $roman->toInt());
    }

    public function testAddValueReturned()
    {
        $roman = new RomanNumeral('XXV');
        $roman1 = new RomanNumeral('IV');
        $romanReturned = $roman->add($roman1);
        $this->assertSame(29, $romanReturned->toInt());
    }
        
    public function testSubtractValueSet()
    {
        $roman = new RomanNumeral('XXVI');
        $roman1 = new RomanNumeral('V');
        $roman->subtract($roman1);
        $this->assertSame(21, $roman->toInt());
    }
        
    public function testSubtractValueReturned()
    {
        $roman = new RomanNumeral('XXVI');
        $roman1 = new RomanNumeral('V');
        $romanReturned = $roman->subtract($roman1);
        $this->assertSame(21, $romanReturned->toInt());
    }

    public function testMultiplyValueSet()
    {
        $roman = new RomanNumeral('CCX');
        $roman1 = new RomanNumeral('X');
        $roman->multiply($roman1);
        $this->assertSame(2100, $roman->toInt());
    }

    public function testMultiplyValueReturned()
    {
        $roman = new RomanNumeral('CCX');
        $roman1 = new RomanNumeral('X');
        $romanReturned = $roman->multiply($roman1);
        $this->assertSame(2100, $romanReturned->toInt());
    }

    public function testDivideValueSet()
    {
        $roman = new RomanNumeral('MMC');
        $roman1 = new RomanNumeral('X');
        $roman->divide($roman1);
        $this->assertSame(210, $roman->toInt());
    }

    public function testDivideValueReturned()
    {
        $roman = new RomanNumeral('MMC');
        $roman1 = new RomanNumeral('X');
        $romanReturned = $roman->divide($roman1);
        $this->assertSame(210, $romanReturned->toInt());
    }
}

?>