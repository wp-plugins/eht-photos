<?php
/*
Plugin Name:	EHT Photos
Plugin URI:		http://ociotec.com/index.php/2008/01/10/eht-photos-plugin-para-wordpress/
Description:	This plugin generates automatically photo galleries with thumbnails and easy recursive navigation links, the photos can be viewed in several sizes, with an easy configuration panel.
Author:			Emilio Gonz&aacute;lez Monta&ntilde;a
Version:		1.0
Author URI:		http://ociotec.com/

History:		0.1		First release.
				0.3		The thumbnails size, the normal size photos and the thumbnails width are configurables. Several upgrades into the presentation.
				0.4		Added options configuration panel.
				0.5		Added an option to show EXIF information of the photos in the detailed view.
				0.7		Renamed from "eht-mis-fotos" to "eht-photos". Added data base support using the photo MD5 as photo ID. The photos have a counter for viewing.
				0.7.1	Corrected an error creating thumbs folder (now create the thumb path when it's needed).
				0.8		Added subpages to options menu, so now there are these subpages: General Options (the previous option page), Photos (you can see all the photos information).
				1.0		Remove tag "thumbs" from plugin sintax, and added two options: "path to images" and "path to thumbs", so the "images" tag is relative to the two new options. Into the options menu subpage "Photos" now you can see the thumbnail into the photo list.

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

add_filter ("the_content", "EHTPhotosFilterTheContent");
add_action ("admin_menu", "EHTPhotosAdminAddPages");

define ("EHT_PHOTOS_SESSION_DOMAIN", "eht-photos");
define ("EHT_PHOTOS_PLUGIN_URL_BASE", get_option ("siteurl") . "/wp-content/plugins/eht-photos/");
define ("EHT_PHOTOS_PLUGIN_URL_BASE_IMAGES", EHT_PHOTOS_PLUGIN_URL_BASE . "images/");
define ("EHT_PHOTOS_PLUGIN_PATH_BASE", $_SERVER["DOCUMENT_ROOT"] . "/wp-content/plugins/eht-photos/");
define ("EHT_PHOTOS_PLUGIN_PATH_BASE_IMAGES", EHT_PHOTOS_PLUGIN_PATH_BASE . "images/");
define ("EHT_PHOTOS_PLUGIN_VERSION", "1.0");
define ("EHT_PHOTOS_PLUGIN_DESCRIPTION", "Plugin <a href=\"http://ociotec.com/index.php/2008/01/10/eht-photos-plugin-para-wordpress/\" target=\"_blank\">EHT Photos v" . EHT_PHOTOS_PLUGIN_VERSION . "</a> - Created by <a href=\"http://ociotec.com\" target=\"_blank\">Emilio Gonz&aacute;lez Monta&ntilde;a</a>");
define ("EHT_PHOTOS_PATH_IMAGES", "eht-photos-option-path-images");
define ("EHT_PHOTOS_PATH_THUMBS", "eht-photos-option-path-thumbs");
define ("EHT_PHOTOS_OPTION_THUMB", "eht-photos-option-thumb");
define ("EHT_PHOTOS_OPTION_NORMAL", "eht-photos-option-normal");
define ("EHT_PHOTOS_OPTION_WIDTH", "eht-photos-option-width");
define ("EHT_PHOTOS_OPTION_EXIF", "eht-photos-option-exif");
define ("EHT_PHOTOS_OPTION_TABLE_RESULTS", "eht-photos-option-table-results");
define ("EHT_PHOTOS_FIELD_SUBPAGE", "eht-photos-field-subpage");
define ("EHT_PHOTOS_SUBPAGE_GENERAL", "General options");
define ("EHT_PHOTOS_SUBPAGE_PHOTOS", "Photos");
define ("EHT_PHOTOS_FIELD_ACTION", "eht-photos-field-action");
define ("EHT_PHOTOS_ACTION_INSTALL", "Install DB");
define ("EHT_PHOTOS_ACTION_UNINSTALL", "Uninstall DB");
define ("EHT_PHOTOS_ACTION_UPDATE", "Update");
define ("EHT_PHOTOS_ACTION_RESET", "Reset");
define ("EHT_PHOTOS_FIELD_ORDER", "eht-photos-field-order");
define ("EHT_PHOTOS_ORDER_ID", "id");
define ("EHT_PHOTOS_ORDER_MD5", "md5");
define ("EHT_PHOTOS_ORDER_NAME", "name");
define ("EHT_PHOTOS_ORDER_VIEWS", "views");
define ("EHT_PHOTOS_ORDER_PATH", "path");
define ("EHT_PHOTOS_FIELD_DIRECTION", "eht-photos-field-direction");
define ("EHT_PHOTOS_FIELD_ID", "eht-photos-field-id");
define ("EHT_PHOTOS_FIELD_OFFSET", "eht-photos-field-offset");
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
define ("EHT_PHOTOS_TABLE_PHOTO", $wpdb->prefix . "eht_photos_photo");
define ("EHT_PHOTOS_TABLE_COMMENT", $wpdb->prefix . "eht_photos_comment");
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
		  photo INT NOT NULL,
		  name VARCHAR (50) NOT NULL,
		  email VARCHAR (50) NOT NULL,
		  web VARCHAR (50) NOT NULL,
		  comment VARCHAR (200) NOT NULL,
		  PRIMARY KEY (id)
		);");

function EHTPhotosFilterTheContent ($content)
{
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
						  $tagImages . EHT_PHOTOS_SLASH;
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
			$text .= "   <tr><td colspan=\"$optionWidth\"><center><small>" . EHT_PHOTOS_PLUGIN_DESCRIPTION . "</small></center></td></tr>\n";
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
	$text = "";
	
	$currentPath = EHTPhotosGetVar (EHT_PHOTOS_VAR_PATH . $index);
	$currentMode = EHTPhotosGetVar (EHT_PHOTOS_VAR_MODE . $index);
	$currentPhoto = EHTPhotosGetVar (EHT_PHOTOS_VAR_PHOTO . $index);
	
	if ($printPath)
	{
		$text .= EHTPhotosPrintPath ($currentPath, $index, $optionWidth);
	}
	
	$files = EHTPhotosListExtensions ($pathImages . $currentPath, split (",", EHT_PHOTOS_PHOTO_EXTENSIONS));
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
					$linkPrevious = $PHP_SELF . "?" .
									EHT_PHOTOS_VAR_PATH . "$index=" . urlencode ($currentPath) . "&" .
									EHT_PHOTOS_VAR_MODE . "$index=" . EHT_PHOTOS_VAR_MODE_NORMAL . "&" .
									EHT_PHOTOS_VAR_PHOTO . "$index=" . urlencode ($files[1][$i - 1]) .
									"#" . EHT_PHOTOS_ANCHOR_GALLERY . "$index";
				}
				if ($i < ($fileCount - 1))
				{
					$linkNext = $PHP_SELF . "?" .
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
	}
	else
	{
		$text .= EHTPhotosPrintThumbs ($files, $currentPath, $urlImages, $pathImages, $urlThumbs, $pathThumbs, $optionThumb, $optionNormal, $optionWidth, $optionExif, $index);
	}
		
	return ($text);
}

function EHTPhotosPrintPath ($path,
							 $index,
							 $optionWidth)
{
	$pieces = explode (EHT_PHOTOS_SLASH, $path);
	$tempPath = "";
	$text .= "<tr><td colspan=\"$optionWidth\" align=\"left\">\n";
	$text .= "<a href=\"$PHP_SELF?" . EHT_PHOTOS_VAR_PATH . "$index=" . EHT_PHOTOS_SLASH . "\">ROOT</a>\n";
	foreach ($pieces as $piece)
	{
		if (strlen ($piece) > 0)
		{
			$tempPath .= $piece . EHT_PHOTOS_SLASH;
			$text .= "/<a href=\"$PHP_SELF?" .
					 EHT_PHOTOS_VAR_PATH . "$index=" . urlencode ($tempPath) . 
					 "#" . EHT_PHOTOS_ANCHOR_GALLERY . "$index\">$piece</a>\n";
		}
	}
	$text .= "</td></tr>\n";
	
	return ($text);
}

function EHTPhotosListFiltered ($path,
								$filter = "*")
{
	$folder = opendir ($path);
	$files = array ();
	$files[] = array ();
	$files[] = array ();
	while (false !== ($entry = readdir ($folder)))
	{
	    if (($entry != ".") && ($entry != ".."))
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
	sort ($files[0]);
	sort ($files[1]);
	
	return ($files);
}

function EHTPhotosListExtensions ($path,
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

	return (EHTPhotosListFiltered ($path, $filter));
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
	$text = "";
	
	$link = $urlImages . $currentPath . $name;
	$baseLink = "<a href=\"$PHP_SELF?".
				EHT_PHOTOS_VAR_PATH . "$index=" . urlencode ($currentPath) .
				"#" . EHT_PHOTOS_ANCHOR_GALLERY . "$index\">[Thumbnails]</a>";
	$normal = EHTPhotosGetThumb ($urlImages . $currentPath,
								 $pathImages . $currentPath,
								 $urlThumbs . $currentPath,
								 $pathThumbs . $currentPath,
								 $name,
								 $optionNormal);

	$text .= "      <tr>\n";
	$text .= "         <td align=\"left\">\n";
	if ($linkPrevious != "")
	{
		$text .= "            <a href=\"$linkPrevious\">&lt;&lt;Previous</a>\n";
	}
	else
	{
		$text .= "            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>\n";
	}
	$text .= "         </td>\n";
	$text .= "         <td align=\"center\" width=\"100%\">\n";
	$text .= "            Photo $photoIndex of $photoTotal $baseLink\n";
	$text .= "         </td>\n";
	$text .= "         <td align=\"right\">\n";
	if ($linkNext != "")
	{
		$text .= "            <a href=\"$linkNext\">Next&gt;&gt;</a>\n";
	}
	else
	{
		$text .= "            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>\n";
	}
	$text .= "         </td>\n";
	$text .= "      </tr>\n";
	$text .= "      <tr>\n";
	$text .= "         <td align=\"center\" colspan=\"3\">\n";
	$text .= "            <a href=\"$link\" target=\"_blank\" border=\"0\"><img src=\"$normal\" border=\"0\"></a>\n";
	$text .= "            <p>\n";
	$text .= "               <a href=\"$link\" target=\"_blank\">" . htmlentities ($name) . "</a><br>\n";
	$fullPath = $pathImages . $currentPath . $name;
	$md5 = md5_file ($fullPath);
	$description = EHTPhotosGetDescription ($md5, false, $name, $fullPath);
	if ($description != "")
	{
		$text .= "               $description\n";
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
			$text .= "               <br>\n";
			$text .= "               <small><table><tr><td colspan=\"2\" align=\"center\"><b>Original photo EXIF information:</b></td></tr>\n";
			foreach ($info as $name => $val)
			{
				$text .= "                  <tr><td><i>$name:</i></td><td>$val</td></tr>\n";
			}
			$text .= "               </table></small>\n";
		}
	}
	$text .= "            </p>\n";

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
		for ($i = 0;
			 $i < $folderCount;
			 $i++)
		{
			$text .= EHTPhotosPrintThumb (EHT_PHOTOS_THUMB_FOLDER, $files[0][$i], $optionThumb, $currentPath, $urlImages, $pathImages, $urlThumbs, $pathThumbs, $index, $x, $y, $optionWidth, $limit);
			EHTPhotosIncrement ($x, $y, $optionWidth);
			$current++;
		}
		for ($i = 0;
			 $i < $fileCount;
			 $i++)
		{
			$text .= EHTPhotosPrintThumb (EHT_PHOTOS_THUMB_FILE, $files[1][$i], $optionThumb, $currentPath, $urlImages, $pathImages, $urlThumbs, $pathThumbs, $index, $x, $y, $optionWidth, $limit);
			EHTPhotosIncrement ($x, $y, $optionWidth);
			$current++;
		}
		for ($i = $current;
			 $i < $limit;
			 $i++)
		{
			$text .= EHTPhotosPrintThumb (EHT_PHOTOS_THUMB_EMPTY, "", $optionThumb, $currentPath, $urlImages, $pathImages, $urlThumbs, $pathThumbs, $index, $x, $y, $optionWidth, $limit);
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
							  $limit)
{
	$text = "";
	
	if ($name == "..")
	{
		$parentPath = EHTPhotosGetParent ($currentPath);
		$link = $PHP_SELF . "?" . 
				EHT_PHOTOS_VAR_PATH . "=" . urlencode ($parentPath) . 
				"#" . EHT_PHOTOS_ANCHOR_GALLERY . "$index";
	}
	else
	{
		if ($type == EHT_PHOTOS_THUMB_FILE)
		{
			$link = $PHP_SELF . "?" .
					EHT_PHOTOS_VAR_PATH . "$index=" . urlencode ($currentPath) . "&" .
					EHT_PHOTOS_VAR_MODE . "$index=" . EHT_PHOTOS_VAR_MODE_NORMAL . "&" .
					EHT_PHOTOS_VAR_PHOTO . "$index=" . urlencode ($name) . 
					"#" . EHT_PHOTOS_ANCHOR_GALLERY . "$index";
		}
		else if ($type == EHT_PHOTOS_THUMB_FOLDER)
		{
			$link = $PHP_SELF . "?" .
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
		$text .= "         <a href=\"$link\" border=\"0\"><img src=\"$thumb\" border=\"0\"></a>\n";
		$text .= "         <p>\n";
		$text .= "            <a href=\"$link\" border=\"0\">" . htmlentities ($wrappedName) . "</a>\n";
		if ($description != "")
		{
			$text .= "<br>$description\n";
		}
		$text .= "         </p>\n";
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

		if ($result->path == "")
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
	if ($position === false)
	{
	    $parent = EHT_PHOTOS_SLASH;
	}
	else
	{
	    $parent = substr ($path, 0, $position);
	}
	
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

function EHTPhotosAdminAddPages ()
{
	if (function_exists ("add_options_page"))
	{
		add_options_page ('EHT Photos', 'EHT Photos', 8, 'eht-photos-options', 'EHTPhotosAdminOptions');
		if (function_exists ("add_submenu_page"))
		{
			add_submenu_page('options-general.php', $page_title, $menu_title, $access_level, $file, $function);
		}
	}
}

function EHTPhotosAdminOptions ()
{
	global $wpdb;
	
	$href = $PHP_SELF . "?page=eht-photos-options&" . EHT_PHOTOS_FIELD_SUBPAGE . "=";
	echo "<div class=\"wrap\">\n" .
		 "<h2>EHT Photos</h2>\n" .
		 "<div id=\"menu\">\n" .
		 "<a href=\"$href" . EHT_PHOTOS_SUBPAGE_GENERAL . "\">" . EHT_PHOTOS_SUBPAGE_GENERAL . "</a> &middot;\n" .
		 "<a href=\"$href" . EHT_PHOTOS_SUBPAGE_PHOTOS . "\">" . EHT_PHOTOS_SUBPAGE_PHOTOS . "</a>\n" .
		 "</div>\n" .
		 "<br>\n";
	$page = $_REQUEST[EHT_PHOTOS_FIELD_SUBPAGE];
	switch ($page)
	{
		case EHT_PHOTOS_SUBPAGE_GENERAL:
		default:
			$action = $_REQUEST[EHT_PHOTOS_FIELD_ACTION];
			if ($action == EHT_PHOTOS_ACTION_UPDATE)
			{
				$optionPathImages = $_REQUEST[EHT_PHOTOS_OPTION_PATH_IMAGES];
				EHTPhotosQuitSlashes ($optionPathImages);
				
				$optionPathThumbs = $_REQUEST[EHT_PHOTOS_OPTION_PATH_THUMBS];
				EHTPhotosQuitSlashes ($optionPathThumbs);
								
				$optionThumb = $_REQUEST[EHT_PHOTOS_OPTION_THUMB];
				if ($optionThumb < EHT_PHOTOS_MIN_THUMB)
				{
					echo "<div class=\"error\">The thumbnail size $optionThumb is fewer than the minimum " . EHT_PHOTOS_MIN_THUMB . ", the minimum will be used.</div>\n";
					$optionThumb = EHT_PHOTOS_MIN_THUMB;
				}
				else if ($optionThumb > EHT_PHOTOS_MAX_THUMB)
				{
					echo "<div class=\"error\">The thumbnail size $optionThumb is greater than the maximum " . EHT_PHOTOS_MAX_THUMB . ", the maximum will be used.</div>\n";
					$optionThumb = EHT_PHOTOS_MAX_THUMB;
				}
		
				$optionNormal = $_REQUEST[EHT_PHOTOS_OPTION_NORMAL];
				if ($optionNormal < EHT_PHOTOS_MIN_NORMAL)
				{
					echo "<div class=\"error\">The normal photo size $optionNormal is fewer than the minimum " . EHT_PHOTOS_MIN_NORMAL . ", the minimum will be used.</div>\n";
					$optionNormal = EHT_PHOTOS_MIN_NORMAL;
				}
				else if ($optionNormal > EHT_PHOTOS_MAX_NORMAL)
				{
					echo "<div class=\"error\">The normal photo size $optionNormal is greater than the maximum " . EHT_PHOTOS_MAX_NORMAL . ", the maximum will be used.</div>\n";
					$optionNormal = EHT_PHOTOS_MAX_NORMAL;
				}
		
				$optionWidth = $_REQUEST[EHT_PHOTOS_OPTION_WIDTH];
				if ($optionWidth < EHT_PHOTOS_MIN_WIDTH)
				{
					echo "<div class=\"error\">The count of photos in horizontal $optionWidth in thumbnail view is fewer than the minimum " . EHT_PHOTOS_MIN_WIDTH . ", the minimum will be used.</div>\n";
					$optionWidth = EHT_PHOTOS_MIN_WIDTH;
				}
				else if ($optionWidth > EHT_PHOTOS_MAX_WIDTH)
				{
					echo "<div class=\"error\">The count of photos in horizontal $optionWidth in thumbnail view is greater than the maximum " . EHT_PHOTOS_MAX_WIDTH . ", the maximum will be used.</div>\n";
					$optionWidth = EHT_PHOTOS_MAX_WIDTH;
				}
		
				$optionExif = $_REQUEST[EHT_PHOTOS_OPTION_EXIF];

				$optionResults = $_REQUEST[EHT_PHOTOS_OPTION_RESULTS];
				if ($optionResults < EHT_PHOTOS_MIN_RESULTS)
				{
					echo "<div class=\"error\">The results per page $optionResults is fewer than the minimum " . EHT_PHOTOS_MIN_RESULTS . ", the minimum will be used.</div>\n";
					$optionResults = EHT_PHOTOS_MIN_RESULTS;
				}
				else if ($optionResults > EHT_PHOTOS_MAX_RESULTS)
				{
					echo "<div class=\"error\">The results per page $optionResults is greater than the maximum " . EHT_PHOTOS_MAX_RESULTS . ", the maximum will be used.</div>\n";
					$optionResults = EHT_PHOTOS_MAX_RESULTS;
				}
			}
			else
			{
				$optionPathImages = get_option (EHT_PHOTOS_OPTION_PATH_IMAGES);
				$optionPathThumbs = get_option (EHT_PHOTOS_OPTION_PATH_THUMBS);
				$optionThumb = get_option (EHT_PHOTOS_OPTION_THUMB);
				$optionNormal = get_option (EHT_PHOTOS_OPTION_NORMAL);
				$optionWidth = get_option (EHT_PHOTOS_OPTION_WIDTH);
				$optionExif = get_option (EHT_PHOTOS_OPTION_EXIF);
				$optionResults = get_option (EHT_PHOTOS_OPTION_RESULTS);
			}
		
			$firstUse = (($optionPathImages == "") && 
						 ($optionPathThumbs == "") &&
						 ($optionThumb == "") && 
						 ($optionNormal == "") &&
						 ($optionWidth == "") &&
						 ($optionExif == "") &&
						 ($optionResults == ""));
			
			if ($optionThumb == "")
			{
				$optionThumb = EHT_PHOTOS_DEFAULT_THUMB;
				$action = EHT_PHOTOS_ACTION_UPDATE;
			}
			if ($optionNormal == "")
			{
				$optionNormal = EHT_PHOTOS_DEFAULT_NORMAL;
				$action = EHT_PHOTOS_ACTION_UPDATE;
			}
			if ($optionWidth == "")
			{
				$optionWidth = EHT_PHOTOS_DEFAULT_WIDTH;
				$action = EHT_PHOTOS_ACTION_UPDATE;
			}
			if ($optionExif == "")
			{
				$optionExif = $firstUse ? EHT_PHOTOS_DEFAULT_EXIF : EHT_PHOTOS_NO;
				$action = $firstUse ? EHT_PHOTOS_ACTION_UPDATE : $action;
			}
			if ($optionResults == "")
			{
				$optionResults = EHT_PHOTOS_DEFAULT_RESULTS;
				$action = EHT_PHOTOS_ACTION_UPDATE;
			}
			
			if ($action == EHT_PHOTOS_ACTION_UPDATE)
			{
		        update_option (EHT_PHOTOS_OPTION_PATH_IMAGES, $optionPathImages);
		        update_option (EHT_PHOTOS_OPTION_PATH_THUMBS, $optionPathThumbs);
				update_option (EHT_PHOTOS_OPTION_THUMB, $optionThumb);
		        update_option (EHT_PHOTOS_OPTION_NORMAL, $optionNormal);
		        update_option (EHT_PHOTOS_OPTION_WIDTH, $optionWidth);
		        update_option (EHT_PHOTOS_OPTION_EXIF, $optionExif);
		        update_option (EHT_PHOTOS_OPTION_RESULTS, $optionResults);
		        echo "<div class=\"updated\">The options have been updated.</div>\n";
			}
			else if ($action == EHT_PHOTOS_ACTION_INSTALL)
			{
				if (!EHTPhotosInstall ($message))
				{
		        	echo "<div class=\"error\">Fail to intall the DB: $message.</div>\n";
				}
				else
				{
		        	echo "<div class=\"updated\">The plugin data base has been installed.</div>\n";
				}
			}
			else if ($action == EHT_PHOTOS_ACTION_UNINSTALL)
			{
				if (!EHTPhotosUninstall ($message))
				{
		        	echo "<div class=\"error\">Fail to unintall the DB: $message.</div>\n";
				}
				else
				{
		        	echo "<div class=\"updated\">The plugin data base has been uninstalled.</div>\n";
				}
			}
		
			echo "<blockquote>\n";
			$tables = array (EHT_PHOTOS_TABLE_PHOTO,
							 EHT_PHOTOS_TABLE_COMMENT);
			foreach ($tables as $table)
			{
				echo "The table \"$table\" is " . (EHTPhotosCheckTable ($table) ? "" : "NOT ") . "installed.<br>\n"; 
			}
			echo "</blockquote>\n";
			echo "<form method=\"post\" action=\"" . str_replace( '%7E', '~', $_SERVER['REQUEST_URI']) . "\">\n";
			echo "<input type=\"hidden\" name=\"" . EHT_PHOTOS_FIELD_ACTION . "\" value=\"" . EHT_PHOTOS_ACTION_UPDATE . "\">\n";
			echo "<p>Relative path (from web root) to images:<br>\n";
			echo "<input type=\"text\" name=\"" . EHT_PHOTOS_OPTION_PATH_IMAGES . "\" value=\"$optionPathImages\"></p>\n";
			echo "<p>Relative path (from web root) to thumbnails:<br>\n";
			echo "<input type=\"text\" name=\"" . EHT_PHOTOS_OPTION_PATH_THUMBS . "\" value=\"$optionPathThumbs\"></p>\n";
			echo "<p>Thumbnail size (in pixels) [" . EHT_PHOTOS_MIN_THUMB . ", " . EHT_PHOTOS_MAX_THUMB . "]:<br>\n";
			echo "<input type=\"text\" name=\"" . EHT_PHOTOS_OPTION_THUMB . "\" value=\"$optionThumb\"></p>\n";
			echo "<p>Normal photo size (in pixels) [" . EHT_PHOTOS_MIN_NORMAL . ", " . EHT_PHOTOS_MAX_NORMAL . "]:<br>\n";
			echo "<input type=\"text\" name=\"" . EHT_PHOTOS_OPTION_NORMAL . "\" value=\"$optionNormal\"></p>\n";
			echo "<p>Count of photos in horizontal in thumbnail view [" . EHT_PHOTOS_MIN_WIDTH . ", " . EHT_PHOTOS_MAX_WIDTH . "]:<br>\n";
			echo "<input type=\"text\" name=\"" . EHT_PHOTOS_OPTION_WIDTH . "\" value=\"$optionWidth\"></p>\n";
			echo "<p>\n";
			echo "<input type=\"checkbox\" name=\"" . EHT_PHOTOS_OPTION_EXIF . "\" value=\"" . EHT_PHOTOS_YES . "\"";
			if ($optionExif == EHT_PHOTOS_YES)
			{
				echo " checked";
			}
			echo "> Show EXIF information in detailed photo view (normal size).\n";
			echo "</p>\n";
			echo "<p>Results per page into options menus [" . EHT_PHOTOS_MIN_RESULTS . ", " . EHT_PHOTOS_MAX_RESULTS . "]:<br>\n";
			echo "<input type=\"text\" name=\"" . EHT_PHOTOS_OPTION_RESULTS . "\" value=\"$optionResults\"></p>\n";
			echo "<p>\n";
			echo "<p class=\"submit\">\n";
			echo "<input type=\"submit\" name=\"" . EHT_PHOTOS_FIELD_ACTION . "\" value=\"" . EHT_PHOTOS_ACTION_INSTALL . "\" onclick=\"return confirm ('Do you really want to install the data base?');\">\n";
			echo "<input type=\"submit\" name=\"" . EHT_PHOTOS_FIELD_ACTION . "\" value=\"" . EHT_PHOTOS_ACTION_UNINSTALL . "\" onclick=\"return confirm ('Do you really want to uninstall the data base?');\">\n";
			echo "<input type=\"submit\" name=\"" . EHT_PHOTOS_FIELD_ACTION . "\" value=\"" . EHT_PHOTOS_ACTION_UPDATE . "\" default>\n";
			echo "</p>\n";
			echo "</form>\n";
			break;

		case EHT_PHOTOS_SUBPAGE_PHOTOS:
			$action = $_REQUEST[EHT_PHOTOS_FIELD_ACTION];
			switch ($action)
			{
				case EHT_PHOTOS_ACTION_RESET:
					$id = $_REQUEST[EHT_PHOTOS_FIELD_ID];
					if ($id)
					{
						$sql = sprintf (EHT_PHOTOS_TABLE_PHOTO_UPDATE_VIEWS, 0, $id);
						if (!($wpdb->query ($sql)))
						{
							echo "<div class=\"error\">Fail to update: \"$sql\"</div>\n";
							$ok = false;
						}
					}
					break;
			}
			
			$order = $_REQUEST[EHT_PHOTOS_FIELD_ORDER];
			$order = (($order == "") ? EHT_PHOTOS_ORDER_ID : $order);
			$direction = $_REQUEST[EHT_PHOTOS_FIELD_DIRECTION];
			$direction = (($direction == "") ? "ASC" : $direction);
			$directionId = (($order != EHT_PHOTOS_ORDER_ID) ? "ASC" : (($direction == "ASC") ? "DESC" : "ASC"));
			$directionName = (($order != EHT_PHOTOS_ORDER_NAME) ? "ASC" : (($direction == "ASC") ? "DESC" : "ASC"));
			$directionViews = (($order != EHT_PHOTOS_ORDER_VIEWS) ? "ASC" : (($direction == "ASC") ? "DESC" : "ASC"));
			$directionMd5 = (($order != EHT_PHOTOS_ORDER_MD5) ? "ASC" : (($direction == "ASC") ? "DESC" : "ASC"));
			$directionPath = (($order != EHT_PHOTOS_ORDER_PATH) ? "ASC" : (($direction == "ASC") ? "DESC" : "ASC"));
			
			$sql = sprintf (EHT_PHOTOS_TABLE_PHOTO_COUNT);
			$row = $wpdb->get_row ($sql);
			$rowCount = $row->count;
			$offset = $_REQUEST[EHT_PHOTOS_FIELD_OFFSET];
			$offset = (($offset == "") ? 0 : $offset);
			$size = get_option (EHT_PHOTOS_OPTION_RESULTS);
			if ($size == "")
			{
				$size = EHT_PHOTOS_DEFAULT_RESULTS;
			}
			
			$href .= EHT_PHOTOS_SUBPAGE_PHOTOS . "&";
			$path = $_SERVER["DOCUMENT_ROOT"];
			$optionImages = get_option (EHT_PHOTOS_OPTION_PATH_IMAGES);
			$basePath = EHTPhotosQuitSlashes ($path, true) . EHT_PHOTOS_SLASH . EHTPhotosQuitSlashes ($optionImages);
			$url = get_option ("siteurl");
			$optionThumbs = get_option (EHT_PHOTOS_OPTION_PATH_THUMBS);
			$baseUrl = EHTPhotosQuitSlashes ($url, true) . EHT_PHOTOS_SLASH . EHTPhotosQuitSlashes ($optionThumbs);
			
			$sql = sprintf (EHT_PHOTOS_TABLE_PHOTO_SELECT_ALL, $order, $direction, $offset, $size);
			$rows = $wpdb->get_results ($sql);
			echo "<table>\n" .
				 "   <tr>\n" .
				 "      <th>Photo count</th>\n" .
				 "      <th>Results per page</th>\n" .
				 "      <th>Page to show</th>\n" .
				 "   </tr>\n" .
				 "   <tr class=\"alternate\">\n" .
				 "      <td>$rowCount</td>\n" .
				 "      <td>$size</td>\n" .
				 "      <td>\n" .
				 "         <form action=\"none\">\n" .
				 "            <select onchange=\"window.location = '$href" . EHT_PHOTOS_FIELD_ORDER . "=$order&" . EHT_PHOTOS_FIELD_DIRECTION . "=$direction&" . EHT_PHOTOS_FIELD_OFFSET . "=' + this.options[this.selectedIndex].value;\">\n";
			$pages = floor (($rowCount + $size - 1) / $size);
			for ($i = 0; $i < $pages; $i++)
			{
				echo "               <option " . ((($i * $size) == $offset) ? "selected " : "") . "value=\"" . ($i * $size) . "\">" . ($i + 1) . "</option>\n";
			}
			echo "            </select>\n" .
				 "         </form>\n" .
				 "      </td>\n" .
				 "   </tr>\n" .
				 "</table>\n" .
				 "<p>\n" .
				 "   <b>Instructions:</b><br>\n" .
				 "   Press <img src=\"" . EHT_PHOTOS_PLUGIN_URL_BASE_IMAGES . EHT_PHOTOS_ICON_RESET . "\"> to reset the photo views counter.<br>\n" .
				 "   Put the mouse over <img src=\"" . EHT_PHOTOS_PLUGIN_URL_BASE_IMAGES . EHT_PHOTOS_ICON_PHOTO . "\"> to see the photo thumbnail.<br>\n" .
				 "</p>\n" .
				 "<table width=\"100%\">\n" .
				 "   <tr>\n" .
				 "      <th align=\"left\"></th>\n" .
				 "      <th align=\"left\"></th>\n" .
				 "      <th align=\"left\"><a href=\"$href" . EHT_PHOTOS_FIELD_ORDER . "=" . EHT_PHOTOS_ORDER_ID . "&" . EHT_PHOTOS_FIELD_DIRECTION . "=" . $directionId . "\">ID</a></th>\n" .
				 "      <th align=\"left\"><a href=\"$href" . EHT_PHOTOS_FIELD_ORDER . "=" . EHT_PHOTOS_ORDER_NAME . "&" . EHT_PHOTOS_FIELD_DIRECTION . "=" . $directionName . "\">Name</a></th>\n" .
				 "      <th align=\"left\"><a href=\"$href" . EHT_PHOTOS_FIELD_ORDER . "=" . EHT_PHOTOS_ORDER_VIEWS . "&" . EHT_PHOTOS_FIELD_DIRECTION . "=" . $directionViews . "\">Views</a></th>\n" .
				 "      <th align=\"left\">Thumbnail</th>\n" .
				 "      <th align=\"left\"><a href=\"$href" . EHT_PHOTOS_FIELD_ORDER . "=" . EHT_PHOTOS_ORDER_MD5 . "&" . EHT_PHOTOS_FIELD_DIRECTION . "=" . $directionMd5 . "\">MD5</a></th>\n" .
				 "      <th align=\"left\"><a href=\"$href" . EHT_PHOTOS_FIELD_ORDER . "=" . EHT_PHOTOS_ORDER_PATH . "&" . EHT_PHOTOS_FIELD_DIRECTION . "=" . $directionPath . "\">Photo full path</a></th>\n" .
				 "   </tr>\n";
			$i = 0;
			$count = count ($rows);
			foreach ($rows as $row)
			{
				$i++;
				$id	= $row->id;
				$name = $row->name;
				$views = $row->views;
				$md5 = $row->md5;
				$path = $row->path;
				
				$image = "";
				if ($path != "")
				{
					$image = $baseUrl . substr ($path, strlen ($basePath));
				}
				$class = ("alternate" == $class) ? "" : "alternate";
				
				echo "   <tr class=\"$class\">\n" .
					 "      <td valign=\"top\">\n";
				if ($views > 0)
				{
					echo "         <span onClick=\"window.location = '$href" . EHT_PHOTOS_FIELD_ORDER . "=$order&" . EHT_PHOTOS_FIELD_DIRECTION . "=$direction&" . EHT_PHOTOS_FIELD_ACTION . "=" . EHT_PHOTOS_ACTION_RESET . "&" . EHT_PHOTOS_FIELD_ID . "=" . $id . "';\" style=\"cursor: pointer;\">\n" .
						 "            <img src=\"" . EHT_PHOTOS_PLUGIN_URL_BASE_IMAGES . EHT_PHOTOS_ICON_RESET . "\" border=\"0\" title=\"Reset views counter\">\n" .
						 "         </span>\n";
				}
				echo "      </td>\n" .
					 "      <td valign=\"top\">\n";
				if ($image != "")
				{
					echo "         <span style=\"cursor: pointer;\" onMouseOver=\"document.getElementById ('thumb$id').style.visibility = 'visible';\" onMouseOut=\"document.getElementById ('thumb$id').style.visibility = 'hidden';\">\n" .
						 "            <img src=\"" . EHT_PHOTOS_PLUGIN_URL_BASE_IMAGES . EHT_PHOTOS_ICON_PHOTO . "\" border=\"0\" title=\"View the photo thumbnail\">\n" .
						 "         </span>\n";
				}
				echo "      </td>\n" .
					 "      <td valign=\"top\">$id</td>\n" .
					 "      <td valign=\"top\">$name</td>\n" .
					 "      <td valign=\"top\">$views</td>\n" .
					 "      <td valign=\"top\" align=\"center\">\n";
				if ($image != "")
				{
					EHTPhotosExtractExtension ($image, $file, $extension);
					$image = $file . "_" . get_option (EHT_PHOTOS_OPTION_THUMB) . "." . $extension;
					$height = ($i < $count) ? "height: 0px;" : "";
					echo "         <div id=\"thumb$id\" style=\"visibility: hidden; $height\">\n" .
						 "            <img src=\"$image\">\n" .
						 "         </div>\n";
				}
				echo "      </td>\n" .
					 "      <td valign=\"top\"><small>$md5</small></td>\n" .
					 "      <td valign=\"top\"><small>$path</small></td>\n" .
					 "   </tr>\n";
			}
			echo "</table>\n";
			break;
	}
	echo "</div>\n" .
		 "<p align=\"center\">" . EHT_PHOTOS_PLUGIN_DESCRIPTION . "</p>\n";
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
					 EHT_PHOTOS_TABLE_COMMENT => EHT_PHOTOS_TABLE_COMMENT_CREATE);
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
					 EHT_PHOTOS_TABLE_COMMENT);
	
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