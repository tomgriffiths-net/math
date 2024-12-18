<?php
class math{
    public static function getClosest($closeNumber,$numberArray){
        $closest = null;
        foreach ($numberArray as $item) {
            if($closest === null || abs($closeNumber - $closest) > abs($item - $closeNumber)) {
                $closest = $item;
            }
        }
        return $closest;
    }
    public static function tension_smooth_pulley(float $A_mass_kg, float $B_mass_kg, float $gravity = 9.81):float{
        $accel = self::acceleration_smooth_pulley($A_mass_kg,$B_mass_kg,$gravity);
        $ma = $B_mass_kg * $accel;
        $bg = $B_mass_kg * $gravity;
        $t = 0;
        if($A_mass_kg > $B_mass_kg){
            $t = $ma + $bg;
        }
        elseif($B_mass_kg > $A_mass_kg){
            $t = $bg - $ma;
        }

        return (float) $t;

    }
    public static function acceleration_smooth_pulley(float $A_mass_kg, float $B_mass_kg, float $gravity = 9.81):float{
        $A = $A_mass_kg * $gravity;
        $B = $B_mass_kg * $gravity;
        if($A > $B){
            $Fsum = $A - $B;
        }
        elseif($B > $A){
            $Fsum = $B - $A;
        }
        else{
            return (float) 0;
        }
        $accelCoeff = $A_mass_kg + $B_mass_kg;
        $accel = $Fsum / $accelCoeff;

        return (float) $accel;

    }
    public static function average(array $numbers):float{
        $count = count($numbers);
        $total = 0;

        foreach($numbers as $number){
            $total += $number;
        }

        if($count > 0){
            return $total / $count;
        }
        return 0;
    }
    public static function isDevisibleByList(int $number, array $list):int|false{
        foreach($list as $num){
            if(!is_int($num)){
                return false;
            }
            if($number%$num === 0){
                return $num;
            }
        }
        return false;
    }
    public static function primes($max=100):array{
        $list = array();
        $numbers = self::numbers(2,$max);
        foreach($numbers as $number){
            if(self::isDevisibleByList($number,self::numbers(2,$number-1)) === false){
                $list[] = $number;
            }
        }
        return $list;
    }
    public static function numbers(int $min=1, int $max=100):array{
        $list = array();
        for($i = $min; $i <= $max; $i ++){
            $list[] = $i;
        }
        return $list;
    }
    public static function primeFactors(int $number):array{
        $primeFactors = array();
        $currentNumber = $number;
        $primes = self::primes($number);
        while(true){
            if(in_array($currentNumber,$primes)){
                $primeFactors[] = $currentNumber;
                break;
            }
            $devide = self::isDevisibleByList($currentNumber,$primes);
            if(!is_int($devide)){
                break;
            }
            $currentNumber = $currentNumber/$devide;
            $primeFactors[] = $devide;
        }
        return $primeFactors;
    }
    public static function totient(int $number):int{
        $primeFactors = self::primeFactors($number);
    
        foreach($primeFactors as $index => $primeFactor){
            if(isset($primeFactors[$index-1])){
                if($primeFactors[$index-1] === $primeFactor){
                    unset($primeFactors[$index]);
                }
            }
        }
    
        $currentNumber = $number;
        foreach($primeFactors as $primeFactor){
            $currentNumber = $currentNumber * ($primeFactor -1);
        }
    
        $devide = 1;
        foreach($primeFactors as $primeFactor){
            $devide = $devide * $primeFactor;
        }
        return $currentNumber / $devide;
    }
}