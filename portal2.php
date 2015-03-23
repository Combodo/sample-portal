<?php
require_once('../approot.inc.php');
require_once(APPROOT.'/application/application.inc.php');
require_once(APPROOT.'/application/webpage.class.inc.php');
require_once(APPROOT.'/application/ajaxwebpage.class.inc.php');
require_once(APPROOT.'/application/wizardhelper.class.inc.php');
require_once(APPROOT.'/application/ui.linkswidget.class.inc.php');
require_once(APPROOT.'/application/ui.extkeywidget.class.inc.php');
require_once(APPROOT.'/application/datatable.class.inc.php');
require_once(APPROOT.'/application/excelexporter.class.inc.php');

try
{
	require_once(APPROOT.'/application/startup.inc.php');
	require_once(APPROOT.'/application/user.preferences.class.inc.php');
	
	require_once(APPROOT.'/application/loginwebpage.class.inc.php');

	$sCurrentPortalId = 'my_alternate_portal';
	LoginWebPage::DoLoginEx($sCurrentPortalId, false);

	
	$oP = new NiceWebPage('My Alternate Portal');
	
	$oP->p('This is my <b>alternate</b> portal');
	
	$aAllowedPortals = LoginWebpage::GetAllowedPortals();
	
	if (count($aAllowedPortals) > 1)
	{
		$oP->add('<p>You can also connect to:</p><ul>');
		foreach($aAllowedPortals as $aPortalDef)
		{
			if ($aPortalDef['id'] != $sCurrentPortalId)
			{
				$oP->add('<li><a href="'.$aPortalDef['url'].'">'.$aPortalDef['label'].'</a></li>');
			}
		}
	}
	$oP->add('</ul>');
	$oP->p('<a href="'.utils::GetAbsoluteUrlAppRoot().'/pages/logoff.php">Log Off</a>');
	$oP->output();
}
catch(Exception $e)
{
	require_once(APPROOT.'/setup/setuppage.class.inc.php');
	$oP = new SetupPage(Dict::S('UI:PageTitle:FatalError'));
	$oP->add("<h1>".Dict::S('UI:FatalErrorMessage')."</h1>\n");
	$oP->error(Dict::Format('UI:Error_Details', $e->getMessage()));
	$oP->output();	
}