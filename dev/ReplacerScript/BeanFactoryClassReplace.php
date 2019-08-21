<?php

$moduleClassList = [
    'Leads' => 'Lead',
];

try {
    ini_set('memory_limit', '512M');

    $basePath = dirname(dirname(__DIR__));

    chdir($basePath);

    echo <<<EOT
<style>
pre 
{
    background: #f5f5f5;
    padding: 15px 20px;
    border-radius: 8px;
    display: inline-block;
}
</style>
EOT;

    ob_start();

    $directories = new \RecursiveDirectoryIterator(
        $basePath
    );

    $filteredDirectories = new \RecursiveCallbackFilterIterator(
        $directories,
        function (\SplFileInfo $current, $key, RecursiveDirectoryIterator $iterator) {
            if (!$current->isReadable()) {
                return false;
            }

            if ($current->isDir() && $iterator->hasChildren()) {
                return strpos(basename($key), '.') === false;
            }

            $current->getExtension();

            if (!$current->isFile()) {
                return false;
            }
            
            return $current->getExtension() === 'php';
        }
    );

    $recursiveDirectoryIterator = new \RecursiveIteratorIterator(
        $filteredDirectories
    );

    $searchList = [];

    $replaceList = [];

    $classList = [];

    foreach ($moduleClassList as $beanName => $className) {
        $searchList[] = sprintf(
            'new %s()',
            $className
        );

        $replaceList[] = sprintf(
            'BeanFactory::newBean(\'%s\')',
            $beanName
        );

        $classList[] = $className;
    }

    $fileCount = 0;

    $updatedFileCount = 0;

    $totalOccurrences = 0;

    $totalOccurrencesFound = [];

    foreach ($recursiveDirectoryIterator as $file) {
        $fileCount++;

        if (!$file->isFile()) {
            continue;
        }

        $fileContents = file_get_contents($file->getRealPath());

        if ($fileContents === false) {
            throw new \RuntimeException(
                sprintf(
                    'Failed to read from: &apos;%s&apos;',
                    $file->getRealPath()
                ),
                400
            );
        }

        $occurrencesFound = [];

        foreach ($searchList as $searchString) {
            $occurrences = substr_count($fileContents, $searchString);

            if ($occurrences > 0) {
                $totalOccurrences += $occurrences;

                $occurrencesFound[] = [
                    'searchString' => $searchString,
                    'count' => $occurrences,
                ];

                $totalOccurrencesFound[$searchString] += $occurrences;
            }
        }

        if (empty($occurrencesFound)) {
            continue;
        }

        $fileContents = str_replace(
            $searchList,
            $replaceList,
            $fileContents
        );

        $success = file_put_contents($file->getRealPath(), $fileContents);

        if (function_exists('opcache_invalidate')) {
            opcache_invalidate($file->getRealPath());
        }

        sleep(1);

        if ($success === false) {
            throw new \RuntimeException(
                sprintf(
                    'Failed to write to: &apos;%s&apos;',
                    $file->getRealPath()
                ),
                400
            );
        }

        echo sprintf(
            '<h4>%s - File: &apos;%s&apos;</h4>',
            ++$updatedFileCount,
            $file->getRealPath()
        );

        echo sprintf(
            '<p>Found occurrence(s) of %s search string(s):</p>',
            count($occurrencesFound)
        );

        foreach ($occurrencesFound as $occurrenceFound) {
            echo sprintf(
                '<p>%s occurrence(s) of &apos;%s&apos;</p>',
                $occurrenceFound['count'],
                $occurrenceFound['searchString']
            );
        }

        $commitCommand = <<<EOT
git -c user.name="www-data" -c user.email="jason.dang@salesagility.com" \

EOT;

        $commitCommand .= <<<EOT
commit -m "PHP Commit - BeanFactory Extend Core Modules" \

EOT;

        $commitMessageLine = <<<EOT
-m "Replace explicit module class instantiations for below module list in file: %s." \

EOT;

        $commitCommand .= sprintf(
            $commitMessageLine,
            $file->getRealPath()
        );

        $commitModuleListItemLine = <<<EOT
-m "- %s" \
EOT;

        $moduleClassCount = 0;

        foreach ($occurrencesFound as $occurrenceFound) {
            $commitModuleListItem = sprintf(
                $commitModuleListItemLine,
                str_replace(
                    ['new ', '()'],
                    '',
                    $occurrenceFound['searchString']
                )
            );


            if (++$moduleClassCount === count($moduleClassList)) {
                $commitModuleListItem = rtrim($commitModuleListItem, '\\');
            }

            $commitCommand .= $commitModuleListItem;
        }

        echo sprintf(
            '<pre>%s</pre>',
            $commitCommand
        );

        shell_exec('git add .');

        $commitOutput = shell_exec($commitCommand);

        echo sprintf(
            '<p>%s</p>',
            $commitOutput
        );

        ob_end_flush();
        ob_flush();
        flush();
        ob_start();
    }

    echo '<p>Done Diddly Done.</p>';

    echo sprintf(
        '<p>Found %s total occurrence(s) of %s search string(s) in %s of %s files.</p>',
        $totalOccurrences,
        count($totalOccurrencesFound),
        $updatedFileCount,
        $fileCount
    );
} catch (Throwable $throwable) {
    echo '<p>Error Encountered...</p>';

    echo sprintf(
        '<p>Code: %s</p>',
        $throwable->getCode()
    );

    echo sprintf(
        '<p>Message: %s</p>',
        $throwable->getMessage()
    );

    echo sprintf(
        '<p>File: %s</p>',
        $throwable->getFile()
    );

    echo sprintf(
        '<p>Line: %s</p>',
        $throwable->getLine()
    );

    echo sprintf(
        '<p>Trace: %s</p>',
        $throwable->getTraceAsString()
    );
}
