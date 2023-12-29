<?php

namespace League\Event;

class Generator implements GeneratorInterface
{
    use GeneratorTrait {
        addEvent as public;
    }
}
