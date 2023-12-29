<?php
namespace Consolidation\AnnotatedCommand\Parser\Internal;

/**
 * Hold some state. Collect tags.
 */
class TagFactory
{
    /** @var DocblockTag|null Current tag */
    protected $current;

    /** @var DocblockTag[] All tag */
    protected $tags;

    /**
     * DocblockTag constructor
     */
    public function __construct()
    {
        $this->current = null;
        $this->tags = [];
    }

    public function parseLine($line)
    {
        if (DocblockTag::isTag($line)) {
            return $this->createTag($line);
        }
        if (empty($line)) {
            return $this->storeCurrentTag();
        }
        return $this->accumulateContent($line);
    }

    public function getTags()
    {
        $this->storeCurrentTag();
        return $this->tags;
    }

    protected function createTag($line)
    {
        DocblockTag::splitTagAndContent($line, $matches);
        $this->storeCurrentTag();
        $this->current = new DocblockTag($matches['tag'], $matches['description']);
        return true;
    }

    protected function storeCurrentTag()
    {
        if (!$this->current) {
            return false;
        }
        $this->tags[] = $this->current;
        $this->current = false;
        return true;
    }

    protected function accumulateContent($line)
    {
        if (!$this->current) {
            return false;
        }
        $this->current->appendContent($line);
        return true;
    }
}
