<?php

namespace App\Traits;

trait GetChangePercent
{
    // MARK: forgetCache
    public function getChangePercent(int $currentCount, int $previousCount): float
    {
        if ($previousCount == 0) {
            return 0;
        }

        return round((($currentCount - $previousCount) / $previousCount) * 100, 2);
    }
}
