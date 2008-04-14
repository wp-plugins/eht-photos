<?php
/*
Plugin Name:	EHT Photos
Plugin URI:		http://ociotec.com/index.php/2008/01/10/eht-photos-plugin-para-wordpress/
Description:	This plugin generates automatically photo galleries with thumbnails and easy recursive navigation links, the photos can be viewed in several sizes, with an easy configuration panel.
Author:			Emilio Gonz&aacute;lez Monta&ntilde;a
Version:		1.7.1
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
				1.5.1	Corrected some errors.
				1.5.2	Corrected some errors (issue #4).
				1.5.3	Corrected some errors (issue #9).
				1.6		Added widget for random photos (issue #13). Added widget for most viewed photos (issue #12).
				1.6.5	The widgets are tabulable, and the number of columns is configurable (issue #18).
				1.6.5.1	Corrected some errors (issue #19).
				1.7		The thumbnails are generated and loaded with AJAX (issue #23), and an option has been added to enable/disable it. Permission update (into administration view) are made with AJAX (issue #24).
				1.7.1	Corrected some cosmetic errors. Adjust the AJAX image loading to hide the thumbnail image until it is loaded (issue #25). Fix not working when Wordpress wasn't on the root URL (issue #27). Not resize images if the thumbnail was bigger than the original image (issue #26). Fix photo counters (issue #9). Fix navigation when Wordpress is not in web root (issue #28). 

Setup:
	1) Install the plugin.
	2) Go to the admin menus, and in "Options" panel, select "EHT Photos".
	3) Press "Install DB".
	4) Configure the plugin if you need.
	5) Insert the plugin tags where you need it (see below the plugin sintax).
	6) Add the Random Photo widget (optional) into the Presentation menu.

Upgrade:
	1) Go to the admin menus, and in "Options" panel, select "EHT Photos".
	2) Press "Install DB" (this will upgrade database if needed).

Plugin sintax:

[photos images={1} path={2}]

Where:
   {1} this is the URL of the path to the photo files relative to options "path to images" and "path to thumbs"
   {2} this is a flag to show (yes) or not (no) the path links

Examples:
[photos images=Hobbies/Informatica/MisFotos path=no]
[photos images= path=yes]

*/

$currentUrl = $PHP_SELF . "?";
$inAdmin = false;
$goodPath = "";

require_once ("Common.php");
require_once ("Admin.php");

add_filter ("the_content", "EHTPhotosFilterTheContent");
add_action ("wp_head", "EHTPhotosHeader");

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
		$optionUseAjax = get_option (EHT_PHOTOS_OPTION_USE_AJAX);
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
		if ($optionUseAjax == "")
		{
			$optionUseAjax = EHT_PHOTOS_DEFAULT_USE_AJAX;
		}
		
		for ($index = 0; $index < count ($results[0]); $index++)
		{
			$text = "\n";
						
			$tagImages = EHTPhotosQuitSlashes (trim ($results[1][$index]));
			$tagPath = (strcasecmp (trim ($results[2][$index]), EHT_PHOTOS_YES) == 0);

			$goodUrl = get_option ("siteurl");
			EHTPhotosQuitSlashes ($goodUrl, true);
			$goodPath = $_SERVER["DOCUMENT_ROOT"];
			EHTPhotosQuitSlashes ($goodPath, true);
			$part = substr ($goodUrl, strpos ($goodUrl, $_SERVER["SERVER_NAME"]) + strlen ($_SERVER["SERVER_NAME"]));
			if ($part != "")
			{
				$goodPath = EHTPhotosConcatPaths ($goodPath, $part);
			}
			
			$urlImages = EHTPhotosConcatPaths (EHTPhotosConcatPaths ($goodUrl, $optionPathImages), $tagImages);
			$pathImages = EHTPhotosConcatPaths (EHTPhotosConcatPaths ($goodPath, $optionPathImages, true), $tagImages, true);
			$urlThumbs = EHTPhotosConcatPaths (EHTPhotosConcatPaths ($goodUrl, $optionPathThumbs), $tagImages);
			$pathThumbs = EHTPhotosConcatPaths (EHTPhotosConcatPaths ($goodPath, $optionPathThumbs, true), $tagImages, true);

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
									 ($optionUseAjax == EHT_PHOTOS_YES),
									 $index);
			$text .= "</table></center><br>\n";
               
			$content = str_replace ($results[0][$index], $text, $content);
		}
	}

	return ($content);
}

function EHTPhotosHeader ()
{
	echo EHT_PHOTOS_JAVASCRIPT;
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
						 $optionUseAjax,
						 $index)
{
	global $post;
	global $inAdmin;
	global $currentUrl;
	
	$text = "";
	
	$currentPath = EHTPhotosGetVar (EHT_PHOTOS_VAR_PATH . $index);
	$currentMode = EHTPhotosGetVar (EHT_PHOTOS_VAR_MODE . $index);
	$currentPhoto = EHTPhotosGetVar (EHT_PHOTOS_VAR_PHOTO . $index);

	$files = EHTPhotosListExtensions (EHTPhotosConcatPaths ($pathImages, $currentPath), $currentPath, split (",", EHT_PHOTOS_PHOTO_EXTENSIONS));
	
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
					$linkPrevious = ($inAdmin ? $currentUrl : (get_permalink ($post->ID) . "?")) .
									EHT_PHOTOS_VAR_PATH . "$index=" . urlencode ($currentPath) . "&" .
									EHT_PHOTOS_VAR_MODE . "$index=" . EHT_PHOTOS_VAR_MODE_NORMAL . "&" .
									EHT_PHOTOS_VAR_PHOTO . "$index=" . urlencode ($files[1][$i - 1]) .
									"#" . EHT_PHOTOS_ANCHOR_GALLERY . "$index";
				}
				if ($i < ($fileCount - 1))
				{
					$linkNext = ($inAdmin ? $currentUrl : (get_permalink ($post->ID) . "?")) .
								EHT_PHOTOS_VAR_PATH . "$index=" . urlencode ($currentPath) . "&" .
								EHT_PHOTOS_VAR_MODE . "$index=" . EHT_PHOTOS_VAR_MODE_NORMAL . "&" .
								EHT_PHOTOS_VAR_PHOTO . "$index=" . urlencode ($files[1][$i + 1]) .
								"#" . EHT_PHOTOS_ANCHOR_GALLERY . "$index";
				}
			}
		}
		if ($imageIndex >= 0)
		{
			$text .= EHTPhotosPrintNormal ($currentPhoto, $currentPath, $imageIndex, $fileCount, $urlImages, $pathImages, $urlThumbs, $pathThumbs, $linkPrevious, $linkNext, $optionNormal, $optionExif, $optionUseAjax, $index);
		}
		$colspan = 3;
	}
	else
	{
		$text .= EHTPhotosPrintThumbs ($files, $currentPath, $urlImages, $pathImages, $urlThumbs, $pathThumbs, $optionThumb, $optionNormal, $optionWidth, $optionExif, $optionUseAjax, $index);
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
	global $post;
	global $inAdmin;
	global $currentUrl;
	
	$pieces = explode (EHT_PHOTOS_SLASH, $path);
	$tempPath = "";
	$text .= "<tr><td colspan=\"$optionWidth\" align=\"left\">\n";
	$text .= "<a href=\"" . ($inAdmin ? $currentUrl : (get_permalink ($post->ID) . "?")) . EHT_PHOTOS_VAR_PATH . "$index=" . EHT_PHOTOS_SLASH . "\">ROOT</a>\n";
	foreach ($pieces as $piece)
	{
		if (strlen ($piece) > 0)
		{
			$tempPath .= $piece . EHT_PHOTOS_SLASH;
			$text .= "/<a href=\"" . ($inAdmin ? $currentUrl : (get_permalink ($post->ID) . "?")) .
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
		$basePath = EHTPhotosConcatPaths ($goodPath, get_option (EHT_PHOTOS_OPTION_PATH_IMAGES)) . EHT_PHOTOS_SLASH;
		$basePath = EHTPhotosConcatPaths (substr ($basePath, strlen ($basePath)), $currentPath);
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
		    	$entryPath = EHTPhotosConcatPaths ($basePath, $entry);
		    	if ($entryPath[0] != EHT_PHOTOS_SLASH)
		    	{
		    		$entryPath = EHT_PHOTOS_SLASH . $entryPath;
		    	}
		    	EHTPhotosGetPermissions ($entryPath, $permissions);
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
	    		if (is_dir (EHTPhotosConcatPaths ($path, $entry)))
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
							   $optionUseAjax,
							   $index)
{
	global $post;
	global $inAdmin;
	global $currentUrl;
	
	$text = "";
	
	$link = $urlImages . $currentPath . $name;
	$baseLink = "<a href=\"". ($inAdmin ? $currentUrl : (get_permalink ($post->ID) . "?")) .
				EHT_PHOTOS_VAR_PATH . "$index=" . urlencode ($currentPath) .
				"#" . EHT_PHOTOS_ANCHOR_GALLERY . "$index\">[Thumbnails]</a>";
	$idDivLoading = sprintf ("id-image-loading-%d", $index);
	$idDivThumbnail = sprintf ("id-image-thumbnail-%d", $index);
	$normal = EHTPhotosGetThumb (EHTPhotosConcatPaths ($pathImages, $currentPath),
								 EHTPhotosConcatPaths ($urlThumbs, $currentPath, true),
								 EHTPhotosConcatPaths ($pathThumbs, $currentPath),
								 $name,
								 $optionNormal,
								 $scriptLoading,
								 $idDivLoading,
								 $idDivThumbnail,
								 $optionUseAjax);

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
			 "            <span onClick=\"window.open ('$link');\" style=\"cursor: pointer;\" id=\"$idDivLoading\"><img src=\"$normal\" border=\"0\" onLoad=\"$scriptLoading\"></span>\n" .
			 "            <span onClick=\"window.open ('$link');\" style=\"cursor: pointer; visibility: hidden;\" id=\"$idDivThumbnail\"></span>\n" .
			 "         </td>\n" .
			 "      </tr>\n" .
			 "      <tr>\n" .
			 "         <td align=\"center\" colspan=\"3\">\n" .
			 "            <span onClick=\"window.open ('$link');\" style=\"cursor: pointer;\">" . htmlentities ($name) . "</span>\n" .
			 "         </td>\n" .
			 "      </tr>\n";
	$fullPath = EHTPhotosConcatPaths (EHTPhotosConcatPaths ($pathImages, $currentPath), $name);
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
							   $optionUseAjax,
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
		$text .= EHTPhotosPrintThumb (EHT_PHOTOS_THUMB_FOLDER, "..", $optionThumb, $currentPath, $urlImages, $pathImages, $urlThumbs, $pathThumbs, $optionUseAjax, $index, $x, $y, $optionWidth, $limit);
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
			$text .= EHTPhotosPrintThumb (EHT_PHOTOS_THUMB_FOLDER, $files[0][$i], $optionThumb, $currentPath, $urlImages, $pathImages, $urlThumbs, $pathThumbs, $optionUseAjax, $index, $x, $y, $optionWidth, $limit, $groups, $basePermissions);
			EHTPhotosIncrement ($x, $y, $optionWidth);
			$current++;
		}
		for ($i = 0;
			 $i < $fileCount;
			 $i++)
		{
			$text .= EHTPhotosPrintThumb (EHT_PHOTOS_THUMB_FILE, $files[1][$i], $optionThumb, $currentPath, $urlImages, $pathImages, $urlThumbs, $pathThumbs, $optionUseAjax, $index, $x, $y, $optionWidth, $limit, $groups, $basePermissions);
			EHTPhotosIncrement ($x, $y, $optionWidth);
			$current++;
		}
		for ($i = $current;
			 $i < $limit;
			 $i++)
		{
			$text .= EHTPhotosPrintThumb (EHT_PHOTOS_THUMB_EMPTY, "", $optionThumb, $currentPath, $urlImages, $pathImages, $urlThumbs, $pathThumbs, $optionUseAjax, $index, $x, $y, $optionWidth, $limit, $groups, $basePermissions);
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
							  $optionUseAjax,
							  $index, 
							  $x,
							  $y,
							  $width,
							  $limit,
							  $groups = "",
							  $basePermissions = "")
{
	global $inAdmin;
	global $post;
	global $currentUrl;
		
	$text = "";
	
	$idDivLoading = "id-image-loading-$index-$x-$y";
	$idDivThumbnail = "id-image-thumbnail-$index-$x-$y";
	
	if ($name == "..")
	{
		$parentPath = EHTPhotosGetParent ($currentPath);
		$link = ($inAdmin ? $currentUrl : (get_permalink ($post->ID) . "?")) . 
				EHT_PHOTOS_VAR_PATH . "$index=" . urlencode ($parentPath) . 
				"#" . EHT_PHOTOS_ANCHOR_GALLERY . "$index";
	}
	else
	{
		if ($type == EHT_PHOTOS_THUMB_FILE)
		{
			$link = ($inAdmin ? $currentUrl : (get_permalink ($post->ID) . "?")) .
					EHT_PHOTOS_VAR_PATH . "$index=" . urlencode ($currentPath) . "&" .
					EHT_PHOTOS_VAR_MODE . "$index=" . EHT_PHOTOS_VAR_MODE_NORMAL . "&" .
					EHT_PHOTOS_VAR_PHOTO . "$index=" . urlencode ($name) . 
					"#" . EHT_PHOTOS_ANCHOR_GALLERY . "$index";
		}
		else if ($type == EHT_PHOTOS_THUMB_FOLDER)
		{
			$link = ($inAdmin ? $currentUrl : (get_permalink ($post->ID) . "?")) .
					EHT_PHOTOS_VAR_PATH . "$index=" . urlencode ($currentPath . $name . EHT_PHOTOS_SLASH) .
					"#" . EHT_PHOTOS_ANCHOR_GALLERY . "$index";
		}
	}

	if ($type == EHT_PHOTOS_THUMB_FILE)
	{
		$thumb = EHTPhotosGetThumb (EHTPhotosConcatPaths ($pathImages, $currentPath),
									EHTPhotosConcatPaths ($urlThumbs, $currentPath, true),
									EHTPhotosConcatPaths ($pathThumbs, $currentPath),
									$name,
									$thumbSize,
									$scriptLoading,
									$idDivLoading,
									$idDivThumbnail,
									$optionUseAjax);
		$fullPath = EHTPhotosConcatPaths (EHTPhotosConcatPaths ($pathImages, $currentPath), $name);
		$md5 = md5_file ($fullPath);
		$description = EHTPhotosGetDescription ($md5, true, $name, $fullPath);
	}
	else if ($type == EHT_PHOTOS_THUMB_FOLDER)
	{
		$thumb = EHTPhotosGetThumb (EHT_PHOTOS_PLUGIN_PATH_BASE_IMAGES,
									EHT_PHOTOS_PLUGIN_URL_BASE_IMAGES,
									EHT_PHOTOS_PLUGIN_PATH_BASE_IMAGES,
									EHT_PHOTOS_IMAGE_FOLDER,
									$thumbSize,
									$scriptLoading,
									$idDiv,
									false);
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
		$text .= "         <span onClick=\"window.location = '$link';\" style=\"cursor: pointer;\" id=\"$idDivLoading\"><img src=\"$thumb\" border=\"0\" onLoad=\"$scriptLoading\"></span>\n" .
				 "         <span onClick=\"window.location = '$link';\" style=\"cursor: pointer; visibility: hidden;\" id=\"$idDivThumbnail\"></span><br>\n" .
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
					 "   <form>\n";
			$permissions = array ();
			EHTPhotosGetPermissions ($path, $permissions);
			foreach ($groups as $groupId => $groupName)
			{
				$checked = "";
				if (isset ($permissions[$groupId]))
				{
					$checked = " checked";
				}
				$onChange = "AJAXExecute ('" . EHT_PHOTOS_PLUGIN_URL_BASE . EHT_PHOTOS_AJAX_PERMISSION_CHANGE . 
							EHT_PHOTOS_FIELD_PATH . "=" . htmlentities ($path) . "&" .
							EHT_PHOTOS_FIELD_GROUP_ID . "=" . htmlentities ($groupId) . "&" . 
							EHT_PHOTOS_FIELD_VALUE . "=" . htmlentities ($checked ? "false" : "true") . 
							"');";
				$text .= "      <input type=\"checkbox\" name=\"". EHT_PHOTOS_FIELD_GROUP . "$groupId\"$checked onChange=\"$onChange\"> $groupName<br>\n";
			}
			$text .= "   </form>\n" .
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

function EHTPhotosGetThumb ($pathImage,
							$urlThumb,
							$pathThumb,
							$name,
							$thumbSize,
							&$scriptLoading,
							$idDivLoading,
							$idDivThumbnail,
							$withAjax)
{
	$getNormal = true;
	$scriptLoading = "";
	if (($idDivLoading != "") && ($idDivThumbnail != "") && $withAjax)
	{
		$scriptLoading = "AJAXModifyInner ('" . EHT_PHOTOS_PLUGIN_URL_BASE . EHT_PHOTOS_AJAX_THUMBNAIL_GENERATION . 
						 "pathImage=" . htmlentities ($pathImage) . 
						 "&urlThumb=" . htmlentities ($urlThumb) . 
						 "&pathThumb=" . htmlentities ($pathThumb) . 
						 "&name=" . htmlentities ($name) . 
						 "&thumbSize=" . htmlentities ($thumbSize) . 
						 "&elementOld=" . htmlentities ($idDivLoading) . 
						 "&elementNew=" . htmlentities ($idDivThumbnail) . 
						 "', '$idDivLoading', '$idDivThumbnail');";
		$getNormal = false;
	}

	if ($getNormal)
	{
		$text = EHTPhotosGenerateThumb ($pathImage,
										$urlThumb,
										$pathThumb,
										$name,
										$thumbSize);
	}
	else
	{
		$text = EHT_PHOTOS_PLUGIN_URL_BASE_IMAGES . EHT_PHOTOS_IMAGE_LOADING;
	}
	
	return ($text);
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

	$sql = sprintf (EHT_PHOTOS_TABLE_PHOTO_SELECT_BY_MD5, $md5);
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
		$sql = sprintf (EHT_PHOTOS_TABLE_PHOTO_SELECT_BY_PATH, $fullPath);
		$result = $wpdb->get_row ($sql);
		if ($result)
		{
			$id = $result->id;
			$sql = sprintf (EHT_PHOTOS_TABLE_PHOTO_UPDATE_MD5, $md5, $id);
			if (!($wpdb->query ($sql)))
			{
				$text .= "Fail to update the MD5: \"$sql\"<br>\n";
			}
			else
			{
				$ok = true;
			}
		}
		else
		{
			$sql = sprintf (EHT_PHOTOS_TABLE_PHOTO_INSERT, $md5, $photo, $fullPath);
			if (!($wpdb->query ($sql)))
			{
				$text .= "Fail to insert: \"$sql\" md5: $md5<br>\n";
			}
			else
			{
				$id = $wpdb->insert_id;
				$ok = true;
			}
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
		$text .= "<small>($views view" . (($views == 1) ? "" : "s") . ")</small>";
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

?>