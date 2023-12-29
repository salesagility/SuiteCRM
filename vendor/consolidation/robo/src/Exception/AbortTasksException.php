<?php

namespace Robo\Exception;

/**
 * By default, rollbacks and completions tasks or callbacks continue even if
 * errors occur. If you would like to explicitly cancel or abort the rollback or
 * completion, you may throw this exception to abort the subsequent tasks in the
 * rollback or completion task list.
 */
class AbortTasksException extends \Exception
{

}
