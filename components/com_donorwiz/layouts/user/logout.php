<?php

// no direct access
defined('_JEXEC') or die;

$return = base64_encode(JFactory::getURI()->toString());

if( JFactory::getApplication()->input->get('return', '', 'BASE64') ){
	
	//JSession::checkToken( 'get' ) or die( 'Invalid Token' );
	$return = JFactory::getApplication()->input->get('return', '', 'BASE64');
	
}

JHtml::_('behavior.formvalidation');

include_once JPATH_ROOT.'/components/com_community/libraries/core.php';

// Get CUser object
$user = CFactory::getUser();
$avatarUrl = $user->getThumbAvatar();
$name = $user->getDisplayName();

?>

<div class="uk-grid" data-uk-grid-margin>
    
	<div class="uk-width-1-1 uk-text-center">
	
		<h1 class="uk-article-title"><?php echo JText::_('JLOGOUT'); ?></h1>

		<hr class="uk-article-divider">
		
		<div class="uk-margin">
			<img class="uk-thumbnail uk-border-circle" src="<?php echo $avatarUrl;?>" alt="<?php echo $name;?>">
		</div>
			
		<form class="uk-form uk-form-horizontal" action="<?php echo JRoute::_('index.php', true); ?>" method="post" data-uk-grid-margin>
		
			<div class="uk-form-row uk-grid uk-margin" >
				<div class="uk-width-1-1">
					<div class="uk-form-icon uk-width-1-1">
						<i class="uk-icon-power-off"></i>
						<input type="submit" name="Submit" class="uk-button uk-button-blank uk-button-large uk-width-1-1 " value="<?php echo JText::_('JLOGOUT'); ?>"/>
					</div>
				</div>
			</div>
	
	
			<input type="hidden" name="option" value="com_users" />
			<input type="hidden" name="task" value="user.logout" />
			<input type="hidden" name="return" value="<?php echo $return;?>" />
			
			<?php echo JHtml::_('form.token'); ?>
		
		</form>

		<div class="uk-margin">
			<a href="<?php echo JRoute::_('index.php?Itemid='. JFactory::getApplication()->getMenu()->getItems( 'link', 'index.php?option=com_donorwiz&view=dashboard', true )->id );?>"><?php echo JText::_('COM_DONORWIZ_RETURN_TO_DASHBOARD');?></a>
		</div>
	</div>

</div>