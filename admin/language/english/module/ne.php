<?php
//-----------------------------------------------------
// Newsletter Enhancements for Opencart
// Created by @DmitryNek (Dmitry Shkolyar)
// exmail.Nek@gmail.com
//-----------------------------------------------------

// Heading
$_['heading_title']							= 'Newsletter Enhancements v3.6.7';

// Text
$_['text_success']							= 'Success: You have modified module Newsletter Enhancements!';
$_['text_module']							= 'Modules';
$_['text_module_localization']  			= 'Localization';
$_['text_ne']  								= 'Newsletter';
$_['text_ne_email']  						= 'Create and Send';
$_['text_ne_draft']  						= 'Draft Newsletter';
$_['text_ne_marketing']  					= 'Marketing Subscribers';
$_['text_ne_subscribers']  					= 'List Subscribers';
$_['text_ne_stats']  						= 'Newsletter Stats';
$_['text_ne_robot']  						= 'Scheduled Newsletter';
$_['text_ne_template']  					= 'Newsletter Templates';
$_['text_ne_subscribe_box']  				= 'Subscribe Box';
$_['text_ne_blacklist']  					= 'Blacklisted Emails';
$_['text_ne_support']  						= 'Support';
$_['text_ne_support_register']  			= 'Register to get Support';
$_['text_ne_support_login']  				= 'Login to get Support';
$_['text_ne_support_dashboard']  			= 'Support Dashboard';
$_['text_ne_update_check']  				= 'Check For Updates';
$_['text_default']		  					= 'Default';
$_['text_general_settings']		  			= 'General';
$_['text_bounce_settings']		  			= 'Bounced emails';
$_['text_throttle_settings']		  		= 'Throttle';

$_['text_cron_command']   					= '*/5 * * * * /usr/bin/wget -o /dev/null -q "%s" >/dev/null 2>&1';
$_['text_help'] 							= '* * * * * command to be executed<br/>- - - - -<br/>| | | | |<br/>| | | | +- - - - day of week (0 - 6) (Sunday=0)<br/>| | | +- - - - - month (1 - 12)<br/>| | +- - - - - - day of month (1 - 31)<br/>| +- - - - - - - hour (0 - 23)<br/>+- - - - - - - - minute (0 - 59)<br/><br/>I.e. configure cron job to run command each 5 minutes.';
$_['text_licence_info'] 					= 'To activate module please provide your email which was used for module purchasing and order ID.';

// Entry
$_['entry_use_throttle']					= 'Use throttle when sending emails:<br /><span class="help">This feature requires configure cron job on server.</span>';
$_['entry_use_embedded_images']				= 'Use embedded images in newsletter:<br /><span class="help">Not supported by Gmail web app.</span>';
$_['entry_throttle_emails']					= 'Emails to send in one iteration:<br /><span class="help">Number of emails to send.</span>';
$_['entry_throttle_time']					= 'Throttle interval:<br /><span class="help">Time in minutes.</span>';
$_['entry_sent_retries']					= 'Retries count:<br /><span class="help">Amount of retries to send newsletter to specified email address.</span>';
$_['entry_name']							= 'Name';
$_['entry_yes']								= 'Yes';
$_['entry_no']								= 'No';
$_['entry_cron_code']						= 'Cron command:';
$_['entry_cron_help']						= 'Cron command help:';
$_['entry_list']							= 'Marketing lists:';
$_['entry_weekdays']						= 'Weekdays:';
$_['entry_months']							= 'Months:';
$_['entry_january']							= 'January';
$_['entry_february']						= 'February';
$_['entry_march']							= 'March';
$_['entry_april']							= 'April';
$_['entry_may']								= 'May';
$_['entry_june']							= 'June';
$_['entry_july']							= 'July';
$_['entry_august']							= 'August';
$_['entry_september']						= 'September';
$_['entry_october']							= 'October';
$_['entry_november']						= 'November';
$_['entry_december']						= 'December';
$_['entry_sunday']							= 'Sunday';
$_['entry_monday']							= 'Monday';
$_['entry_tuesday']							= 'Tuesday';
$_['entry_wednesday']						= 'Wednesday';
$_['entry_thursday']						= 'Thursday';
$_['entry_friday']							= 'Friday';
$_['entry_saturday']						= 'Saturday';
$_['entry_use_bounce_check']				= 'Check for bounced emails';
$_['entry_bounce_email']					= 'Email address for bounced emails<br/><span class="help">Email address for receiving bounced emails</span>';
$_['entry_bounce_pop3_server']				= 'POP3 server for bounced emails<br/><span class="help">POP3 server name or IP address</span>';
$_['entry_bounce_pop3_user']				= 'POP3 server login<br/><span class="help">Login for authenticating on server</span>';
$_['entry_bounce_pop3_password']			= 'POP3 server password<br/><span class="help">Password for authenticating on server</span>';
$_['entry_bounce_pop3_port']				= 'POP3 server port<br/><span class="help">If empty, 110 port will be used</span>';
$_['entry_bounce_delete']					= 'Delete bounced emails<br/><span class="help">If yes, known bounced emails will be deleted from mailbox</span>';
$_['entry_transaction_id'] 					= 'Order ID:';
$_['entry_transaction_email'] 				= 'E-mail:';
$_['entry_hide_marketing'] 					= 'Hide marketing lists in frontend:';

// Button
$_['button_add_list']   					= 'Add';

// Error
$_['error_permission']						= 'Warning: You do not have permission to modify module Newsletter Enhancements!';

$_['entry_use_smtp']						= 'Use custom mail configuration:';
$_['entry_mail_protocol']					= 'Mail Protocol:<span class="help">Only choose \'Mail\' unless your host has disabled the php mail function.';
$_['text_mail']								= 'Mail';
$_['text_mail_phpmailer']					= 'Mail (PHPMailer)';
$_['text_smtp']								= 'SMTP';
$_['text_smtp_phpmailer']					= 'SMTP (PHPMailer)';
$_['entry_email']							= 'Email address:';
$_['entry_mail_parameter']					= 'Mail Parameters:<span class="help">When using \'Mail\', additional mail parameters can be added here (e.g. "-femail@storeaddress.com".';
$_['entry_smtp_host']						= 'SMTP Host:';
$_['entry_smtp_username']					= 'SMTP Username:';
$_['entry_smtp_password']					= 'SMTP Password:';
$_['entry_smtp_port']						= 'SMTP Port:';
$_['entry_smtp_timeout']					= 'SMTP Timeout:';
$_['entry_stores']							= 'Stores:';
$_['text_smtp_settings']					= 'Mail Settings';

?>
