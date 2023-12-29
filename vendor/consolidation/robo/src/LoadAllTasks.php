<?php

namespace Robo;

trait LoadAllTasks
{
    use TaskAccessor;

    use Collection\Tasks;

    // standard tasks
    use Task\Base\Tasks;
    use Task\Development\Tasks;
    use Task\Filesystem\Tasks;
    use Task\File\Tasks;
    use Task\Archive\Tasks;
    use Task\Vcs\Tasks;
    use Task\Logfile\Tasks;

    // package managers
    use Task\Composer\Tasks;
    use Task\Bower\Tasks;
    use Task\Npm\Tasks;

    // assets
    use Task\Assets\Tasks;

    // 3rd-party tools
    use Task\Remote\Tasks;
    use Task\Testing\Tasks;
    use Task\ApiGen\Tasks;
    use Task\Docker\Tasks;

    // task runners
    use Task\Gulp\Tasks;

    // shortcuts
    use Task\Base\Shortcuts;
    use Task\Filesystem\Shortcuts;
    use Task\Vcs\Shortcuts;
    use Task\Logfile\Shortcuts;
}
