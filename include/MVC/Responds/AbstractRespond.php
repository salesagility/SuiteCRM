<?php


namespace SuiteCRM\MVC\Responds;


abstract class AbstractRespond implements RespondInterface
{
    protected $content;
    protected int $status = 200;

    /**
     * AbstractRespond constructor.
     * @param $content
     * @param int $status
     */
    public function __construct($content, int $status)
    {
        $this->content = $content;
        $this->status = $status;
    }


    public function show(): string
    {
        $this->initHeader();
        http_response_code($this->status);
        return $this->getContent();
    }

    public function is_empty(): bool
    {
        return empty($this->getContent());
    }

    abstract protected function initHeader();

    abstract protected function getContent(): string;

}