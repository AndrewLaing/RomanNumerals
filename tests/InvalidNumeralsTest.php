<?php
namespace PhpNwSykes\Tests;

use PhpNwSykes\InvalidNumeral;
use PhpNwSykes\RomanNumeral;
use PHPUnit\Framework\TestCase;

class InvalidNumeralsTest extends TestCase
{
    /**
     * @param $numeral
     * @dataProvider badMappings
     */
    public function testInvalidOutput($numeral)
    {
        $this->expectException(InvalidNumeral::class);
        $roman = new RomanNumeral($numeral);
        $roman->toInt();
    }

    public function badMappings(): array
    {
        return [
            ['Bad'],
            ['XI Something'],
            ['Something MM'],
            ['-X'],
            ['VIM']
        ];
    }

    /**
     * @param $number The value to set the numeral to
     * @dataProvider fromIntBadMapping
     */
    public function testSetFromIntInvalidOutput($number)
    {
        $this->expectException(InvalidNumeral::class);
        $roman = new RomanNumeral('');
        $roman->setFromInt($number);
    }

    public function fromIntBadMapping()
    {
        return [
            ["Bad"],
            [0.132],
            [-1210]
        ];
    }
}
