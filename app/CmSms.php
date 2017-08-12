<?php
namespace App;
class CmSms
{
    /*
    |--------------------------------------------------------------------------
    | CmSms Class
    |--------------------------------------------------------------------------
    |
    | This class creates formats messages in Xml and sends them using CM Telecom Gateway
    |
    */

    /**
     * Build message XML to send via CM Telecom Gateway
     *
     * @param  string  $from
     * @param  string  $receipent
     * @param  string  $message
     * @return string  XML format of the message
     */
    static public function buildMessageXml($from, $recipient, $message) {
        $xml = new \SimpleXMLElement('<MESSAGES/>');

        $authentication = $xml->addChild('AUTHENTICATION');
        $authentication->addChild('PRODUCTTOKEN', env('CM_PRODUCTTOKEN'));

        $msg = $xml->addChild('MSG');
        $msg->addChild('FROM', $from);
        $msg->addChild('TO', $recipient);
        $msg->addChild('BODY', $message);
        $msg->addChild('DCS', 8);
        $msg->addChild('MINIMUMNUMBEROFMESSAGEPARTS',1);
        $msg->addChild('MAXIMUMNUMBEROFMESSAGEPARTS',8);

        return $xml->asXML();
    }
    /**
     * Build and send message XML to  CM Telecom Gateway
     *
     * @param  string  $from
     * @param  string  $receipent
     * @param  string  $message
     * @return string  API response
     */
    static public function sendMessage($from, $recipient, $message) {
        $xml = self::buildMessageXml($from, $recipient, $message);

        $ch = curl_init(); // cURL v7.18.1+ and OpenSSL 0.9.8j+ are required
        curl_setopt_array($ch, array(
                CURLOPT_URL            => 'https://sgw01.cm.nl/gateway.ashx',
                CURLOPT_HTTPHEADER     => array('Content-Type: application/xml'),
                CURLOPT_POST           => true,
                CURLOPT_POSTFIELDS     => $xml,
                CURLOPT_RETURNTRANSFER => true
            )
        );

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }
}
