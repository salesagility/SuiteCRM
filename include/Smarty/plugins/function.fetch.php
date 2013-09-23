<?php

/*

Modification information for LGPL compliance

r56990 - 2010-06-16 13:05:36 -0700 (Wed, 16 Jun 2010) - kjing - snapshot "Mango" svn branch to a new one for GitHub sync

r56989 - 2010-06-16 13:01:33 -0700 (Wed, 16 Jun 2010) - kjing - defunt "Mango" svn dev branch before github cutover

r55980 - 2010-04-19 13:31:28 -0700 (Mon, 19 Apr 2010) - kjing - create Mango (6.1) based on windex

r51719 - 2009-10-22 10:18:00 -0700 (Thu, 22 Oct 2009) - mitani - Converted to Build 3  tags and updated the build system 

r51634 - 2009-10-19 13:32:22 -0700 (Mon, 19 Oct 2009) - mitani - Windex is the branch for Sugar Sales 1.0 development

r51443 - 2009-10-12 13:34:36 -0700 (Mon, 12 Oct 2009) - jmertic - Bug 33332 - Made application PHP 5.3 compliant with E_DEPRECATED warnings on by:
- Changing all ereg function to either preg or simple string based ones
- No more references to magic quotes.
- Change all the session_unregister() functions to just unset() the correct session variable instead.

r50375 - 2009-08-24 18:07:43 -0700 (Mon, 24 Aug 2009) - dwong - branch kobe2 from tokyo r50372

r42807 - 2008-12-29 11:16:59 -0800 (Mon, 29 Dec 2008) - dwong - Branch from trunk/sugarcrm r42806 to branches/tokyo/sugarcrm

r10971 - 2006-01-12 14:58:30 -0800 (Thu, 12 Jan 2006) - chris - Bug 4128: updating Smarty templates to 2.6.11, a version supposedly that plays better with PHP 5.1

r8230 - 2005-10-03 17:47:19 -0700 (Mon, 03 Oct 2005) - majed - Added Sugar_Smarty to the code tree.


*/


/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {fetch} plugin
 *
 * Type:     function<br>
 * Name:     fetch<br>
 * Purpose:  fetch file, web or ftp data and display results
 * @link http://smarty.php.net/manual/en/language.function.fetch.php {fetch}
 *       (Smarty online manual)
 * @author Monte Ohrt <monte at ohrt dot com>
 * @param array
 * @param Smarty
 * @return string|null if the assign parameter is passed, Smarty assigns the
 *                     result to a template variable
 */
function smarty_function_fetch($params, &$smarty)
{
    if (empty($params['file'])) {
        $smarty->_trigger_fatal_error("[plugin] parameter 'file' cannot be empty");
        return;
    }

    $content = '';
    if ($smarty->security && !preg_match('!^(http|ftp)://!i', $params['file'])) {
        $_params = array('resource_type' => 'file', 'resource_name' => $params['file']);
        require_once(SMARTY_CORE_DIR . 'core.is_secure.php');
        if(!smarty_core_is_secure($_params, $smarty)) {
            $smarty->_trigger_fatal_error('[plugin] (secure mode) fetch \'' . $params['file'] . '\' is not allowed');
            return;
        }
        
        // fetch the file
        if($fp = @fopen($params['file'],'r')) {
            while(!feof($fp)) {
                $content .= fgets ($fp,4096);
            }
            fclose($fp);
        } else {
            $smarty->_trigger_fatal_error('[plugin] fetch cannot read file \'' . $params['file'] . '\'');
            return;
        }
    } else {
        // not a local file
        if(preg_match('!^http://!i',$params['file'])) {
            // http fetch
            if($uri_parts = parse_url($params['file'])) {
                // set defaults
                $host = $server_name = $uri_parts['host'];
                $timeout = 30;
                $accept = "image/gif, image/x-xbitmap, image/jpeg, image/pjpeg, */*";
                $agent = "Smarty Template Engine ".$smarty->_version;
                $referer = "";
                $uri = !empty($uri_parts['path']) ? $uri_parts['path'] : '/';
                $uri .= !empty($uri_parts['query']) ? '?' . $uri_parts['query'] : '';
                $_is_proxy = false;
                if(empty($uri_parts['port'])) {
                    $port = 80;
                } else {
                    $port = $uri_parts['port'];
                }
                if(!empty($uri_parts['user'])) {
                    $user = $uri_parts['user'];
                }
                if(!empty($uri_parts['pass'])) {
                    $pass = $uri_parts['pass'];
                }
                // loop through parameters, setup headers
                foreach($params as $param_key => $param_value) {
                    switch($param_key) {
                        case "file":
                        case "assign":
                        case "assign_headers":
                            break;
                        case "user":
                            if(!empty($param_value)) {
                                $user = $param_value;
                            }
                            break;
                        case "pass":
                            if(!empty($param_value)) {
                                $pass = $param_value;
                            }
                            break;
                        case "accept":
                            if(!empty($param_value)) {
                                $accept = $param_value;
                            }
                            break;
                        case "header":
                            if(!empty($param_value)) {
                                if(!preg_match('![\w\d-]+: .+!',$param_value)) {
                                    $smarty->_trigger_fatal_error("[plugin] invalid header format '".$param_value."'");
                                    return;
                                } else {
                                    $extra_headers[] = $param_value;
                                }
                            }
                            break;
                        case "proxy_host":
                            if(!empty($param_value)) {
                                $proxy_host = $param_value;
                            }
                            break;
                        case "proxy_port":
                            if(!preg_match('!\D!', $param_value)) {
                                $proxy_port = (int) $param_value;
                            } else {
                                $smarty->_trigger_fatal_error("[plugin] invalid value for attribute '".$param_key."'");
                                return;
                            }
                            break;
                        case "agent":
                            if(!empty($param_value)) {
                                $agent = $param_value;
                            }
                            break;
                        case "referer":
                            if(!empty($param_value)) {
                                $referer = $param_value;
                            }
                            break;
                        case "timeout":
                            if(!preg_match('!\D!', $param_value)) {
                                $timeout = (int) $param_value;
                            } else {
                                $smarty->_trigger_fatal_error("[plugin] invalid value for attribute '".$param_key."'");
                                return;
                            }
                            break;
                        default:
                            $smarty->_trigger_fatal_error("[plugin] unrecognized attribute '".$param_key."'");
                            return;
                    }
                }
                if(!empty($proxy_host) && !empty($proxy_port)) {
                    $_is_proxy = true;
                    $fp = fsockopen($proxy_host,$proxy_port,$errno,$errstr,$timeout);
                } else {
                    $fp = fsockopen($server_name,$port,$errno,$errstr,$timeout);
                }

                if(!$fp) {
                    $smarty->_trigger_fatal_error("[plugin] unable to fetch: $errstr ($errno)");
                    return;
                } else {
                    if($_is_proxy) {
                        fputs($fp, 'GET ' . $params['file'] . " HTTP/1.0\r\n");
                    } else {
                        fputs($fp, "GET $uri HTTP/1.0\r\n");
                    }
                    if(!empty($host)) {
                        fputs($fp, "Host: $host\r\n");
                    }
                    if(!empty($accept)) {
                        fputs($fp, "Accept: $accept\r\n");
                    }
                    if(!empty($agent)) {
                        fputs($fp, "User-Agent: $agent\r\n");
                    }
                    if(!empty($referer)) {
                        fputs($fp, "Referer: $referer\r\n");
                    }
                    if(isset($extra_headers) && is_array($extra_headers)) {
                        foreach($extra_headers as $curr_header) {
                            fputs($fp, $curr_header."\r\n");
                        }
                    }
                    if(!empty($user) && !empty($pass)) {
                        fputs($fp, "Authorization: BASIC ".base64_encode("$user:$pass")."\r\n");
                    }

                    fputs($fp, "\r\n");
                    while(!feof($fp)) {
                        $content .= fgets($fp,4096);
                    }
                    fclose($fp);
                    $csplit = explode("\r\n\r\n",$content,2);

                    $content = $csplit[1];

                    if(!empty($params['assign_headers'])) {
                        $smarty->assign($params['assign_headers'],explode("\r\n",$csplit[0]));
                    }
                }
            } else {
                $smarty->_trigger_fatal_error("[plugin] unable to parse URL, check syntax");
                return;
            }
        } else {
            // ftp fetch
            if($fp = @fopen($params['file'],'r')) {
                while(!feof($fp)) {
                    $content .= fgets ($fp,4096);
                }
                fclose($fp);
            } else {
                $smarty->_trigger_fatal_error('[plugin] fetch cannot read file \'' . $params['file'] .'\'');
                return;
            }
        }

    }


    if (!empty($params['assign'])) {
        $smarty->assign($params['assign'],$content);
    } else {
        return $content;
    }
}

/* vim: set expandtab: */

?>
