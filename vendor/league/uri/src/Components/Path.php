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
namespace League\Uri\Components;

use League\Uri\Interfaces\Path as PathInterface;

/**
 * Value object representing a URI path component.
 *
 * @package League.uri
 * @author  Ignace Nyamagana Butera <nyamsprod@gmail.com>
 * @since   1.0.0
 */
class Path extends AbstractComponent implements PathInterface
{
    use PathTrait;

    /**
     * @inheritdoc
     */
    protected function validate($data)
    {
        return $this->decodePath($this->validateString($data));
    }

    /**
     * @inheritdoc
     */
    public function getContent()
    {
        return $this->encodePath($this->data);
    }
}
