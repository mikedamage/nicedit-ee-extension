<?php

if ( ! defined('EXT'))
{
    exit('Invalid file request');
}

class NicEdit
{
    var $settings        = array();

    var $name            = 'NicEdit EE Extension';
    var $version         = '0.1';
    var $description     = 'Converts textareas in the Publish section into NicEdit WYSIWYG editors.';
    var $settings_exist  = 'n';
    var $docs_url        = 'http://www.nicedit.com';

    // -------------------------------
    //   Constructor - Extensions use this for settings
    // -------------------------------

    function NicEdit($settings='')
    {
        $this->settings = $settings;
    }
    // END

	// Add javascript header
	function add_header()
	{
		global $PREFS, $EXT;
		$tags = '<script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script>
<script type="text/javascript">
//<![CDATA[
	bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
//]]>
</script>';
		return $tags;
	}

	// Activate Extension
	function activate_extension()
	{
		global $DB, $PREFS;
		$default_settings = serialize(array('script_url' => $PREFS->ini('site_url', TRUE).'nicedit/nicedit.js'));
		$DB->query($DB->insert_string('exp_extensions', array(
					'extension_id' 	=> '',
					'class'			=> "NicEdit",
					'method'		=> "add_header",
					'hook'			=> "publish_form_headers",
					'settings'		=> $default_settings,
					'priority'		=> 10,
					'version'		=> $this->version,
					'enabled'		=> 'y'
				)
			)
		);
	}
	// End Activate Extension Function

	// Update Extension
	function update_extension($current='')
    {
    	global $DB;

    	if ($current == '' OR $current == $this->version)
    	{
    		return FALSE;
    	}

    	if ($current > '1.0.0')
    	{
    		// Update queries for next version 1.0.1
    	}

    	$DB->query("UPDATE exp_extensions
    				SET version = '".$DB->escape_str($this->version)."'
    				WHERE class = 'Publish_form'");
    }
	// End Update Extension Function

	// Disable Extension
	function disable_extension()
	{
	    global $DB;

	    $DB->query("DELETE FROM exp_extensions WHERE class = 'NicEdit'");
	}
	// End Disable Extension Function

}
// END CLASS

?>
