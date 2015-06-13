<?php 

defined('_JEXEC') or die;

include_once JPATH_ROOT.'/components/com_community/libraries/core.php';
$user = CFactory::getUser();
$ThumbAvatar = $user->getThumbAvatar();
$isDefaultAvatar = $user->isDefaultAvatar();
$DisplayName = $user->getDisplayName();

?>

<div class="uk-panel uk-panel-box uk-panel-dark">
	
	<?php echo JLayoutHelper::render( 'dashboard.profile-completeness', array ( ) , JPATH_ROOT .'/components/com_donorwiz/layouts' , null ); ?>
	
	<div class="uk-text-center">
		<a href="<?php echo JRoute::_('profile');?>" title="<?php echo JText::_('COM_DONORWIZ_DASHBOARD_VIEW_PROFILE_PAGE');?>" data-uk-tooltip>
			<img class="uk-thumbnail uk-border-circle" src="<?php echo $ThumbAvatar;?>" alt="<?php echo $DisplayName;?>">
		</a>
	</div>

	<h3 class="uk-text-center uk-text-contrast uk-margin-remove"><?php echo $DisplayName;?></h3>
	
	<?php if ( $isDefaultAvatar ) :?>
	<div class="uk-text-center">
		<a href="profile/change-profile-picture"><?php echo JText::_('COM_DONORWIZ_DASHBOARD_CHANGE_PROFILE_AVATAR');?></a>
	</div>
	<?php endif; ?>

	<div class="uk-width-1-1 uk-margin-top uk-text-center">

		<a class="uk-button uk-button-large uk-button-contrast uk-border-circle uk-margin-small-left uk-margin-small-right" href="<?php echo JRoute::_('profile');?>" title="<?php echo JText::_('COM_DONORWIZ_DASHBOARD_MY_PAGE');?>" data-uk-tooltip>
			<i class="uk-icon-user"></i>
		</a>
		
		<a class="uk-button uk-button-large uk-button-contrast uk-border-circle uk-margin-small-left uk-margin-small-right" href="<?php echo JRoute::_('profile/edit');?>" title="<?php echo JText::_('COM_DONORWIZ_DASHBOARD_MYACCOUNT_EDIT');?>" data-uk-tooltip>
			<i class="uk-icon-cog"></i>
		</a>	
		
		<a class="uk-button uk-button-large uk-button-contrast uk-border-circle uk-margin-small-left uk-margin-small-right" href="<?php echo JRoute::_('profile/notifications');?>" title="<?php echo JText::_('COM_DONORWIZ_DASHBOARD_NOTIFICATIONS');?>" data-uk-tooltip>
			<i class="uk-icon-comment"></i>
		</a>
		<a class="uk-button uk-button-large uk-button-contrast uk-border-circle uk-margin-small-left uk-margin-small-right" href="<?php echo JRoute::_('profile/message/inbox');?>" title="<?php echo JText::_('COM_DONORWIZ_DASHBOARD_SEND_MESSAGE');?>" data-uk-tooltip>
			<i class="uk-icon-envelope-o"></i>
		</a>
		<a class="uk-button uk-button-large uk-button-contrast uk-border-circle uk-margin-small-left uk-margin-small-right" href="<?php echo JRoute::_('index.php?option=com_donorwiz&view=login&Itemid=314&return='.base64_encode( JURI::base() ) );?>" title="<?php echo JText::_('COM_DONORWIZ_LOGOUT_UPPERCASE');?>" data-uk-tooltip>
			<i class="uk-icon-power-off"></i>
		</a>
	</div>

</div>