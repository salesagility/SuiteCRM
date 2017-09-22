<?php

namespace SuiteCRM\api\JsonApi\v1;

/**
 * Class Links
 * @package SuiteCRM\api\JsonApi\v1
 */
class Links
{
    /**
     * @var string $self
     */
    private $self;

    /**
     * @var string $first
     */
    private $first;

    /**
     * @var string $prev
     */
    private $prev;

    /**
     * @var string $next
     */
    private $next;

    /**
     * @var string $last
     */
    private $last;

    /**
     * @var string $href
     */
    private $href;

    /**
     * @var array $meta
     */
    private $meta;

    /**
     * @var Links related
     */
    private $related;

    /**
     * Links constructor.
     * @param Links|null $linksObject
     */
    public function __construct(Links $linksObject = null)
    {
        if($linksObject !== null) {
            $this->self = $linksObject->self;
            $this->first = $linksObject->first;
            $this->prev = $linksObject->prev;
            $this->next = $linksObject->next;
            $this->last = $linksObject->last;
            $this->meta = $linksObject->meta;
        }
    }

    public static function get() {
        return new self();
    }

    /**
     * @param string $url
     * @return Links
     */
    public function withSelf($url) {
        $this->self = $url;
        return $this;
    }

    /**
     * @param string $url
     * @return Links
     */
    public function withFirst($url) {
        $this->first = $url;
        return new self();
    }

    /**
     * @param string $url
     * @return Links
     */
    public function withPrev($url) {
        $this->prev = $url;
        return $this;
    }

    /**
     * @param string $url
     * @return Links
     */
    public function withNext($url) {
        $this->next = $url;
        return $this;
    }

    /**
     * @param string $url
     * @return Links
     */
    public function withLast($url) {
        $this->last = $url;
        return $this;
    }

    /**
     * @param array $meta
     * @return Links
     */
    public function withMeta($meta) {
        if($this->meta === null) {
            $this->meta = $meta;
        } else {
            $this->meta = array_merge($this->meta, $meta);
        }

        return $this;
    }


    /**
     * @param string $url
     * @return Links
     */
    public function withHref($url) {
        $this->href = $url;
        return $this;
    }

    /**
     * @param Links $related
     * @return Links
     */
    public function withRelated(Links $related) {
        $this->related = $related;
        return $this;
    }

    /**
     * @return array
     */
    public function getArray()
    {
        $response = array();
        if($this->hasSelf()) {
            $response['self'] = $this->self;
        }

        if($this->hasHref()) {
            $response['href'] = $this->self;
        }

        if($this->hasMeta()) {
            $response['meta'] = $this->meta;
        }

        if($this->hasPagination()) {
            $response['first'] = $this->first;
            $response['prev'] = $this->prev;
            $response['next'] = $this->next;
            $response['last'] = $this->last;
        }

        if($this->hasRelated()) {
            $response['related'] = $this->relate->getArray();
        }
        return $response;
    }

    /**
     * @return bool
     */
    private function hasPagination()
    {
        return $this->first !== null ||
            $this->prev !== null ||
            $this->next !== null ||
            $this->last !== null;
    }

    /**
     * @return bool
     */
    private function hasSelf()
    {
        return $this->self !== null;
    }

    /**
     * @return bool
     */
    private function hasHref()
    {
        return $this->href !== null;
    }

    /**
     * @return bool
     */
    private function hasMeta()
    {
        return $this->meta !== null;
    }

    /**
     * @return bool
     */
    private function hasRelated()
    {
        return $this->related !== null;
    }
}