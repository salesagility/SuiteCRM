<?php
namespace Api\V8\Response;

class ModuleResponse implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $name;

    /**
     * @var string|null
     */
    private $dateEntered;

    /**
     * @var string|null
     */
    private $dateModified;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @return null|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param null|string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return null|string
     */
    public function getDateEntered()
    {
        return $this->dateEntered;
    }

    /**
     * @param null|string $dateEntered
     */
    public function setDateEntered($dateEntered)
    {
        $this->dateEntered = $dateEntered;
    }

    /**
     * @return null|string
     */
    public function getDateModified()
    {
        return $this->dateModified;
    }

    /**
     * @param null|string $dateModified
     */
    public function setDateModified($dateModified)
    {
        $this->dateModified = $dateModified;
    }

    /**
     * @return null|string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return [
            'name' => $this->getName(),
            'dateEntered' => $this->getDateEntered(),
            'dateModified' => $this->getDateModified(),
            'description' => $this->getDescription(),
        ];
    }
}
