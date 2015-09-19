<?php

namespace spec\Http\Client\Exception;

use PhpSpec\ObjectBehavior;

class RuntimeExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Http\Client\Exception\RuntimeException');
    }

    function it_is_runtime_exception()
    {
        $this->shouldHaveType('RuntimeException');
    }

    function it_is_exception()
    {
        $this->shouldImplement('Http\Client\Exception');
    }
}