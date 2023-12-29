<?php
/**
 * NOTE ON THE SOFTWARE USE LICENSE
 *
 * The use of this software is subject to the terms of use of software that
 * are included in the package in the document "Legal Notice.pdf". also can
 * get a copy in the following url:
 * http://www.redsys.es/wps/portal/redsys/publica/areadeserviciosweb/descargaDeDocumentacionYEjecutables
 *
 * Redsys owns all intellectual and industrial property rights of the software.
 *
 * Reproduction, distribution and distribution are expressly prohibited.
 * public communication, including its method of making available for purposes
 * other than those described in the Conditions of use.
 *
 * Redsys reserves the possibility of exercising the legal actions that
 * correspond to enforce your rights against any violation of
 * Intellectual and / or industrial property rights.
 *
 * Redsys Processing Services, S.L., CIF B85955367
 */

class RedsysAPI
{
    /****** Array de Input Data ******/
    public $vars_pay = array();

    /**
     * Set parameter
     */
    public function setParameter($key, $value)
    {
        $this->vars_pay[$key] = $value;
    }

    /**
     * Get parameter
     */
    public function getParameter($key)
    {
        return $this->vars_pay[$key];
    }

    //////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////
    ////////////                    AUXILIARY FUNCTIONS:                              ////////////
    //////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * 3DES Function
     * Updating to PHP version 7 mcrypt_encrypt() fails, so it has been changed to openssl_encrypt()
     * https://blog.trescomatres.com/2018/09/redsys-mycrypt-openssl-servidor-con-php-7-1-o-superior/
     */
    public function encrypt_3DES($message, $key)
    {
        $l = ceil(strlen($message) / 8) * 8;
        $ciphertext = substr(openssl_encrypt($message . str_repeat("\0", $l - strlen($message)), 'des-ede3-cbc', $key, OPENSSL_RAW_DATA, "\0\0\0\0\0\0\0\0"), 0, $l);
        return $ciphertext;
    }

    /******  Base64 Functions  ******/
    public function base64_url_encode($input)
    {
        return strtr(base64_encode($input), '+/', '-_');
    }

    public function encodeBase64($data)
    {
        $data = base64_encode($data);
        return $data;
    }

    public function base64_url_decode($input)
    {
        return base64_decode(strtr($input, '-_', '+/'));
    }

    public function decodeBase64($data)
    {
        $data = base64_decode($data);
        return $data;
    }

    /**
     * MAC Function
     */
    public function mac256($ent, $key)
    {
        $res = hash_hmac('sha256', $ent, $key, true); //(PHP 5 >= 5.1.2)
        return $res;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////
    ////////////       FUNCTIONS FOR THE GENERATION OF THE PAYMENT FORM:                 ////////////
    //////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Get Order Number
     */
    public function getOrder()
    {
        $ordernumber = "";
        if (empty($this->vars_pay['DS_MERCHANT_ORDER'])) {
            $ordernumber = $this->vars_pay['Ds_Merchant_Order'];
        } else {
            $ordernumber = $this->vars_pay['DS_MERCHANT_ORDER'];
        }
        return $ordernumber;
    }

    /**
     * Convert Array to JSON Object
     */
    public function arrayToJson()
    {
        $json = json_encode($this->vars_pay); //(PHP 5 >= 5.2.0)
        return $json;
    }

    public function createMerchantParameters()
    {
        // The data array is transformed into a Json object
        $json = $this->arrayToJson();
        // Base64 data is encoded
        return $this->encodeBase64($json);
    }

    public function createMerchantSignature($key)
    {
        // Base64 key is decoded
        $key = $this->decodeBase64($key);
        // The Ds_MerchantParameters parameter is generated
        $ent = $this->createMerchantParameters();
        // The code is diversified with the Order Number
        $key = $this->encrypt_3DES($this->getOrder(), $key);
        // MAC256 of the Ds_MerchantParameters parameter
        $res = $this->mac256($ent, $key);
        // Base64 data is encoded
        return $this->encodeBase64($res);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////
    ////////////     FUNCTIONS FOR RECEIVING PAYMENT DATA  (Notif, URLOK y URLKO):    ////////////
    //////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Get Order Number
     */
    public function getOrderNotif()
    {
        $ordernumber = "";
        if (empty($this->vars_pay['Ds_Order'])) {
            $ordernumber = $this->vars_pay['DS_ORDER'];
        } else {
            $ordernumber = $this->vars_pay['Ds_Order'];
        }

        return $ordernumber;
    }

    public function getOrderNotifSOAP($data)
    {
        $iniOrderPos = strrpos($data, "<Ds_Order>");
        $iniOrderSize = strlen("<Ds_Order>");
        $endOrderPos = strrpos($data, "</Ds_Order>");

        return substr($data, $iniOrderPos + $iniOrderSize, $endOrderPos - ($iniOrderPos + $iniOrderSize));
    }

    public function getRequestNotifSOAP($data)
    {
        $posReqIni = strrpos($data, "<Request");
        $posReqFin = strrpos($data, "</Request>");
        $tamReqFin = strlen("</Request>");

        return substr($data, $posReqIni, ($posReqFin + $tamReqFin) - $posReqIni);
    }

    public function getResponseNotifSOAP($data)
    {
        $posReqIni = strrpos($data, "<Response");
        $posReqFin = strrpos($data, "</Response>");
        $tamReqFin = strlen("</Response>");

        return substr($data, $posReqIni, ($posReqFin + $tamReqFin) - $posReqIni);
    }

    /**
     * Convert String to Array
     */
    public function stringToArray($dataDecod)
    {
        $this->vars_pay = json_decode($dataDecod, true); //(PHP 5 >= 5.2.0)
    }

    public function decodeMerchantParameters($data)
    {
        // Base64 data is decoded
        $decodec = $this->base64_url_decode($data);
        return $decodec;
    }

    public function createMerchantSignatureNotif($key, $data)
    {
        // Base64 key is decoded
        $key = $this->decodeBase64($key);
        // Base64 data is decoded
        $decodec = $this->base64_url_decode($data);
        // Decoded data is passed to the data array
        $this->stringToArray($decodec);
        // The code is diversified with the Order Number
        $key = $this->encrypt_3DES($this->getOrderNotif(), $key);
        // MAC256 of the Ds_Parameters parameter sent by Redsys
        $res = $this->mac256($data, $key);
        // Base64 data is encoded
        return $this->base64_url_encode($res);
    }

    /**
     * SOAP INPUT Notifications
     */
    public function createMerchantSignatureNotifSOAPRequest($key, $data)
    {
        // Base64 key is decoded
        $key = $this->decodeBase64($key);
        // Request data is obtained
        $data = $this->getRequestNotifSOAP($data);
        // The code is diversified with the Order Number
        $key = $this->encrypt_3DES($this->getOrderNotifSOAP($data), $key);
        // MAC256 of the Ds_Parameters parameter sent by Redsys
        $res = $this->mac256($data, $key);
        // Base64 data is encoded
        return $this->encodeBase64($res);
    }

    /**
     * SOAP OUTPUT Notifications
     */
    public function createMerchantSignatureNotifSOAPResponse($key, $data, $ordernumber)
    {
        // Base64 key is decoded
        $key = $this->decodeBase64($key);
        // Request data is obtained
        $data = $this->getResponseNotifSOAP($data);
        // The code is diversified with the Order Number
        $key = $this->encrypt_3DES($ordernumber, $key);
        // MAC256 of the Ds_Parameters parameter sent by Redsys
        $res = $this->mac256($data, $key);
        // Base64 data is encoded
        return $this->encodeBase64($res);
    }
}
