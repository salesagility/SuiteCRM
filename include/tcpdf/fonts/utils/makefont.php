<?php

/*

Modification information for LGPL compliance

r56990 - 2010-06-16 13:05:36 -0700 (Wed, 16 Jun 2010) - kjing - snapshot "Mango" svn branch to a new one for GitHub sync

r56989 - 2010-06-16 13:01:33 -0700 (Wed, 16 Jun 2010) - kjing - defunt "Mango" svn dev branch before github cutover

r55980 - 2010-04-19 13:31:28 -0700 (Mon, 19 Apr 2010) - kjing - create Mango (6.1) based on windex

r51719 - 2009-10-22 10:18:00 -0700 (Thu, 22 Oct 2009) - mitani - Converted to Build 3  tags and updated the build system

r51634 - 2009-10-19 13:32:22 -0700 (Mon, 19 Oct 2009) - mitani - Windex is the branch for Sugar Sales 1.0 development

r50375 - 2009-08-24 18:07:43 -0700 (Mon, 24 Aug 2009) - dwong - branch kobe2 from tokyo r50372

r47930 - 2009-06-02 16:21:39 -0700 (Tue, 02 Jun 2009) - jenny - Updating with changes from bsoufflet.


*/


// BEGIN SUGARCRM SPECIFIC
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
// END SUGARCRM SPECIFIC

//============================================================+
// File name   : makefont.php
// Begin       : 2004-12-31
// Last Update : 2008-12-06
// Version     : 1.2.004
// License     : GNU LGPL (http://www.gnu.org/copyleft/lesser.html)
// 	----------------------------------------------------------------------------
// 	Copyright (C) 2008  Nicola Asuni - Tecnick.com S.r.l.
//
// 	This program is free software: you can redistribute it and/or modify
// 	it under the terms of the GNU Lesser General Public License as published by
// 	the Free Software Foundation, either version 2.1 of the License, or
// 	(at your option) any later version.
//
// 	This program is distributed in the hope that it will be useful,
// 	but WITHOUT ANY WARRANTY; without even the implied warranty of
// 	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// 	GNU Lesser General Public License for more details.
//
// 	You should have received a copy of the GNU Lesser General Public License
// 	along with this program.  If not, see <http://www.gnu.org/licenses/>.
//
// 	See LICENSE.TXT file for more information.
//  ----------------------------------------------------------------------------
//
// Description : Utility to generate font definition files fot TCPDF
//
// Authors: Nicola Asuni, Olivier Plathey, Steven Wittens
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com S.r.l.
//               Via della Pace, 11
//               09044 Quartucciu (CA)
//               ITALY
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Utility to generate font definition files fot TCPDF.
 * @author Nicola Asuni, Olivier Plathey, Steven Wittens
 * @copyright 2004-2009 Nicola Asuni - Tecnick.com S.r.l (www.tecnick.com) Via Della Pace, 11 - 09044 - Quartucciu (CA) - ITALY - www.tecnick.com - info@tecnick.com
 * @package com.tecnick.tcpdf
 * @link http://www.tcpdf.org
 * @license http://www.gnu.org/copyleft/lesser.html LGPL
*/

/**
 *
 * @param string $fontfile path to font file (TTF, OTF or PFB).
 * @param string $fmfile font metrics file (UFM or AFM).
 * @param boolean $embedded Set to false to not embed the font, true otherwise (default).
 * @param string $enc Name of the encoding table to use. Omit this parameter for TrueType Unicode, OpenType Unicode and symbolic fonts like Symbol or ZapfDingBats.
 * @param array $patch Optional modification of the encoding
 */
function MakeFont($fontfile, $fmfile, $embedded=true, $enc='cp1252', $patch=array()/* BEGIN SUGARCRM SPECIFIC */, $cidInfo=""/* END SUGARCRM SPECIFIC */)
{
    //Generate a font definition file
    set_magic_quotes_runtime(0);
    ini_set('auto_detect_line_endings', '1');
    if (!file_exists($fontfile)) {
        die('Error: file not found: '.$fontfile);
    }
    if (!file_exists($fmfile)) {
        die('Error: file not found: '.$fmfile);
    }
    $cidtogidmap = '';
    $map = array();
    $diff = '';
    $dw = 0; // default width
    $ffext = strtolower(substr($fontfile, -3));
    $fmext = strtolower(substr($fmfile, -3));
    if ($fmext == 'afm') {
        if (($ffext == 'ttf') or ($ffext == 'otf')) {
            $type = 'TrueType';
        } elseif ($ffext == 'pfb') {
            $type = 'Type1';
        } else {
            die('Error: unrecognized font file extension: '.$ffext);
        }
        if ($enc) {
            $map = ReadMap($enc);
            foreach ($patch as $cc => $gn) {
                $map[$cc] = $gn;
            }
        }
        $fm = ReadAFM($fmfile, $map);
        if (isset($widths['.notdef'])) {
            $dw = $widths['.notdef'];
        }
        if ($enc) {
            $diff = MakeFontEncoding($map);
        }
        $fd = MakeFontDescriptor($fm, empty($map));
    } elseif ($fmext == 'ufm') {
        $enc = '';
        if (($ffext == 'ttf') or ($ffext == 'otf')) {
            $type = 'TrueTypeUnicode';
        } else {
            die('Error: not a TrueType font: '.$ffext);
        }
        $fm = ReadUFM($fmfile, $cidtogidmap);
        $dw = $fm['MissingWidth'];
        $fd = MakeFontDescriptor($fm, false);
    }
    //Start generation
    $s = '<?php

/*

Modification information for LGPL compliance

r56990 - 2010-06-16 13:05:36 -0700 (Wed, 16 Jun 2010) - kjing - snapshot "Mango" svn branch to a new one for GitHub sync

r56989 - 2010-06-16 13:01:33 -0700 (Wed, 16 Jun 2010) - kjing - defunt "Mango" svn dev branch before github cutover

r55980 - 2010-04-19 13:31:28 -0700 (Mon, 19 Apr 2010) - kjing - create Mango (6.1) based on windex

r51719 - 2009-10-22 10:18:00 -0700 (Thu, 22 Oct 2009) - mitani - Converted to Build 3  tags and updated the build system 

r51634 - 2009-10-19 13:32:22 -0700 (Mon, 19 Oct 2009) - mitani - Windex is the branch for Sugar Sales 1.0 development

r50375 - 2009-08-24 18:07:43 -0700 (Mon, 24 Aug 2009) - dwong - branch kobe2 from tokyo r50372

r47930 - 2009-06-02 16:21:39 -0700 (Tue, 02 Jun 2009) - jenny - Updating with changes from bsoufflet.


*/

'."\n";
    // BEGIN SUGARCRM SPECIFIC
    if ($embedded) {
        // END SUGARCRM SPECIFIC
        $s .= '$type=\''.$type."';\n";
    // BEGIN SUGARCRM SPECIFIC
    } else {
        $s .= '$type=\''."cidfont0';\n";
    }
    // END SUGARCRM SPECIFIC
    $s .= '$name=\''.$fm['FontName']."';\n";
    $s .= '$desc='.$fd.";\n";
    if (!isset($fm['UnderlinePosition'])) {
        $fm['UnderlinePosition'] = -100;
    }
    if (!isset($fm['UnderlineThickness'])) {
        $fm['UnderlineThickness'] = 50;
    }
    $s .= '$up='.$fm['UnderlinePosition'].";\n";
    $s .= '$ut='.$fm['UnderlineThickness'].";\n";
    if ($dw <= 0) {
        if (isset($fm['Widths'][32]) and ($fm['Widths'][32] > 0)) {
            // assign default space width
            $dw = $fm['Widths'][32];
        } else {
            $dw = 600;
        }
    }
    // BEGIN SUGARCRM SPECIFIC
    if ($embedded) {
        // END SUGARCRM SPECIFIC
        $s .= '$dw='.$dw.";\n";
    // BEGIN SUGARCRM SPECIFIC
    } else {
        $s .= '$dw='."1000;\n";
    }
    // END SUGARCRM SPECIFIC
    $w = MakeWidthArray($fm);
    $s .= '$cw='.$w.";\n";
    // BEGIN SUGARCRM SPECIFIC
    if ($embedded) {
        // END SUGARCRM SPECIFIC
        $s .= '$enc=\''.$enc."';\n";
        // BEGIN SUGARCRM SPECIFIC
    }
    // END SUGARCRM SPECIFIC
    $s .= '$diff=\''.$diff."';\n";
    $basename = substr(basename($fmfile), 0, -4);
    // BEGIN SUGARCRM SPECIFIC
    $dirname = dirname($fmfile);
    // END SUGARCRM SPECIFIC
    if ($embedded) {
        //Embedded font
        if (($type == 'TrueType') or ($type == 'TrueTypeUnicode')) {
            CheckTTF($fontfile);
        }
        $f = fopen($fontfile, 'rb');
        if (!$f) {
            die('Error: Unable to open '.$fontfile);
        }
        $file = stream_get_contents($f);
        fclose($f);
        if ($type == 'Type1') {
            //Find first two sections and discard third one
            $header = (ord($file{0}) == 128);
            if ($header) {
                //Strip first binary header
                $file = substr($file, 6);
            }
            $pos = strpos($file, 'eexec');
            if (!$pos) {
                die('Error: font file does not seem to be valid Type1');
            }
            $size1 = $pos + 6;
            if ($header and (ord($file{$size1}) == 128)) {
                //Strip second binary header
                $file = substr($file, 0, $size1).substr($file, $size1+6);
            }
            $pos = strpos($file, '00000000');
            if (!$pos) {
                die('Error: font file does not seem to be valid Type1');
            }
            $size2 = $pos - $size1;
            $file = substr($file, 0, ($size1 + $size2));
        }
        $basename = strtolower($basename);
        if (function_exists('gzcompress')) {
            $cmp = $basename.'.z';
            // BEGIN SUGARCRM SPECIFIC
            /*
            // END SUGARCRM SPECIFIC
            SaveToFile($cmp, gzcompress($file, 9), 'b');
            // BEGIN SUGARCRM SPECIFIC
            */
            SaveToFile($dirname."/".$cmp, gzcompress($file, 9), 'b');
            // END SUGARCRM SPECIFIC
            $s .= '$file=\''.$cmp."';\n";
            print "Font file compressed (".$cmp.")\n";
            if (!empty($cidtogidmap)) {
                $cmp = $basename.'.ctg.z';
                // BEGIN SUGARCRM SPECIFIC
                /*
                // END SUGARCRM SPECIFIC
                SaveToFile($cmp, gzcompress($cidtogidmap, 9), 'b');
                // BEGIN SUGARCRM SPECIFIC
                */
                SaveToFile($dirname."/".$cmp, gzcompress($cidtogidmap, 9), 'b');
                // END SUGARCRM SPECIFIC
                print "CIDToGIDMap created and compressed (".$cmp.")\n";
                $s .= '$ctg=\''.$cmp."';\n";
            }
        } else {
            $s .= '$file=\''.basename($fontfile)."';\n";
            print "Notice: font file could not be compressed (zlib extension not available)\n";
            if (!empty($cidtogidmap)) {
                $cmp = $basename.'.ctg';
                // BEGIN SUGARCRM SPECIFIC
                /*
                // END SUGARCRM SPECIFIC
                $f = fopen($cmp, 'wb');
                // BEGIN SUGARCRM SPECIFIC
                */
                $f = fopen($dirname."/".$cmp, 'wb');
                // END SUGARCRM SPECIFIC
                fwrite($f, $cidtogidmap);
                fclose($f);
                print "CIDToGIDMap created (".$cmp.")\n";
                $s .= '$ctg=\''.$cmp."';\n";
            }
        }
        if ($type == 'Type1') {
            $s .= '$size1='.$size1.";\n";
            $s .= '$size2='.$size2.";\n";
        } else {
            $s.='$originalsize='.filesize($fontfile).";\n";
        }
    } else {
        //Not embedded font
        // BEGIN SUGARCRM SPECIFIC
        /*
        // END SUGARCRM SPECIFIC
        $s .= '$file='."'';\n";
        // BEGIN SUGARCRM SPECIFIC
        */
        $s .= $cidInfo;
        // END SUGARCRM SPECIFIC
    }
    $s .= "?>";
    // BEGIN SUGARCRM SPECIFIC
    /*
    // END SUGARCRM SPECIFIC
    SaveToFile($basename.'.php',$s);
    // BEGIN SUGARCRM SPECIFIC
    */
    SaveToFile($dirname."/".$basename.'.php', $s);
    // END SUGARCRM SPECIFIC
    print "Font definition file generated (".$basename.".php)\n";
    // BEGIN SUGARCRM SPECIFIC
    return $dirname."/".$basename;
    // END SUGARCRM SPECIFIC
}

/**
 * Read the specified encoding map.
 * @param string $enc map name (see /enc/ folder for valid names).
 */
function ReadMap($enc)
{
    //Read a map file
    $file = dirname(__FILE__).'/enc/'.strtolower($enc).'.map';
    $a = file($file);
    if (empty($a)) {
        die('Error: encoding not found: '.$enc);
    }
    $cc2gn = array();
    foreach ($a as $l) {
        if ($l{0} == '!') {
            $e = preg_split('/[ \\t]+/', rtrim($l));
            $cc = hexdec(substr($e[0], 1));
            $gn = $e[2];
            $cc2gn[$cc] = $gn;
        }
    }
    for ($i = 0; $i <= 255; $i++) {
        if (!isset($cc2gn[$i])) {
            $cc2gn[$i] = '.notdef';
        }
    }
    return $cc2gn;
}

/**
 * Read UFM file
 */
function ReadUFM($file, &$cidtogidmap)
{
    //Prepare empty CIDToGIDMap
    $cidtogidmap = str_pad('', (256 * 256 * 2), "\x00");
    //Read a font metric file
    $a = file($file);
    if (empty($a)) {
        die('File not found');
    }
    $widths = array();
    $fm = array();
    foreach ($a as $l) {
        $e = explode(' ', rtrim($l));
        if (count($e) < 2) {
            continue;
        }
        $code = $e[0];
        $param = $e[1];
        if ($code == 'U') {
            // U 827 ; WX 0 ; N squaresubnosp ; G 675 ;
            //Character metrics
            $cc = (int)$e[1];
            if ($cc != -1) {
                $gn = $e[7];
                $w = $e[4];
                $glyph = $e[10];
                $widths[$cc] = $w;
                if ($cc == ord('X')) {
                    $fm['CapXHeight'] = $e[13];
                }
                // Set GID
                if (($cc >= 0) and ($cc < 0xFFFF) and $glyph) {
                    $cidtogidmap{($cc * 2)} = chr($glyph >> 8);
                    $cidtogidmap{(($cc * 2) + 1)} = chr($glyph & 0xFF);
                }
            }
            if (($gn == '.notdef') and (!isset($fm['MissingWidth']))) {
                $fm['MissingWidth'] = $w;
            }
        } elseif ($code == 'FontName') {
            $fm['FontName'] = $param;
        } elseif ($code == 'Weight') {
            $fm['Weight'] = $param;
        } elseif ($code == 'ItalicAngle') {
            $fm['ItalicAngle'] = (double)$param;
        } elseif ($code == 'Ascender') {
            $fm['Ascender'] = (int)$param;
        } elseif ($code == 'Descender') {
            $fm['Descender'] = (int)$param;
        } elseif ($code == 'UnderlineThickness') {
            $fm['UnderlineThickness'] = (int)$param;
        } elseif ($code == 'UnderlinePosition') {
            $fm['UnderlinePosition'] = (int)$param;
        } elseif ($code == 'IsFixedPitch') {
            $fm['IsFixedPitch'] = ($param == 'true');
        } elseif ($code == 'FontBBox') {
            $fm['FontBBox'] = array($e[1], $e[2], $e[3], $e[4]);
        } elseif ($code == 'CapHeight') {
            $fm['CapHeight'] = (int)$param;
        } elseif ($code == 'StdVW') {
            $fm['StdVW'] = (int)$param;
        }
    }
    if (!isset($fm['MissingWidth'])) {
        $fm['MissingWidth'] = 600;
    }
    if (!isset($fm['FontName'])) {
        die('FontName not found');
    }
    $fm['Widths'] = $widths;
    return $fm;
}

/**
 * Read AFM file
 */
function ReadAFM($file, &$map)
{
    //Read a font metric file
    $a = file($file);
    if (empty($a)) {
        die('File not found');
    }
    $widths = array();
    $fm = array();
    $fix = array(
        'Edot'=>'Edotaccent',
        'edot'=>'edotaccent',
        'Idot'=>'Idotaccent',
        'Zdot'=>'Zdotaccent',
        'zdot'=>'zdotaccent',
        'Odblacute' => 'Ohungarumlaut',
        'odblacute' => 'ohungarumlaut',
        'Udblacute'=>'Uhungarumlaut',
        'udblacute'=>'uhungarumlaut',
        'Gcedilla'=>'Gcommaaccent'
        ,'gcedilla'=>'gcommaaccent',
        'Kcedilla'=>'Kcommaaccent',
        'kcedilla'=>'kcommaaccent',
        'Lcedilla'=>'Lcommaaccent',
        'lcedilla'=>'lcommaaccent',
        'Ncedilla'=>'Ncommaaccent',
        'ncedilla'=>'ncommaaccent',
        'Rcedilla'=>'Rcommaaccent',
        'rcedilla'=>'rcommaaccent',
        'Scedilla'=>'Scommaaccent',
        'scedilla'=>'scommaaccent',
        'Tcedilla'=>'Tcommaaccent',
        'tcedilla'=>'tcommaaccent',
        'Dslash'=>'Dcroat',
        'dslash'=>'dcroat',
        'Dmacron'=>'Dcroat',
        'dmacron'=>'dcroat',
        'combininggraveaccent'=>'gravecomb',
        'combininghookabove'=>'hookabovecomb',
        'combiningtildeaccent'=>'tildecomb',
        'combiningacuteaccent'=>'acutecomb',
        'combiningdotbelow'=>'dotbelowcomb',
        'dongsign'=>'dong'
        );
    foreach ($a as $l) {
        $e = explode(' ', rtrim($l));
        if (count($e) < 2) {
            continue;
        }
        $code = $e[0];
        $param = $e[1];
        if ($code == 'C') {
            //Character metrics
            $cc = (int)$e[1];
            $w = $e[4];
            $gn = $e[7];
            if (substr($gn, -4) == '20AC') {
                $gn = 'Euro';
            }
            if (isset($fix[$gn])) {
                //Fix incorrect glyph name
                foreach ($map as $c => $n) {
                    if ($n == $fix[$gn]) {
                        $map[$c] = $gn;
                    }
                }
            }
            if (empty($map)) {
                //Symbolic font: use built-in encoding
                $widths[$cc] = $w;
            } else {
                $widths[$gn] = $w;
                if ($gn == 'X') {
                    $fm['CapXHeight'] = $e[13];
                }
            }
            if ($gn == '.notdef') {
                $fm['MissingWidth'] = $w;
            }
        } elseif ($code == 'FontName') {
            $fm['FontName'] = $param;
        } elseif ($code == 'Weight') {
            $fm['Weight'] = $param;
        } elseif ($code == 'ItalicAngle') {
            $fm['ItalicAngle'] = (double)$param;
        } elseif ($code == 'Ascender') {
            $fm['Ascender'] = (int)$param;
        } elseif ($code == 'Descender') {
            $fm['Descender'] = (int)$param;
        } elseif ($code == 'UnderlineThickness') {
            $fm['UnderlineThickness'] = (int)$param;
        } elseif ($code == 'UnderlinePosition') {
            $fm['UnderlinePosition'] = (int)$param;
        } elseif ($code == 'IsFixedPitch') {
            $fm['IsFixedPitch'] = ($param == 'true');
        } elseif ($code == 'FontBBox') {
            $fm['FontBBox'] = array($e[1], $e[2], $e[3], $e[4]);
        } elseif ($code == 'CapHeight') {
            $fm['CapHeight'] = (int)$param;
        } elseif ($code == 'StdVW') {
            $fm['StdVW'] = (int)$param;
        }
    }
    if (!isset($fm['FontName'])) {
        die('FontName not found');
    }
    if (!empty($map)) {
        if (!isset($widths['.notdef'])) {
            $widths['.notdef'] = 600;
        }
        if (!isset($widths['Delta']) and isset($widths['increment'])) {
            $widths['Delta'] = $widths['increment'];
        }
        //Order widths according to map
        for ($i = 0; $i <= 255; $i++) {
            if (!isset($widths[$map[$i]])) {
                print "Warning: character ".$map[$i]." is missing\n";
                $widths[$i] = $widths['.notdef'];
            } else {
                $widths[$i] = $widths[$map[$i]];
            }
        }
    }
    $fm['Widths'] = $widths;
    return $fm;
}

function MakeFontDescriptor($fm, $symbolic=false)
{
    //Ascent
    $asc = (isset($fm['Ascender']) ? $fm['Ascender'] : 1000);
    $fd = "array('Ascent'=>".$asc;
    //Descent
    $desc = (isset($fm['Descender']) ? $fm['Descender'] : -200);
    $fd .= ",'Descent'=>".$desc;
    //CapHeight
    if (isset($fm['CapHeight'])) {
        $ch = $fm['CapHeight'];
    } elseif (isset($fm['CapXHeight'])) {
        $ch = $fm['CapXHeight'];
    } else {
        $ch = $asc;
    }
    $fd .= ",'CapHeight'=>".$ch;
    //Flags
    $flags = 0;
    if (isset($fm['IsFixedPitch']) and $fm['IsFixedPitch']) {
        $flags += 1<<0;
    }
    if ($symbolic) {
        $flags += 1<<2;
    } else {
        $flags += 1<<5;
    }
    if (isset($fm['ItalicAngle']) and ($fm['ItalicAngle'] != 0)) {
        $flags += 1<<6;
    }
    $fd .= ",'Flags'=>".$flags;
    //FontBBox
    if (isset($fm['FontBBox'])) {
        $fbb = $fm['FontBBox'];
    } else {
        $fbb = array(0, ($desc - 100), 1000, ($asc + 100));
    }
    $fd .= ",'FontBBox'=>'[".$fbb[0].' '.$fbb[1].' '.$fbb[2].' '.$fbb[3]."]'";
    //ItalicAngle
    $ia = (isset($fm['ItalicAngle']) ? $fm['ItalicAngle'] : 0);
    $fd .= ",'ItalicAngle'=>".$ia;
    //StemV
    if (isset($fm['StdVW'])) {
        $stemv = $fm['StdVW'];
    } elseif (isset($fm['Weight']) and eregi('(bold|black)', $fm['Weight'])) {
        $stemv = 120;
    } else {
        $stemv = 70;
    }
    $fd .= ",'StemV'=>".$stemv;
    //MissingWidth
    if (isset($fm['MissingWidth'])) {
        $fd .= ",'MissingWidth'=>".$fm['MissingWidth'];
    }
    $fd .= ')';
    return $fd;
}

function MakeWidthArray($fm)
{
    //Make character width array
    $s = 'array(';
    $cw = $fm['Widths'];
    $els = array();
    $c = 0;
    foreach ($cw as $i => $w) {
        if (is_numeric($i)) {
            $els[] = (((($c++)%10) == 0) ? "\n" : '').$i.'=>'.$w;
        }
    }
    $s .= implode(',', $els);
    $s .= ')';
    return $s;
}

function MakeFontEncoding($map)
{
    //Build differences from reference encoding
    $ref = ReadMap('cp1252');
    $s = '';
    $last = 0;
    for ($i = 32; $i <= 255; $i++) {
        if ($map[$i] != $ref[$i]) {
            if ($i != $last+1) {
                $s .= $i.' ';
            }
            $last = $i;
            $s .= '/'.$map[$i].' ';
        }
    }
    return rtrim($s);
}

function SaveToFile($file, $s, $mode='t')
{
    $f = fopen($file, 'w'.$mode);
    if (!$f) {
        die('Can\'t write to file '.$file);
    }
    fwrite($f, $s, strlen($s));
    fclose($f);
}

function ReadShort($f)
{
    $a = unpack('n1n', fread($f, 2));
    return $a['n'];
}

function ReadLong($f)
{
    $a = unpack('N1N', fread($f, 4));
    return $a['N'];
}

function CheckTTF($file)
{
    //Check if font license allows embedding
    $f = fopen($file, 'rb');
    if (!$f) {
        die('Error: unable to open '.$file);
    }
    //Extract number of tables
    fseek($f, 4, SEEK_CUR);
    $nb = ReadShort($f);
    fseek($f, 6, SEEK_CUR);
    //Seek OS/2 table
    $found = false;
    for ($i = 0; $i < $nb; $i++) {
        if (fread($f, 4) == 'OS/2') {
            $found = true;
            break;
        }
        fseek($f, 12, SEEK_CUR);
    }
    if (!$found) {
        fclose($f);
        return;
    }
    fseek($f, 4, SEEK_CUR);
    $offset = ReadLong($f);
    fseek($f, $offset, SEEK_SET);
    //Extract fsType flags
    fseek($f, 8, SEEK_CUR);
    $fsType = ReadShort($f);
    $rl = ($fsType & 0x02) != 0;
    $pp = ($fsType & 0x04) != 0;
    $e = ($fsType & 0x08) != 0;
    fclose($f);
    if ($rl and (!$pp) and (!$e)) {
        print "Warning: font license does not allow embedding\n";
    }
}
// BEGIN SUGARCRM SPECIFIC
/*
// END SUGARCRM SPECIFIC

$arg = $GLOBALS['argv'];
if (count($arg) >= 3) {
    ob_start();
    array_shift($arg);
    if (sizeof($arg) == 3) {
        $arg[3] = $arg[2];
        $arg[2] = true;
    } else {
        if (!isset($arg[2])) {
            $arg[2] = true;
        }
        if (!isset($arg[3])) {
            $arg[3] = 'cp1252';
        }
    }
    if (!isset($arg[4])) {
        $arg[4] = array();
    }
    MakeFont($arg[0], $arg[1], $arg[2], $arg[3], $arg[4]);
    $t = ob_get_clean();
    print preg_replace('!<BR( /)?>!i', "\n", $t);
} else {
    print "Usage: makefont.php <ttf/otf/pfb file> <afm/ufm file> <encoding> <patch>\n";
}

// BEGIN SUGARCRM SPECIFIC
*/
// END SUGARCRM SPECIFIC
