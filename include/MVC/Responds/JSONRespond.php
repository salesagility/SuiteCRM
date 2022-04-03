<?php

namespace SuiteCRM\MVC\Responds;

require_once 'include/MVC/Responds/RespondInterface.php';

class JSONRespond extends AbstractRespond
{

    protected $content = [];

    /**
     * JSONRespond constructor.
     * @param array $content
     */
    public function __construct(array $content, int $status = 200)
    {
        $this->content = $content;
        $this->status = $status;
    }

    protected function initHeader()
    {
        header('Content-Type: application/json; charset=utf-8');
    }


    protected function getContent(): string
    {
        return json_encode($this->content);
    }
}