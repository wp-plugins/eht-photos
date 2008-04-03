<?php

define ("EHT_PHOTOS_PLUGIN_NAME", "eht-photos");
define ("EHT_PHOTOS_PLUGIN_TITLE", "EHT Photos");
define ("EHT_PHOTOS_SESSION_DOMAIN", "eht-photos");
define ("EHT_PHOTOS_PLUGIN_URL_BASE", get_option ("siteurl") . "/wp-content/plugins/eht-photos/");
define ("EHT_PHOTOS_PLUGIN_URL_BASE_IMAGES", EHT_PHOTOS_PLUGIN_URL_BASE . "images/");
define ("EHT_PHOTOS_PLUGIN_PATH_BASE", $_SERVER["DOCUMENT_ROOT"] . "/wp-content/plugins/eht-photos/");
define ("EHT_PHOTOS_PLUGIN_PATH_BASE_IMAGES", EHT_PHOTOS_PLUGIN_PATH_BASE . "images/");
define ("EHT_PHOTOS_PLUGIN_VERSION", "1.7");
define ("EHT_PHOTOS_PLUGIN_DESCRIPTION", "Plugin <a href=\"http://ociotec.com/index.php/2008/01/10/eht-photos-plugin-para-wordpress/\" target=\"_blank\">" . EHT_PHOTOS_PLUGIN_TITLE . " v" . EHT_PHOTOS_PLUGIN_VERSION . "</a> - Created by <a href=\"http://ociotec.com\" target=\"_blank\">Emilio Gonz&aacute;lez Monta&ntilde;a</a>");
define ("EHT_PHOTOS_PLUGIN_SHORT_DESCRIPTION", "<a href=\"http://ociotec.com/index.php/2008/01/10/eht-photos-plugin-para-wordpress/\" target=\"_blank\">" . EHT_PHOTOS_PLUGIN_TITLE . " v" . EHT_PHOTOS_PLUGIN_VERSION . "</a> by <a href=\"http://ociotec.com\" target=\"_blank\">Emilio</a>");
define ("EHT_PHOTOS_OPTION_PATH_IMAGES", EHT_PHOTOS_PLUGIN_NAME . "-option-path-images");
define ("EHT_PHOTOS_OPTION_PATH_THUMBS", EHT_PHOTOS_PLUGIN_NAME . "-option-path-thumbs");
define ("EHT_PHOTOS_OPTION_THUMB", EHT_PHOTOS_PLUGIN_NAME . "-option-thumb");
define ("EHT_PHOTOS_OPTION_NORMAL", EHT_PHOTOS_PLUGIN_NAME . "-option-normal");
define ("EHT_PHOTOS_OPTION_WIDTH", EHT_PHOTOS_PLUGIN_NAME . "-option-width");
define ("EHT_PHOTOS_OPTION_EXIF", EHT_PHOTOS_PLUGIN_NAME . "-option-exif");
define ("EHT_PHOTOS_OPTION_USE_AJAX", EHT_PHOTOS_PLUGIN_NAME . "-option-use-ajax");
define ("EHT_PHOTOS_OPTION_RESULTS", EHT_PHOTOS_PLUGIN_NAME . "-option-results");
define ("EHT_PHOTOS_WIDGET_RANDOM_NAME", EHT_PHOTOS_PLUGIN_NAME . "-widget-random");
define ("EHT_PHOTOS_WIDGET_RANDOM_CAPTION", "Random Photos (" . EHT_PHOTOS_PLUGIN_TITLE . ")");
define ("EHT_PHOTOS_WIDGET_RANDOM_TITLE", EHT_PHOTOS_WIDGET_RANDOM_NAME . "-title");
define ("EHT_PHOTOS_WIDGET_RANDOM_TITLE_DEFAULT", "Random photos");
define ("EHT_PHOTOS_WIDGET_RANDOM_THUMB", EHT_PHOTOS_WIDGET_RANDOM_NAME . "-thumb");
define ("EHT_PHOTOS_WIDGET_RANDOM_THUMB_DEFAULT", get_option (EHT_PHOTOS_OPTION_THUMB));
define ("EHT_PHOTOS_WIDGET_RANDOM_COUNT", EHT_PHOTOS_WIDGET_RANDOM_NAME . "-count");
define ("EHT_PHOTOS_WIDGET_RANDOM_COUNT_DEFAULT", 3);
define ("EHT_PHOTOS_WIDGET_RANDOM_COLUMNS", EHT_PHOTOS_WIDGET_RANDOM_NAME . "-columns");
define ("EHT_PHOTOS_WIDGET_RANDOM_COLUMNS_DEFAULT", 1);
define ("EHT_PHOTOS_WIDGET_RANDOM_PAGE", EHT_PHOTOS_WIDGET_RANDOM_NAME . "-page");
define ("EHT_PHOTOS_WIDGET_RANDOM_SUBMIT", EHT_PHOTOS_WIDGET_RANDOM_NAME . "-submit");
define ("EHT_PHOTOS_WIDGET_RANDOM_MAX_ATTEMPTS", 5);
define ("EHT_PHOTOS_WIDGET_MOST_VIEWED_NAME", EHT_PHOTOS_PLUGIN_NAME . "-widget-most-viewed");
define ("EHT_PHOTOS_WIDGET_MOST_VIEWED_CAPTION", "Most Viewed Photos (" . EHT_PHOTOS_PLUGIN_TITLE . ")");
define ("EHT_PHOTOS_WIDGET_MOST_VIEWED_TITLE", EHT_PHOTOS_WIDGET_MOST_VIEWED_NAME . "-title");
define ("EHT_PHOTOS_WIDGET_MOST_VIEWED_TITLE_DEFAULT", "Most viewed photos");
define ("EHT_PHOTOS_WIDGET_MOST_VIEWED_THUMB", EHT_PHOTOS_WIDGET_MOST_VIEWED_NAME . "-thumb");
define ("EHT_PHOTOS_WIDGET_MOST_VIEWED_THUMB_DEFAULT", get_option (EHT_PHOTOS_OPTION_THUMB));
define ("EHT_PHOTOS_WIDGET_MOST_VIEWED_COUNT", EHT_PHOTOS_WIDGET_MOST_VIEWED_NAME . "-count");
define ("EHT_PHOTOS_WIDGET_MOST_VIEWED_COUNT_DEFAULT", 3);
define ("EHT_PHOTOS_WIDGET_MOST_VIEWED_COLUMNS", EHT_PHOTOS_WIDGET_MOST_VIEWED_NAME . "-columns");
define ("EHT_PHOTOS_WIDGET_MOST_VIEWED_COLUMNS_DEFAULT", 1);
define ("EHT_PHOTOS_WIDGET_MOST_VIEWED_PAGE", EHT_PHOTOS_WIDGET_MOST_VIEWED_NAME . "-page");
define ("EHT_PHOTOS_WIDGET_MOST_VIEWED_SUBMIT", EHT_PHOTOS_WIDGET_MOST_VIEWED_NAME . "-submit");
define ("EHT_PHOTOS_WIDGET_MOST_VIEWED_MAX_ATTEMPTS", 5);
define ("EHT_PHOTOS_FIELD_SUBPAGE", EHT_PHOTOS_PLUGIN_NAME . "-field-subpage");
define ("EHT_PHOTOS_SUBPAGE_GENERAL", "General options");
define ("EHT_PHOTOS_SUBPAGE_PHOTOS", "Photos");
define ("EHT_PHOTOS_SUBPAGE_GALLERY", "Gallery");
define ("EHT_PHOTOS_SUBPAGE_GROUPS", "Groups");
define ("EHT_PHOTOS_SUBPAGE_USERS", "Users");
define ("EHT_PHOTOS_FIELD_ACTION", EHT_PHOTOS_PLUGIN_NAME . "-field-action");
define ("EHT_PHOTOS_ACTION_INSTALL", "Install DB");
define ("EHT_PHOTOS_ACTION_UNINSTALL", "Uninstall DB");
define ("EHT_PHOTOS_ACTION_UPDATE", "Update");
define ("EHT_PHOTOS_ACTION_RESET", "Reset");
define ("EHT_PHOTOS_ACTION_RESET_PHOTOS", "Reset photos");
define ("EHT_PHOTOS_ACTION_CREATE", "Create");
define ("EHT_PHOTOS_ACTION_EDIT", "Edit");
define ("EHT_PHOTOS_FIELD_ORDER", EHT_PHOTOS_PLUGIN_NAME . "-field-order");
define ("EHT_PHOTOS_ORDER_ID", "id");
define ("EHT_PHOTOS_ORDER_MD5", "md5");
define ("EHT_PHOTOS_ORDER_NAME", "name");
define ("EHT_PHOTOS_ORDER_VIEWS", "views");
define ("EHT_PHOTOS_ORDER_PATH", "path");
define ("EHT_PHOTOS_FIELD_DIRECTION", EHT_PHOTOS_PLUGIN_NAME . "-field-direction");
define ("EHT_PHOTOS_FIELD_ID", EHT_PHOTOS_PLUGIN_NAME . "-field-id");
define ("EHT_PHOTOS_FIELD_OFFSET", EHT_PHOTOS_PLUGIN_NAME . "-field-offset");
define ("EHT_PHOTOS_FIELD_NAME", EHT_PHOTOS_PLUGIN_NAME . "-field-name");
define ("EHT_PHOTOS_FIELD_DESCRIPTION", EHT_PHOTOS_PLUGIN_NAME . "-field-description");
define ("EHT_PHOTOS_FIELD_USER", EHT_PHOTOS_PLUGIN_NAME . "-field-user-%d-%d");
define ("EHT_PHOTOS_FIELD_GROUP", EHT_PHOTOS_PLUGIN_NAME . "-field-group-");
define ("EHT_PHOTOS_FIELD_GROUP_ID", EHT_PHOTOS_PLUGIN_NAME . "-field-group-id");
define ("EHT_PHOTOS_FIELD_PATH", EHT_PHOTOS_PLUGIN_NAME . "-field-path");
define ("EHT_PHOTOS_FIELD_VALUE", EHT_PHOTOS_PLUGIN_NAME . "-field-value");
define ("EHT_PHOTOS_YES", "yes");
define ("EHT_PHOTOS_NO", "no");
define ("EHT_PHOTOS_DEFAULT_THUMB", 170);
define ("EHT_PHOTOS_DEFAULT_NORMAL", 700);
define ("EHT_PHOTOS_DEFAULT_WIDTH", 4);
define ("EHT_PHOTOS_DEFAULT_EXIF", EHT_PHOTOS_YES);
define ("EHT_PHOTOS_DEFAULT_USE_AJAX", EHT_PHOTOS_YES);
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
define ("EHT_PHOTOS_IMAGE_LOADING", "Loading.gif");
define ("EHT_PHOTOS_IMAGE_EMPTY", "Transparent.gif");
define ("EHT_PHOTOS_ICON_RESET", "IconReset.png");
define ("EHT_PHOTOS_ICON_PHOTO", "IconPhoto.png");
define ("EHT_PHOTOS_ICON_EDIT", "IconEdit.png");
define ("EHT_PHOTOS_ICON_DELETE", "IconDelete.png");
define ("EHT_PHOTOS_ICON_PERMISSIONS", "IconPermissions.png");
define ("EHT_PHOTOS_ICON_MINUS", "IconMinus.png");
define ("EHT_PHOTOS_ICON_PLUS", "IconPlus.png");
define ("EHT_PHOTOS_COLUMN_WRAP", 10);
define ("EHT_PHOTOS_JAVASCRIPT",
		"\n\n" .
		"<!-- JavaScript scripts needed by " . EHT_PHOTOS_PLUGIN_TITLE . " -->\n" .
		"<script src=\"" . EHT_PHOTOS_PLUGIN_URL_BASE . "XMLRequest.js\"></script>\n" .
		"<script src=\"" . EHT_PHOTOS_PLUGIN_URL_BASE . "Functions.js\"></script>\n" .
		"\n");
define ("EHT_PHOTOS_AJAX_THUMBNAIL_GENERATION", "AJAX.php?action=thumbnail&");
define ("EHT_PHOTOS_AJAX_PERMISSION_CHANGE", "AJAX.php?action=permission&");
define ("EHT_PHOTOS_TABLE_PHOTO", $wpdb->prefix . "eht_photos_photo");
define ("EHT_PHOTOS_TABLE_COMMENT", $wpdb->prefix . "eht_photos_comment");
define ("EHT_PHOTOS_TABLE_GROUP", $wpdb->prefix . "eht_photos_group");
define ("EHT_PHOTOS_TABLE_USER", $wpdb->prefix . "eht_photos_user");
define ("EHT_PHOTOS_TABLE_PERMISSION", $wpdb->prefix . "eht_photos_permission");
define ("EHT_PHOTOS_TABLE_CHECK", "SHOW TABLES LIKE \"%s\";");
define ("EHT_PHOTOS_TABLE_DROP", "DROP TABLE %s;");
define ("EHT_PHOTOS_TABLE_DELETE_ALL",
		"DELETE FROM %s;");
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
define ("EHT_PHOTOS_TABLE_PHOTO_SELECT_ALL_PAGINABLE",
		"SELECT * FROM " . EHT_PHOTOS_TABLE_PHOTO . " ORDER BY %s %s LIMIT %d, %d;");
define ("EHT_PHOTOS_TABLE_PHOTO_SELECT_ALL",
		"SELECT id, path, views FROM " . EHT_PHOTOS_TABLE_PHOTO . ";");
define ("EHT_PHOTOS_TABLE_PHOTO_SELECT_MOST_VIEWED",
		"SELECT id, path, views FROM " . EHT_PHOTOS_TABLE_PHOTO . " ORDER BY views DESC;");
define ("EHT_PHOTOS_TABLE_PHOTO_COUNT",
		"SELECT COUNT(id) AS count FROM " . EHT_PHOTOS_TABLE_PHOTO);
define ("EHT_PHOTOS_TABLE_PHOTO_INSERT",
		"INSERT INTO " . EHT_PHOTOS_TABLE_PHOTO . " (md5, name, views, path) VALUES (\"%s\", \"%s\", 0, \"%s\");");
define ("EHT_PHOTOS_TABLE_PHOTO_UPDATE_VIEWS",
		"UPDATE " . EHT_PHOTOS_TABLE_PHOTO . " SET views = %d WHERE id = %d;");
define ("EHT_PHOTOS_TABLE_PHOTO_UPDATE_PATH",
		"UPDATE " . EHT_PHOTOS_TABLE_PHOTO . " SET path = \"%s\" WHERE id = %d;");
define ("EHT_PHOTOS_TABLE_PHOTO_CLEAN_PATH",
		"UPDATE " . EHT_PHOTOS_TABLE_PHOTO . " SET path = REPLACE (path, \"//\", \"/\"");
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

function EHTPhotosGenerateThumb ($pathImage,
								 $urlThumb,
								 $pathThumb,
								 $name,
								 $thumbSize)
{
	EHTPhotosExtractExtension ($name, $file, $extension);
	$imageName = EHTPhotosConcatPaths ($pathImage, $name);
	$thumbName = EHTPhotosConcatPaths ($pathThumb, $file . "_" . $thumbSize . "." . $extension);
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
							   $onlyEnd = false,
							   $onlyBegin = false)
{
	$size = strlen ($path);
	if ($size > 0)
	{
		while ((!$onlyEnd) && ($size > 0) && ($path[0] == EHT_PHOTOS_SLASH))
		{
			$path = substr ($path, 1);
			$size--;
		}
		while ((!$onlyBegin) && ($size > 0) && ($path[$size - 1] == EHT_PHOTOS_SLASH))
		{
			$path = substr ($path, 0, ($size - 1));
			$size--;
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

function EHTPhotosExtractFile ($all,
							   &$path,
							   &$file)
{
	if (($position = strrpos ($all, "/")) === false)
	{
		$path = $all;
		$file = "";
	}
	else
	{
		$path = substr ($all, 0, $position);
		$file = substr ($all, $position + 1);
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

function EHTPhotosConcatPaths ($path1, $path2)
{
	$cleanedPath1 = $path1;
	EHTPhotosQuitSlashes ($cleanedPath1, true, false);
	$cleanedPath2 = $path2;
	EHTPhotosQuitSlashes ($cleanedPath2, false, true);

	$path = $cleanedPath1 . EHT_PHOTOS_SLASH . $cleanedPath2;

	return ($path);
}

?>