<?php
/**
 *
 */

class ListViewSmartyCustom extends ListViewSmarty
{
    /**
     * @param $file
     * @param $data
     * @param $htmlpublic
     * @return void
     */
    public function process($file, $data, $htmlpublic)
    {
        foreach ((array)$this->displayColumns as $name => $params) {
            if (isset($params['visible']) && false === $params['visible']) {
                unset($this->displayColumns[$name]);
            }
        }
        parent::process($file, $data, $htmlpublic);
    }
}
