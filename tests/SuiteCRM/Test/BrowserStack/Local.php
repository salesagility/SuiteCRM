<?php

namespace SuiteCRM\Test\BrowserStack;

use BrowserStack\LocalException;

/**
 * Class Local
 * @package SuiteCRM\Test\BrowserStack
 *
 * Extends browser stacks local driver
 */
class Local extends \BrowserStack\Local
{
    public function start($arguments) {
        foreach($arguments as $key => $value)
            $this->add_args($key,$value);

        $this->binary = new LocalBinary();
        $this->binary_path = $this->binary->binary_path();

        $call = $this->start_command();
        if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
            system('echo "" > '. '$this->logfile');
        else
            system("echo \"\" > '$this->logfile' ");
        $call = $call . "2>&1";
        $return_message = shell_exec($call);
        $data = json_decode($return_message,true);
        if ($data["state"] != "connected") {
            throw new LocalException($data['message']['message']);
        }
        $this->pid = $data['pid'];
    }
}