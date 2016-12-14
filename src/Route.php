<?php

namespace Equip;

use Equip\Input;
use Equip\Responder\ChainedResponder;

class Route
{
    /**
     * The action specification.
     *
     * @var ActionInterface
     */
    protected $action;

    /**
     * The input specification.
     *
     * @var InputInterface
     */
    protected $input = Input::class;

    /**
     * The responder specification.
     *
     * @var ResponderInterface
     */
    protected $responder = ChainedResponder::class;

    /**
     * @inheritDoc
     */
    public function __construct(
        $action,
        $input = null,
        $responder = null
    ) {
        $this->action = $action;

        if ($input) {
            $this->input = $input;
        }

        if ($responder) {
            $this->responder = $responder;
        }
    }

    /**
     * Returns the action specification.
     *
     * @return ActionInterface
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Returns the input specification.
     *
     * @return InputInterface
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * Returns the responder specification.
     *
     * @return ResponderInterface
     */
    public function getResponder()
    {
        return $this->responder;
    }
}
