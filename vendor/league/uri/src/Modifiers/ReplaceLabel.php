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

use League\Uri\Modifiers\Filters\Label;
use League\Uri\Modifiers\Filters\Offset;

/**
 * Replace a label from a Host
 *
 * @package League.uri
 * @author  Ignace Nyamagana Butera <nyamsprod@gmail.com>
 * @since   4.0.0
 */
class ReplaceLabel extends AbstractHostModifier
{
    use Label;
    use Offset;

    /**
     * New instance
     *
     * @param int    $offset
     * @param string $label
     */
    public function __construct($offset, $label)
    {
        $this->offset = $this->filterOffset($offset);
        $this->label = $this->filterLabel($label);
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
        return (string) $this->label
            ->modify($str)
            ->replace($this->offset, $this->label->getContent());
    }
}
