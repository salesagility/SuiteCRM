<?php
namespace Consolidation\AnnotatedCommand\Parser\Internal;

class FullyQualifiedClassCache
{
    protected $classCache = [];
    protected $namespaceCache = [];

    public function qualify($filename, $className)
    {
        $this->primeCache($filename, $className);
        return $this->cached($filename, $className);
    }

    protected function cached($filename, $className)
    {
        return isset($this->classCache[$filename][$className]) ? $this->classCache[$filename][$className] : $className;
    }

    protected function primeCache($filename, $className)
    {
        // If the cache has already been primed, do no further work
        if (isset($this->namespaceCache[$filename])) {
            return false;
        }

        $handle = fopen($filename, "r");
        if (!$handle) {
            return false;
        }

        $namespaceName = $this->primeNamespaceCache($filename, $handle);
        $this->primeUseCache($filename, $handle);

        // If there is no 'use' statement for the className, then
        // generate an effective classname from the namespace
        if (!isset($this->classCache[$filename][$className])) {
            $this->classCache[$filename][$className] = $namespaceName . '\\' . $className;
        }

        fclose($handle);
    }

    protected function primeNamespaceCache($filename, $handle)
    {
        $namespaceName = $this->readNamespace($handle);
        if (!$namespaceName) {
            return false;
        }
        $this->namespaceCache[$filename] = $namespaceName;
        return $namespaceName;
    }

    protected function primeUseCache($filename, $handle)
    {
        $usedClasses = $this->readUseStatements($handle);
        if (empty($usedClasses)) {
            return false;
        }
        $this->classCache[$filename] = $usedClasses;
    }

    protected function readNamespace($handle)
    {
        $namespaceRegex = '#^\s*namespace\s+#';
        $line = $this->readNextRelevantLine($handle);
        if (!$line || !preg_match($namespaceRegex, $line)) {
            return false;
        }

        $namespaceName = preg_replace($namespaceRegex, '', $line);
        $namespaceName = rtrim($namespaceName, ';');
        return $namespaceName;
    }

    protected function readUseStatements($handle)
    {
        $useRegex = '#^\s*use\s+#';
        $result = [];
        while (true) {
            $line = $this->readNextRelevantLine($handle);
            if (!$line || !preg_match($useRegex, $line)) {
                return $result;
            }
            $usedClass = preg_replace($useRegex, '', $line);
            $usedClass = rtrim($usedClass, ';');
            $unqualifiedClass = preg_replace('#.*\\\\#', '', $usedClass);
            // If this is an aliased class, 'use \Foo\Bar as Baz', then adjust
            if (strpos($usedClass, ' as ')) {
                $unqualifiedClass = preg_replace('#.*\sas\s+#', '', $usedClass);
                $usedClass = preg_replace('#[a-zA-Z0-9]+\s+as\s+#', '', $usedClass);
            }
            $result[$unqualifiedClass] = $usedClass;
        }
    }

    protected function readNextRelevantLine($handle)
    {
        while (($line = fgets($handle)) !== false) {
            if (preg_match('#^\s*\w#', $line)) {
                return trim($line);
            }
        }
        return false;
    }
}
