<?php
/**
 * @author      Wizacha DevTeam <dev@wizacha.com>
 * @copyright   Copyright (c) Wizacha
 * @license     Proprietary
 */
declare(strict_types=1);

namespace Wizaplace\Atoum\Slicer;

use atoum\atoum\scripts\runner;

class Command extends runner
{
    /** @var SlicerRunner */
    protected $runner;

    public function __construct($name)
    {
        parent::__construct($name, null, null);

        $this->runner = new SlicerRunner();

        $this->addArgumentHandler(
            function (Command $runner, string $argument, array $values): void {
                $this->setSliceArguments($values);
            },
            ['-s', '--slices'],
            null,
            $this->locale->_('Atoum slicer')
        );
    }

    protected function setSliceArguments(array $values): void
    {
        $parts = [];
        if (!preg_match('/^([0-9]+)\/([0-9]+)$/', $values[0], $parts)) {
            echo '--slices: you must provide a value like 2/4 if you want to run the second slice on a total of 4';
            exit(1);
        }
        $currentSlice = (int) $parts[1];
        $totalSlices = (int) $parts[2];
        if ($currentSlice > $totalSlices) {
            echo '--slices: current slice must be <= total slices';
            exit(1);
        }
        if ($totalSlices < 1 || $currentSlice < 1) {
            echo '--slices: the two values must be > 0';
            exit(1);
        }

        $this->runner->setCurrentSlice($currentSlice);
        $this->runner->setTotalSlices($totalSlices);
    }

    public function getRunner(): SlicerRunner
    {
        return $this->runner;
    }
}
