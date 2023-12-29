<?php

namespace Consolidation\AnnotatedCommand\Hooks\Dispatchers;

use Consolidation\AnnotatedCommand\Hooks\ExtractOutputInterface;
use Consolidation\AnnotatedCommand\Hooks\HookManager;
use Consolidation\AnnotatedCommand\OutputDataInterface;

/**
 * Call hooks
 */
class ExtracterHookDispatcher extends HookDispatcher implements ExtractOutputInterface
{
    /**
     * Convert the result object to printable output in
     * structured form.
     */
    public function extractOutput($result)
    {
        if ($result instanceof OutputDataInterface) {
            return $result->getOutputData();
        }

        $hooks = [
            HookManager::EXTRACT_OUTPUT,
        ];
        $extractors = $this->getHooks($hooks);
        foreach ($extractors as $extractor) {
            $structuredOutput = $this->callExtractor($extractor, $result);
            if (isset($structuredOutput)) {
                return $structuredOutput;
            }
        }

        return $result;
    }

    protected function callExtractor($extractor, $result)
    {
        if ($extractor instanceof ExtractOutputInterface) {
            return $extractor->extractOutput($result);
        }
        if (is_callable($extractor)) {
            return $extractor($result);
        }
    }
}
