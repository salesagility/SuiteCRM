<?php

require_once 'include/portability/ModuleNameMapper.php';
require_once 'include/portability/ActionNameMapper.php';

/**
 * Class RouteConverter
 *
 * @package SuiteCRM\Core\Legacy
 */
class RouteConverter
{
    /**
     * @var ModuleNameMapper
     */
    protected $moduleNameMapper;

    /**
     * @var ActionNameMapper
     */
    private $actionNameMapper;

    /**
     * RouteConverter constructor.
     */
    public function __construct()
    {
        $this->moduleNameMapper = new ModuleNameMapper();
        $this->actionNameMapper = new ActionNameMapper();
    }

    /**
     * Convert given $request route
     *
     * @param string|null $module
     * @param string|null $action
     * @param string|null $record
     * @param array|null $queryParams
     * @return string
     */
    public function convert(?string $module, ?string $action, ?string $record, ?array $queryParams): string
    {
        if (empty($module)) {
            throw new InvalidArgumentException('No module defined');
        }

        $route = $this->buildRoute($module, $action, $record);

        $queryString = $this->buildQueryString($queryParams, ['module', 'action', 'record']);

        if (!empty($queryString)) {
            $queryString = '?' . $queryString;
        }

        return $route . $queryString;
    }

    /**
     * Convert given $uri route and point to Suite 8 path
     *
     * @param string $uri
     * @return string
     */
    public function generateUiLink(string $uri): string
    {
        $link = $this->convertUri($uri);

        return str_replace('./', '../', $link);
    }

    /**
     * Convert given $uri route
     *
     * @param string $uri
     * @return string
     */
    public function convertUri(string $uri): string
    {
        $query = parse_url($uri, PHP_URL_QUERY);

        if (empty($query)){
            throw new InvalidArgumentException('No module defined');
        }
        parse_str($query, $data);

        $defaults = [
            'module' => '',
            'action' => '',
            'record' => ''
        ];

        ['module' => $module, 'action' => $action, 'record' => $record] = array_merge($defaults, $data);

        return $this->convert($module, $action, $record, $data);
    }

    /**
     * Build Suite 8 route
     *
     * @param string $module
     * @param string|null $action
     * @param string|null $record
     * @return string
     */
    protected function buildRoute(?string $module, ?string $action, ?string $record): string
    {
        $moduleName = $this->mapModule($module);
        $route = "./#/$moduleName";

        if (!empty($action)) {
            $actionName = $this->mapAction($action);
            $route .= "/$actionName";
        }

        if (!empty($record)) {
            $route .= "/$record";
        }

        return $route;
    }

    /**
     * Map action name
     * @param string $action
     * @return string
     */
    protected function mapAction(string $action): string
    {
        return $this->actionNameMapper->toFrontend($action);
    }

    /**
     * Map module name
     * @param string $module
     * @return string
     */
    protected function mapModule(string $module): string
    {
        return $this->moduleNameMapper->toFrontEnd($module);
    }

    /**
     * Build query string
     * @param array $queryParams
     * @param array $exclude
     * @return string
     */
    public function buildQueryString(array $queryParams, array $exclude): string
    {
        $validParams = $this->excludeParams($queryParams, $exclude);

        if (empty($exclude)){
            return '';
        }

        return http_build_query($validParams, '', '&', PHP_QUERY_RFC3986);
    }

    /**
     * Build new array where list of query params are excluded
     * @param array $queryParams
     * @param array $exclude
     * @return array
     */
    public function excludeParams(array $queryParams, array $exclude): array
    {
        $validParams = [];

        foreach ($queryParams as $name => $value) {
            if (in_array($name, $exclude, true)) {
                continue;
            }
            $validParams[$name] = $value;
        }

        return $validParams;
    }
}
