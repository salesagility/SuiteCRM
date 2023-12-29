<?php
namespace Consolidation\AnnotatedCommand;

/**
 * If an annotated command method returns an object that
 * implements OutputDataInterface, then the getOutputData()
 * method is used to fetch the output to print from the
 * result object.
 */
interface OutputDataInterface
{
    public function getOutputData();
}
