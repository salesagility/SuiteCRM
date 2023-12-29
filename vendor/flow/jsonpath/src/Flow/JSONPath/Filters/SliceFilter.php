<?php
namespace Flow\JSONPath\Filters;

use Flow\JSONPath\AccessHelper;

class SliceFilter extends AbstractFilter
{

    /**
     * @param $collection
     * @return array
     */
    public function filter($collection)
    {
        /*

        a[start:end] # items start through end-1
        a[start:]    # items start through the rest of the array
        a[:end]      # items from the beginning through end-1
        a[:]         # a copy of the whole array

        a[-1]    # last item in the array
        a[-2:]   # last two items in the array
        a[:-2]   # everything except the last two items

         */

        $result = [];

        $length = count($collection);
        $start  = $this->token->value['start'];
        $end    = $this->token->value['end'];
        $step   = $this->token->value['step'] ?: 1;

        if ($start !== null && $end !== null) {
            // standard
        }

        if ($start !== null && $end === null) {
            // negative index start means the end is -1, else the end is last index
            $end = $start < 0 ? -1 : $length - 1;
        }

        if ($start === null && $end !== null) {
            $start = 0;
        }

        if ($start === null && $end === null) {
            $start = 0;
            $end = $length - 1;
        }

        if ($end < 0 && $start >= 0) {
            $end = ($length + $end) - 1;
        }

        if ($start < 0 && $end === null) {
            $end = -1;
        }

        for ($i = $start; $i <= $end; $i += $step) {
            $index = $i;

            if ($i < 0) {
                $index = $length + $i;
            }

            if (AccessHelper::keyExists($collection, $index, $this->magicIsAllowed)) {
                $result[] = $collection[$index];
            }
        }

        return $result;
    }

}
 