<?php
/**
 * This file is part of the ZBateson\MailMimeParser project.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 */
namespace ZBateson\MailMimeParser\Header\Part;

/**
 * Extends HeaderPartFactory to instantiate MimeLiteralParts for its newInstance
 * function.
 *
 * @author Zaahid Bateson
 */
class MimeLiteralPartFactory extends HeaderPartFactory
{
    /**
     * Creates and returns a MimeLiteralPart.
     * 
     * @param string $value
     * @return HeaderPart
     */
    public function newInstance($value)
    {
        return $this->newMimeLiteralPart($value);
    }
}
