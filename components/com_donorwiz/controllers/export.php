<?php

defined('_JEXEC') or die;

require_once JPATH_COMPONENT . '/controller.php';

class DonorwizControllerExport extends DonorwizController {
	
	public function csv() {
		
		//Check access token
		JSession::checkToken( ) or die( 'Invalid Token' );

		$jinput = JFactory::getApplication()->input;
		$filename = $jinput->get('filename', '', 'string') ;
		$items = json_decode(  htmlspecialchars_decode ( $jinput->get('items', '', 'html') ) );
		$fields = explode(',', $jinput->get('fields', '', 'string')) ;
		$component = $jinput->get('component', '', 'string') ;
		
		//Check if the user is beneficiary for the component, so that he can export
		$isBeneficiary = null;

		if ( $component ) 
		{
			$user = JFactory::getUser();
			$donorwizUser = new DonorwizUser( $user -> id );
			$isBeneficiary = ( $donorwizUser -> isBeneficiary( $component ) == true ) ? true : null;	
		}
		
		if( !$isBeneficiary )
			die( 'Access denied' );
		
		header("Content-Type: application/csv");
		header("Content-Disposition: attachment;Filename=".$filename.".csv");

		$jinput = JFactory::getApplication()->input;
		$items = json_decode(  htmlspecialchars_decode ( $jinput->get('items', '', 'html') ) );
		$fields = explode(',', $jinput->get('fields', '', 'string')) ;

		$csv = '';

		//First get the columns
		foreach ( $items as $key => $item) {

			foreach ( $item as $k => $v)
			{
				if ( in_array( $k , $fields) )
				{
					$csv = $csv . $k . ";" ;
				}
			}
			
			break;
		}

		$csv = $csv . "\n";

		//Get the data
		foreach ( $items as $key => $item) {

			foreach ( $item as $k => $v)
			{
				if ( is_string( $item->$k ) && in_array ( $k , $fields ) ) 
				{
					//TO DO : escape character ; , because it is the delimeter and if it is inside the value it causes malformed columns.
					$csv = $csv . str_replace( ';', '?' , html_entity_decode( $item->$k ) ) . ';';
				}
			}
			
			$csv = $csv . "\n";
		}

		echo $csv;

		jexit();
	}
	
	private function toLetter($n){

		$arrayMap= array(
			
			1 => 'A',
			2 => 'B',
			3 => 'C',
			4 => 'D',
			5 => 'E',
			6 => 'F',
			7 => 'G',
			8 => 'H',
			9 => 'I',
			10 => 'J',
			11 => 'K',
			12 => 'L',
			13 => 'M'
			
		
		
		);
		
		return $arrayMap[$n];
		}
	
	public function xls(){
//http://phpexcel.codeplex.com/
		//Check access token
		JSession::checkToken( ) or die( 'Invalid Token' );

		$jinput = JFactory::getApplication()->input;
		$filename = $jinput->get('filename', '', 'string') ;
		$items = json_decode(  htmlspecialchars_decode ( $jinput->get('items', '', 'html') ) );
		$fields = explode(',', $jinput->get('fields', '', 'string')) ;
		$component = $jinput->get('component', '', 'string') ;
		
		//Check if the user is beneficiary for the component, so that he can export
		$isBeneficiary = null;

		if ( $component ) 
		{
			$user = JFactory::getUser();
			$donorwizUser = new DonorwizUser( $user -> id );
			$isBeneficiary = ( $donorwizUser -> isBeneficiary( $component ) == true ) ? true : null;	
		}
		
		if( !$isBeneficiary )
			die( 'Access denied' );

		
		require_once dirname(__FILE__) . '/../../../libraries/vendor/phpexcel/PHPExcel.php';
		
		// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");



							 



		$jinput = JFactory::getApplication()->input;
		$items = json_decode(  htmlspecialchars_decode ( $jinput->get('items', '', 'html') ) );
		$fields = explode(',', $jinput->get('fields', '', 'string')) ;

		//$csv = '';

		//First get the columns
		
		$col=1;
		foreach ( $items as $key => $item) {

			foreach ( $item as $k => $v)
			{
				if ( in_array( $k , $fields) )
				{
	
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->toLetter($col).'1', $k);
					$col++;
				}
			}
			
			break;
		}


		
$row=1;
		//Get the data
		 foreach ( $items as $key => $item) {

		 		$row++;
			
			
			$col=1;
			foreach ( $item as $k => $v)
			{

				 
				 if ( is_string( $item->$k ) && in_array ( $k , $fields ) ) 
				 {
					 //TO DO : escape character ; , because it is the delimeter and if it is inside the value it causes malformed columns.
					 //$csv = $csv . str_replace( ';', '?' , html_entity_decode( $item->$k ) ) . ';';
					 //var_dump($this->toLetter($col));
					 

					 //var_dump($this->toLetter($col).$row);
					 //var_dump($v);
					 $objPHPExcel->setActiveSheetIndex(0)->setCellValue($this->toLetter($col).$row, (string)$v);
					 
					 $col++;
				 }
			 }
			

			}
			
			
			//die;
			

			
			
			
			
			
			
			
			
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="01simple.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
		
	}
}

