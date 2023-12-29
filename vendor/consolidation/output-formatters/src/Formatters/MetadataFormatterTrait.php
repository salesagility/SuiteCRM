<?php

namespace Consolidation\OutputFormatters\Formatters;

use Consolidation\OutputFormatters\Options\FormatterOptions;
use Symfony\Component\Console\Output\OutputInterface;
use Consolidation\OutputFormatters\StructuredData\MetadataInterface;

trait MetadataFormatterTrait
{
    /**
     * @inheritdoc
     */
    public function writeMetadata(OutputInterface $output, $structuredOutput, FormatterOptions $options)
    {
        $template = $options->get(FormatterOptions::METADATA_TEMPLATE);
        if (!$template) {
            return;
        }
        if (!$structuredOutput instanceof MetadataInterface) {
            return;
        }
        $metadata = $structuredOutput->getMetadata();
        if (empty($metadata)) {
            return;
        }
        $message = $this->interpolate($template, $metadata);
        return $output->writeln($message);
    }

    /**
     * Interpolates context values into the message placeholders.
     *
     * @author PHP Framework Interoperability Group
     *
     * @param string $message
     * @param array  $context
     *
     * @return string
     */
    private function interpolate($message, array $context)
    {
        // build a replacement array with braces around the context keys
        $replace = array();
        foreach ($context as $key => $val) {
            if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
                $replace[sprintf('{%s}', $key)] = $val;
            }
        }

        // interpolate replacement values into the message and return
        return strtr($message, $replace);
    }
}
