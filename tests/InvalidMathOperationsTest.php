<?php
namespace PhpNwSykes\Tests;

use PhpNwSykes\InvalidNumeral;
use PhpNwSykes\RomanNumeral;
use PHPUnit\Framework\TestCase;

class InvalidMathOperationsTest extends TestCase
{
    /**
     * @param $numeral
     * @param $testValue
     * @dataProvider badMappings
     */
    public function testAddValueInvalidOutput($numeral, $testValue)
    {
        $this->expectException(InvalidNumeral::class);
        $roman = new RomanNumeral($numeral);
        $roman1 = $testValue;
        $roman->add($roman1);
    }
 
    /**
     * @param $numeral
     * @param $testValue
     * @dataProvider badMappings
     */
    public function testSubtractValueInvalidOutput($numeral, $testValue)
    {
        $this->expectException(InvalidNumeral::class);
        $roman = new RomanNumeral($numeral);
        $roman1 = $testValue;
        $roman->subtract($roman1);
    }
  
    /**
     * @param $numeral
     * @param $testValue
     * @dataProvider badMappings
     */      
    public function testSubtractValueInvalidNegativeOutput($numeral, $testValue)
    {
        $this->expectException(InvalidNumeral::class);
        $roman = new RomanNumeral($numeral);
        $roman1 = $testValue;
        $roman->subtract($roman1);
    }     

    /**
     * @param $numeral
     * @param $testValue
     * @dataProvider badMappings
     */
    public function testMultiplyValueInvalidOutput($numeral, $testValue)
    {
        $this->expectException(InvalidNumeral::class);
        $roman = new RomanNumeral($numeral);
        $roman1 = $testValue;
        $roman->multiply($roman1);
    }

    /**
     * @param $numeral
     * @param $testValue
     * @dataProvider badMappings
     */
    public function testDivideValueInvalidOutput($numeral, $testValue)
    {
        $this->expectException(InvalidNumeral::class);
        $roman = new RomanNumeral($numeral);
        $roman1 = $testValue;
        $roman->divide($roman1);
    }

    public function badMappings(): array
    {
        return [
            ['XXI', 'Bad'],
            ['XXI', 'XI Something'],
            ['XXI', 'Something MM'],
            ['XXI', '-X'],
            ['XXI', 4]
        ];
    }

    public function testDivideValueLessThanOneInvalidOutput()
    {
        $this->expectException(InvalidNumeral::class);
        $roman = new RomanNumeral('I');
        $roman1 = new RomanNumeral('XX');
        $roman->divide($roman1);
    }
}

?>