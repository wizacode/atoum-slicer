<?php
/**
 * @author      Wizacha DevTeam <dev@wizacha.com>
 * @copyright   Copyright (c) Wizacha
 * @license     Proprietary
 */
declare(strict_types=1);

namespace Wizaplace\Test\Atoum\Slicer;

use PHPUnit\Framework\TestCase;
use Wizaplace\Atoum\Slicer\Command;
use Wizaplace\Atoum\Slicer\SlicerRunner;

class RunnerTest extends TestCase
{
    public function testDefaultRunner(): void
    {
        static::assertCount(5, $this->getRunner()->getDeclaredTestClasses());
    }

    /**
     * @dataProvider sliceArgument
     * @param int $excepted
     * @param string $slices
     */
    public function testSetRunnerWithArguments(int $excepted, string $slices): void
    {
        static::assertCount(
            $excepted,
            $this->getRunner(['--slices', $slices])->getDeclaredTestClasses()
        );
    }

    public function sliceArgument(): array
    {
        return [
            [3, '1/2'],
            [2, '2/2'],
            [1, '1/5'],
            [1, '2/5'],
        ];
    }

    private function getRunner(array $arguments = []): SlicerRunner
    {
        return (new Command('test'))
            ->run(array_merge(['-d' , 'tests/', '-udr', '-ncc'], $arguments))
            ->getRunner()
        ;
    }


}
