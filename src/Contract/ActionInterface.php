<?php

namespace Equip\Contract;

interface ActionInterface
{
    /**
     * @param array $input
     *
     * @return PayloadInterface
     */
    public function __invoke(array $input);
}
