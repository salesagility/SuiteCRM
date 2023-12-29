<?php
/**
 * This file is part of KReporter. KReporter is an enhancement developed
 * by Christian Knoll. All rights are (c) 2012 by Christian Knoll
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 *
 * You can contact Christian Knoll at info@kreporter.org
 */
if (!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

$kreportLayouts = array(
    '1x1' => array(
        'items' => array(
            array(
                'top' => '0%',
                'left' => '0%',
                'width' => '100%',
                'height' => '100%'
            )
        )
    ),
    '1x2' => array(
        'items' => array(
            array(
                'top' => '0%',
                'left' => '0%',
                'width' => '50%',
                'height' => '100%'
            ),
            array(
                'top' => '0%',
                'left' => '50%',
                'width' => '50%',
                'height' => '100%'
            ),
        )
    ),
    '1x3' => array(
        'items' => array(
            array(
                'top' => '0%',
                'left' => '0%',
                'width' => '33%',
                'height' => '100%'
            ),
            array(
                'top' => '0%',
                'left' => '33%',
                'width' => '34%',
                'height' => '100%'
            ),
            array(
                'top' => '0%',
                'left' => '67%',
                'width' => '33%',
                'height' => '100%'
            )
        )
    ),
    '1x4' => array(
        'items' => array(
            array(
                'top' => '0%',
                'left' => '0%',
                'width' => '25%',
                'height' => '100%'
            ),
            array(
                'top' => '0%',
                'left' => '25%',
                'width' => '25%',
                'height' => '100%'
            ),
            array(
                'top' => '0%',
                'left' => '50%',
                'width' => '25%',
                'height' => '100%'
            ),
            array(
                'top' => '0%',
                'left' => '75%',
                'width' => '25%',
                'height' => '100%'
            )
        )
    ),
    '2x2' => array(
        'items' => array(
            array(
                'top' => '0%',
                'left' => '0%',
                'width' => '50%',
                'height' => '50%'
            ),
            array(
                'top' => '0%',
                'left' => '50%',
                'width' => '50%',
                'height' => '50%'
            ),
            array(
                'top' => '50%',
                'left' => '0%',
                'width' => '50%',
                'height' => '50%'
            ),
            array(
                'top' => '50%',
                'left' => '50%',
                'width' => '50%',
                'height' => '50%'
            )
        )
    ),
    '2x2wide' => array(
        'items' => array(
            array(
                'top' => '0%',
                'left' => '0%',
                'width' => '33%',
                'height' => '50%'
            ),
            array(
                'top' => '0%',
                'left' => '33%',
                'width' => '67%',
                'height' => '50%'
            ),
            array(
                'top' => '50%',
                'left' => '0%',
                'width' => '33%',
                'height' => '50%'
            ),
            array(
                'top' => '50%',
                'left' => '33%',
                'width' => '67%',
                'height' => '50%'
            )
        )
    ),
    '1x3x2' => array(
        'items' => array(
            array(
                'top' => '0%',
                'left' => '0%',
                'width' => '67%',
                'height' => '100%'
            ),
            array(
                'top' => '0%',
                'left' => '67%',
                'width' => '33%',
                'height' => '50%'
            ),
            array(
                'top' => '50%',
                'left' => '67%',
                'width' => '33%',
                'height' => '50%'
            )
        )
    ),
    '1x2x1' => array(
        'items' => array(
            array(
                'top' => '0%',
                'left' => '0%',
                'width' => '67%',
                'height' => '100%'
            ),
            array(
                'top' => '0%',
                'left' => '67%',
                'width' => '33%',
                'height' => '100%'
            )
        )
    ),
    '1+1+2' => array(
        'items' => array(
            array(
                'top' => '0%',
                'left' => '0%',
                'width' => '33%',
                'height' => '100%'
            ),
            array(
                'top' => '0%',
                'left' => '33%',
                'width' => '33%',
                'height' => '100%'
            ),
            array(
                'top' => '0%',
                'left' => '66%',
                'width' => '34%',
                'height' => '50%'
            ),
            array(
                'top' => '50%',
                'left' => '66%',
                'width' => '34%',
                'height' => '50%'
            )
        )
    ),
    '1x2x2' => array(
        'items' => array(
            array(
                'top' => '0%',
                'left' => '0%',
                'width' => '50%',
                'height' => '100%'
            ),
            array(
                'top' => '0%',
                'left' => '50%',
                'width' => '25%',
                'height' => '100%'
            ),
            array(
                'top' => '0%',
                'left' => '75%',
                'width' => '25%',
                'height' => '100%'
            )
        )
    ),
    '2x1x4' => array(
        'items' => array(
            array(
                'top' => '0%',
                'left' => '0%',
                'width' => '100%',
                'height' => '50%'
            ),
            array(
                'top' => '50%',
                'left' => '0%',
                'width' => '25%',
                'height' => '50%'
            ),
            array(
                'top' => '50%',
                'left' => '25%',
                'width' => '25%',
                'height' => '50%'
            ),
            array(
                'top' => '50%',
                'left' => '50%',
                'width' => '25%',
                'height' => '50%'
            ),
            array(
                'top' => '50%',
                'left' => '75%',
                'width' => '25%',
                'height' => '50%'
            )
        )
    )
);

if(file_exists('custom/modules/KReports/config/KReportLayouts.php'))
    include('custom/modules/KReports/config/KReportLayouts.php');
?>
