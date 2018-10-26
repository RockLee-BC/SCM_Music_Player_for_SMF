<?php
/********************************************************************************
* SCMP.template.php - Subs of the SCM Music Player for SMF mod
*********************************************************************************
* This program is distributed in the hope that it is and will be useful, but
* WITHOUT ANY WARRANTIES; without even any implied warranty of MERCHANTABILITY
* or FITNESS FOR A PARTICULAR PURPOSE,
**********************************************************************************/
if (!defined('SMF'))
	die('Hacking attempt...');

function template_callback_SCM_playlists()
{
	global $context, $txt, $modSettings, $boardurl;

	// List the tracks in the playlist:
	echo '
						<dt>
							<strong><u>', $txt['SCM_music_title'], '</u></strong>
						</dt>
						<dd>
							<strong><u>', $txt['SCM_music_URL'], '</u></strong>
						</dd>';
	$counter = 0;
	if (!empty($modSettings['SCM_playlist']))
	{
		$playlist = safe_unserialize($modSettings['SCM_playlist']);
		if (count($playlist))
		{
			foreach ($playlist as $title => $url)
			{
				$counter++;
				echo '
						<dt id="title_', $counter, '">
							<input type="text" name="SCM_title[]" value=', JavaScriptEscape($title), ' size="25" class="input_text" />
						</dt>
						<dd id="url_', $counter, '">
							<input type="text" name="SCM_url[]" value=', JavaScriptEscape($url), ' size="40" class="input_text" />
							<a href="javascript:void(0);" onclick="removeTrack(', $counter .'); return false;"><img src="', $boardurl, '/Themes/default/images/icons/quick_remove.gif"></a>
						</dd>';
			}
		}
	}

	// Add the button and Javascript to add a track to the playlist:
	echo '				<div id="insert_playlist"></div>
						<script type="text/javascript">
							var counter = ', ++$counter, ';
							function addTrack()
							{
								setOuterHTML(document.getElementById("insert_playlist"), \'<dt id="title_\' + counter + \'"><input type="text" name="SCM_title[]" size="25" class="input_text" /></dt><dd id="url_\' + counter + \'"><input type="text" name="SCM_url[]" size="40" class="input_text" /> <a href="javascript:void(0);" onclick="removeTrack(\' + counter + \'); return false;"><img src="' . $boardurl . '/Themes/default/images/icons/quick_remove.gif"></a></dd><div id="insert_playlist"></div>\');
								counter++;
							}
							function removeTrack(track)
							{
								setOuterHTML(document.getElementById("title_" + track), "");
								setOuterHTML(document.getElementById("url_" + track), "");
							}
							document.write(\'<dt><input type="submit" name="addtrack" id="addtrack" value="', $txt['SCM_add_track'], '" onclick="addTrack(); return false;" class="button_submit" /></dt>\');
							addTrack();
						</script>';
}

function template_callback_SCM_style()
{
	global $modSettings, $txt, $context;

	echo '
						<table style="margin-left:auto; margin-right: auto;">';
	foreach ($context['SCM_styles'] as $style)
		echo '
							<tr>
								<td><input type="radio" name="SCM_style"', ($modSettings['SCM_style'] == $style ? ' checked="checked"' : ''), ' value="', $style, (!empty($modSettings['SCM_enabled']) ? '" onclick="SCM.skin(\'skins/' . $style . '/skin.css\');" ' : '"'), '/>', $style, '</td>
								<td><iframe src="http://scmplayer.net/skinPreview.html#skins/', $style, '/skin.css" frameborder="0" width="400" height="25" style="padding: 1px;"></iframe></option></td>
							</tr>';
	echo '
							<tr>
								<td><input type="radio" name="SCM_style"', ($modSettings['SCM_style'] == '_custom_' ? ' checked="checked"' : ''), ' value="_custom_" />', $txt['SCM_custom_style'], '</td>
								<td><input type="text" name="SCM_custom_url" size="50"', (isset($modSettings['SCM_custom_url']) && $modSettings['SCM_style'] == '_custom_' ? 'value="' . $modSettings['SCM_custom_url'] . '"' : ''), ' /></td>
							</tr>
						</table>';
}

function template_SCMP_popup_trigger()
{
	global $boardurl, $txt;
	echo ' <a class="button" href="#SCMP_popup"><img src="', $boardurl, '/Themes/default/images/helptopics.gif" class="icon" alt="', $txt['SCMP_popup_title'], '"></a>';
}

?>