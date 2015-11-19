<?php

defined('JPATH_PLATFORM') or die;

class DonorwizGA {
	
	public function sendEvent( $category=null, $action=null, $label=null )
	{
        $data = array(
		'v' => 1,
		'tid' => JFactory::getConfig()->get('gaua'), 
		'cid' => $this->parseCookie(),
		't' => 'event',
		'ec' => $category, //Category (Required)
		'ea' => $action, //Action (Required)
		'el' => $label, //Label
        'ev' => 1
        );
        
        return ( $this->sendData( $data ) );
	}

    //Send Data to Google Analytics
    //https://developers.google.com/analytics/devguides/collection/protocol/v1/devguide#event
    private function sendData($data)
    {
        $url = 'http://www.google-analytics.com/collect?';
        $url .= http_build_query($data);

        // Get cURL resource
        $curl = curl_init();
        $timeout = 5;
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            //CURLOPT_HEADER => 0
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13',
            CURLOPT_CONNECTTIMEOUT => $timeout,
            CURLOPT_SSL_VERIFYPEER => false
        ));
        
        // Send the request & save response to $resp
        curl_exec($curl);
        $info = curl_getinfo($curl);
        // Close request to clear up some resources
        curl_close($curl);
        
        return $info;
    }
    
    
    private function parseCookie()
    {
        if (isset($_COOKIE['_ga'])) {
            list($version, $domainDepth, $cid1, $cid2) = explode('.', $_COOKIE["_ga"], 4);
            $contents = array('version' => $version, 'domainDepth' => $domainDepth, 'cid' => $cid1 . '.' . $cid2);
            //$contents = array('version' => $version, 'domainDepth' => $domainDepth, 'cid' => $cid1 );
            $cid = $contents['cid'];

        } else {
            $cid = $this->generateUUID();
        }
        return $cid;
    }

    //Generate UUID
    //Special thanks to stumiller.me for this formula.
    private function generateUUID() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
    
}