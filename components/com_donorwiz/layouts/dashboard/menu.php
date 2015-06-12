<?php 
// no direct access
defined('_JEXEC') or die;
?>

<div class="uk-panel uk-panel-dark">

	<?php echo JLayoutHelper::render( 'dashboard.user', array ( ) , JPATH_ROOT .'/components/com_donorwiz/layouts' , null ); ?>

	<div class="uk-panel uk-margin-top uk-margin-bottom">
	
		<?php 
		//Joomla Module
		jimport( 'joomla.application.module.helper' );
		$module = JModuleHelper::getModule( 'menu', 'Dashboard' );
		$attribs['style'] = 'xhtml';
		echo JModuleHelper::renderModule( $module, $attribs );
		?>
	</div>

</div>

<?php echo JLayoutHelper::render( 'dashboard.footer', array () , JPATH_ROOT .'/components/com_donorwiz/layouts' , null ); ?>