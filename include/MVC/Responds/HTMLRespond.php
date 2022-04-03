<?php


namespace SuiteCRM\MVC\Responds;


class HTMLRespond extends AbstractRespond
{
    protected $content = '';

    /**
     * HTMLRespond constructor.
     * @param string $content
     * @param int $status
     */
    public function __construct(string $content, int $status = 200)
    {
        $this->content = $content;
        $this->status = $status;
    }

    protected function initHeader()
    {
        header('Content-Type:text/html; charset=UTF-8');
    }

    protected function getContent(): string
    {
        return $this->content;
    }
}