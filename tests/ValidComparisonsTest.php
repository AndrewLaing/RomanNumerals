<?php
namespace PhpNwSykes\Tests;

use PhpNwSykes\RomanNumeral;
use PHPUnit\Framework\TestCase;

class ValidComparisonsTest extends TestCase
{
    public function testEqualsTrue()
    {
        $roman = new RomanNumeral('MXXXIV');
        $roman1 = new RomanNumeral('MXXXIV');
        $this->assertTrue($roman->equals($roman1));
    }

    public function testEqualsFalse()
    {
        $roman = new RomanNumeral('MXXXIV');
        $roman1 = new RomanNumeral('LXVIII');
        $this->assertFalse($roman->equals($roman1));
    }

    public function testCompareLessThan()
    {
        $roman = new RomanNumeral('IV');
        $roman1 = new RomanNumeral('LVI');
        $this->assertSame($roman->compare($roman1), -1);
    }

    public function testCompareEquals()
    {
        $roman = new RomanNumeral('MXXXIV');
        $roman1 = new RomanNumeral('MXXXIV');
        $this->assertSame($roman->compare($roman1), 0);
    }

    public function testCompareGreaterThan()
    {
        $roman = new RomanNumeral('MXXXIV');
        $roman1 = new RomanNumeral('CXXIII');
        $this->assertSame($roman->compare($roman1), 1);
    }
}

?>