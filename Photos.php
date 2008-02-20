<?php
/*
Plugin Name:	EHT Photos
Plugin URI:		http://ociotec.com/index.php/2008/01/10/eht-photos-plugin-para-wordpress/
Description:	This plugin generates automatically photo galleries with thumbnails and easy recursive navigation links, the photos can be viewed in several sizes, with an easy configuration panel.
Author:			Emilio Gonz&aacute;lez Monta&ntilde;a
Version:		1.5
Author URI:		http://ociotec.com/

History:		0.1		First release.
				0.3		The thumbnails size, the normal size photos and the thumbnails width are configurables. Several upgrades into the presentation.
				0.4		Added options configuration panel.
				0.5		Added an option to show EXIF information of the photos in the detailed view.
				0.7		Renamed from "eht-mis-fotos" to "eht-photos". Added data base support using the photo MD5 as photo ID. The photos have a counter for viewing.
				0.7.1	Corrected an error creating thumbs folder (now create the thumb path when it's needed).
				0.8		Added subpages to options menu, so now there are these subpages: General Options (the previous option page), Photos (you can see all the photos information).
				1.0		Remove tag "thumbs" from plugin sintax, and added two options: "path to images" and "path to thumbs", so the "images" tag is relative to the two new options. Into the options menu subpage "Photos" now you can see the thumbnail into the photo list.
				1.5		Added permissions support, so you can require permissions to view folders and files from the administration options menu, and define groups.

Setup:
	1) Install the plugin.
	2) Go to the admin menus, and in "Options" panel, select "EHT Photos".
	3) Press "Install DB".
	4) Configure the plugin if you need.
	5) Insert the plugin tags where you need it (see below the plugin sintax).

Plugin sintax:

[photos images={1} path={2}]

Where:
   {1} this is the URL of the path to the photo files relative to options "path to images" and "path to thumbs"
   {2} this is a flag to show (yes) or not (no) the path links

Example:

[photos images=Hobbies/Informatica/MisFotos path=yes]

*/

define ("EHT_PHOTOS_SESSION_DOMAIN", "eht-photos");
define ("EHT_PHOTOS_PLUGIN_URL_BASE", get_option ("siteurl") . "/wp-content/plugins/eht-photos/");
define ("EHT_PHOTOS_PLUGIN_URL_BASE_IMAGES", EHT_PHOTOS_PLUGIN_URL_BASE . "images/");
define ("EHT_PHOTOS_PLUGIN_PATH_BASE", $_SERVER["DOCUMENT_ROOT"] . "/wp-content/plugins/eht-photos/");
define ("EHT_PHOTOS_PLUGIN_PATH_BASE_IMAGES", EHT_PHOTOS_PLUGIN_PATH_BASE . "images/");
define ("EHT_PHOTOS_PLUGIN_VERSION", "1.5");
define ("EHT_PHOTOS_PLUGIN_DESCRIPTION", "Plugin <a href=\"http://ociotec.com/index.php/2008/01/10/eht-photos-plugin-para-wordpress/\" target=\"_blank\">EHT Photos v" . EHT_PHOTOS_PLUGIN_VERSION . "</a> - Created by <a href=\"http://ociotec.com\" target=\"_blank\">Emilio Gonz&aacute;lez Monta&ntilde;a</a>");
define ("EHT_PHOTOS_OPTION_PATH_IMAGES", "eht-photos-option-path-images");
define ("EHT_PHOTOS_OPTION_PATH_THUMBS", "eht-photos-option-path-thumbs");
define ("EHT_PHOTOS_OPTION_THUMB", "eht-photos-option-thumb");
define ("EHT_PHOTOS_OPTION_NORMAL", "eht-photos-option-normal");
define ("EHT_PHOTOS_OPTION_WIDTH", "eht-photos-option-width");
define ("EHT_PHOTOS_OPTION_EXIF", "eht-photos-option-exif");
define ("EHT_PHOTOS_OPTION_TABLE_RESULTS", "eht-photos-option-table-results");
define ("EHT_PHOTOS_FIELD_SUBPAGE", "eht-photos-field-subpage");
define ("EHT_PHOTOS_SUBPAGE_GENERAL", "General options");
define ("EHT_PHOTOS_SUBPAGE_PHOTOS", "Photos");
define ("EHT_PHOTOS_SUBPAGE_GALLERY", "Gallery");
define ("EHT_PHOTOS_SUBPAGE_GROUPS", "Groups");
define ("EHT_PHOTOS_SUBPAGE_USERS", "Users");
define ("EHT_PHOTOS_FIELD_ACTION", "eht-photos-field-action");
define ("EHT_PHOTOS_ACTION_INSTALL", "Install DB");
define ("EHT_PHOTOS_ACTION_UNINSTALL", "Uninstall DB");
define ("EHT_PHOTOS_ACTION_UPDATE", "Update");
define ("EHT_PHOTOS_ACTION_RESET", "Reset");
define ("EHT_PHOTOS_ACTION_CREATE", "Create");
define ("EHT_PHOTOS_ACTION_EDIT", "Edit");
define ("EHT_PHOTOS_FIELD_ORDER", "eht-photos-field-order");
define ("EHT_PHOTOS_ORDER_ID", "id");
define ("EHT_PHOTOS_ORDER_MD5", "md5");
define ("EHT_PHOTOS_ORDER_NAME", "name");
define ("EHT_PHOTOS_ORDER_VIEWS", "views");
define ("EHT_PHOTOS_ORDER_PATH", "path");
define ("EHT_PHOTOS_FIELD_DIRECTION", "eht-photos-field-direction");
define ("EHT_PHOTOS_FIELD_ID", "eht-photos-field-id");
define ("EHT_PHOTOS_FIELD_OFFSET", "eht-photos-field-offset");
define ("EHT_PHOTOS_FIELD_NAME", "eht-photos-field-name");
define ("EHT_PHOTOS_FIELD_DESCRIPTION", "eht-photos-field-description");
define ("EHT_PHOTOS_FIELD_USER", "eht-photos-field-user-%d-%d");
define ("EHT_PHOTOS_FIELD_GROUP", "eht-photos-field-group-");
define ("EHT_PHOTOS_FIELD_PATH", "eht-photos-field-path");
define ("EHT_PHOTOS_YES", "yes");
define ("EHT_PHOTOS_NO", "no");
define ("EHT_PHOTOS_DEFAULT_THUMB", 170);
define ("EHT_PHOTOS_DEFAULT_NORMAL", 700);
define ("EHT_PHOTOS_DEFAULT_WIDTH", 4);
define ("EHT_PHOTOS_DEFAULT_EXIF", EHT_PHOTOS_YES);
define ("EHT_PHOTOS_DEFAULT_RESULTS", 32);
define ("EHT_PHOTOS_MIN_THUMB", 16);
define ("EHT_PHOTOS_MAX_THUMB", 512);
define ("EHT_PHOTOS_MIN_NORMAL", 128);
define ("EHT_PHOTOS_MAX_NORMAL", 2048);
define ("EHT_PHOTOS_MIN_WIDTH", 1);
define ("EHT_PHOTOS_MAX_WIDTH", 16);
define ("EHT_PHOTOS_MIN_RESULTS", 8);
define ("EHT_PHOTOS_MAX_RESULTS", 1024);
define ("EHT_PHOTOS_PHOTO_EXTENSIONS", "jpg,jpeg,png,gif");
define ("EHT_PHOTOS_THUMB_FOLDER", 1);
define ("EHT_PHOTOS_THUMB_FILE", 2);
define ("EHT_PHOTOS_THUMB_EMPTY", 3);
define ("EHT_PHOTOS_VAR_PATH", "path");
define ("EHT_PHOTOS_VAR_MODE", "mode");
define ("EHT_PHOTOS_VAR_PHOTO", "photo");
define ("EHT_PHOTOS_ANCHOR_GALLERY", "gallery");
define ("EHT_PHOTOS_VAR_MODE_THUMB", "thumb");
define ("EHT_PHOTOS_VAR_MODE_NORMAL", "normal");
define ("EHT_PHOTOS_WORD_WRAP", 20);
define ("EHT_PHOTOS_SLASH", strstr (PHP_OS, "WIN") ? "\\" : "/");
define ("EHT_PHOTOS_IMAGE_FOLDER", "Folder.jpg");
define ("EHT_PHOTOS_IMAGE_EMPTY", "Transparent.gif");
define ("EHT_PHOTOS_ICON_RESET", "IconReset.png");
define ("EHT_PHOTOS_ICON_PHOTO", "IconPhoto.png");
define ("EHT_PHOTOS_ICON_EDIT", "IconEdit.png");
define ("EHT_PHOTOS_ICON_DELETE", "IconDelete.png");
define ("EHT_PHOTOS_ICON_PERMISSIONS", "IconPermissions.png");
define ("EHT_PHOTOS_ICON_MINUS", "IconMinus.png");
define ("EHT_PHOTOS_ICON_PLUS", "IconPlus.png");
define ("EHT_PHOTOS_COLUMN_WRAP", 10);
define ("EHT_PHOTOS_TABLE_PHOTO", $wpdb->prefix . "eht_photos_photo");
define ("EHT_PHOTOS_TABLE_COMMENT", $wpdb->prefix . "eht_photos_comment");
define ("EHT_PHOTOS_TABLE_GROUP", $wpdb->prefix . "eht_photos_group");
define ("EHT_PHOTOS_TABLE_USER", $wpdb->prefix . "eht_photos_user");
define ("EHT_PHOTOS_TABLE_PERMISSION", $wpdb->prefix . "eht_photos_permission");
define ("EHT_PHOTOS_TABLE_CHECK", "SHOW TABLES LIKE \"%s\";");
define ("EHT_PHOTOS_TABLE_DROP", "DROP TABLE %s;");
define ("EHT_PHOTOS_TABLE_PHOTO_CREATE",
		"CREATE TABLE " . EHT_PHOTOS_TABLE_PHOTO . " (
		  id INT NOT NULL AUTO_INCREMENT,
		  md5 VARCHAR (32) NOT NULL,
		  name VARCHAR (50) NOT NULL,
		  views INT NOT NULL,
		  path VARCHAR (255) NOT NULL,
		  PRIMARY KEY (id),
		  UNIQUE INDEX md5Unique (md5)
		);");
define ("EHT_PHOTOS_TABLE_PHOTO_SELECT",
		"SELECT * FROM " . EHT_PHOTOS_TABLE_PHOTO . " WHERE md5 = \"%s\";");
define ("EHT_PHOTOS_TABLE_PHOTO_SELECT_ALL",
		"SELECT * FROM " . EHT_PHOTOS_TABLE_PHOTO . " ORDER BY %s %s LIMIT %d, %d;");
define ("EHT_PHOTOS_TABLE_PHOTO_COUNT",
		"SELECT COUNT(id) AS count FROM " . EHT_PHOTOS_TABLE_PHOTO);
define ("EHT_PHOTOS_TABLE_PHOTO_INSERT",
		"INSERT INTO " . EHT_PHOTOS_TABLE_PHOTO . " (md5, name, views, path) VALUES (\"%s\", \"%s\", 0, \"%s\");");
define ("EHT_PHOTOS_TABLE_PHOTO_UPDATE_VIEWS",
		"UPDATE " . EHT_PHOTOS_TABLE_PHOTO . " SET views = %d WHERE id = %d;");
define ("EHT_PHOTOS_TABLE_PHOTO_UPDATE_PATH",
		"UPDATE " . EHT_PHOTOS_TABLE_PHOTO . " SET path = \"%s\" WHERE id = %d;");
define ("EHT_PHOTOS_TABLE_COMMENT_CREATE",
		"CREATE TABLE " . EHT_PHOTOS_TABLE_COMMENT . " (
		  id INT NOT NULL AUTO_INCREMENT,
		  idPhoto INT NOT NULL,
		  name VARCHAR (50) NOT NULL,
		  email VARCHAR (50) NOT NULL,
		  web VARCHAR (50) NOT NULL,
		  comment VARCHAR (200) NOT NULL,
		  PRIMARY KEY (id)
		);");
define ("EHT_PHOTOS_TABLE_GROUP_CREATE",
		"CREATE TABLE " . EHT_PHOTOS_TABLE_GROUP . " (
		  id INT NOT NULL AUTO_INCREMENT,
		  name VARCHAR (50) NOT NULL,
		  description VARCHAR (200) NOT NULL,
		  PRIMARY KEY (id),
		  UNIQUE INDEX nameUnique (name)
		);");
define ("EHT_PHOTOS_TABLE_GROUP_SELECT_ALL",
		"SELECT * FROM " . EHT_PHOTOS_TABLE_GROUP . " ORDER BY name ASC;");
define ("EHT_PHOTOS_TABLE_GROUP_SELECT_NAMES",
		"SELECT id, name FROM " . EHT_PHOTOS_TABLE_GROUP . " ORDER BY name ASC;");
define ("EHT_PHOTOS_TABLE_GROUP_INSERT",
		"INSERT INTO " . EHT_PHOTOS_TABLE_GROUP . " (name, description) VALUES (\"%s\", \"%s\");");
define ("EHT_PHOTOS_TABLE_GROUP_UPDATE",
		"UPDATE " . EHT_PHOTOS_TABLE_GROUP . " SET name = \"%s\", description = \"%s\" WHERE id = %d;");
define ("EHT_PHOTOS_TABLE_GROUP_DELETE",
		"DELETE FROM " . EHT_PHOTOS_TABLE_GROUP . " WHERE id = %d;");
define ("EHT_PHOTOS_TABLE_USER_CREATE",
		"CREATE TABLE " . EHT_PHOTOS_TABLE_USER . " (
		  id INT NOT NULL AUTO_INCREMENT,
		  idUser INT NOT NULL,
		  idGroup INT NOT NULL,
		  PRIMARY KEY (id),
		  UNIQUE INDEX userGroupUnique (idUser, idGroup)
		);");
define ("EHT_PHOTOS_TABLE_USER_SELECT_ALL",
		"SELECT u.idUser, u.idGroup FROM " . EHT_PHOTOS_TABLE_USER . " AS u, " . EHT_PHOTOS_TABLE_GROUP . " AS g, " . $wpdb->prefix . "users AS w WHERE g.id = u.idGroup AND u.idUser = w.ID;");
define ("EHT_PHOTOS_TABLE_USER_SELECT_NAMES",
		"SELECT ID AS id, user_nicename AS name FROM " . $wpdb->prefix . "users ORDER BY name ASC;");
define ("EHT_PHOTOS_TABLE_USER_SELECT_GROUPS",
		"SELECT g.id AS id, g.name AS name FROM " . EHT_PHOTOS_TABLE_USER . " AS u, " . EHT_PHOTOS_TABLE_GROUP . " AS g, " . $wpdb->prefix . "users AS w WHERE g.id = u.idGroup AND u.idUser = w.ID AND w.ID = %d;");
define ("EHT_PHOTOS_TABLE_USER_INSERT",
		"INSERT INTO " . EHT_PHOTOS_TABLE_USER . " (idUser, idGroup) VALUES (%d, %d);");
define ("EHT_PHOTOS_TABLE_USER_DELETE",
		"DELETE FROM " . EHT_PHOTOS_TABLE_USER . " WHERE idUser = %d AND idGroup = %d;");
define ("EHT_PHOTOS_TABLE_PERMISSION_CREATE",
		"CREATE TABLE " . EHT_PHOTOS_TABLE_PERMISSION . " (
		  id INT NOT NULL AUTO_INCREMENT,
		  idGroup INT NOT NULL,
		  path VARCHAR (255) NOT NULL,
		  PRIMARY KEY (id),
		  UNIQUE INDEX groupPathUnique (idGroup, path)
		);");
define ("EHT_PHOTOS_TABLE_PERMISSION_SELECT_PATH",
		"SELECT p.idGroup AS groupId, g.name AS groupName FROM " . EHT_PHOTOS_TABLE_PERMISSION . " AS p, " . EHT_PHOTOS_TABLE_GROUP . " AS g WHERE p.idGroup = g.id AND p.path = \"%s\";");
define ("EHT_PHOTOS_TABLE_PERMISSION_INSERT",
		"INSERT INTO " . EHT_PHOTOS_TABLE_PERMISSION . " (idGroup, path) VALUES (%d, \"%s\");");
define ("EHT_PHOTOS_TABLE_PERMISSION_DELETE",
		"DELETE FROM " . EHT_PHOTOS_TABLE_PERMISSION . " WHERE idGroup = %d AND path = \"%s\";");

$currentUrl = $PHP_SELF . "?";
$inAdmin = false;
$goodPath = "";

require_once ("Admin.php");

add_filter ("the_content", "EHTPhotosFilterTheContent");

function EHTPhotosFilterTheContent ($content)
{
	global $goodPath;
	
	$search = "/\[photos\s*images\s*=\s*([^\]]+)\s*path\s*=\s*([^\]]+)\s*\]/i";

	preg_match_all ($search, $content, $results);

	if (is_array ($results))
	{
		$optionPathImages = get_option (EHT_PHOTOS_OPTION_PATH_IMAGES);
		$optionPathThumbs = get_option (EHT_PHOTOS_OPTION_PATH_THUMBS);
		$optionThumb = get_option (EHT_PHOTOS_OPTION_THUMB);
		$optionNormal = get_option (EHT_PHOTOS_OPTION_NORMAL);
		$optionWidth = get_option (EHT_PHOTOS_OPTION_WIDTH);
		$optionExif = get_option (EHT_PHOTOS_OPTION_EXIF);
		if ($optionThumb == "")
		{
			$optionThumb = EHT_PHOTOS_DEFAULT_THUMB;
		}
		if ($optionNormal == "")
		{
			$optionNormal = EHT_PHOTOS_DEFAULT_NORMAL;
		}
		if ($optionWidth == "")
		{
			$optionWidth = EHT_PHOTOS_DEFAULT_WIDTH;
		}
		if ($optionExif == "")
		{
			$optionExif = EHT_PHOTOS_DEFAULT_EXIF;
		}

		for ($index = 0; $index < count ($results[0]); $index++)
		{
			$tagImages = EHTPhotosQuitSlashes (trim ($results[1][$index]));
			$tagPath = (strcasecmp (trim ($results[2][$index]), EHT_PHOTOS_YES) == 0);

			$goodUrl = get_option ("siteurl");
			EHTPhotosQuitSlashes ($goodUrl, true);
			$goodPath = $_SERVER["DOCUMENT_ROOT"];
			EHTPhotosQuitSlashes ($goodPath, true);
											
			$urlImages = $goodUrl . EHT_PHOTOS_SLASH . 
						 $optionPathImages . EHT_PHOTOS_SLASH .
						 $tagImages . EHT_PHOTOS_SLASH;
			$pathImages = $goodPath . EHT_PHOTOS_SLASH . 
						  $optionPathImages . EHT_PHOTOS_SLASH .
						  $tagImages;
			$urlThumbs = $goodUrl . EHT_PHOTOS_SLASH . 
						 $optionPathThumbs . EHT_PHOTOS_SLASH .
						 $tagImages . EHT_PHOTOS_SLASH;
			$pathThumbs = $goodPath . EHT_PHOTOS_SLASH . 
						  $optionPathThumbs . EHT_PHOTOS_SLASH .
						  $tagImages . EHT_PHOTOS_SLASH;
						  
			$text = "\n";
			$text .= "<a name=\"" . EHT_PHOTOS_ANCHOR_GALLERY . "$index\"></a>\n";
			$text .= "<center><table border=\"0\" align=\"center\">\n";
			$text .= EHTPhotosPrint ($tagPath,
									 $urlImages,
									 $pathImages,
									 $urlThumbs,
									 $pathThumbs,
									 $optionThumb,
									 $optionNormal,
									 $optionWidth,
									 ($optionExif == EHT_PHOTOS_YES),
									 $index);
			$text .= "</table></center><br>\n";
               
			$content = str_replace ($results[0][$index], $text, $content);
		}
	}

	return ($content);
}

function EHTPhotosPrint ($printPath,
						 $urlImages,
						 $pathImages,
						 $urlThumbs,
						 $pathThumbs,
						 $optionThumb,
						 $optionNormal,
						 $optionWidth,
						 $optionExif,
						 $index)
{
	global $currentUrl;
	
	$text = "";
	
	$currentPath = EHTPhotosGetVar (EHT_PHOTOS_VAR_PATH . $index);
	$currentMode = EHTPhotosGetVar (EHT_PHOTOS_VAR_MODE . $index);
	$currentPhoto = EHTPhotosGetVar (EHT_PHOTOS_VAR_PHOTO . $index);
	
	$files = EHTPhotosListExtensions ($pathImages . $currentPath, $currentPath, split (",", EHT_PHOTOS_PHOTO_EXTENSIONS));
	
	if ($printPath)
	{
		$extraInfo = "";
		if ($currentMode != EHT_PHOTOS_VAR_MODE_NORMAL)
		{
			$countFolders = count ($files[0]);
			$countFiles = count ($files[1]);
			$extraInfo .= " ($countFolders folder" . (($countFolders == 1) ? "" : "s") . " and $countFiles file" . (($countFiles == 1) ? "" : "s") . ").";
		}
		$text .= EHTPhotosPrintPath ($currentPath, $index, $optionWidth, $extraInfo);
	}
	
	if ($currentMode == EHT_PHOTOS_VAR_MODE_NORMAL)
	{
		$fileCount = count ($files[1]);
		$imageIndex = -1;
		for ($i = 0; ($i < $fileCount) && ($imageIndex < 0); $i++)
		{
			if ($files[1][$i] == $currentPhoto)
			{
				$imageIndex = $i + 1;
				if ($i > 0)
				{
					$linkPrevious = $currentUrl .
									EHT_PHOTOS_VAR_PATH . "$index=" . urlencode ($currentPath) . "&" .
									EHT_PHOTOS_VAR_MODE . "$index=" . EHT_PHOTOS_VAR_MODE_NORMAL . "&" .
									EHT_PHOTOS_VAR_PHOTO . "$index=" . urlencode ($files[1][$i - 1]) .
									"#" . EHT_PHOTOS_ANCHOR_GALLERY . "$index";
				}
				if ($i < ($fileCount - 1))
				{
					$linkNext = $currentUrl .
								EHT_PHOTOS_VAR_PATH . "$index=" . urlencode ($currentPath) . "&" .
								EHT_PHOTOS_VAR_MODE . "$index=" . EHT_PHOTOS_VAR_MODE_NORMAL . "&" .
								EHT_PHOTOS_VAR_PHOTO . "$index=" . urlencode ($files[1][$i + 1]) .
								"#" . EHT_PHOTOS_ANCHOR_GALLERY . "$index";
				}
			}
		}
		if ($imageIndex >= 0)
		{
			$text .= EHTPhotosPrintNormal ($currentPhoto, $currentPath, $imageIndex, $fileCount, $urlImages, $pathImages, $urlThumbs, $pathThumbs, $linkPrevious, $linkNext, $optionNormal, $optionExif, $index);
		}
		$colspan = 3;
	}
	else
	{
		$text .= EHTPhotosPrintThumbs ($files, $currentPath, $urlImages, $pathImages, $urlThumbs, $pathThumbs, $optionThumb, $optionNormal, $optionWidth, $optionExif, $index);
		$colspan = $optionWidth;
	}
	$text .= "   <tr><td colspan=\"$colspan\"><center><small>" . EHT_PHOTOS_PLUGIN_DESCRIPTION . "</small></center></td></tr>\n";
	
	return ($text);
}

function EHTPhotosPrintPath ($path,
							 $index,
							 $optionWidth,
							 $extraInfo = "")
{
	global $currentUrl;
	
	$pieces = explode (EHT_PHOTOS_SLASH, $path);
	$tempPath = "";
	$text .= "<tr><td colspan=\"$optionWidth\" align=\"left\">\n";
	$text .= "<a href=\"$currentUrl" . EHT_PHOTOS_VAR_PATH . "$index=" . EHT_PHOTOS_SLASH . "\">ROOT</a>\n";
	foreach ($pieces as $piece)
	{
		if (strlen ($piece) > 0)
		{
			$tempPath .= $piece . EHT_PHOTOS_SLASH;
			$text .= "/<a href=\"$currentUrl" .
					 EHT_PHOTOS_VAR_PATH . "$index=" . urlencode ($tempPath) . 
					 "#" . EHT_PHOTOS_ANCHOR_GALLERY . "$index\">$piece</a>\n";
		}
	}
	$text .= "$extraInfo</td></tr>\n";
	
	return ($text);
}

function EHTPhotosListFiltered ($path,
								$currentPath,
								$filter = "*")
{
	global $goodPath, $user_ID, $wpdb;
	
	if (!$inAdmin)
	{
		$basePath = $goodPath . EHT_PHOTOS_SLASH . 
					get_option (EHT_PHOTOS_OPTION_PATH_IMAGES) . EHT_PHOTOS_SLASH;
		$basePath = substr ($basePath, strlen ($basePath)) .  $currentPath;
		$basePermissions = array ();
		EHTPhotosGetFullPermissions ($basePath, $basePermissions);

		$groups = array ();
		$sql = sprintf (EHT_PHOTOS_TABLE_USER_SELECT_GROUPS, $user_ID);
		$rows = $wpdb->get_results ($sql);
		foreach ($rows as $row)
		{
			$groups[$row->id] = $row->name;
		}
	}

	$folder = opendir ($path);
	$files = array ();
	$files[] = array ();
	$files[] = array ();
	while (false !== ($entry = readdir ($folder)))
	{
	    if (($entry != ".") && ($entry != ".."))
	    {
	    	$goOn = true;
	    	if (!$inAdmin)
	    	{
		    	$permissions = $basePermissions;
		    	EHTPhotosGetPermissions ($basePath . $entry, $permissions);
		    	if (count ($permissions) > 0)
		    	{
		    		$goOn = false;
		    		foreach ($groups as $group)
		    		{
		    			foreach ($permissions as $permission)
		    			{
		    				if ($group->id == $permission->id)
		    				{
		    					$goOn = true;
		    				}
		    			}
		    		}
		    	}
	    	}
	    	
	    	if ($goOn)
	    	{
				if (is_dir ($path . $entry))
				{
				    $files[0][] = $entry;
				}
				else if (($filter == "*") ||
					 (preg_match ("/" . $filter . "/i", $entry)))
				{
				    $files[1][] = $entry;
				}
	    	}
	    }
	}
	sort ($files[0]);
	sort ($files[1]);
	
	return ($files);
}

function EHTPhotosListExtensions ($path,
								  $currentPath,
								  $extensions)
{
    if (count ($extensions) <= 0)
	{
	    $filter = "*";
	}
	else
	{
		foreach ($extensions as $extension)
	    {
			$filter .= ((strlen ($filter) > 0) ? "|" : "");
			$filter .= "(.*\.$extension\Z)";
	    }
	}

	return (EHTPhotosListFiltered ($path, $currentPath, $filter));
}

function EHTPhotosPrintNormal ($name,
							   $currentPath,
							   $photoIndex,
							   $photoTotal,
							   $urlImages, 
							   $pathImages, 
							   $urlThumbs, 
							   $pathThumbs, 
							   $linkPrevious,
							   $linkNext,
							   $optionNormal,
							   $optionExif, 
							   $index)
{
	global $currentUrl;
	
	$text = "";
	
	$link = $urlImages . $currentPath . $name;
	$baseLink = "<a href=\"$currentUrl".
				EHT_PHOTOS_VAR_PATH . "$index=" . urlencode ($currentPath) .
				"#" . EHT_PHOTOS_ANCHOR_GALLERY . "$index\">[Thumbnails]</a>";
	$normal = EHTPhotosGetThumb ($urlImages . $currentPath,
								 $pathImages . $currentPath,
								 $urlThumbs . $currentPath,
								 $pathThumbs . $currentPath,
								 $name,
								 $optionNormal);

	$text .= "      <tr>\n" .
			 "         <td align=\"left\">\n";
	if ($linkPrevious != "")
	{
		$text .= "            <a href=\"$linkPrevious\">&lt;&lt;Previous</a>\n";
	}
	$text .= "         </td>\n" .
			 "         <td align=\"center\" width=\"100%\">\n" .
			 "            Photo $photoIndex of $photoTotal $baseLink\n" .
			 "         </td>\n" .
			 "         <td align=\"right\">\n";
	if ($linkNext != "")
	{
		$text .= "            <a href=\"$linkNext\">Next&gt;&gt;</a>\n";
	}
	$text .= "         </td>\n" .
			 "      </tr>\n" .
			 "      <tr>\n" .
			 "         <td align=\"center\" colspan=\"3\">\n" .
			 "            <a href=\"$link\" target=\"_blank\" border=\"0\"><img src=\"$normal\" border=\"0\"></a>\n" .
			 "         </td>\n" .
			 "      </tr>\n" .
			 "      <tr>\n" .
			 "         <td align=\"center\" colspan=\"3\">\n" .
			 "            <a href=\"$link\" target=\"_blank\">" . htmlentities ($name) . "</a>\n" .
			 "         </td>\n" .
			 "      </tr>\n";
	$fullPath = $pathImages . $currentPath . $name;
	$md5 = md5_file ($fullPath);
	$description = EHTPhotosGetDescription ($md5, false, $name, $fullPath);
	if ($description != "")
	{
		$text .= "      <tr>\n" .
				 "         <td align=\"center\" colspan=\"3\">\n" .
				 "            $description\n" .
				 "         </td>\n" .
				 "      </tr>\n";
	}
	if ($optionExif)
	{
		$imageFile = $pathImages . $currentPath . $name;
		if (exif_imagetype ($imageFile))
		{
			$exif = exif_read_data ($imageFile, 0, true);
			$info["Date"] = $exif["EXIF"]["DateTimeOriginal"];
			$info["Size"] = EHTPhotosGetFileSize ($exif["FILE"]["FileSize"]) . " bytes";
			$info["MIME type"] = $exif["FILE"]["MimeType"];
			$info["Width"] = $exif["COMPUTED"]["Width"];
			$info["Height"] = $exif["COMPUTED"]["Height"];
			$info["Manufacturer"] = $exif["IFD0"]["Make"];
			$info["Model"] = $exif["IFD0"]["Model"];
			$text .= "      <tr>\n" .
					 "         <td align=\"center\" colspan=\"3\">\n" .
					 "            <small><table border=\"0\"><tr><td colspan=\"2\" align=\"center\"><b>Original photo EXIF information:</b></td></tr>\n";
			foreach ($info as $name => $val)
			{
				$text .= "               <tr><td><i>$name:</i></td><td>$val</td></tr>\n";
			}
			$text .= "            </table></small>\n" .
					 "         </td>\n" .
					 "      </tr>\n";
		}
	}
	
	return ($text);
}

function EHTPhotosPrintThumbs ($files,
							   $currentPath,
							   $urlImages, 
							   $pathImages, 
							   $urlThumbs, 
							   $pathThumbs, 
							   $optionThumb, 
							   $optionNormal, 
							   $optionWidth, 
							   $optionExif, 
							   $index)
{
	global $inAdmin;
	global $wpdb;
	
	$text = "";

	$folderCount = count ($files[0]);
	$fileCount = count ($files[1]);
	$limit = $folderCount + $fileCount;
	$x = 0;
	$y = 0;
	$current = 0;

	if (($currentPath != EHT_PHOTOS_SLASH) && ($currentPath != ""))
	{
		$limit++;
	}
	$limit = ($limit <= $optionWidth) ? $optionWidth : ((floor (($limit - 1) / $optionWidth) + 1) * $optionWidth);
	if (($currentPath != EHT_PHOTOS_SLASH) && ($currentPath != ""))
	{
		$text .= EHTPhotosPrintThumb (EHT_PHOTOS_THUMB_FOLDER, "..", $optionThumb, $currentPath, $urlImages, $pathImages, $urlThumbs, $pathThumbs, $index, $x, $y, $optionWidth, $limit);
		EHTPhotosIncrement ($x, $y, $optionWidth);
		$current++;
	}
	
	if ($limit > 0)
	{
		$sql = sprintf (EHT_PHOTOS_TABLE_GROUP_SELECT_NAMES);
		$rows = $wpdb->get_results ($sql);
		$groups = array ();
		foreach ($rows as $row)
		{ 
			$groups[$row->id] = $row->name;
		}

		for ($i = 0;
			 $i < $folderCount;
			 $i++)
		{
			$text .= EHTPhotosPrintThumb (EHT_PHOTOS_THUMB_FOLDER, $files[0][$i], $optionThumb, $currentPath, $urlImages, $pathImages, $urlThumbs, $pathThumbs, $index, $x, $y, $optionWidth, $limit, $groups, $basePermissions);
			EHTPhotosIncrement ($x, $y, $optionWidth);
			$current++;
		}
		for ($i = 0;
			 $i < $fileCount;
			 $i++)
		{
			$text .= EHTPhotosPrintThumb (EHT_PHOTOS_THUMB_FILE, $files[1][$i], $optionThumb, $currentPath, $urlImages, $pathImages, $urlThumbs, $pathThumbs, $index, $x, $y, $optionWidth, $limit, $groups, $basePermissions);
			EHTPhotosIncrement ($x, $y, $optionWidth);
			$current++;
		}
		for ($i = $current;
			 $i < $limit;
			 $i++)
		{
			$text .= EHTPhotosPrintThumb (EHT_PHOTOS_THUMB_EMPTY, "", $optionThumb, $currentPath, $urlImages, $pathImages, $urlThumbs, $pathThumbs, $index, $x, $y, $optionWidth, $limit, $groups, $basePermissions);
			EHTPhotosIncrement ($x, $y, $optionWidth);
			$current++;
		}
	}

	return ($text);
}

function EHTPhotosPrintThumb ($type,
							  $name,
							  $thumbSize,
							  $currentPath,
							  $urlImages, 
							  $pathImages, 
							  $urlThumbs, 
							  $pathThumbs, 
							  $index, 
							  $x,
							  $y,
							  $width,
							  $limit,
							  $groups = "",
							  $basePermissions = "")
{
	global $currentUrl;
	global $inAdmin;
		
	$text = "";
	
	if ($name == "..")
	{
		$parentPath = EHTPhotosGetParent ($currentPath);
		$link = $currentUrl . 
				EHT_PHOTOS_VAR_PATH . "$index=" . urlencode ($parentPath) . 
				"#" . EHT_PHOTOS_ANCHOR_GALLERY . "$index";
	}
	else
	{
		if ($type == EHT_PHOTOS_THUMB_FILE)
		{
			$link = $currentUrl .
					EHT_PHOTOS_VAR_PATH . "$index=" . urlencode ($currentPath) . "&" .
					EHT_PHOTOS_VAR_MODE . "$index=" . EHT_PHOTOS_VAR_MODE_NORMAL . "&" .
					EHT_PHOTOS_VAR_PHOTO . "$index=" . urlencode ($name) . 
					"#" . EHT_PHOTOS_ANCHOR_GALLERY . "$index";
		}
		else if ($type == EHT_PHOTOS_THUMB_FOLDER)
		{
			$link = $currentUrl .
					EHT_PHOTOS_VAR_PATH . "$index=" . urlencode ($currentPath . $name . EHT_PHOTOS_SLASH) .
					"#" . EHT_PHOTOS_ANCHOR_GALLERY . "$index";
		}
	}

	if ($type == EHT_PHOTOS_THUMB_FILE)
	{
		$thumb = EHTPhotosGetThumb ($urlImages . $currentPath,
									$pathImages . $currentPath,
									$urlThumbs . $currentPath,
									$pathThumbs . $currentPath,
									$name,
									$thumbSize);
		$fullPath = $pathImages . $currentPath . $name;
		$md5 = md5_file ($fullPath);
		$description = EHTPhotosGetDescription ($md5, true, $name, $fullPath);
	}
	else if ($type == EHT_PHOTOS_THUMB_FOLDER)
	{
		$thumb = EHTPhotosGetThumb (EHT_PHOTOS_PLUGIN_URL_BASE_IMAGES,
									EHT_PHOTOS_PLUGIN_PATH_BASE_IMAGES,
									EHT_PHOTOS_PLUGIN_URL_BASE_IMAGES,
									EHT_PHOTOS_PLUGIN_PATH_BASE_IMAGES,
									EHT_PHOTOS_IMAGE_FOLDER,
									$thumbSize);
		$fullPath = $pathImages . $currentPath . $name;
	}
	else
	{
		$thumb = EHT_PHOTOS_PLUGIN_URL_BASE_IMAGES . 
				 EHT_PHOTOS_IMAGE_EMPTY;
	}

	if (($x % $width) == 0)
	{
		$text .= "   <tr valign=\"top\">\n";
	}

	$text .= "      <td align=\"center\" width=\"$thumbSize\">\n";
	if ($type == EHT_PHOTOS_THUMB_EMPTY)
	{
		$text .= "         <img src=\"$thumb\" border=\"0\" width=\"$thumbSize\" height=\"1\">\n";
	}
	else
	{
		$wrappedName = wordwrap ($name, EHT_PHOTOS_WORD_WRAP, " ", true);
		$text .= "         <span onClick=\"window.location = '$link';\" style=\"cursor: pointer;\"><img src=\"$thumb\" border=\"0\"></span>\n" .
				 "         <span onClick=\"window.location = '$link;\" style=\"cursor: pointer;\">" . htmlentities ($wrappedName) . "</span>\n";
		if ($description != "")
		{
			$text .= "<br>$description\n";
		}
		
		if ($inAdmin && ($name != "..") && ($groups != ""))
		{
			$href = $PHP_SELF . "?page=eht-photos-options&" . EHT_PHOTOS_FIELD_SUBPAGE . "=" . EHT_PHOTOS_SUBPAGE_GALLERY . "&" .
					EHT_PHOTOS_VAR_PATH . "$index=" . urlencode ($currentPath) .
					"#" . EHT_PHOTOS_ANCHOR_GALLERY . "$index";
			$imageMinusId = "image-minus-$x-$y";
			$imagePlusId = "image-plus-$x-$y";
			$permissionsId = "permissions-$x-$y";
			$path = $currentPath . $name;
			if ($path[0] != EHT_PHOTOS_SLASH)
			{
				$path = EHT_PHOTOS_SLASH . $path;
			}
			$text .= "<div onClick=\"" .
					 "if (document.getElementById ('$imageMinusId').width != 0) " .
					 "{" .
					 "   document.getElementById ('$imagePlusId').width = document.getElementById ('$imageMinusId').width;" .
					 "   document.getElementById ('$imageMinusId').width = 0;" .
					 "   document.getElementById ('$permissionsId').style.display = 'none';" .
					 "}" .
					 "else" .
					 "{" .
					 "   document.getElementById ('$imageMinusId').width = document.getElementById ('$imagePlusId').width;" .
					 "   document.getElementById ('$imagePlusId').width = 0;" .
					 "   document.getElementById ('$permissionsId').style.display = '';" .
					 "}" .
					 "\" style=\"cursor: pointer;\" align=\"left\">\n" .
					 "   <img id=\"$imageMinusId\" src=\"" . EHT_PHOTOS_PLUGIN_URL_BASE_IMAGES . EHT_PHOTOS_ICON_MINUS . "\">\n" . 
					 "   <img id=\"$imagePlusId\" src=\"" . EHT_PHOTOS_PLUGIN_URL_BASE_IMAGES . EHT_PHOTOS_ICON_PLUS . "\" width=\"0\">\n" .
					 "   <img src=\"" . EHT_PHOTOS_PLUGIN_URL_BASE_IMAGES . EHT_PHOTOS_ICON_PERMISSIONS . "\">\n" .
					 "   Permissions\n" . 
					 "</div>\n" .
					 "<div id=\"$permissionsId\" align=\"left\" style=\"display: ; border-style: solid; border-color: grey; border-width: 1px;\">\n" .
					 "   <form method=\"post\" action=\"$href\">\n" .
					 "      <input type=\"hidden\" name=\"" . EHT_PHOTOS_FIELD_PATH . "\" value=\"$path\">\n";
			$permissions = array ();
			EHTPhotosGetPermissions ($path, $permissions);
			foreach ($groups as $groupId => $groupName)
			{
				$checked = "";
				
				if (isset ($permissions[$groupId]))
				{
					$checked = " checked";
				}
				$text .= "      <input type=\"checkbox\" name=\"". EHT_PHOTOS_FIELD_GROUP . "$groupId\"$checked> $groupName<br>\n";
			}
			$text .= "      <input type=\"submit\" name=\"" . EHT_PHOTOS_FIELD_ACTION . "\" value=\"" . EHT_PHOTOS_ACTION_UPDATE . "\">\n" .
					 "   </form>\n" .
					 "</div>\n";
		}
	}
	$text .= "      </td>\n";

	if (($x % $width) == ($width - 1))
	{
		$text .= "   </tr>\n";
	}

	return ($text);
}

function EHTPhotosGetThumb ($urlImage,
							$pathImage,
							$urlThumb,
							$pathThumb,
							$name,
							$thumbSize)
{
	EHTPhotosExtractExtension ($name, $file, $extension);
	$imageName = $pathImage . $name;
	$thumbName = $pathThumb . $file . "_" . $thumbSize . "." . $extension;
	$thumbUrlName = $urlThumb . $file . "_" . $thumbSize . "." . $extension;
	if (file_exists ($imageName) && (!file_exists ($thumbName)))
	{
		EHTPhotosCreateFolder ($pathThumb);
		
		if ((strcasecmp ($extension, "jpg") == 0) ||
			(strcasecmp ($extension, "jpeg") == 0))
		{
			$image = imagecreatefromjpeg ($imageName);
		}
		else if (strcasecmp ($extension, "png") == 0)
		{
			$image = imagecreatefrompng ($imageName);
		}
		else if (strcasecmp ($extension, "gif") == 0)
		{
			$image = imagecreatefromgif ($imageName);
		}
		else
		{
			$image = false;
		}

		if ($image !== false)
		{
			$width = ImageSX ($image);
			$height = ImageSY ($image);
			$ratio= $width / $height;
			if ($ratio > 1)
			{
				$newWidth = $thumbSize;
				$newHeight = $thumbSize / $ratio;
			}
			else
			{
				$newWidth = $thumbSize * $ratio;
				$newHeight = $thumbSize;
			}
			$thumb = imagecreatetruecolor ($newWidth, $newHeight);
			imagecopyresampled ($thumb, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
			imagejpeg ($thumb, $thumbName);
			imagedestroy ($image);
			imagedestroy ($thumb);
		}
	}
	
	return ($thumbUrlName);
}

function EHTPhotosGetDescription ($md5,
								  $short,
								  $photo,
								  $fullPath)
{
	global $wpdb;

	$text = "";
	$ok = false;
	
	$id = 0;
	$views = 0;
	$name = $photo;

	$sql = sprintf (EHT_PHOTOS_TABLE_PHOTO_SELECT, $md5);
	$result = $wpdb->get_row ($sql);
	if ($result)
	{
		$ok = true;
		$id	= $result->id;
		$views = $result->views;
		$name = $result->name;

		if (($result->path == "") || ($result->path != $fullPath))
		{
			$sql = sprintf (EHT_PHOTOS_TABLE_PHOTO_UPDATE_PATH, $fullPath, $id);
			if (!($wpdb->query ($sql)))
			{
				$text .= "Fail to update the path: \"$sql\"<br>\n";
				$ok = false;
			}
		}
	}
	else
	{
		$sql = sprintf (EHT_PHOTOS_TABLE_PHOTO_INSERT, $md5, $photo, $path, $fullPath);
		if (!($wpdb->query ($sql)))
		{
			$text .= "Fail to insert: \"$sql\"<br>\n";
		}
		else
		{
			$ok = true;
		}
	}
	
	if ($ok && (!$short) && ($id != 0))
	{
		$views++;
		$sql = sprintf (EHT_PHOTOS_TABLE_PHOTO_UPDATE_VIEWS, $views, $id);
		if (!($wpdb->query ($sql)))
		{
			$text .= "Fail to update the views: \"$sql\"<br>\n";
			$ok = false;
		}
	}
	
	if (!$ok)
	{
		$text .= $photo;
	}
	else
	{
		if ($name != $photo)
		{
			$text .= "$name<br>\n";
		}
		$text .= "<small>($views views)</small>";
	}
	
	return ($text);
}

function EHTPhotosGetPermissions ($path, &$permissions)
{
	global $wpdb;
	
	if (is_array ($permissions))
	{
		$sql = sprintf (EHT_PHOTOS_TABLE_PERMISSION_SELECT_PATH, $path);
		$rows = $wpdb->get_results ($sql);
		foreach ($rows as $row)
		{
			$permissions[$row->groupId] = $row->groupName;
		}
	}
	
	return ($permissions);
}

function EHTPhotosGetFullPermissions ($path, &$permissions)
{
	if (is_array ($permissions))
	{
		$tempPath = "";
		$parts = split (EHT_PHOTOS_SLASH, $path);
		foreach ($parts as $part)
		{
			if ($part != "")
			{
				$tempPath .= EHT_PHOTOS_SLASH . $part;
				$tempPermissions = array ();
				EHTPhotosGetPermissions ($tempPath, $tempPermissions);
				foreach ($tempPermissions as $newId => $new)
				{
					$permissions[$newId] = $new;
				}
			}
		}
	}
	
	return ($permissions);
}

function EHTPhotosGetVar ($name)
{
	if (isset ($_GET[$name]))
	{
		$var = $_GET[$name];
	}
	else if (isset ($_POST[$name]))
	{
		$var = $_POST[$name];
	}
	else
	{
		$var = "";
	}
	
	return ($var);
}

function EHTPhotosIncrement (&$x,
							 &$y,
							 $width)
{
	if (((++$x) % $width) == 0)
	{
		$x = 0;
		$y++;
	}
}

function EHTPhotosGetParent ($path)
{
	$pathWithoutSlash = substr ($path, 0, strlen ($path) - 2);
	$position = strrpos ($pathWithoutSlash, EHT_PHOTOS_SLASH);
	if ($position !== false)
	{
	    $parent = substr ($path, 0, $position);
	}
	$parent .= EHT_PHOTOS_SLASH;
		
	return ($parent);
}

function EHTPhotosGetFileSize ($size)
{
	$number = $size;
	while ($number > 0)
	{
		$rest = $number % 1000;
		$number = floor ($number / 1000);
		if ($number == 0)
		{
			$text = $rest . $text;
		}
		else
		{
			$text = sprintf (".%03d", $rest) . $text;
		}
	}
	
	return ($text);
}

function EHTPhotosCreateFolder ($folder)
{
	$ok = false;
    $pieces = explode (EHT_PHOTOS_SLASH, $folder);
    if ((!file_exists ($folder)) && is_array ($pieces))
    {
    	$piecesCount = count ($pieces);
    	$tempPath = "";
    	for ($i = 0; $i < $piecesCount; $i++)
    	{
    		$tempPath .= $pieces[$i] . EHT_PHOTOS_SLASH;
    		if (!file_exists ($tempPath))
    		{
    			mkdir ($tempPath);
    		}
    	}
    	$ok = true;
    }
    
    return ($ok);
}

function EHTPhotosQuitSlashes (&$path,
							   $onlyEnd = false)
{
	$size = strlen ($path);
	if ($size > 0)
	{
		if ((!$onlyEnd) && ($path[0] == EHT_PHOTOS_SLASH))
		{
			$path = substr ($path, 1);
			$size--;
		}
		if ($path[$size - 1] == EHT_PHOTOS_SLASH)
		{
			$path = substr ($path, 0, ($size - 1));
		}
	}
	
	return ($path);
}

function EHTPhotosExtractExtension ($path,
									&$file,
									&$extension)
{
	if (($position = strrpos ($path, ".")) === false)
	{
		$file = $path;
		$extension = "";
	}
	else
	{
		$file = substr ($path, 0, $position);
		$extension = substr ($path, $position + 1);
	}
}

function EHTPhotosTextVertical ($text)
{
	$vertical = "";
	$length = strlen ($text);
	if ($length > 0)
	{
		$vertical .= $text[0];
		for ($i = 1; $i < $length; $i++)
		{
			$vertical .= "<br>" . $text[$i];
		}
	}
	
	return ($vertical);
}

function EHTPhotosCheckTable ($table)
{
	global $wpdb;

	$sql = sprintf (EHT_PHOTOS_TABLE_CHECK, $table);
	$result = $wpdb->get_var ($sql);
	
	return ($result == $table);
}

function EHTPhotosInstall (&$message)
{
	global $wpdb;
	$tables = array (EHT_PHOTOS_TABLE_PHOTO => EHT_PHOTOS_TABLE_PHOTO_CREATE,
					 EHT_PHOTOS_TABLE_COMMENT => EHT_PHOTOS_TABLE_COMMENT_CREATE,
					 EHT_PHOTOS_TABLE_GROUP => EHT_PHOTOS_TABLE_GROUP_CREATE,
					 EHT_PHOTOS_TABLE_USER => EHT_PHOTOS_TABLE_USER_CREATE,
					 EHT_PHOTOS_TABLE_PERMISSION => EHT_PHOTOS_TABLE_PERMISSION_CREATE);
	$values = array ();
	
	$ok = true;
	$message = "";
	foreach ($tables as $table => $query)
	{
		dbDelta ($query);
		
		if (!EHTPhotosCheckTable ($table))
		{
			if ($message != "")
			{
				$message .= "<br>\n";
			}
			$message .= "Fail to create the table \"$table\" with query \"$query\"";
			$ok = false;
		}
	}
	if ($ok)
	{
		foreach ($values as $table => $query)
		{
			$wpdb->query ($query);
		}
	}
	
	return ($ok);
}

function EHTPhotosUninstall (&$message)
{
	global $wpdb;
	$tables = array (EHT_PHOTOS_TABLE_PHOTO,
					 EHT_PHOTOS_TABLE_COMMENT,
					 EHT_PHOTOS_TABLE_GROUP,
					 EHT_PHOTOS_TABLE_USER,
					 EHT_PHOTOS_TABLE_PERMISSION);
	
	$ok = true;
	$message = "";
	foreach ($tables as $table)
	{
		if (!EHTPhotosCheckTable ($table))
		{
			if ($message != "")
			{
				$message .= "<br>\n";
			}
			$message .= "The table to drop \"$table\" doesn't exist";
			$ok = false;
		}
		else
		{
			$query = sprintf (EHT_PHOTOS_TABLE_DROP, $table);
			$wpdb->query ($query);
			if (EHTPhotosCheckTable ($table))
			{
				if ($message != "")
				{
					$message .= "<br>\n";
				}
				$message .= "Fail to drop the table \"$table\" with query \"$query\"";
				$ok = false;
			}
		}
	}
	
	return ($ok);
}

?>