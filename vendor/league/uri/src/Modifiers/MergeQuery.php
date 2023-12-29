<?php
/**
 * League.Uri (http://uri.thephpleague.com)
 *
 * @package   League.uri
 * @author    Ignace Nyamagana Butera <nyamsprod@gmail.com>
 * @copyright 2013-2015 Ignace Nyamagana Butera
 * @license   https://github.com/thephpleague/uri/blob/master/LICENSE (MIT License)
 * @version   4.1.0
 * @link      https://github.com/thephpleague/uri/
 */
namespace League\Uri\Modifiers;

use League\Uri\Modifiers\Filters\QueryString;

/**
 * Add or Update the Query string from the URI object
 *
 * @package League.uri
 * @author  Ignace Nyamagana Butera <nyamsprod@gmail.com>
 * @since   4.0.0
 */
class MergeQuery extends AbstractQueryModifier
{
    use QueryString;

    /**
     * New Instance
     *
     * @param string $query
     */
    public function __construct($query)
    {
        $this->query = $this->filterQuery($query);
    }

    /**
     * Modify a URI part
     *
     * @param string $str the URI part string representation
     *
     * @return string the modified URI part string representation
     */
    protected function modify($str)
    {
        return (string) $this->query
            ->modify($str)
            ->merge((string) $this->query);
    }
}
