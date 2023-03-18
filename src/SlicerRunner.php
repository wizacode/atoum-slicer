<?php
/**
 * @author      Wizacha DevTeam <dev@wizacha.com>
 * @copyright   Copyright (c) Wizacha
 * @license     Proprietary
 */
declare(strict_types=1);

namespace Wizaplace\Atoum\Slicer;

use atoum\atoum\runner;

class SlicerRunner extends runner
{
    /**
     * @var int
     */
    private $currentSlice = 0;

    /**
     * @var int
     */
    private $totalSlices = 0;

    public function getCurrentSlice(): int
    {
        return $this->currentSlice;
    }

    public function setCurrentSlice(int $currentSlice): self
    {
        $this->currentSlice = $currentSlice;

        return $this;
    }

    public function getTotalSlices(): int
    {
        return $this->totalSlices;
    }

    public function setTotalSlices(int $totalSlices): self
    {
        $this->totalSlices = $totalSlices;

        return $this;
    }

    public function hasNotSlices(array $tests): bool
    {
        return 0 === count($tests) || 0 === $this->getTotalSlices();
    }

    public function getDeclaredTestClasses($testBaseClass = null): array
    {
        $tests = parent::findTestClasses($testBaseClass);

        if ($this->hasNotSlices($tests)) {
            return $tests;
        }

        $limit = (int) ceil(count($tests) / $this->getTotalSlices());

        return array_slice(
            $tests,
            $limit * ($this->getCurrentSlice() - 1),
            $limit
        );
    }
}
