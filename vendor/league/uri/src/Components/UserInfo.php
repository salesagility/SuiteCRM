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

use InvalidArgumentException;
use League\Uri\Interfaces\Pass as PassInterface;
use League\Uri\Interfaces\UriPart;
use League\Uri\Interfaces\User as UserInterface;
use League\Uri\Interfaces\UserInfo as UserInfoInterface;
use League\Uri\Types\ImmutablePropertyTrait;
use League\Uri\Types\ValidatorTrait;

/**
 * Value object representing the UserInfo part of an URI.
 *
 * @package League.uri
 * @author  Ignace Nyamagana Butera <nyamsprod@gmail.com>
 * @since   4.0.0
 *
 */
class UserInfo implements UserInfoInterface
{
    use ImmutablePropertyTrait;
    use ValidatorTrait;

    /**
     * User Component
     *
     * @var User
     */
    protected $user;

    /**
     * Pass Component
     *
     * @var Pass
     */
    protected $pass;

    /**
     * Create a new instance of UserInfo
     *
     * @param UserInterface|string $user
     * @param PassInterface|string $pass
     */
    public function __construct($user = null, $pass = null)
    {
        $this->user = !$user instanceof UserInterface ? new User($user) : $user;
        $this->pass = !$pass instanceof PassInterface ? new Pass($pass) : $pass;
        $this->assertValidObject();
    }

    /**
     * Retrieve the user component of the URI User Info part
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user->__toString();
    }

    /**
     * Retrieve the pass component of the URI User Info part
     *
     * @return string
     */
    public function getPass()
    {
        return $this->pass->__toString();
    }

    /**
     * @inheritdoc
     */
    public function __debugInfo()
    {
        return ['userInfo' => $this->getContent()];
    }

    /**
     * @inheritdoc
     */
    public static function __set_state(array $properties)
    {
        return new static($properties['user'], $properties['pass']);
    }

    /**
     * Returns the component literal value.
     *
     * @return null|string
     */
    public function getContent()
    {
        $userInfo = $this->user->__toString();
        if ('' === $userInfo) {
            return $this->user->getContent();
        }

        $pass = $this->pass->__toString();
        if ('' !== $pass) {
            $userInfo .= UserInfoInterface::SEPARATOR.$pass;
        }

        return $userInfo;
    }

    /**
     * Returns the instance string representation; If the
     * instance is not defined an empty string is returned
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getContent();
    }

    /**
     * Returns the instance string representation
     * with its optional URI delimiters
     *
     * @return string
     */
    public function getUriComponent()
    {
        $component = $this->__toString();
        if ('' !== $component) {
            $component .= UserInfoInterface::DELIMITER;
        }

        return $component;
    }

    /**
     * DEPRECATION WARNING! This method will be removed in the next major point release
     *
     * @deprecated deprecated since version 4.2
     *
     * Returns whether two UriPart objects represent the same value
     * The comparison is based on the getUriComponent method
     *
     * @param UriPart $component
     *
     * @return bool
     */
    public function sameValueAs(UriPart $component)
    {
        return $this->getUriComponent() === $component->getUriComponent();
    }

    /**
     * Return an instance with the specified user.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified user.
     *
     * An empty user is equivalent to removing the user information.
     *
     * @param string $user The user to use with the new instance.
     *
     * @throws \InvalidArgumentException for invalid user.
     *
     * @return static
     */
    public function withUser($user)
    {
        return $this->withProperty('user', $user);
    }

    /**
     * Return an instance with the specified password.
     *
     * This method MUST retain the state of the current instance, and return
     * an instance that contains the specified password.
     *
     * An empty password is equivalent to removing the password.
     *
     * @param string $pass The password to use with the new instance.
     *
     * @throws \InvalidArgumentException for invalid password.
     *
     * @return static
     */
    public function withPass($pass)
    {
        return $this->withProperty('pass', $pass);
    }

    /**
     * Create a new instance from a string
     *
     * @param string $content
     *
     * @return static
     */
    public function withContent($content = null)
    {
        if ($content === $this->getContent()) {
            return $this;
        }

        if (null !== $content && !is_string($content)) {
            throw new InvalidArgumentException(sprintf(
                'Expected data to be a string or NULL; received "%s"',
                gettype($content)
            ));
        }

        $res = explode(UserInfoInterface::SEPARATOR, $content, 2);
        $new = new static(array_shift($res), array_shift($res));
        if ($new->getContent() === $this->getContent()) {
            return $this;
        }

        return $new;
    }

    /**
     * @inheritdoc
     */
    protected function assertValidObject()
    {
    }
}
