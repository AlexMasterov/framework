<?php

namespace Equip\Contract;

use Equip\Adr\PayloadInterface;

interface ActionInterface
{
    /**
     * @param array $input
     *
     * @return PayloadInterface
     */
    public function __invoke(array $input): PayloadInterface;
}
