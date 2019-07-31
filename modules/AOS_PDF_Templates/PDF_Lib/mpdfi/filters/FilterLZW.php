<?php
//
//  FPDI - Version 1.3.1
//
//    Copyright 2004-2009 Setasign - Jan Slabon
//
//  Licensed under the Apache License, Version 2.0 (the "License");
//  you may not use this file except in compliance with the License.
//  You may obtain a copy of the License at
//
//      http://www.apache.org/licenses/LICENSE-2.0
//
//  Unless required by applicable law or agreed to in writing, software
//  distributed under the License is distributed on an "AS IS" BASIS,
//  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
//  See the License for the specific language governing permissions and
//  limitations under the License.
//

class FilterLZW
{
    public $sTable = array();
    public $data = null;
    public $dataLength = 0;
    public $tIdx;
    public $bitsToGet = 9;
    public $bytePointer;
    public $bitPointer;
    public $nextData = 0;
    public $nextBits = 0;
    public $andTable = array(511, 1023, 2047, 4095);

    public function error($msg)
    {
        die($msg);
    }
    
    /**
     * Method to decode LZW compressed data.
     *
     * @param string data    The compressed data.
     */
    public function decode($data)
    {
        if ($data[0] == 0x00 && $data[1] == 0x01) {
            $this->error('LZW flavour not supported.');
        }

        $this->initsTable();

        $this->data = $data;
        $this->dataLength = strlen($data);

        // Initialize pointers
        $this->bytePointer = 0;
        $this->bitPointer = 0;

        $this->nextData = 0;
        $this->nextBits = 0;

        $oldCode = 0;

        $string = '';
        $uncompData = '';

        while (($code = $this->getNextCode()) != 257) {
            if ($code == 256) {
                $this->initsTable();
                $code = $this->getNextCode();

                if ($code == 257) {
                    break;
                }

                $uncompData .= $this->sTable[$code];
                $oldCode = $code;
            } else {
                if ($code < $this->tIdx) {
                    $string = $this->sTable[$code];
                    $uncompData .= $string;

                    $this->addStringToTable($this->sTable[$oldCode], $string[0]);
                    $oldCode = $code;
                } else {
                    $string = $this->sTable[$oldCode];
                    $string = $string.$string[0];
                    $uncompData .= $string;

                    $this->addStringToTable($string);
                    $oldCode = $code;
                }
            }
        }
        
        return $uncompData;
    }


    /**
     * Initialize the string table.
     */
    public function initsTable()
    {
        $this->sTable = array();

        for ($i = 0; $i < 256; $i++) {
            $this->sTable[$i] = chr($i);
        }

        $this->tIdx = 258;
        $this->bitsToGet = 9;
    }

    /**
     * Add a new string to the string table.
     */
    public function addStringToTable($oldString, $newString='')
    {
        $string = $oldString.$newString;

        // Add this new String to the table
        $this->sTable[$this->tIdx++] = $string;

        if ($this->tIdx == 511) {
            $this->bitsToGet = 10;
        } elseif ($this->tIdx == 1023) {
            $this->bitsToGet = 11;
        } elseif ($this->tIdx == 2047) {
            $this->bitsToGet = 12;
        }
    }

    // Returns the next 9, 10, 11 or 12 bits
    public function getNextCode()
    {
        if ($this->bytePointer == $this->dataLength) {
            return 257;
        }

        $this->nextData = ($this->nextData << 8) | (ord($this->data[$this->bytePointer++]) & 0xff);
        $this->nextBits += 8;

        if ($this->nextBits < $this->bitsToGet) {
            $this->nextData = ($this->nextData << 8) | (ord($this->data[$this->bytePointer++]) & 0xff);
            $this->nextBits += 8;
        }

        $code = ($this->nextData >> ($this->nextBits - $this->bitsToGet)) & $this->andTable[$this->bitsToGet-9];
        $this->nextBits -= $this->bitsToGet;

        return $code;
    }
    
    public function encode($in)
    {
        $this->error("LZW encoding not implemented.");
    }
}
