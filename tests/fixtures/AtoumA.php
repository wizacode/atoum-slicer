<?php
/**
 * @author      Wizacha DevTeam <dev@wizacha.com>
 * @copyright   Copyright (c) Wizacha
 * @license     Proprietary
 */
declare(strict_types=1);

namespace Wizaplace\Atoum\Slicer\tests\units;

use atoum\atoum\test;

\error_reporting(0);

class AtoumA extends test
{
    public function testOne()
    {
        $this->array(['foo'])->contains('foo');
    }

    public function testTwo()
    {
        $this->array(['foo'])->contains('foo');
    }
}
