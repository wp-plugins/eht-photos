<?php

define('DOING_AJAX', true);

require_once ("../../../wp-config.php");
require_once ("../../../wp-admin/includes/admin.php");
require_once ("Common.php");

$action = $_REQUEST["action"];
switch ($action)
{
	case "thumbnail":
		$text = EHTPhotosActionThumbnail ();
		break;
	case "permission":
		$text = EHTPhotosActionPermission ();
		break;
	default:
		$text = "Unknown action \"$action\".";
		break;
}

echo $text;

function EHTPhotosActionThumbnail ()
{
	$pathImage = $_REQUEST["pathImage"];
	$urlThumb = $_REQUEST["urlThumb"];
	$pathThumb = $_REQUEST["pathThumb"];
	$name = $_REQUEST["name"];
	$thumbSize = $_REQUEST["thumbSize"];
	$elementOld = $_REQUEST["elementOld"];
	$elementNew = $_REQUEST["elementNew"];
	
	$text = EHTPhotosGenerateThumb ($pathImage,
									$urlThumb,
									$pathThumb,
									$name,
									$thumbSize);
	
	$text = "<img src=\"$text\" border=\"0\" onLoad=\"HideAndShow ('$elementOld', '$elementNew');\">";

	return ($text);
}

function EHTPhotosActionPermission ()
{
	global $wpdb;
	
	$path = $wpdb->escape ($_REQUEST[EHT_PHOTOS_FIELD_PATH]);
	$groupId = $wpdb->escape ($_REQUEST[EHT_PHOTOS_FIELD_GROUP_ID]);
	$value = ($_REQUEST[EHT_PHOTOS_FIELD_VALUE] == "true");
	if (($path != "") && ($groupId != ""))
	{
		$sql = sprintf ($value ? EHT_PHOTOS_TABLE_PERMISSION_INSERT : EHT_PHOTOS_TABLE_PERMISSION_DELETE, $groupId, $path);					
		$wpdb->query ($sql);
	}
}

?>