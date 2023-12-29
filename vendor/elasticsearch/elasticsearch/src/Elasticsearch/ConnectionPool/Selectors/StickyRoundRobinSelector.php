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

namespace Elasticsearch\ConnectionPool\Selectors;

use Elasticsearch\Connections\ConnectionInterface;

class StickyRoundRobinSelector implements SelectorInterface
{
    /**
     * @var int
     */
    private $current = 0;

    /**
     * @var int
     */
    private $currentCounter = 0;

    /**
     * Use current connection unless it is dead, otherwise round-robin
     *
     * @param ConnectionInterface[] $connections Array of connections to choose from
     */
    public function select(array $connections): ConnectionInterface
    {
        /**
 * @var ConnectionInterface[] $connections
*/
        if ($connections[$this->current]->isAlive()) {
            return $connections[$this->current];
        }

        $this->currentCounter += 1;
        $this->current = $this->currentCounter % count($connections);

        return $connections[$this->current];
    }
}
