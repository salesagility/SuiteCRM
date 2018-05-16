<?php
namespace Api\V8\JsonApi\Response;

class DocumentResponse implements \JsonSerializable
{
    /**
     * @var DataResponse|DataResponse[]|[]
     */
    private $data;

    /**
     * @var MetaResponse
     */
    private $meta;

    /**
     * @var LinksResponse
     */
    private $links;

    /**
     * @return DataResponse|DataResponse[]|[]
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param DataResponse|DataResponse[]|[] $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return MetaResponse
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * @param MetaResponse $meta
     */
    public function setMeta(MetaResponse $meta)
    {
        $this->meta = $meta;
    }

    /**
     * @return LinksResponse
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * @param LinksResponse $links
     */
    public function setLinks(LinksResponse $links)
    {
        $this->links = $links;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        if (!$this->getData()) {
            $this->setMeta(new MetaResponse(['message' => 'Request was successful, but there is no result']));
        }

        $response = [
            'meta' => $this->getMeta(),
            'data' => $this->getData(),
            'links' => $this->getLinks(),
        ];

        return array_filter($response);
    }
}
