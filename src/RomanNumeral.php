<?php
namespace PhpNwSykes;

class RomanNumeral
{
    protected $symbols = [
        1000 => 'M',
        500 => 'D',
        100 => 'C',
        50 => 'L',
        10 => 'X',
        5 => 'V',
        1 => 'I',
    ];

    protected $romanToInteger = [
        "I" => 1,
        "V" => 5,
        "X" => 10,
        "L" => 50,
        "C" => 100,
        "D" => 500,
        "M" => 1000 
    ];

    protected $numeral;

  
    public function __construct(string $romanNumeral)
    {
        $this->numeral = $romanNumeral;
    }


    /**
     * Allows numeral to be implicitly converted to a string.
     * 
     * @return string The value of the Roman Numeral.
     */
    public function __toString() 
    {
        return $this->numeral;
    }

    /**
     * Tests if a value passed to a function is a valid
     * Roman Numeral.
     * 
     * @return bool True if the value is a RomanNumeral object,
     *              otherwise false.
     */
    private function isRomanNumeral($toTest):bool {
        if(!is_object($toTest)) {
            return false;
        } 
        else if (get_class($this)!==get_class($toTest) ) {
            return false;
        }
        return true;
    }


    /**
     * Adds the value of a roman numeral to this numeral, and
     * returns the modified object.
     *  
     * @param RomanNumeral $roman A RomanNumeral object. 
     * @return RomanNumeral The modified object.
     * @throws InvalidNumeral on failure (when numeral cannot be added)
     */
    public function add($roman): RomanNumeral  
    {
        if($this->isRomanNumeral($roman) == false) {
            throw new InvalidNumeral('Invalid Roman Numeral!');
        }
        try {
            $currentValue = $this->toInt();
            $toAdd = $roman->toInt();
            $result = $currentValue + $toAdd;
            $this->setFromInt($result);

            return $this;
        }
        catch (Exception $e) {
            throw new InvalidNumeral('Cannot add this value to the numeral!');
        }
    }


    /**
     * Subtracts the value of a roman numeral from this numeral.
     *  
     * @param RomanNumeral $roman A RomanNumeral object. 
     * @return RomanNumeral The modified object.
     * @throws InvalidNumeral on failure (when numeral cannot be subtracted)
     */
    public function subtract($roman): RomanNumeral  
    {
        if($this->isRomanNumeral($roman) == false) {
            throw new InvalidNumeral('Invalid Roman Numeral!');
        }
        try {
            $currentValue = $this->toInt();
            $toSubtract = $roman->toInt();

            if($toSubtract >= $currentValue) {
                throw new InvalidNumeral('Result cannot be negative or zero!');
            }

            $result = $currentValue - $toSubtract;
            $this->setFromInt($result);

            return $this;
        }
        catch (Exception $e) {
            throw new InvalidNumeral('Cannot subtract this value from the numeral!');
        }
    }


    /**
     * Multiplies the numeral by the value of a roman numeral.
     *  
     * @param RomanNumeral $roman A RomanNumeral object. 
     * @return RomanNumeral The modified object.
     * @throws InvalidNumeral on failure (when numeral cannot be multiplied)
     */
    public function multiply($roman): RomanNumeral 
    {
        if($this->isRomanNumeral($roman) == false) {
            throw new InvalidNumeral('Invalid Roman Numeral!');
        }
        try {
            $currentValue = $this->toInt();
            $multiplier = $roman->toInt();
            $result = $currentValue * $multiplier;
            $this->setFromInt($result);

            return $this;
        }
        catch (Exception $e) {
            throw new InvalidNumeral('Cannot multiply the numeral by this value!');
        }
    }


    /**
     * Divides the numeral by the value of a roman numeral.
     * (Rounded to the nearest valid numeral.)
     * 
     * @param RomanNumeral $roman A RomanNumeral object. 
     * @return RomanNumeral The modified object.
     * @throws InvalidNumeral on failure (when numeral cannot be divided,
     *                        or the result is zero.)
     */
    public function divide($roman): RomanNumeral 
    {
        if($this->isRomanNumeral($roman) == false) {
            throw new InvalidNumeral('Invalid Roman Numeral!');
        }
        try {  
          $currentValue = $this->toInt();

          $divisor = $roman->toInt();
          $result = round($currentValue / $divisor);

          /** Roman numerals have no number for zero and no decimal point concept */
          if( $result < 1)  {
            throw new InvalidNumeral('Dividing by this value does not produce a valid numeral!');
          }

          $this->setFromInt($result);

          return $this;
        }
        catch (Exception $e) {
            throw new InvalidNumeral('Cannot divide the numeral by this value!');
        }
    }


    /**
     * Tests if this Roman numeral is equal to another.
     *  
     * @param RomanNumeral $roman A RomanNumeral object.
     * @return boolean True if $roman is equal to this numeral, otherwise false.
     * @throws InvalidNumeral on failure (when a numeral is invalid)
     */
    public function equals($roman):bool
    {
        if($this->isRomanNumeral($roman) == false) {
            throw new InvalidNumeral('Invalid Roman Numeral!');
        }
        try {
            return $this->toInt() === $roman->toInt();
        }
        catch (Exception $e) {
            throw new InvalidNumeral('Invalid Roman Numeral!');
        }
    }


    /**
     * Tests if this Roman numeral is equal to another.
     *  
     * @param RomanNumeral $roman A RomanNumeral object.
     * @return int -1 if this numeral is less than $roman,
     *              0 if it is equal to $roman,
     *              1 if it is greater than $roman.
     * @throws InvalidNumeral on failure (when a numeral is invalid)
     */
    public function compare($roman):int
    {
        if($this->isRomanNumeral($roman) == false) {
            throw new InvalidNumeral('Invalid Roman Numeral!');
        }
        try {
          $a = $this->toInt();
          $b = $roman->toInt();

          if($a==$b) {
              return 0;
          } else if ($a<$b) {
              return -1;
          } else {
              return 1;
          }
      }
      catch (Exception $e) {
          throw new InvalidNumeral('Cannot compare value to this numeral!!');
      }
    }

  
    /** @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
     *      Functions to convert the numeral to an integer
     *  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    /**
     * Tests if a character is a valid Roman Numeral character,
     * and if it is a correct position (e.g., 'VVXVV. is invalid, and
     * so is 'FALSENUMBER')
     * 
     * @param string $current The numeral being tested
     * @param string $prev The character preceding it in $numeral
     * @return true if valid, otherwise false.
     * @dataProvider isValidRomanNumeral
     */
    private function isValidNextNumeral($current, $prev): bool
    {
        $result = false;
        switch($prev) {
          case "I":
            $result = (strpos("IVX", $current)!==false);
            break;
          case "V":
            $result = (strpos("I", $current)!==false);
            break;
          case "X":
            $result = (strpos("IVXLC", $current)!==false);
            break;
          case "L":
            $result = (strpos("IVX", $current)!==false);
            break;
          case "C":
            $result = (strpos("IVXLCDM", $current)!==false);
            break;
          case "D":
            $result = (strpos("IVXC", $current)!==false);
            break;
          case "M":
            $result = true;
            break;
          default:
            break;
        }
      
        return $result;
      }


    /**
     * Tests if $this->numeral is a valid Roman Numeral.
     * 
     * @return boolean true if valid, otherwise false.
     */
    private function isValidRomanNumeral():bool
    {
      if(strlen($this->numeral)==0) {
          return false;
      }

      $firstCharacter = $this->numeral[0];

      // Test the first character against 'M'. (It will only fail
      // if it is not a valid character.)
      if($this->isValidNextNumeral($firstCharacter, "M")==false) {
          return false;
      }
      
      $prev = $firstCharacter;

      // Test the other characters in the numeral string
      for($i=1; $i<strlen($this->numeral); $i++) {
        $current = $this->numeral[$i];

        if($this->isValidNextNumeral($current, $prev)==false) {
          return false;
        }
      }  

      return true;
    }


    /**
     * Converts a roman numeral such as 'X' to a number, 10
     *
     * @throws InvalidNumeral on failure (when a numeral is invalid)
     */
    public function toInt():int
    { 
        if($this->isValidRomanNumeral()==false) {
            throw new InvalidNumeral('Invalid Roman Numeral!');
        }

        $previous = 0;
        $total = 0;
      
        for($i=0; $i<strlen($this->numeral); $i++) {
            $current = $this->romanToInteger[$this->numeral[$i]];
        
            if($previous==0) {
                $total+=$current;
            }
            else if($current > $previous) {
                $total+=$current;
                $total-=$previous*2;
            } 
            else {
                $total+=$current;
            }
        
            $previous=$current;
        }  

        return $total;
    }


    /** @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
     *      Functions to create the numeral from an integer
     *  @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ */

    /**
     * Tests if a number can be converted to a valid Roman Numeral.
     * 
     * @param int $toTest The number to be tested.
     * @return true if valid, otherwise false.
     * @dataProvider setFromInt
     */
    private function isValidNumber($toTest):bool
    {
      if(strlen($toTest)===0) {
          return false;
      }

      // A valid number cannot start with zero, and cannot be signed.
      if(preg_match('!^[1-9][0-9]*$!', $toTest)) {
          return true;
      } 
      else {
          return false;
      }
    }


    /**
     * Converts digits from a number to Roman Numerals.
     * 
     * @param int $toConvert The digits to be converted.
     * @return string Roman numerals representing the digits.     
     * @throws InvalidNumeral on failure (when numeral cannot be converted.)
     * @dataProvider setFromInt
     */
    private function convertDigitsToRomanNumerals($toConvert) {         
      $result = "INVALID";

      try {
        switch(true) {
            case ($toConvert < 4):
                $result = str_repeat($this->symbols[1],$toConvert);
                break;
            case ($toConvert == 4):
                $result = $this->symbols[1] . $this->symbols[5];
                break;
            case ($toConvert == 5):
                $result =  $this->symbols[5];
                break;
            case ($toConvert == 9):
                $result =  $this->symbols[1] . $this->symbols[10];
                break;
            case ($toConvert < 9):
                $result = $this->symbols[5] . str_repeat($this->symbols[1],($toConvert-5));
                break;
            case ($toConvert < 40):
                $firstNumber = $toConvert/10;
                $result = str_repeat($this->symbols[10],$firstNumber);
                break;
            case ($toConvert == 40):
                $result = $this->symbols[10] . $this->symbols[50];
                break;
            case ($toConvert == 50):
                $result =  $this->symbols[50];
                break;
            case ($toConvert == 90):
                $result =  $this->symbols[10] . $this->symbols[100];
                break;
            case ($toConvert < 90):
                $firstNumber = $toConvert/10;
                $result = $this->symbols[50] . str_repeat($this->symbols[10],$firstNumber-5);
                break;
            case ($toConvert < 400):
                $firstNumber = $toConvert/100;
                $result = str_repeat($this->symbols[100],$firstNumber);
                break;
            case ($toConvert == 400):
                $result = $this->symbols[100] . $symbols[500];
                break;
            case ($toConvert == 500):
                $result =  $this->symbols[500];
                break;
            case ($toConvert == 900):
                $result =  $this->symbols[100] . $this->symbols[1000];
                break;
            case ($toConvert < 900):
                $firstNumber = $toConvert/100;
                $result = $this->symbols[500] . str_repeat($this->symbols[100],($firstNumber-5));
                break;
            case ($toConvert >= 1000):
                $firstNumbers = $toConvert/1000;
                $result = str_repeat($this->symbols[1000],$firstNumbers);
                break;
            default:
                break;
        }

        return $result;
      }
      catch (InvalidNumeral $e) {
          throw new InvalidNumeral('Cannot create a numeral from this value!');
      } 
    }


    /**
     * Allows numeral to be created from an integer.
     *
     * @param int $num The value to create the numeral from.
     * @throws InvalidNumeral on failure (when a numeral is invalid)
     */
    public function setFromInt($num) {
      $toConvert = $num;

      if($this->isValidNumber($toConvert)==false) {
          throw new InvalidNumeral('Cannot create a numeral from this value!');
      }
  
      $result = "";
      $divisor = 10;

      try {
          while($divisor<10000) {
              $remainder = $toConvert % $divisor;
              $result = $this->convertDigitsToRomanNumerals($remainder) . $result;
              $toConvert -= $remainder;
              $divisor *= 10;
          }

          if($toConvert>=1000) {
              $result = $this->convertDigitsToRomanNumerals($toConvert) . $result;
          }

          $this->numeral = $result;        
      }
      catch (InvalidNumeral $e) {
          throw new InvalidNumeral('Cannot create a numeral from this value!');
      }
    }

}

?>
