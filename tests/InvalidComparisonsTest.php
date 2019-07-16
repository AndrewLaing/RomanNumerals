<?php
namespace PhpNwSykes\Tests;

use PhpNwSykes\InvalidNumeral;
use PhpNwSykes\RomanNumeral;
use PHPUnit\Framework\TestCase;

class InvalidComparisonsTest extends TestCase
{
    public function testEqualsStringInvalidOutput()
    {
        $this->expectException(InvalidNumeral::class);
        $roman = new RomanNumeral('XXV');
        $roman1 = "HUNDRED";
        $roman->equals($roman1);
    }

    public function testEqualsIntInvalidOutput()
    {
        $this->expectException(InvalidNumeral::class);
        $roman = new RomanNumeral('XXV');
        $roman1 = 25;
        $roman->equals($roman1);
    }

    public function testCompareStringInvalidOutput()
    {
        $this->expectException(InvalidNumeral::class);
        $roman = new RomanNumeral('XXV');
        $roman1 = "HUNDRED";
        $roman->compare($roman1);
    }

    public function testCompareIntInvalidOutput()
    {
        $this->expectException(InvalidNumeral::class);
        $roman = new RomanNumeral('XXV');
        $roman1 = 25;
        $roman->compare($roman1);
    }
}

?>