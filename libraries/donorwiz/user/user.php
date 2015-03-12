<?php

defined('JPATH_PLATFORM') or die;

jimport('joomla.application.component.helper');

include_once JPATH_ROOT.'/components/com_community/libraries/core.php';
include_once JPATH_ROOT.'/components/com_community/libraries/user.php';

class DonorwizUser extends CUser {
	
	public function isBeneficiary($component)
	{
		$com_params = JComponentHelper::getParams($component);
		
		$com_beneficiary_usergroups = $com_params->get('beneficiary_usergroups');
		
		$table   = JUser::getTable();
		
		if(!$table->load( $this -> id ))
		{
			return false;	
		}

		$user = JFactory::getUser( $this -> id );
		
		$user_usergroups = $user -> get('groups');
		
		$isBeneficiary = false; 
		
		foreach ($user_usergroups as $key => $value) {
			
			if( in_array ( $value , $com_beneficiary_usergroups ))
			{
				$isBeneficiary = true;
			}
		}
		
		return $isBeneficiary;
	
	}
	
	public function getCoordinates($address)
	{

		if($address==''||!$address)
			return array( "lat" => 0, "lng" => 0 , "address" => '' );
		

		$address = urlencode($address);
		$url = "http://maps.google.com/maps/api/geocode/json?sensor=false&address=" . $address;
		$response = file_get_contents($url);
		
		if(!$response)
			return array( "lat" => 0, "lng" => 0 , "address" => '' );
		
		$json = json_decode($response,true);
		
		if( isset( $json['results'] ) && isset( $json['results'][0] ) && isset( $json['results'][0]['geometry'] ) && isset( $json['results'][0]['geometry']['location'] ) ) 
		{
		
			$lat = $json['results'][0]['geometry']['location']['lat'];
			$lng = $json['results'][0]['geometry']['location']['lng'];

			return array( "lat" => $lat, "lng" => $lng , "address" => urldecode ( $address ) );

		}
		else
		{
			return array( "lat" => 0, "lng" => 0 , "address" => '' );
			
		}
	}

	
	public function getUserCoordinates($user_id)
	{
		$user = CFactory::getUser($user_id);
		
		$address = $user -> getInfo('FIELD_ADDRESS');
		$state = $user -> getInfo('FIELD_STATE');
		$city = $user -> getInfo('FIELD_CITY');
		$pc = $user -> getInfo('FIELD_PC');
		$country = $user -> getInfo('FIELD_COUNTRY');
		
		$lang = JFactory::getLanguage();
		$lang->load('com_community.country', JPATH_SITE , $lang->getTag(), true);
		$coordinates_address=array();
		
		if( trim ( $address ) !='')
			$coordinates_address[]= trim ( $address );

		if( trim ( $state ) !='')
			$coordinates_address[]= ' '.trim ( $state );

		if( trim ( $city ) !='')
			$coordinates_address[]= ' '.trim ( $city );

		if( trim ( $pc ) !='')
			$coordinates_address[]= ' '.trim ( $pc );

		if( trim ( JText::_($country) ) !='')
			$coordinates_address[]= ' '. trim ( JText::_($country) );

		return $this->getCoordinates( implode ( $coordinates_address ) );
	}
}