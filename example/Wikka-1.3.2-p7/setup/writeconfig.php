<?php
// fetch config
$config = $config2 = unserialize($_POST["config"]);

// merge existing configuration with new one
$config = array_merge($wakkaConfig, $config);

// remove obsolete config settings if present
unset($config["allow_doublequote_html"]);
unset($config["header_action"]);
unset($config["footer_action"]);
unset($config["external_link_tail"]);

// Parse navlinks, convert to menu configuration files, #891 (since 1.2)
// Check to see if config is writeable...
if(!is_writeable('config'))
{
	print("<p><span class=\"failed\">WARNING:</span> The <tt>config</tt> directory is not writeable; therefore, conversion of old navigation links to new menu items cannot be performed.  Please give your web server temporary write access to the <tt>config</tt> directory (<tt>chmod 777 config</tt>; don't forget to remove write access later, i.e. <tt>chmod 555 config</tt>). If you are unable to make this directory writeable, you will need to manually edit the menu files in the <tt>config</tt> directory.  You will also need to remove the <tt>navigation_links</tt> and <tt>logged_in_navigation_links</tt> parameters in your <tt>wikka.config.php</tt> file. If you are still having difficulties, please visit <a href=\"http://docs.wikkawiki.org/WikkaInstallation\">WikkaInstallation</a>.</p>\n"); 
	?>
	<form action="<?php echo myLocation() ?>?installAction=writeconfig" method="post">
	<input type="hidden" name="config" value="<?php echo Wakka::hsc_secure(serialize($config2)) ?>" /><?php /*  #427 */ ?>
	<input type="submit" value="Try again" />
	</form>	
	<?php
	return;	
}
$path = 'config'.DIRECTORY_SEPARATOR;
if(isset($config['navigation_links']))
{
	$navlinks = $config['navigation_links'];
	$links = array();
	if(FALSE!==preg_match_all('/[A-Z���]+[a-z����]+[A-Z0-9���][A-Za-z0-9�������]*|\[\[.*?\]\]/', $navlinks, $links))
	{
		if(file_exists($path.'main_menu.inc'))
		{
			rename($path.'main_menu.inc', $path.'main_menu.orig.inc');
		}
		$h = fopen($path.'main_menu.inc', 'w'); 
		foreach($links[0] as $link)
		{
			fwrite($h, $link."\n");
		}
		fwrite($h, "{{searchform}}\n");
		fwrite($h, 'Your hostname is {{whoami}}');
		fclose($h);
	}
	unset($config['navigation_links']);
}
if(isset($config['logged_in_navigation_links']))
{
    $navlinks = $config['logged_in_navigation_links'];
	$links = array();
	if(FALSE!==preg_match_all('/[A-Z���]+[a-z����]+[A-Z0-9���][A-Za-z0-9�������]*|\[\[.*?\]\]/', $navlinks, $links))
	{
		if(file_exists($path.'main_menu.user.inc'))
		{
			rename($path.'main_menu.user.inc', $path.'main_menu.user.orig.inc');
		}
		$h = fopen($path.'main_menu.user.inc', 'w'); 
		foreach($links[0] as $link)
		{
			fwrite($h, $link."\n");
		}
		fwrite($h, "{{searchform}}\n");
		fwrite($h, 'You are {{whoami}}');
		fclose($h);
	}
    unset($config['logged_in_navigation_links']); // since 1.2
}

// set version to current version, yay!
$config["wakka_version"] = WAKKA_VERSION;

// convert config array into PHP code
$double_backslash = '\\\\';
$single_quote = '\'';
$configCode = "<?php\n/**\n * WikkaWiki configuration file \n * \n * This file was generated by the Wikka installer on ".strftime("%c")."\n * Do not manually change wakka_version if you wish to keep your engine up-to-date.\n * Documentation is available at: http://docs.wikkawiki.org/ConfigurationOptions\n */\n\$wakkaConfig = array(\n";
foreach ($config as $k => $v)
{
	$entries[] = "\t'".$k."' => '".preg_replace('/['.$double_backslash.$single_quote.']/', $double_backslash.'$0', $v)."'"; // #5
}
$configCode .= implode(",\n", $entries).");\n?>";

// try to write configuration file
print("<h2>Writing configuration</h2>\n");
test("Writing configuration file <tt>".$wakkaConfigLocation."</tt>...", $fp = @fopen($wakkaConfigLocation, "w"), "", 0);

if ($fp)
{
	fwrite($fp, $configCode);
	// write
	fclose($fp);
	
	print("<p>That's all! You can now <a href=\"".WIKKA_BASE_URL."\">return to your Wikka site</a>. However, you are advised to remove write access to <tt>wikka.config.php</tt> again now that it's been written. Leaving the file writable can be a security risk!</p>");
}
else
{
	// complain
	print("<p><span class=\"failed\">WARNING:</span> The configuration file <tt>".$wakkaConfigLocation."</tt> could not be written. You will need to give your web server temporary write access to either your wakka directory, or a blank file called <tt>wikka.config.php</tt> (<tt>touch wikka.config.php ; chmod 666 wikka.config.php</tt>; don't forget to remove write access again later, ie <tt>chmod 644 wikka.config.php</tt>). If, for any reason, you can't do this, you'll have to copy the text below into a new file and save/upload it as <tt>wikka.config.php</tt> into the Wikka directory. Once you've done this, your Wikka site should work. If not, please visit <a href=\"http://docs.wikkawiki.org/WikkaInstallation\">WikkaInstallation</a>.</p>\n");
	?>
	<form action="<?php echo myLocation() ?>?installAction=writeconfig" method="post">
	<input type="hidden" name="config" value="<?php echo Wakka::hsc_secure(serialize($config2)) ?>" /><?php /*  #427 */ ?>
	<input type="submit" value="Try again" />
	</form>	
	<?php
	print("<xmp>".$configCode."</xmp>\n"); //TODO: replace xmp and make code block downloadable
}

?>
