<?php
/**
 * Elasticsearch PHP client
 *
 * @link      https://github.com/elastic/elasticsearch-php/
 * @copyright Copyright (c) Elasticsearch B.V (https://www.elastic.co)
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license   https://www.gnu.org/licenses/lgpl-2.1.html GNU Lesser General Public License, Version 2.1
 *
 * Licensed to Elasticsearch B.V under one or more agreements.
 * Elasticsearch B.V licenses this file to you under the Apache 2.0 License or
 * the GNU Lesser General Public License, Version 2.1, at your option.
 * See the LICENSE file in the project root for more information.
 */


declare(strict_types = 1);

namespace Elasticsearch\Connections;

use Elasticsearch\Serializers\SerializerInterface;
use Elasticsearch\Transport;
use Psr\Log\LoggerInterface;

interface ConnectionInterface
{
    /**
     * Get the transport schema for this connection
     */
    public function getTransportSchema(): string;

    /**
     * Get the hostname for this connection
     */
    public function getHost(): string;

    /**
     * Get the port for this connection
     *
     * @return int
     */
    public function getPort();

    /**
     * Get the username:password string for this connection, null if not set
     */
    public function getUserPass(): ?string;

    /**
     * Get the URL path suffix, null if not set
     */
    public function getPath(): ?string;

    /**
     * Check to see if this instance is marked as 'alive'
     */
    public function isAlive(): bool;

    /**
     * Mark this instance as 'alive'
     */
    public function markAlive(): void;

    /**
     * Mark this instance as 'dead'
     */
    public function markDead(): void;

    /**
     * Return an associative array of information about the last request
     */
    public function getLastRequestInfo(): array;

    /**
     * @param  null $body
     * @return mixed
     */
    public function performRequest(string $method, string $uri, ?array $params = [], $body = null, array $options = [], Transport $transport = null);
}
