<?php

namespace Robo\Task\Development;

use Robo\Task\BaseTask;
use Robo\Result;

/**
 * Generate a Robo Task that is a wrapper around an existing class.
 *
 * ``` php
 * <?php
 * $this->taskGenerateTask('Symfony\Component\Filesystem\Filesystem', 'FilesystemStack')
 *   ->run();
 * ```
 */
class GenerateTask extends BaseTask
{
    /**
     * @var string
     */
    protected $className;

    /**
     * @var string
     */
    protected $wrapperClassName;

    /**
     * @param string $className
     * @param string $wrapperClassName
     */
    public function __construct($className, $wrapperClassName = '')
    {
        $this->className = $className;
        $this->wrapperClassName = $wrapperClassName;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $delegate = new \ReflectionClass($this->className);
        $replacements = [];

        $leadingCommentChars = " * ";
        $methodDescriptions = [];
        $methodImplementations = [];
        $immediateMethods = [];
        foreach ($delegate->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            $methodName = $method->name;
            $getter = preg_match('/^(get|has|is)/', $methodName);
            $setter = preg_match('/^(set|unset)/', $methodName);
            $argPrototypeList = [];
            $argNameList = [];
            $needsImplementation = false;
            foreach ($method->getParameters() as $arg) {
                $argDescription = '$' . $arg->name;
                $argNameList[] = $argDescription;
                if ($arg->isOptional()) {
                    $argDescription = $argDescription . ' = ' . str_replace("\n", "", var_export($arg->getDefaultValue(), true));
                    // We will create wrapper methods for any method that
                    // has default parameters.
                    $needsImplementation = true;
                }
                $argPrototypeList[] = $argDescription;
            }
            $argPrototypeString = implode(', ', $argPrototypeList);
            $argNameListString = implode(', ', $argNameList);

            if ($methodName[0] != '_') {
                $methodDescriptions[] = "@method $methodName($argPrototypeString)";

                if ($getter) {
                    $immediateMethods[] = "    public function $methodName($argPrototypeString)\n    {\n        return \$this->delegate->$methodName($argNameListString);\n    }";
                } elseif ($setter) {
                    $immediateMethods[] = "    public function $methodName($argPrototypeString)\n    {\n        \$this->delegate->$methodName($argNameListString);\n        return \$this;\n    }";
                } elseif ($needsImplementation) {
                    // Include an implementation for the wrapper method if necessary
                    $methodImplementations[] = "    protected function _$methodName($argPrototypeString)\n    {\n        \$this->delegate->$methodName($argNameListString);\n    }";
                }
            }
        }

        $classNameParts = explode('\\', $this->className);
        $delegate = array_pop($classNameParts);
        $delegateNamespace = implode('\\', $classNameParts);

        if (empty($this->wrapperClassName)) {
            $this->wrapperClassName = $delegate;
        }

        $replacements['{delegateNamespace}'] = $delegateNamespace;
        $replacements['{delegate}'] = $delegate;
        $replacements['{wrapperClassName}'] = $this->wrapperClassName;
        $replacements['{taskname}'] = "task$delegate";
        $replacements['{methodList}'] = $leadingCommentChars . implode("\n$leadingCommentChars", $methodDescriptions);
        $replacements['{immediateMethods}'] = "\n\n" . implode("\n\n", $immediateMethods);
        $replacements['{methodImplementations}'] = "\n\n" . implode("\n\n", $methodImplementations);

        $template = file_get_contents(__DIR__ . '/../../../data/Task/Development/GeneratedWrapper.tmpl');
        $template = str_replace(array_keys($replacements), array_values($replacements), $template);

        // Returning data in the $message will cause it to be printed.
        return Result::success($this, $template);
    }
}
