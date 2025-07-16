<?php 

class Calculator{
    public function add($a, $b)
    {
        return $a + $b;
    }
    public function divide($a, $b)
    {
        if($b === 0)
        {
            throw new InvalidArgumentException("Division par Zéro");
        }
        return $a / $b;
    }
}