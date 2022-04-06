<?php


namespace SuiteCRM\MVC\RouteParser;


class RouteParser
{
    protected string $type = 'internal';
    protected string $module = '';
    protected string $action = '';
    protected string $record = '';
    protected array $routeParams = [];

    public function __construct(\Symfony\Component\HttpFoundation\Request $request)
    {
        $this->routeParams = [];
        $this->routeParams = explode('/', $request->get('uri'));

        if ($request->get('module')) {
            $this->module = $request->get('module');
            $this->action = $request->get('action') ?? '';
            $this->record = $request->get('record') ?? '';
        }
        if (!empty($request->get('uri')) && empty($this->module)) {
            if(!empty($this->routeParams[0]) && $this->routeParams[0] == 'internal'){
                $this->module = $this->routeParams[1] ?? '';
                $this->action = $this->routeParams[2] ?? '';
                $this->record = $this->routeParams[3] ?? '';
            }
         }
    }

    /**
     * @return string
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return string
     */
    public function getRecord()
    {
        return $this->record;
    }

    /**
     * @return array|string[]
     */
    public function getRouteParams()
    {
        return $this->routeParams;
    }

}