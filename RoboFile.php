<?php
/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{
    use \Codeception\Task\MergeReports;

    private $numParallel = 4;

    public function parallelRun()
    {
        $parallel = $this->taskParallelExec();
        for ($i = 0; $i < $this->numParallel; $i++) {
            $parallel->process(
                $this->taskCodecept() // use built-in Codecept task
                ->suite('acceptance') // run acceptance tests
                ->env("parallel_$i")          // in its own environment
                ->group("single")
                    ->xml("tests/_log/result_$i.xml")
            );
        }
        return $parallel->run();
    }

    function parallelMergeResults()
    {
        $merge = $this->taskMergeXmlReports();
        for ($i=0; $i<$this->numParallel; $i++) {
            $merge->from("tests/_output/tests/_log/result_$i.xml");
        }
        $merge->into("tests/_output/tests/_log/result.xml")
            ->run();
    }

    function parallelAll()
    {
        $result = $this->parallelRun();
        $this->parallelMergeResults();
        return $result;
    }
}