<?php
namespace App\Service;

final class PointsCalculator
{
    public function calculate(float $amount): int
    {
        return ((int) floor($amount / 100)) * 10;
    }
}
