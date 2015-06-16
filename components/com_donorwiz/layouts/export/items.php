<?php

defined('_JEXEC') or die;

$canExport = null;

//Check if the we are in dashboard
$jinputFilter = JFactory::getApplication()->input->get('filter','','array');
$dashboard = ( isset ( $jinputFilter[ 'dashboard' ] ) && $jinputFilter[ 'dashboard' ] == 'true' ) ? true : null ;

//Check if the user is beneficiary for the component, so that he can export
$isBeneficiary = null;
$component = ( isset ( $displayData['component'] ) ) ? $displayData['component'] : null ;

if ( $component ) 
{
	$user = JFactory::getUser();
	$donorwizUser = new DonorwizUser( $user -> id );
	$isBeneficiary = ( $donorwizUser -> isBeneficiary( $component ) == true ) ? true : null;	
}

//Check the number of items
$items = $displayData['items'];

if ( $dashboard && $isBeneficiary & count($items) > 0 )
{
	$canExport = true;
}

if ( $canExport )
{
	JFactory::getLanguage()->load('com_donorwiz');
	$fields = $displayData['fields'] ;
	$filename = JFile::makeSafe( $displayData['filename'] );
}
?>

<?php if( $canExport ) : ?>

<i class="uk-icon-download uk-text-primary"></i> 
<a onclick="jQuery('#<?php echo $component;?>-export-form').trigger('submit');return false;" class="uk-text-primary" href="#" title="<?php echo JText::_('COM_DONORWIZ_DASHBOARD_EXPORT_TOOLTIP'); ?>" data-uk-tooltip>
	
	<?php echo JText::_('COM_DONORWIZ_DASHBOARD_EXPORT'); ?>
</a>

<form id="<?php echo $component;?>-export-form" class="uk-hidden" action="<?php echo JURI::Base();?>index.php?option=com_donorwiz&task=export.xls" method="post">
    <input name="<?php echo JSession::getFormToken();?>" value="1"/>
    <input name="items" value="<?php echo htmlspecialchars ( json_encode(  $items ) );?>"/>
    <input name="fields" value="<?php echo $fields; ?>"/>
    <input name="filename" value="<?php echo $filename; ?>"/>
    <input name="component" value="<?php echo $component; ?>"/>
    <input type="submit" value="download"/>
</form>

<?php endif; ?>