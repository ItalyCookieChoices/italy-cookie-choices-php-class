<?php
return array(
	/*
	 * Activate
	 * Display banner for Cookie Law
	 *
	 * Accepted values: Boolean (true || false)
	 */
	'active'=> false,

	/*
	 * Where display the banner
	 *
	 * Accepted values: Integer (1 || 2 || 3)
	 * 1 => Top Bar (Default, Display a top bar with your message)
	 * 2 => Dialog (Display an overlay with your message)
	 * 3 => Bottom Bar (Display a bar in the footer with your message)
	 */
	'banner'=> 1,

	/*
	 * Mouse scroll event
	 * Accepts disclosures on mouse scroll event
	 *
	 * Accepted values: Boolean (true || false)
	 */
	'scroll'=>false,

	/*
	 * Accept on second view
	 * Activate accept on second view
	 *
	 * Accepted values: Boolean (true || false)
	 */
	'secondView'=>false,

	/*
	 * Refresh page
	 * Refresh page after button click (DEPRECATED)
	 *
	 * Accepted values: Boolean (true || false)
	 */
	'reload'=>false,

	/*
	 * Cookie name
	 * Insert your cookie name (Default: displayCookieConsent)
	 *
	 * Accepted values: String
	 */
	'cookie_name'=>'displayCookieConsent',

	/*
	 * Cookie value
	 * Insert your cookie value (Default: y)
	 *
	 * Accepted values: String
	 */
	'cookie_value'=>'y',

	/*
	 * URL for cookie policy
	 * Insert here the link to your policy page
	 *
	 * Accepted values: String (e.g. '/policy/')
	 */
	'url'=>'',

	/*
	 * Cookie policy page slug
	 * Insert your cookie policy page slug (e.g. your-policy-url), it will display only topbar in your cookie policy page
	 *
	 * Accepted values: String (e.g. '/policy/')
	 */
	'slug'=>'',

	/*
	 * Banner Background color
	 * Custom Background color for banner
	 *
	 * Accepted values: String (e.g. '#000000')
	 */
	'banner_bg'=>'#000',

	/*
	 * Banner text color
	 * Custom text color for banner
	 *
	 * Accepted values: String (e.g. '#FFFFFF')
	 */
	'banner_text_color'=>'#FFF',

	/*
	 * Text to display
	 * People will see this notice only the first time that they enter your site
	 *
	 * Accepted values: String
	 */
	'text'=>'',

	/*
	 * Button text
	 * Insert here name of button (e.g. "Close")
	 *
	 * Accepted values: String
	 */
	'button_text'=>'',

	/*
	 * Anchor text for URL
	 * Insert here anchor text for the link
	 *
	 * Accepted values: String
	 */
	'anchor_text'=>'',

	/*
	 * Text message for locked embedded content
	 * People will see this notice only the first time that they enter your site
	 *
	 * Accepted values: String
	 */
	'content_message_text'=>'',

	/*
	 * Button text to activate locked embedded content
	 * Insert here name of button (e.g. "Close")
	 *
	 * Accepted values: String
	 */
	'content_message_button_text' =>'',

	/*
	 * HTML top margin
	 * Add a page top margin for info top bar, only for default topbar stile
	 *
	 * Accepted values: Boolean (true || false)
	 */
	'html_margin' => false,

	/*
	 * CookieChoices Template
	 * Select the template to use
	 *
	 * Accepted values: String ('default' || 'bigbutton' || 'smallbutton')
	 * 'default' => Default cookiechoices template (centered with text links)
     * 'bigbutton' => Centered container with left aligned text and big buttons
     * 'smallbutton' => Centered container with left aligned text and small buttons
	 */
	'js_template' => 'default',

	/*
	 * Open policy in new page
	 * Open your cookie policy page in new one
	 *
	 * Accepted values: Boolean (true || false)
	 */
	'target' => false,

	/*
	 * Third part cookie block
	 * Cookie from any embed in all body section
	 *
	 * Accepted values: Boolean (true || false)
	 */
	'block_body'=>false,

	/*
	 * Script to exclude from block
	 * List of scripts to be excluded from the block
	 *
	 * Accepted values: Array stings
	 *
	 * Accept string o regular expression
	 * For example:
	 * '<script src="/js/myspecial.js"></script>', // only script
	 * '<script src="/js/.*?"></script>', // all scripts in /js/
	 */
	'block_body_scripts_exclude'=> array(
		//'<script src="/js/myspecial.js"></script>', // only script
	 	//'<script src="/js/.*?"></script>', // all scripts in /js/
	),

	/*
	 * Script to block in the head section
	 * List of scripts to block in head section
	 *
	 * Accepted values: Array stings
	 *
	 * Accept string o regular expression
	 * For example:
	 * '<script src="/js/myspecial.js"></script>', // only script
	 * '<script src="/js/.*?"></script>', // all scripts in /js/
	 */
	'block_head_scripts_include'=> array(
		//'<script src="/js/myspecial.js"></script>', // only script
	 	//'<script src="/js/.*?"></script>', // all scripts in /js/
	),
);
?>
