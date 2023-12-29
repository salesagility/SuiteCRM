<?php

namespace Robo\Common;

/**
 * This task specifies exactly one shell command.
 * It can take additional arguments and options as config parameters.
 */
trait ExecOneCommand
{
    use ExecCommand;
    use CommandArguments;
}
