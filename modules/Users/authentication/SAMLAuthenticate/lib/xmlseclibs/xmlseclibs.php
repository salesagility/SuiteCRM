<?php
/**
 * xmlseclibs.php
 *
 * Copyright (c) 2007, Robert Richards <rrichards@cdatazone.org>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Robert Richards nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @author     Robert Richards <rrichards@cdatazone.org>
 * @copyright  2007 Robert Richards <rrichards@cdatazone.org>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    1.2.2
 */

/*
Functions to generate simple cases of Exclusive Canonical XML - Callable function is C14NGeneral()
i.e.: $canonical = C14NGeneral($domelement, TRUE);
*/

/* helper function */
function sortAndAddAttrs($element, $arAtts) {
   $newAtts = array();
   foreach ($arAtts AS $attnode) {
      $newAtts[$attnode->nodeName] = $attnode;
   }
   ksort($newAtts);
   foreach ($newAtts as $attnode) {
      $element->setAttribute($attnode->nodeName, $attnode->nodeValue);
   }
}

/* helper function */
function canonical($tree, $element, $withcomments) {
    if ($tree->nodeType != XML_DOCUMENT_NODE) {
        $dom = $tree->ownerDocument;
    } else {
        $dom = $tree;
    }
    if ($element->nodeType != XML_ELEMENT_NODE) {
        if ($element->nodeType == XML_DOCUMENT_NODE) {
            foreach ($element->childNodes AS $node) {
                canonical($dom, $node, $withcomments);
            }
            return;
        }
        if ($element->nodeType == XML_COMMENT_NODE && ! $withcomments) {
            return;
        }
        $tree->appendChild($dom->importNode($element, TRUE));
        return;
    }
    $arNS = array();
    if ($element->namespaceURI != "") {
        if ($element->prefix == "") {
            $elCopy = $dom->createElementNS($element->namespaceURI, $element->nodeName);
        } else {
            $prefix = $tree->lookupPrefix($element->namespaceURI);
            if ($prefix == $element->prefix) {
                $elCopy = $dom->createElementNS($element->namespaceURI, $element->nodeName);
            } else {
                $elCopy = $dom->createElement($element->nodeName);
                $arNS[$element->namespaceURI] = $element->prefix;
            }
        }
    } else {
        $elCopy = $dom->createElement($element->nodeName);
    }
    $tree->appendChild($elCopy);

    /* Create DOMXPath based on original document */
    $xPath = new DOMXPath($element->ownerDocument);

    /* Get namespaced attributes */
    $arAtts = $xPath->query('attribute::*[namespace-uri(.) != ""]', $element);

    /* Create an array with namespace URIs as keys, and sort them */
    foreach ($arAtts AS $attnode) {
        if (array_key_exists($attnode->namespaceURI, $arNS) &&
            ($arNS[$attnode->namespaceURI] == $attnode->prefix)) {
            continue;
        }
        $prefix = $tree->lookupPrefix($attnode->namespaceURI);
        if ($prefix != $attnode->prefix) {
           $arNS[$attnode->namespaceURI] = $attnode->prefix;
        } else {
            $arNS[$attnode->namespaceURI] = NULL;
        }
    }
    if (count($arNS) > 0) {
        asort($arNS);
    }

    /* Add namespace nodes */
    foreach ($arNS AS $namespaceURI=>$prefix) {
        if ($prefix != NULL) {
              $elCopy->setAttributeNS("http://www.w3.org/2000/xmlns/",
                               "xmlns:".$prefix, $namespaceURI);
        }
    }
    if (count($arNS) > 0) {
        ksort($arNS);
    }

    /* Get attributes not in a namespace, and then sort and add them */
    $arAtts = $xPath->query('attribute::*[namespace-uri(.) = ""]', $element);
    sortAndAddAttrs($elCopy, $arAtts);

    /* Loop through the URIs, and then sort and add attributes within that namespace */
    foreach ($arNS as $nsURI=>$prefix) {
       $arAtts = $xPath->query('attribute::*[namespace-uri(.) = "'.$nsURI.'"]', $element);
       sortAndAddAttrs($elCopy, $arAtts);
    }

    foreach ($element->childNodes AS $node) {
        canonical($elCopy, $node, $withcomments);
    }
}

/*
$element - DOMElement for which to produce the canonical version of
$exclusive - boolean to indicate exclusive canonicalization (must pass TRUE)
$withcomments - boolean indicating wether or not to include comments in canonicalized form
*/
function C14NGeneral($element, $exclusive=FALSE, $withcomments=FALSE) {
    /* IF PHP 5.2+ then use built in canonical functionality */
    $php_version = explode('.', PHP_VERSION);
    if (($php_version[0] > 5) || ($php_version[0] == 5 && $php_version[1] >= 2) ) {
        return $element->C14N($exclusive, $withcomments);
    }

    /* Must be element or document */
    if (! $element instanceof DOMElement && ! $element instanceof DOMDocument) {
        return NULL;
    }
    /* Currently only exclusive XML is supported */
    if ($exclusive == FALSE) {
        throw new Exception("Only exclusive canonicalization is supported in this version of PHP");
    }

    $copyDoc = new DOMDocument();
    canonical($copyDoc, $element, $withcomments);
    return $copyDoc->saveXML($copyDoc->documentElement, LIBXML_NOEMPTYTAG);
}

class XMLSecurityKey {
    const TRIPLEDES_CBC = 'http://www.w3.org/2001/04/xmlenc#tripledes-cbc';
    const AES128_CBC = 'http://www.w3.org/2001/04/xmlenc#aes128-cbc';
    const AES192_CBC = 'http://www.w3.org/2001/04/xmlenc#aes192-cbc';
    const AES256_CBC = 'http://www.w3.org/2001/04/xmlenc#aes256-cbc';
    const RSA_1_5 = 'http://www.w3.org/2001/04/xmlenc#rsa-1_5';
    const RSA_OAEP_MGF1P = 'http://www.w3.org/2001/04/xmlenc#rsa-oaep-mgf1p';
    const DSA_SHA1 = 'http://www.w3.org/2000/09/xmldsig#dsa-sha1';
    const RSA_SHA1 = 'http://www.w3.org/2000/09/xmldsig#rsa-sha1';
    const RSA_SHA256 = 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256';

    private $cryptParams = array();
    public $type = 0;
    public $key = NULL;
    public $passphrase = "";
    public $iv = NULL;
    public $name = NULL;
    public $keyChain = NULL;
    public $isEncrypted = FALSE;
    public $encryptedCtx = NULL;
    public $guid = NULL;

    /**
     * This variable contains the certificate as a string if this key represents an X509-certificate.
     * If this key doesn't represent a certificate, this will be NULL.
     */
    private $x509Certificate = NULL;

    public function __construct($type, $params=NULL) {
        srand();
        switch ($type) {
            case (XMLSecurityKey::TRIPLEDES_CBC):
                $this->cryptParams['library'] = 'mcrypt';
                $this->cryptParams['cipher'] = MCRYPT_TRIPLEDES;
                $this->cryptParams['mode'] = MCRYPT_MODE_CBC;
                $this->cryptParams['method'] = 'http://www.w3.org/2001/04/xmlenc#tripledes-cbc';
                break;
            case (XMLSecurityKey::AES128_CBC):
                $this->cryptParams['library'] = 'mcrypt';
                $this->cryptParams['cipher'] = MCRYPT_RIJNDAEL_128;
                $this->cryptParams['mode'] = MCRYPT_MODE_CBC;
                $this->cryptParams['method'] = 'http://www.w3.org/2001/04/xmlenc#aes128-cbc';
                break;
            case (XMLSecurityKey::AES192_CBC):
                $this->cryptParams['library'] = 'mcrypt';
                $this->cryptParams['cipher'] = MCRYPT_RIJNDAEL_128;
                $this->cryptParams['mode'] = MCRYPT_MODE_CBC;
                $this->cryptParams['method'] = 'http://www.w3.org/2001/04/xmlenc#aes192-cbc';
                break;
            case (XMLSecurityKey::AES256_CBC):
                $this->cryptParams['library'] = 'mcrypt';
                $this->cryptParams['cipher'] = MCRYPT_RIJNDAEL_128;
                $this->cryptParams['mode'] = MCRYPT_MODE_CBC;
                $this->cryptParams['method'] = 'http://www.w3.org/2001/04/xmlenc#aes256-cbc';
                break;
            case (XMLSecurityKey::RSA_1_5):
                $this->cryptParams['library'] = 'openssl';
                $this->cryptParams['padding'] = OPENSSL_PKCS1_PADDING;
                $this->cryptParams['method'] = 'http://www.w3.org/2001/04/xmlenc#rsa-1_5';
                if (is_array($params) && ! empty($params['type'])) {
                    if ($params['type'] == 'public' || $params['type'] == 'private') {
                        $this->cryptParams['type'] = $params['type'];
                        break;
                    }
                }
                throw new Exception('Certificate "type" (private/public) must be passed via parameters');
                return;
            case (XMLSecurityKey::RSA_OAEP_MGF1P):
                $this->cryptParams['library'] = 'openssl';
                $this->cryptParams['padding'] = OPENSSL_PKCS1_OAEP_PADDING;
                $this->cryptParams['method'] = 'http://www.w3.org/2001/04/xmlenc#rsa-oaep-mgf1p';
                $this->cryptParams['hash'] = NULL;
                if (is_array($params) && ! empty($params['type'])) {
                    if ($params['type'] == 'public' || $params['type'] == 'private') {
                        $this->cryptParams['type'] = $params['type'];
                        break;
                    }
                }
                throw new Exception('Certificate "type" (private/public) must be passed via parameters');
                return;
            case (XMLSecurityKey::RSA_SHA1):
                $this->cryptParams['library'] = 'openssl';
                $this->cryptParams['method'] = 'http://www.w3.org/2000/09/xmldsig#rsa-sha1';
                $this->cryptParams['padding'] = OPENSSL_PKCS1_PADDING;
                if (is_array($params) && ! empty($params['type'])) {
                    if ($params['type'] == 'public' || $params['type'] == 'private') {
                        $this->cryptParams['type'] = $params['type'];
                        break;
                    }
                }
                throw new Exception('Certificate "type" (private/public) must be passed via parameters');
                break;
            case (XMLSecurityKey::RSA_SHA256):
                $this->cryptParams['library'] = 'openssl';
                $this->cryptParams['method'] = 'http://www.w3.org/2001/04/xmldsig-more#rsa-sha256';
                $this->cryptParams['padding'] = OPENSSL_PKCS1_PADDING;
                $this->cryptParams['digest'] = 'SHA256';
                if (is_array($params) && ! empty($params['type'])) {
                    if ($params['type'] == 'public' || $params['type'] == 'private') {
                        $this->cryptParams['type'] = $params['type'];
                        break;
                    }
                }
                throw new Exception('Certificate "type" (private/public) must be passed via parameters');
                break;
            default:
                throw new Exception('Invalid Key Type');
                return;
        }
        $this->type = $type;
    }

    public function generateSessionKey() {
        $key = '';
        if (! empty($this->cryptParams['cipher']) && ! empty($this->cryptParams['mode'])) {
            $keysize = mcrypt_module_get_algo_key_size($this->cryptParams['cipher']);
            /* Generating random key using iv generation routines */
            if (($keysize > 0) && ($td = mcrypt_module_open(MCRYPT_RIJNDAEL_256, '',$this->cryptParams['mode'], ''))) {
                if ($this->cryptParams['cipher'] == MCRYPT_RIJNDAEL_128) {
                    $keysize = 16;
                    if ($this->type == XMLSecurityKey::AES256_CBC) {
                        $keysize = 32;
                    } elseif ($this->type == XMLSecurityKey::AES192_CBC) {
                        $keysize = 24;
                    }
                }
                while (strlen($key) < $keysize) {
                    $key .= mcrypt_create_iv(mcrypt_enc_get_iv_size ($td),MCRYPT_RAND);
                }
                mcrypt_module_close($td);
                $key = substr($key, 0, $keysize);
                $this->key = $key;
            }
        }
        return $key;
    }

    public function loadKey($key, $isFile=FALSE, $isCert = FALSE) {
        if ($isFile) {
            $this->key = file_get_contents($key);
        } else {
            $this->key = $key;
        }
        if ($isCert) {
            $this->key = openssl_x509_read($this->key);
            openssl_x509_export($this->key, $str_cert);
            $this->x509Certificate = $str_cert;
            $this->key = $str_cert;
        } else {
            $this->x509Certificate = NULL;
        }
        if ($this->cryptParams['library'] == 'openssl') {
            if ($this->cryptParams['type'] == 'public') {
                // Disable this part due to openssl bug on some systems
                // that think public key is private key. Certificate
                // should still serve as key for verification purposes
                // By smalyshev 1 May 2012
                 // $this->key = openssl_get_publickey($this->key);
            } else {
                $this->key = openssl_get_privatekey($this->key, $this->passphrase);
            }
        } else if ($this->cryptParams['cipher'] == MCRYPT_RIJNDAEL_128) {
            /* Check key length */
            switch ($this->type) {
                case (XMLSecurityKey::AES256_CBC):
                    if (strlen($this->key) < 25) {
                        throw new Exception('Key must contain at least 25 characters for this cipher');
                    }
                    break;
                case (XMLSecurityKey::AES192_CBC):
                    if (strlen($this->key) < 17) {
                        throw new Exception('Key must contain at least 17 characters for this cipher');
                    }
                    break;
            }
        }
    }

    private function encryptMcrypt($data) {
        $td = mcrypt_module_open($this->cryptParams['cipher'], '', $this->cryptParams['mode'], '');
        $this->iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $this->key, $this->iv);
        if ($this->cryptParams['mode'] == MCRYPT_MODE_CBC) {
            $bs = mcrypt_enc_get_block_size($td);
            for ($datalen0=$datalen=strlen($data); (($datalen%$bs)!=($bs-1)); $datalen++)
                $data.=chr(rand(1, 127));
            $data.=chr($datalen-$datalen0+1);
        }
        $encrypted_data = $this->iv.mcrypt_generic($td, $data);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return $encrypted_data;
    }

    private function decryptMcrypt($data) {
        $td = mcrypt_module_open($this->cryptParams['cipher'], '', $this->cryptParams['mode'], '');
        $iv_length = mcrypt_enc_get_iv_size($td);

        $this->iv = substr($data, 0, $iv_length);
        $data = substr($data, $iv_length);

        mcrypt_generic_init($td, $this->key, $this->iv);
        $decrypted_data = mdecrypt_generic($td, $data);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        if ($this->cryptParams['mode'] == MCRYPT_MODE_CBC) {
            $dataLen = strlen($decrypted_data);
            $paddingLength = substr($decrypted_data, $dataLen - 1, 1);
            $decrypted_data = substr($decrypted_data, 0, $dataLen - ord($paddingLength));
        }
        return $decrypted_data;
    }

    private function encryptOpenSSL($data) {
        if ($this->cryptParams['type'] == 'public') {
            if (! openssl_public_encrypt($data, $encrypted_data, $this->key, $this->cryptParams['padding'])) {
                throw new Exception('Failure encrypting Data');
                return;
            }
        } else {
            if (! openssl_private_encrypt($data, $encrypted_data, $this->key, $this->cryptParams['padding'])) {
                throw new Exception('Failure encrypting Data');
                return;
            }
        }
        return $encrypted_data;
    }

    private function decryptOpenSSL($data) {
        if ($this->cryptParams['type'] == 'public') {
            if (! openssl_public_decrypt($data, $decrypted, $this->key, $this->cryptParams['padding'])) {
                throw new Exception('Failure decrypting Data');
                return;
            }
        } else {
            if (! openssl_private_decrypt($data, $decrypted, $this->key, $this->cryptParams['padding'])) {
                throw new Exception('Failure decrypting Data');
                return;
            }
        }
        return $decrypted;
    }

    private function signOpenSSL($data) {
	    $algo = OPENSSL_ALGO_SHA1;
	    if (! empty($this->cryptParams['digest'])) {
	        $algo = $this->cryptParams['digest'];
	    }
        if (! openssl_sign ($data, $signature, $this->key, $algo)) {
            throw new Exception('Failure Signing Data: ' . openssl_error_string() . ' - ' . $algo);
            return;
        }
        return $signature;
    }

    private function verifyOpenSSL($data, $signature) {
	    $algo = OPENSSL_ALGO_SHA1;
	    if (! empty($this->cryptParams['digest'])) {
	        $algo = $this->cryptParams['digest'];
	    }
        return openssl_verify ($data, $signature, $this->key, $algo);
    }

    public function encryptData($data) {
        switch ($this->cryptParams['library']) {
            case 'mcrypt':
                return $this->encryptMcrypt($data);
                break;
            case 'openssl':
                return $this->encryptOpenSSL($data);
                break;
        }
    }

    public function decryptData($data) {
        switch ($this->cryptParams['library']) {
            case 'mcrypt':
                return $this->decryptMcrypt($data);
                break;
            case 'openssl':
                return $this->decryptOpenSSL($data);
                break;
        }
    }

    public function signData($data) {
        switch ($this->cryptParams['library']) {
            case 'openssl':
                return $this->signOpenSSL($data);
                break;
        }
    }

    public function verifySignature($data, $signature) {
        switch ($this->cryptParams['library']) {
            case 'openssl':
                return $this->verifyOpenSSL($data, $signature);
                break;
        }
    }

    public function getAlgorith() {
        return $this->cryptParams['method'];
    }

    static function makeAsnSegment($type, $string) {
        switch ($type){
            case 0x02:
                if (ord($string) > 0x7f)
                    $string = chr(0).$string;
                break;
            case 0x03:
                $string = chr(0).$string;
                break;
        }

        $length = strlen($string);

        if ($length < 128){
           $output = sprintf("%c%c%s", $type, $length, $string);
        } else if ($length < 0x0100){
           $output = sprintf("%c%c%c%s", $type, 0x81, $length, $string);
        } else if ($length < 0x010000) {
           $output = sprintf("%c%c%c%c%s", $type, 0x82, $length/0x0100, $length%0x0100, $string);
        } else {
            $output = NULL;
        }
        return($output);
    }

    /* Modulus and Exponent must already be base64 decoded */
    static function convertRSA($modulus, $exponent) {
        /* make an ASN publicKeyInfo */
        $exponentEncoding = XMLSecurityKey::makeAsnSegment(0x02, $exponent);
        $modulusEncoding = XMLSecurityKey::makeAsnSegment(0x02, $modulus);
        $sequenceEncoding = XMLSecurityKey:: makeAsnSegment(0x30, $modulusEncoding.$exponentEncoding);
        $bitstringEncoding = XMLSecurityKey::makeAsnSegment(0x03, $sequenceEncoding);
        $rsaAlgorithmIdentifier = pack("H*", "300D06092A864886F70D0101010500");
        $publicKeyInfo = XMLSecurityKey::makeAsnSegment (0x30, $rsaAlgorithmIdentifier.$bitstringEncoding);

        /* encode the publicKeyInfo in base64 and add PEM brackets */
        $publicKeyInfoBase64 = base64_encode($publicKeyInfo);
        $encoding = "-----BEGIN PUBLIC KEY-----\n";
        $offset = 0;
        while ($segment=substr($publicKeyInfoBase64, $offset, 64)){
           $encoding = $encoding.$segment."\n";
           $offset += 64;
        }
        return $encoding."-----END PUBLIC KEY-----\n";
    }

    public function serializeKey($parent) {

    }



    /**
     * Retrieve the X509 certificate this key represents.
     *
     * Will return the X509 certificate in PEM-format if this key represents
     * an X509 certificate.
     *
     * @return  The X509 certificate or NULL if this key doesn't represent an X509-certificate.
     */
    public function getX509Certificate() {
        return $this->x509Certificate;
    }

}

class XMLSecurityDSig {
    const XMLDSIGNS = 'http://www.w3.org/2000/09/xmldsig#';
    const SHA1 = 'http://www.w3.org/2000/09/xmldsig#sha1';
    const SHA256 = 'http://www.w3.org/2001/04/xmlenc#sha256';
    const SHA512 = 'http://www.w3.org/2001/04/xmlenc#sha512';
    const RIPEMD160 = 'http://www.w3.org/2001/04/xmlenc#ripemd160';

    const C14N = 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315';
    const C14N_COMMENTS = 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315#WithComments';
    const EXC_C14N = 'http://www.w3.org/2001/10/xml-exc-c14n#';
    const EXC_C14N_COMMENTS = 'http://www.w3.org/2001/10/xml-exc-c14n#WithComments';

    const template = '<ds:Signature xmlns:ds="http://www.w3.org/2000/09/xmldsig#">
  <ds:SignedInfo>
    <ds:SignatureMethod />
  </ds:SignedInfo>
</ds:Signature>';

    public $sigNode = NULL;
    public $idKeys = array();
    public $idNS = array();
    private $signedInfo = NULL;
    private $xPathCtx = NULL;
    private $canonicalMethod = NULL;
    private $prefix = 'ds';
    private $searchpfx = 'secdsig';

    /* This variable contains an associative array of validated nodes. */
    private $validatedNodes = NULL;

    public function __construct() {
        $sigdoc = new DOMDocument();
        $sigdoc->loadXML(XMLSecurityDSig::template);
        $this->sigNode = $sigdoc->documentElement;
    }

    private function getXPathObj() {
        if (empty($this->xPathCtx) && ! empty($this->sigNode)) {
            $xpath = new DOMXPath($this->sigNode->ownerDocument);
            $xpath->registerNamespace('secdsig', XMLSecurityDSig::XMLDSIGNS);
            $this->xPathCtx = $xpath;
        }
        return $this->xPathCtx;
    }

    static function generate_GUID($prefix='pfx') {
        $uuid = md5(uniqid(rand(), true));
        $guid =  $prefix.substr($uuid,0,8)."-".
                substr($uuid,8,4)."-".
                substr($uuid,12,4)."-".
                substr($uuid,16,4)."-".
                substr($uuid,20,12);
        return $guid;
    }

    public function locateSignature($objDoc) {
        if ($objDoc instanceof DOMDocument) {
            $doc = $objDoc;
        } else {
            $doc = $objDoc->ownerDocument;
        }
        if ($doc) {
            $xpath = new DOMXPath($doc);
            $xpath->registerNamespace('secdsig', XMLSecurityDSig::XMLDSIGNS);
            $query = ".//secdsig:Signature";
            $nodeset = $xpath->query($query, $objDoc);
            $this->sigNode = $nodeset->item(0);
            return $this->sigNode;
        }
        return NULL;
    }

    public function createNewSignNode($name, $value=NULL) {
        $doc = $this->sigNode->ownerDocument;
        if (! is_null($value)) {
            $node = $doc->createElementNS(XMLSecurityDSig::XMLDSIGNS, $this->prefix.':'.$name, $value);
        } else {
            $node = $doc->createElementNS(XMLSecurityDSig::XMLDSIGNS, $this->prefix.':'.$name);
        }
        return $node;
    }

    public function setCanonicalMethod($method) {
        switch ($method) {
            case 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315':
            case 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315#WithComments':
            case 'http://www.w3.org/2001/10/xml-exc-c14n#':
            case 'http://www.w3.org/2001/10/xml-exc-c14n#WithComments':
                $this->canonicalMethod = $method;
                break;
            default:
                throw new Exception('Invalid Canonical Method');
        }
        if ($xpath = $this->getXPathObj()) {
            $query = './'.$this->searchpfx.':SignedInfo';
            $nodeset = $xpath->query($query, $this->sigNode);
            if ($sinfo = $nodeset->item(0)) {
                $query = './'.$this->searchpfx.'CanonicalizationMethod';
                $nodeset = $xpath->query($query, $sinfo);
                if (! ($canonNode = $nodeset->item(0))) {
                    $canonNode = $this->createNewSignNode('CanonicalizationMethod');
                    $sinfo->insertBefore($canonNode, $sinfo->firstChild);
                }
                $canonNode->setAttribute('Algorithm', $this->canonicalMethod);
            }
        }
    }

    private function canonicalizeData($node, $canonicalmethod, $arXPath=NULL, $prefixList=NULL) {
        $exclusive = FALSE;
        $withComments = FALSE;
        switch ($canonicalmethod) {
            case 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315':
                $exclusive = FALSE;
                $withComments = FALSE;
                break;
            case 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315#WithComments':
                $withComments = TRUE;
                break;
            case 'http://www.w3.org/2001/10/xml-exc-c14n#':
                $exclusive = TRUE;
                break;
            case 'http://www.w3.org/2001/10/xml-exc-c14n#WithComments':
                $exclusive = TRUE;
                $withComments = TRUE;
                break;
        }
/* Support PHP versions < 5.2 not containing C14N methods in DOM extension */
        $php_version = explode('.', PHP_VERSION);
        if (($php_version[0] < 5) || ($php_version[0] == 5 && $php_version[1] < 2) ) {
            if (! is_null($arXPath)) {
                throw new Exception("PHP 5.2.0 or higher is required to perform XPath Transformations");
            }
            return C14NGeneral($node, $exclusive, $withComments);
        }
        return $node->C14N($exclusive, $withComments, $arXPath, $prefixList);
    }

    public function canonicalizeSignedInfo() {

        $doc = $this->sigNode->ownerDocument;
        $canonicalmethod = NULL;
        if ($doc) {
            $xpath = $this->getXPathObj();
            $query = "./secdsig:SignedInfo";
            $nodeset = $xpath->query($query, $this->sigNode);
            if ($signInfoNode = $nodeset->item(0)) {
                $query = "./secdsig:CanonicalizationMethod";
                $nodeset = $xpath->query($query, $signInfoNode);
                if ($canonNode = $nodeset->item(0)) {
                    $canonicalmethod = $canonNode->getAttribute('Algorithm');
                }
                $this->signedInfo = $this->canonicalizeData($signInfoNode, $canonicalmethod);
                return $this->signedInfo;
            }
        }
        return NULL;
    }

    public function calculateDigest ($digestAlgorithm, $data) {
        switch ($digestAlgorithm) {
            case XMLSecurityDSig::SHA1:
                $alg = 'sha1';
                break;
            case XMLSecurityDSig::SHA256:
                $alg = 'sha256';
                break;
            case XMLSecurityDSig::SHA512:
                $alg = 'sha512';
                break;
            case XMLSecurityDSig::RIPEMD160:
                $alg = 'ripemd160';
                break;
            default:
                throw new Exception("Cannot validate digest: Unsupported Algorith <$digestAlgorithm>");
        }
        if (function_exists('hash')) {
            return base64_encode(hash($alg, $data, TRUE));
        } elseif (function_exists('mhash')) {
            $alg = "MHASH_" . strtoupper($alg);
            return base64_encode(mhash(constant($alg), $data));
        } elseif ($alg === 'sha1') {
            return base64_encode(sha1($data, TRUE));
        } else {
            throw new Exception('xmlseclibs is unable to calculate a digest. Maybe you need the mhash library?');
        }
    }

    public function validateDigest($refNode, $data) {
        $xpath = new DOMXPath($refNode->ownerDocument);
        $xpath->registerNamespace('secdsig', XMLSecurityDSig::XMLDSIGNS);
        $query = 'string(./secdsig:DigestMethod/@Algorithm)';
        $digestAlgorithm = $xpath->evaluate($query, $refNode);
        $digValue = $this->calculateDigest($digestAlgorithm, $data);
        $query = 'string(./secdsig:DigestValue)';
        $digestValue = $xpath->evaluate($query, $refNode);
        return ($digValue == $digestValue);
    }

    public function processTransforms($refNode, $objData) {
        $data = $objData;
        $xpath = new DOMXPath($refNode->ownerDocument);
        $xpath->registerNamespace('secdsig', XMLSecurityDSig::XMLDSIGNS);
        $query = './secdsig:Transforms/secdsig:Transform';
        $nodelist = $xpath->query($query, $refNode);
        $canonicalMethod = 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315';
        $arXPath = NULL;
        $prefixList = NULL;
        foreach ($nodelist AS $transform) {
            $algorithm = $transform->getAttribute("Algorithm");
            switch ($algorithm) {
                case 'http://www.w3.org/2001/10/xml-exc-c14n#':
                case 'http://www.w3.org/2001/10/xml-exc-c14n#WithComments':
                    $node = $transform->firstChild;
                    while ($node) {
                        if ($node->localName == 'InclusiveNamespaces') {
                            if ($pfx = $node->getAttribute('PrefixList')) {
                                $arpfx = array();
                                $pfxlist = preg_split("/\s/", $pfx);
                                foreach ($pfxlist AS $pfx) {
                                    $val = trim($pfx);
                                    if (! empty($val)) {
                                        $arpfx[] = $val;
                                    }
                                }
                                if (count($arpfx) > 0) {
                                    $prefixList = $arpfx;
                                }
                            }
                            break;
                        }
                        $node = $node->nextSibling;
                    }
                case 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315':
                case 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315#WithComments':
                    $canonicalMethod = $algorithm;
                    break;
                case 'http://www.w3.org/TR/1999/REC-xpath-19991116':
                    $node = $transform->firstChild;
                    while ($node) {
                        if ($node->localName == 'XPath') {
                            $arXPath = array();
                            $arXPath['query'] = '(.//. | .//@* | .//namespace::*)['.$node->nodeValue.']';
                            $arXpath['namespaces'] = array();
                            $nslist = $xpath->query('./namespace::*', $node);
                            foreach ($nslist AS $nsnode) {
                                if ($nsnode->localName != "xml") {
                                    $arXPath['namespaces'][$nsnode->localName] = $nsnode->nodeValue;
                                }
                            }
                            break;
                        }
                        $node = $node->nextSibling;
                    }
                    break;
            }
        }
        if ($data instanceof DOMNode) {
            $data = $this->canonicalizeData($objData, $canonicalMethod, $arXPath, $prefixList);
        }
        return $data;
    }

    public function processRefNode($refNode) {
        $dataObject = NULL;
        if ($uri = $refNode->getAttribute("URI")) {
            $arUrl = parse_url($uri);
            if (empty($arUrl['path'])) {
                if ($identifier = $arUrl['fragment']) {
                    $xPath = new DOMXPath($refNode->ownerDocument);
                    if ($this->idNS && is_array($this->idNS)) {
                        foreach ($this->idNS AS $nspf=>$ns) {
                            $xPath->registerNamespace($nspf, $ns);
                        }
                    }
                    $iDlist = '@Id="'.$identifier.'"';
                    if (is_array($this->idKeys)) {
                        foreach ($this->idKeys AS $idKey) {
                            $iDlist .= " or @$idKey='$identifier'";
                        }
                    }
                    $query = '//*['.$iDlist.']';
                    $dataObject = $xPath->query($query)->item(0);
                } else {
                    $dataObject = $refNode->ownerDocument;
                }
            } else {
                $dataObject = file_get_contents($arUrl);
            }
        } else {
            $dataObject = $refNode->ownerDocument;
        }
        $data = $this->processTransforms($refNode, $dataObject);
        if (!$this->validateDigest($refNode, $data)) {
            return FALSE;
        }

        if ($dataObject instanceof DOMNode) {
            /* Add this node to the list of validated nodes. */
            if(! empty($identifier)) {
                $this->validatedNodes[$identifier] = $dataObject;
            } else {
                $this->validatedNodes[] = $dataObject;
            }
        }

        return TRUE;
    }

    public function getRefNodeID($refNode) {
        if ($uri = $refNode->getAttribute("URI")) {
            $arUrl = parse_url($uri);
            if (empty($arUrl['path'])) {
                if ($identifier = $arUrl['fragment']) {
                    return $identifier;
                }
            }
        }
        return null;
    }

    public function getRefIDs() {
        $refids = array();
        $doc = $this->sigNode->ownerDocument;

        $xpath = $this->getXPathObj();
        $query = "./secdsig:SignedInfo/secdsig:Reference";
        $nodeset = $xpath->query($query, $this->sigNode);
        if ($nodeset->length == 0) {
            throw new Exception("Reference nodes not found");
        }
        foreach ($nodeset AS $refNode) {
            $refids[] = $this->getRefNodeID($refNode);
        }
        return $refids;
    }

    public function validateReference() {
        $doc = $this->sigNode->ownerDocument;
        if (! $doc->isSameNode($this->sigNode)) {
            $this->sigNode->parentNode->removeChild($this->sigNode);
        }
        $xpath = $this->getXPathObj();
        $query = "./secdsig:SignedInfo/secdsig:Reference";
        $nodeset = $xpath->query($query, $this->sigNode);
        if ($nodeset->length == 0) {
            throw new Exception("Reference nodes not found");
        }

        /* Initialize/reset the list of validated nodes. */
        $this->validatedNodes = array();

        foreach ($nodeset AS $refNode) {
            if (! $this->processRefNode($refNode)) {
                /* Clear the list of validated nodes. */
                $this->validatedNodes = NULL;
                throw new Exception("Reference validation failed");
            }
        }
        return TRUE;
    }

    private function addRefInternal($sinfoNode, $node, $algorithm, $arTransforms=NULL, $options=NULL) {
        $prefix = NULL;
        $prefix_ns = NULL;
        $id_name = 'Id';
        $overwrite_id  = TRUE;
        $force_uri = FALSE;

        if (is_array($options)) {
            $prefix = empty($options['prefix'])?NULL:$options['prefix'];
            $prefix_ns = empty($options['prefix_ns'])?NULL:$options['prefix_ns'];
            $id_name = empty($options['id_name'])?'Id':$options['id_name'];
            $overwrite_id = !isset($options['overwrite'])?TRUE:(bool)$options['overwrite'];
            $force_uri = !isset($options['force_uri'])?FALSE:(bool)$options['force_uri'];
        }

        $attname = $id_name;
        if (! empty($prefix)) {
            $attname = $prefix.':'.$attname;
        }

        $refNode = $this->createNewSignNode('Reference');
        $sinfoNode->appendChild($refNode);

        if (! $node instanceof DOMDocument) {
            $uri = NULL;
            if (! $overwrite_id) {
                $uri = $node->getAttributeNS($prefix_ns, $attname);
            }
            if (empty($uri)) {
                $uri = XMLSecurityDSig::generate_GUID();
                $node->setAttributeNS($prefix_ns, $attname, $uri);
            }
            $refNode->setAttribute("URI", '#'.$uri);
        } elseif ($force_uri) {
            $refNode->setAttribute("URI", '');
        }

        $transNodes = $this->createNewSignNode('Transforms');
        $refNode->appendChild($transNodes);

        if (is_array($arTransforms)) {
            foreach ($arTransforms AS $transform) {
                $transNode = $this->createNewSignNode('Transform');
                $transNodes->appendChild($transNode);
                if (is_array($transform) &&
                    (! empty($transform['http://www.w3.org/TR/1999/REC-xpath-19991116'])) &&
                    (! empty($transform['http://www.w3.org/TR/1999/REC-xpath-19991116']['query']))) {
                    $transNode->setAttribute('Algorithm', 'http://www.w3.org/TR/1999/REC-xpath-19991116');
                    $XPathNode = $this->createNewSignNode('XPath', $transform['http://www.w3.org/TR/1999/REC-xpath-19991116']['query']);
                    $transNode->appendChild($XPathNode);
                    if (! empty($transform['http://www.w3.org/TR/1999/REC-xpath-19991116']['namespaces'])) {
                        foreach ($transform['http://www.w3.org/TR/1999/REC-xpath-19991116']['namespaces'] AS $prefix => $namespace) {
                            $XPathNode->setAttributeNS("http://www.w3.org/2000/xmlns/", "xmlns:$prefix", $namespace);
                        }
                    }
                } else {
                    $transNode->setAttribute('Algorithm', $transform);
                }
            }
        } elseif (! empty($this->canonicalMethod)) {
            $transNode = $this->createNewSignNode('Transform');
            $transNodes->appendChild($transNode);
            $transNode->setAttribute('Algorithm', $this->canonicalMethod);
        }

        $canonicalData = $this->processTransforms($refNode, $node);
        $digValue = $this->calculateDigest($algorithm, $canonicalData);

        $digestMethod = $this->createNewSignNode('DigestMethod');
        $refNode->appendChild($digestMethod);
        $digestMethod->setAttribute('Algorithm', $algorithm);

        $digestValue = $this->createNewSignNode('DigestValue', $digValue);
        $refNode->appendChild($digestValue);
    }

    public function addReference($node, $algorithm, $arTransforms=NULL, $options=NULL) {
        if ($xpath = $this->getXPathObj()) {
            $query = "./secdsig:SignedInfo";
            $nodeset = $xpath->query($query, $this->sigNode);
            if ($sInfo = $nodeset->item(0)) {
                $this->addRefInternal($sInfo, $node, $algorithm, $arTransforms, $options);
            }
        }
    }

    public function addReferenceList($arNodes, $algorithm, $arTransforms=NULL, $options=NULL) {
        if ($xpath = $this->getXPathObj()) {
            $query = "./secdsig:SignedInfo";
            $nodeset = $xpath->query($query, $this->sigNode);
            if ($sInfo = $nodeset->item(0)) {
                foreach ($arNodes AS $node) {
                    $this->addRefInternal($sInfo, $node, $algorithm, $arTransforms, $options);
                }
            }
        }
    }

   public function addObject($data, $mimetype=NULL, $encoding=NULL) {
      $objNode = $this->createNewSignNode('Object');
      $this->sigNode->appendChild($objNode);
      if (! empty($mimetype)) {
         $objNode->setAtribute('MimeType', $mimetype);
      }
      if (! empty($encoding)) {
         $objNode->setAttribute('Encoding', $encoding);
      }

      if ($data instanceof DOMElement) {
         $newData = $this->sigNode->ownerDocument->importNode($data, TRUE);
      } else {
         $newData = $this->sigNode->ownerDocument->createTextNode($data);
      }
      $objNode->appendChild($newData);

      return $objNode;
   }

    public function locateKey($node=NULL) {
        if (empty($node)) {
            $node = $this->sigNode;
        }
        if (! $node instanceof DOMNode) {
            return NULL;
        }
        if ($doc = $node->ownerDocument) {
            $xpath = new DOMXPath($doc);
            $xpath->registerNamespace('secdsig', XMLSecurityDSig::XMLDSIGNS);
            $query = "string(./secdsig:SignedInfo/secdsig:SignatureMethod/@Algorithm)";
            $algorithm = $xpath->evaluate($query, $node);
            if ($algorithm) {
                try {
                    $objKey = new XMLSecurityKey($algorithm, array('type'=>'public'));
                } catch (Exception $e) {
                    return NULL;
                }
                return $objKey;
            }
        }
        return NULL;
    }

    public function verify($objKey) {
        $doc = $this->sigNode->ownerDocument;
        $xpath = new DOMXPath($doc);
        $xpath->registerNamespace('secdsig', XMLSecurityDSig::XMLDSIGNS);
        $query = "string(./secdsig:SignatureValue)";
        $sigValue = $xpath->evaluate($query, $this->sigNode);
        if (empty($sigValue)) {
            throw new Exception("Unable to locate SignatureValue");
        }
        return $objKey->verifySignature($this->signedInfo, base64_decode($sigValue));
    }

    public function signData($objKey, $data) {
        return $objKey->signData($data);
    }

    public function sign($objKey) {
        if ($xpath = $this->getXPathObj()) {
            $query = "./secdsig:SignedInfo";
            $nodeset = $xpath->query($query, $this->sigNode);
            if ($sInfo = $nodeset->item(0)) {
                $query = "./secdsig:SignatureMethod";
                $nodeset = $xpath->query($query, $sInfo);
                $sMethod = $nodeset->item(0);
                $sMethod->setAttribute('Algorithm', $objKey->type);
                $data = $this->canonicalizeData($sInfo, $this->canonicalMethod);
                $sigValue = base64_encode($this->signData($objKey, $data));
                $sigValueNode = $this->createNewSignNode('SignatureValue', $sigValue);
                if ($infoSibling = $sInfo->nextSibling) {
                    $infoSibling->parentNode->insertBefore($sigValueNode, $infoSibling);
                } else {
                    $this->sigNode->appendChild($sigValueNode);
                }
            }
        }
    }

    public function appendCert() {

    }

    public function appendKey($objKey, $parent=NULL) {
        $objKey->serializeKey($parent);
    }


    /**
     * This function inserts the signature element.
     *
     * The signature element will be appended to the element, unless $beforeNode is specified. If $beforeNode
     * is specified, the signature element will be inserted as the last element before $beforeNode.
     *
     * @param $node  The node the signature element should be inserted into.
     * @param $beforeNode  The node the signature element should be located before.
     */
    public function insertSignature($node, $beforeNode = NULL) {

        $document = $node->ownerDocument;
        $signatureElement = $document->importNode($this->sigNode, TRUE);

        if($beforeNode == NULL) {
            $node->insertBefore($signatureElement);
        } else {
            $node->insertBefore($signatureElement, $beforeNode);
        }
    }

    public function appendSignature($parentNode, $insertBefore = FALSE) {
        $beforeNode = $insertBefore ? $parentNode->firstChild : NULL;
        $this->insertSignature($parentNode, $beforeNode);
    }

    static function get509XCert($cert, $isPEMFormat=TRUE) {
        $certs = XMLSecurityDSig::staticGet509XCerts($cert, $isPEMFormat);
        if (! empty($certs)) {
            return $certs[0];
        }
        return '';
    }

    static function staticGet509XCerts($certs, $isPEMFormat=TRUE) {
        if ($isPEMFormat) {
            $data = '';
            $certlist = array();
            $arCert = explode("\n", $certs);
            $inData = FALSE;
            foreach ($arCert AS $curData) {
                if (! $inData) {
                    if (strncmp($curData, '-----BEGIN CERTIFICATE', 22) == 0) {
                        $inData = TRUE;
                    }
                } else {
                    if (strncmp($curData, '-----END CERTIFICATE', 20) == 0) {
                        $inData = FALSE;
                        $certlist[] = $data;
                        $data = '';
                        continue;
                    }
                    $data .= trim($curData);
                }
            }
            return $certlist;
        } else {
            return array($certs);
        }
    }

    static function staticAdd509Cert($parentRef, $cert, $isPEMFormat=TRUE, $isURL=False, $xpath=NULL) {
          if ($isURL) {
            $cert = file_get_contents($cert);
          }
          if (! $parentRef instanceof DOMElement) {
            throw new Exception('Invalid parent Node parameter');
          }
          $baseDoc = $parentRef->ownerDocument;

          if (empty($xpath)) {
              $xpath = new DOMXPath($parentRef->ownerDocument);
              $xpath->registerNamespace('secdsig', XMLSecurityDSig::XMLDSIGNS);
          }

         $query = "./secdsig:KeyInfo";
         $nodeset = $xpath->query($query, $parentRef);
         $keyInfo = $nodeset->item(0);
         if (! $keyInfo) {
              $inserted = FALSE;
              $keyInfo = $baseDoc->createElementNS(XMLSecurityDSig::XMLDSIGNS, 'ds:KeyInfo');

               $query = "./secdsig:Object";
               $nodeset = $xpath->query($query, $parentRef);
               if ($sObject = $nodeset->item(0)) {
                    $sObject->parentNode->insertBefore($keyInfo, $sObject);
                    $inserted = TRUE;
               }

              if (! $inserted) {
                   $parentRef->appendChild($keyInfo);
              }
         }

         // Add all certs if there are more than one
         $certs = XMLSecurityDSig::staticGet509XCerts($cert, $isPEMFormat);

         // Atach X509 data node
         $x509DataNode = $baseDoc->createElementNS(XMLSecurityDSig::XMLDSIGNS, 'ds:X509Data');
         $keyInfo->appendChild($x509DataNode);

         // Atach all certificate nodes
         foreach ($certs as $X509Cert){
            $x509CertNode = $baseDoc->createElementNS(XMLSecurityDSig::XMLDSIGNS, 'ds:X509Certificate', $X509Cert);
         $x509DataNode->appendChild($x509CertNode);
         }
     }

    public function add509Cert($cert, $isPEMFormat=TRUE, $isURL=False) {
         if ($xpath = $this->getXPathObj()) {
            self::staticAdd509Cert($this->sigNode, $cert, $isPEMFormat, $isURL, $xpath);
         }
    }

    /* This function retrieves an associative array of the validated nodes.
     *
     * The array will contain the id of the referenced node as the key and the node itself
     * as the value.
     *
     * Returns:
     *  An associative array of validated nodes or NULL if no nodes have been validated.
     */
    public function getValidatedNodes() {
        return $this->validatedNodes;
    }
}

class XMLSecEnc {
    const template = "<xenc:EncryptedData xmlns:xenc='http://www.w3.org/2001/04/xmlenc#'>
   <xenc:CipherData>
      <xenc:CipherValue></xenc:CipherValue>
   </xenc:CipherData>
</xenc:EncryptedData>";

    const Element = 'http://www.w3.org/2001/04/xmlenc#Element';
    const Content = 'http://www.w3.org/2001/04/xmlenc#Content';
    const URI = 3;
    const XMLENCNS = 'http://www.w3.org/2001/04/xmlenc#';

    private $encdoc = NULL;
    private $rawNode = NULL;
    public $type = NULL;
    public $encKey = NULL;

    public function __construct() {
        $this->encdoc = new DOMDocument();
        $this->encdoc->loadXML(XMLSecEnc::template);
    }

    public function setNode($node) {
        $this->rawNode = $node;
    }

    public function encryptNode($objKey, $replace=TRUE) {
        $data = '';
        if (empty($this->rawNode)) {
            throw new Exception('Node to encrypt has not been set');
        }
        if (! $objKey instanceof XMLSecurityKey) {
            throw new Exception('Invalid Key');
        }
        $doc = $this->rawNode->ownerDocument;
        $xPath = new DOMXPath($this->encdoc);
        $objList = $xPath->query('/xenc:EncryptedData/xenc:CipherData/xenc:CipherValue');
        $cipherValue = $objList->item(0);
        if ($cipherValue == NULL) {
            throw new Exception('Error locating CipherValue element within template');
        }
        switch ($this->type) {
            case (XMLSecEnc::Element):
                $data = $doc->saveXML($this->rawNode);
                $this->encdoc->documentElement->setAttribute('Type', XMLSecEnc::Element);
                break;
            case (XMLSecEnc::Content):
                $children = $this->rawNode->childNodes;
                foreach ($children AS $child) {
                    $data .= $doc->saveXML($child);
                }
                $this->encdoc->documentElement->setAttribute('Type', XMLSecEnc::Content);
                break;
            default:
                throw new Exception('Type is currently not supported');
                return;
        }

        $encMethod = $this->encdoc->documentElement->appendChild($this->encdoc->createElementNS(XMLSecEnc::XMLENCNS, 'xenc:EncryptionMethod'));
        $encMethod->setAttribute('Algorithm', $objKey->getAlgorith());
        $cipherValue->parentNode->parentNode->insertBefore($encMethod, $cipherValue->parentNode);

        $strEncrypt = base64_encode($objKey->encryptData($data));
        $value = $this->encdoc->createTextNode($strEncrypt);
        $cipherValue->appendChild($value);

        if ($replace) {
            switch ($this->type) {
                case (XMLSecEnc::Element):
                    if ($this->rawNode->nodeType == XML_DOCUMENT_NODE) {
                        return $this->encdoc;
                    }
                    $importEnc = $this->rawNode->ownerDocument->importNode($this->encdoc->documentElement, TRUE);
                    $this->rawNode->parentNode->replaceChild($importEnc, $this->rawNode);
                    return $importEnc;
                    break;
                case (XMLSecEnc::Content):
                    $importEnc = $this->rawNode->ownerDocument->importNode($this->encdoc->documentElement, TRUE);
                    while($this->rawNode->firstChild) {
                        $this->rawNode->removeChild($this->rawNode->firstChild);
                    }
                    $this->rawNode->appendChild($importEnc);
                    return $importEnc;
                    break;
            }
        }
    }

    public function decryptNode($objKey, $replace=TRUE) {
        $data = '';
        if (empty($this->rawNode)) {
            throw new Exception('Node to decrypt has not been set');
        }
        if (! $objKey instanceof XMLSecurityKey) {
            throw new Exception('Invalid Key');
        }
        $doc = $this->rawNode->ownerDocument;
        $xPath = new DOMXPath($doc);
        $xPath->registerNamespace('xmlencr', XMLSecEnc::XMLENCNS);
        /* Only handles embedded content right now and not a reference */
        $query = "./xmlencr:CipherData/xmlencr:CipherValue";
        $nodeset = $xPath->query($query, $this->rawNode);

        if ($node = $nodeset->item(0)) {
            $encryptedData = base64_decode($node->nodeValue);
            $decrypted = $objKey->decryptData($encryptedData);
            if ($replace) {
                switch ($this->type) {
                    case (XMLSecEnc::Element):
                        $newdoc = new DOMDocument();
                        $newdoc->loadXML($decrypted);
                        if ($this->rawNode->nodeType == XML_DOCUMENT_NODE) {
                            return $newdoc;
                        }
                        $importEnc = $this->rawNode->ownerDocument->importNode($newdoc->documentElement, TRUE);
                        $this->rawNode->parentNode->replaceChild($importEnc, $this->rawNode);
                        return $importEnc;
                        break;
                    case (XMLSecEnc::Content):
                        if ($this->rawNode->nodeType == XML_DOCUMENT_NODE) {
                            $doc = $this->rawNode;
                        } else {
                            $doc = $this->rawNode->ownerDocument;
                        }
                        $newFrag = $doc->createDocumentFragment();
                        $newFrag->appendXML($decrypted);
                        $parent = $this->rawNode->parentNode;
                        $parent->replaceChild($newFrag, $this->rawNode);
                        return $parent;
                        break;
                    default:
                        return $decrypted;
                }
            } else {
                return $decrypted;
            }
        } else {
            throw new Exception("Cannot locate encrypted data");
        }
    }

    public function encryptKey($srcKey, $rawKey, $append=TRUE) {
        if ((! $srcKey instanceof XMLSecurityKey) || (! $rawKey instanceof XMLSecurityKey)) {
            throw new Exception('Invalid Key');
        }
        $strEncKey = base64_encode($srcKey->encryptData($rawKey->key));
        $root = $this->encdoc->documentElement;
        $encKey = $this->encdoc->createElementNS(XMLSecEnc::XMLENCNS, 'xenc:EncryptedKey');
        if ($append) {
            $keyInfo = $root->appendChild($this->encdoc->createElementNS('http://www.w3.org/2000/09/xmldsig#', 'dsig:KeyInfo'));
            $keyInfo->appendChild($encKey);
        } else {
            $this->encKey = $encKey;
        }
        $encMethod = $encKey->appendChild($this->encdoc->createElementNS(XMLSecEnc::XMLENCNS, 'xenc:EncryptionMethod'));
        $encMethod->setAttribute('Algorithm', $srcKey->getAlgorith());
        if (! empty($srcKey->name)) {
            $keyInfo = $encKey->appendChild($this->encdoc->createElementNS('http://www.w3.org/2000/09/xmldsig#', 'dsig:KeyInfo'));
            $keyInfo->appendChild($this->encdoc->createElementNS('http://www.w3.org/2000/09/xmldsig#', 'dsig:KeyName', $srcKey->name));
        }
        $cipherData = $encKey->appendChild($this->encdoc->createElementNS(XMLSecEnc::XMLENCNS, 'xenc:CipherData'));
        $cipherData->appendChild($this->encdoc->createElementNS(XMLSecEnc::XMLENCNS, 'xenc:CipherValue', $strEncKey));
        return;
    }

    public function decryptKey($encKey) {
        if (! $encKey->isEncrypted) {
            throw new Exception("Key is not Encrypted");
        }
        if (empty($encKey->key)) {
            throw new Exception("Key is missing data to perform the decryption");
        }
        return $this->decryptNode($encKey, FALSE);
    }

    public function locateEncryptedData($element) {
        if ($element instanceof DOMDocument) {
            $doc = $element;
        } else {
            $doc = $element->ownerDocument;
        }
        if ($doc) {
            $xpath = new DOMXPath($doc);
            $query = "//*[local-name()='EncryptedData' and namespace-uri()='".XMLSecEnc::XMLENCNS."']";
            $nodeset = $xpath->query($query);
            return $nodeset->item(0);
        }
        return NULL;
    }

    public function locateKey($node=NULL) {
        if (empty($node)) {
            $node = $this->rawNode;
        }
        if (! $node instanceof DOMNode) {
            return NULL;
        }
        if ($doc = $node->ownerDocument) {
            $xpath = new DOMXPath($doc);
            $xpath->registerNamespace('xmlsecenc', XMLSecEnc::XMLENCNS);
            $query = ".//xmlsecenc:EncryptionMethod";
            $nodeset = $xpath->query($query, $node);
            if ($encmeth = $nodeset->item(0)) {
                   $attrAlgorithm = $encmeth->getAttribute("Algorithm");
                try {
                    $objKey = new XMLSecurityKey($attrAlgorithm, array('type'=>'private'));
                } catch (Exception $e) {
                    return NULL;
                }
                return $objKey;
            }
        }
        return NULL;
    }

    static function staticLocateKeyInfo($objBaseKey=NULL, $node=NULL) {
        if (empty($node) || (! $node instanceof DOMNode)) {
            return NULL;
        }
        if ($doc = $node->ownerDocument) {
            $xpath = new DOMXPath($doc);
            $xpath->registerNamespace('xmlsecenc', XMLSecEnc::XMLENCNS);
            $xpath->registerNamespace('xmlsecdsig', XMLSecurityDSig::XMLDSIGNS);
            $query = "./xmlsecdsig:KeyInfo";
            $nodeset = $xpath->query($query, $node);
            if ($encmeth = $nodeset->item(0)) {
                foreach ($encmeth->childNodes AS $child) {
                    switch ($child->localName) {
                        case 'KeyName':
                            if (! empty($objBaseKey)) {
                                $objBaseKey->name = $child->nodeValue;
                            }
                            break;
                        case 'KeyValue':
                            foreach ($child->childNodes AS $keyval) {
                                switch ($keyval->localName) {
                                    case 'DSAKeyValue':
                                        throw new Exception("DSAKeyValue currently not supported");
                                        break;
                                    case 'RSAKeyValue':
                                        $modulus = NULL;
                                        $exponent = NULL;
                                        if ($modulusNode = $keyval->getElementsByTagName('Modulus')->item(0)) {
                                            $modulus = base64_decode($modulusNode->nodeValue);
                                        }
                                        if ($exponentNode = $keyval->getElementsByTagName('Exponent')->item(0)) {
                                            $exponent = base64_decode($exponentNode->nodeValue);
                                        }
                                        if (empty($modulus) || empty($exponent)) {
                                            throw new Exception("Missing Modulus or Exponent");
                                        }
                                        $publicKey = XMLSecurityKey::convertRSA($modulus, $exponent);
                                        $objBaseKey->loadKey($publicKey);
                                        break;
                                }
                            }
                            break;
                        case 'RetrievalMethod':
                            /* Not currently supported */
                            break;
                        case 'EncryptedKey':
                            $objenc = new XMLSecEnc();
                            $objenc->setNode($child);
                            if (! $objKey = $objenc->locateKey()) {
                                throw new Exception("Unable to locate algorithm for this Encrypted Key");
                            }
                            $objKey->isEncrypted = TRUE;
                            $objKey->encryptedCtx = $objenc;
                            XMLSecEnc::staticLocateKeyInfo($objKey, $child);
                            return $objKey;
                            break;
                        case 'X509Data':
                            if ($x509certNodes = $child->getElementsByTagName('X509Certificate')) {
                                if ($x509certNodes->length > 0) {
                                    $x509cert = $x509certNodes->item(0)->textContent;
                                    $x509cert = str_replace(array("\r", "\n"), "", $x509cert);
                                    $x509cert = "-----BEGIN CERTIFICATE-----\n".chunk_split($x509cert, 64, "\n")."-----END CERTIFICATE-----\n";
                                    $objBaseKey->loadKey($x509cert, FALSE, TRUE);
                                }
                            }
                            break;
                    }
                }
            }
            return $objBaseKey;
        }
        return NULL;
    }

    public function locateKeyInfo($objBaseKey=NULL, $node=NULL) {
        if (empty($node)) {
            $node = $this->rawNode;
        }
        return XMLSecEnc::staticLocateKeyInfo($objBaseKey, $node);
    }
}
