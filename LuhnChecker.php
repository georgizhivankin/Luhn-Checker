<?php namespace Zhivanking\Luhn;

/**
 *
 * @author Georgi Zhivankin
 * @version 0.1
 *
 *          This Luhn checker checks whether a supplied number conforms to the Luhn algorithm <https://en.wikipedia.org/wiki/Luhn_algorithm>
 */
class LuhnChecker
{

    /**
     *
     * @param int $number
     */
    public function checkNumber($number)
    {

        // Get checksum
        $checksum = substr($number, -1);

        // Reverse number
        $number = strrev($number);

        // Go through the number and double each second digit
        for($i = strlen($number) - 1; $i >= 0; $i = $i - 2)
        {

            // Sum the digits
            $summedDigit = $number[$i] + $number[$i];

            // If the sum of digits is greater than 9, split it in two and sum it into a single digit
            if ($summedDigit > 9)
            {

                // Split the digit by two and sum it again
                $splittedDigit = str_split($summedDigit);

                $summedDigit = $splittedDigit[0] + $splittedDigit[1];
            }

            // Replace the summed digit within the number
            $number[$i] = $summedDigit;
        }

        // Add all digits from the number together (except the first one which is our original checksum)
        $finalNumber = 0;
        for($j = 1; $j <= strlen($number) - 1; $j++)
        {
            $finalNumber = $finalNumber + $number[$j];
        }

        // Multiply the number by 9 and modulo by 10 which would give the new checksum
        $newChecksum = ($finalNumber * 9) % 10;

        // Check if both checksums match
        if ($checksum == $newChecksum)
        {

            return true;
        }
        else
        {

            return false;
        }
    }
}

/**
 * Example usage
 */
$luhn = new LuhnChecker();

// Number that does not conform to the Luhn algorithm
$numberToCheck = '5809096721';
if ($luhn->checkNumber($numberToCheck))
{
    echo "Supplied number: " . $numberToCheck . " conforms to the Luhn algorithm.<br>";
}
else
{
    echo "Supplied number: " . $numberToCheck . " does not conform to the Luhn algorithm.<br>";
}

// Number that conforms to the luhn algorithm
$numberToCheck = '4242424242424242';
if ($luhn->checkNumber($numberToCheck))
{
    echo "Supplied number: " . $numberToCheck . " conforms to the Luhn algorithm.<br>";
}
else
{
    echo "Supplied number: " . $numberToCheck . " does not conform to the Luhn algorithm.<br>";
}