<?php

add_action ("admin_menu", "EHTPhotosAdminAddPages");
add_action ("init", "EHTPhotosRegisterWidgets");

require_once (ABSPATH . "wp-admin/includes/upgrade.php");

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

function EHTPhotosRegisterWidgets ()
{
	if (function_exists ("register_sidebar_widget")) :

	function EHTPhotosWidgetRandom ($arguments)
	{
		global $wpdb;
		
		extract ($arguments);
		
		$title = get_option (EHT_PHOTOS_WIDGET_RANDOM_TITLE);
		$title = ($title != "") ? $title : EHT_PHOTOS_DEFAULT_WIDGET_RANDOM_TITLE;
		$thumb = get_option (EHT_PHOTOS_WIDGET_RANDOM_THUMB);
		$thumb = (($thumb == "") ? EHT_PHOTOS_WIDGET_RANDOM_THUMB_DEFAULT : $thumb);
		$count = get_option (EHT_PHOTOS_WIDGET_RANDOM_COUNT);
		$count = ($count != "") ? $count : EHT_PHOTOS_DEFAULT_WIDGET_RANDOM_COUNT;
		$columns = get_option (EHT_PHOTOS_WIDGET_RANDOM_COLUMNS);
		$columns = ($columns != "") ? $columns : EHT_PHOTOS_WIDGET_RANDOM_COLUMNS_DEFAULT;
		$text = $before_widget .
				$before_title . $title . $after_title . "\n" .
				"<div align=\"center\">\n" . 
				"<small>\n" .
				EHTPhotosWidgetPhotos ($count, $columns, $thumb, true) .
				"<i>" . EHT_PHOTOS_PLUGIN_SHORT_DESCRIPTION . "</i>\n" .
				"</small>\n" .
				"</div>\n" .
				$after_widget;
				
		echo $text;
	}
	
	function EHTPhotosWidgetRandomControl ()
	{
		$title = $newTitle = get_option (EHT_PHOTOS_WIDGET_RANDOM_TITLE);
		if ($_POST[EHT_PHOTOS_WIDGET_RANDOM_SUBMIT])
		{
			$newTitle = $_POST[EHT_PHOTOS_WIDGET_RANDOM_TITLE];
			if ($newTitle == "")
			{
				$newTitle = EHT_PHOTOS_WIDGET_RANDOM_TITLE_DEFAULT;
			}
		}
		if ($title != $newTitle)
		{
			$title = $newTitle;
			update_option (EHT_PHOTOS_WIDGET_RANDOM_TITLE, $title);
		}
		if (($title == "") &&
			(!$_POST[EHT_PHOTOS_WIDGET_RANDOM_SUBMIT]))
		{
			$title = EHT_PHOTOS_WIDGET_RANDOM_TITLE_DEFAULT;
		}
		$title = htmlspecialchars ($title, ENT_QUOTES);
		
		$thumb = $newThumb = get_option (EHT_PHOTOS_WIDGET_RANDOM_THUMB);
		if ($_POST[EHT_PHOTOS_WIDGET_RANDOM_SUBMIT])
		{
			$newThumb = $_POST[EHT_PHOTOS_WIDGET_RANDOM_THUMB];
			if ($newThumb == "")
			{
				$newThumb = EHT_PHOTOS_WIDGET_RANDOM_THUMB_DEFAULT;
			}
		}
		if ($thumb != $newThumb)
		{
			$thumb = $newThumb;
			update_option (EHT_PHOTOS_WIDGET_RANDOM_THUMB, $thumb);
		}
		if (($thumb == "") &&
			(!$_POST[EHT_PHOTOS_WIDGET_RANDOM_SUBMIT]))
		{
			$thumb = EHT_PHOTOS_WIDGET_RANDOM_THUMB_DEFAULT;
		}
		$thumb = htmlspecialchars ($thumb, ENT_QUOTES);
		
		$count = $newCount = get_option (EHT_PHOTOS_WIDGET_RANDOM_COUNT);
		if ($_POST[EHT_PHOTOS_WIDGET_RANDOM_SUBMIT])
		{
			$newCount = $_POST[EHT_PHOTOS_WIDGET_RANDOM_COUNT];
			if ($newCount == "")
			{
				$newCount = EHT_PHOTOS_WIDGET_RANDOM_COUNT_DEFAULT;
			}
		}
		if ($count != $newCount)
		{
			$count = $newCount;
			update_option (EHT_PHOTOS_WIDGET_RANDOM_COUNT, $count);
		}
		if (($count == "") &&
			(!$_POST[EHT_PHOTOS_WIDGET_RANDOM_SUBMIT]))
		{
			$count = EHT_PHOTOS_WIDGET_RANDOM_COUNT_DEFAULT;
		}
		$count = htmlspecialchars ($count, ENT_QUOTES);
		
		$columns = $newColumns = get_option (EHT_PHOTOS_WIDGET_RANDOM_COLUMNS);
		if ($_POST[EHT_PHOTOS_WIDGET_RANDOM_SUBMIT])
		{
			$newColumns = $_POST[EHT_PHOTOS_WIDGET_RANDOM_COLUMNS];
			if ($newColumns == "")
			{
				$newColumns = EHT_PHOTOS_WIDGET_RANDOM_COLUMNS_DEFAULT;
			}
		}
		if ($columns != $newColumns)
		{
			$columns = $newColumns;
			update_option (EHT_PHOTOS_WIDGET_RANDOM_COLUMNS, $columns);
		}
		if (($columns == "") &&
			(!$_POST[EHT_PHOTOS_WIDGET_RANDOM_SUBMIT]))
		{
			$columns = EHT_PHOTOS_WIDGET_RANDOM_COLUMNS_DEFAULT;
		}
		$columns = htmlspecialchars ($columns, ENT_QUOTES);
		
		$page = $newPage = get_option (EHT_PHOTOS_WIDGET_RANDOM_PAGE);
		if ($_POST[EHT_PHOTOS_WIDGET_RANDOM_SUBMIT])
		{
			$newPage = $_POST[EHT_PHOTOS_WIDGET_RANDOM_PAGE];
		}
		if ($page != $newPage)
		{
			$page = $newPage;
			update_option (EHT_PHOTOS_WIDGET_RANDOM_PAGE, $page);
		}
		$page = htmlspecialchars ($page, ENT_QUOTES);
		
		echo "<p>\n" .
			 "   <label for=\"" . EHT_PHOTOS_WIDGET_RANDOM_TITLE . "\">Title<br>\n" .
			 "   <input style=\"width: 250px;\" id=\"". EHT_PHOTOS_WIDGET_RANDOM_TITLE . "\"".
			 "    name=\"". EHT_PHOTOS_WIDGET_RANDOM_TITLE . "\" type=\"text\" value=\"$title\" /></label>\n" .
			 "</p>\n" .
			 "<p>\n" .
			 "   <label for=\"" . EHT_PHOTOS_WIDGET_RANDOM_THUMB . "\">Thumbnail size<br>\n" .
			 "   <input style=\"width: 250px;\" id=\"". EHT_PHOTOS_WIDGET_RANDOM_THUMB . "\"".
			 "    name=\"". EHT_PHOTOS_WIDGET_RANDOM_THUMB . "\" type=\"text\" value=\"$thumb\" /></label>\n" .
			 "</p>\n" .
			 "<p>\n" .
			 "   <label for=\"" . EHT_PHOTOS_WIDGET_RANDOM_COUNT . "\">Count of photos to show<br>\n" .
			 "   <input style=\"width: 250px;\" id=\"". EHT_PHOTOS_WIDGET_RANDOM_COUNT . "\"".
			 "    name=\"". EHT_PHOTOS_WIDGET_RANDOM_COUNT . "\" type=\"text\" value=\"$count\" /></label>\n" .
			 "</p>\n" .
			 "<p>\n" .
			 "   <label for=\"" . EHT_PHOTOS_WIDGET_RANDOM_COLUMNS . "\">Columns to show<br>\n" .
			 "   <input style=\"width: 250px;\" id=\"". EHT_PHOTOS_WIDGET_RANDOM_COLUMNS . "\"".
			 "    name=\"". EHT_PHOTOS_WIDGET_RANDOM_COLUMNS . "\" type=\"text\" value=\"$columns\" /></label>\n" .
			 "</p>\n" .
			 "<p>\n" .
			 "   <label for=\"" . EHT_PHOTOS_WIDGET_RANDOM_PAGE . "\">Photos page to link to<br>\n" .
			 "   <input style=\"width: 250px;\" id=\"". EHT_PHOTOS_WIDGET_RANDOM_PAGE . "\"".
			 "    name=\"". EHT_PHOTOS_WIDGET_RANDOM_PAGE . "\" type=\"text\" value=\"$page\" /></label>\n" .
			 "</p>\n" .
			 "<input type=\"hidden\" id=\"". EHT_PHOTOS_WIDGET_RANDOM_SUBMIT . "\"" .
			 " name=\"". EHT_PHOTOS_WIDGET_RANDOM_SUBMIT . "\" value=\"1\" />\n";
	}

	register_sidebar_widget (EHT_PHOTOS_WIDGET_RANDOM_CAPTION, "EHTPhotosWidgetRandom", null, EHT_PHOTOS_WIDGET_RANDOM_NAME);
	register_widget_control (EHT_PHOTOS_WIDGET_RANDOM_CAPTION, "EHTPhotosWidgetRandomControl", 300, 270, EHT_PHOTOS_WIDGET_RANDOM_NAME);
	
	function EHTPhotosWidgetMostViewed ($arguments)
	{
		global $wpdb;
		
		extract ($arguments);
		
		$title = get_option (EHT_PHOTOS_WIDGET_MOST_VIEWED_TITLE);
		$title = ($title != "") ? $title : EHT_PHOTOS_DEFAULT_WIDGET_MOST_VIEWED_TITLE;
		$thumb = get_option (EHT_PHOTOS_WIDGET_MOST_VIEWED_THUMB);
		$thumb = (($thumb == "") ? EHT_PHOTOS_WIDGET_MOST_VIEWED_THUMB_DEFAULT : $thumb);
		$count = get_option (EHT_PHOTOS_WIDGET_MOST_VIEWED_COUNT);
		$count = ($count != "") ? $count : EHT_PHOTOS_DEFAULT_WIDGET_MOST_VIEWED_COUNT;
		$columns = get_option (EHT_PHOTOS_WIDGET_MOST_VIEWED_COLUMNS);
		$columns = ($columns != "") ? $columns : EHT_PHOTOS_WIDGET_MOST_VIEWED_COLUMNS_DEFAULT;
		$text = $before_widget .
				$before_title . $title . $after_title . "\n" .
				"<div align=\"center\">\n" . 
				"<small>\n" .
				EHTPhotosWidgetPhotos ($count, $columns, $thumb, false) .
				"<i>" . EHT_PHOTOS_PLUGIN_SHORT_DESCRIPTION . "</i>\n" .
				"</small>\n" .
				"</div>\n" .
				$after_widget;
				
		echo $text;
	}
	
	function EHTPhotosWidgetMostViewedControl ()
	{
		$title = $newTitle = get_option (EHT_PHOTOS_WIDGET_MOST_VIEWED_TITLE);
		if ($_POST[EHT_PHOTOS_WIDGET_MOST_VIEWED_SUBMIT])
		{
			$newTitle = $_POST[EHT_PHOTOS_WIDGET_MOST_VIEWED_TITLE];
			if ($newTitle == "")
			{
				$newTitle = EHT_PHOTOS_WIDGET_MOST_VIEWED_TITLE_DEFAULT;
			}
		}
		if ($title != $newTitle)
		{
			$title = $newTitle;
			update_option (EHT_PHOTOS_WIDGET_MOST_VIEWED_TITLE, $title);
		}
		if (($title == "") &&
			(!$_POST[EHT_PHOTOS_WIDGET_MOST_VIEWED_SUBMIT]))
		{
			$title = EHT_PHOTOS_WIDGET_MOST_VIEWED_TITLE_DEFAULT;
		}
		$title = htmlspecialchars ($title, ENT_QUOTES);

		$thumb = $newThumb = get_option (EHT_PHOTOS_WIDGET_MOST_VIEWED_THUMB);
		if ($_POST[EHT_PHOTOS_WIDGET_MOST_VIEWED_SUBMIT])
		{
			$newThumb = $_POST[EHT_PHOTOS_WIDGET_MOST_VIEWED_THUMB];
			if ($newThumb == "")
			{
				$newThumb = EHT_PHOTOS_WIDGET_MOST_VIEWED_THUMB_DEFAULT;
			}
		}
		if ($thumb != $newThumb)
		{
			$thumb = $newThumb;
			update_option (EHT_PHOTOS_WIDGET_MOST_VIEWED_THUMB, $thumb);
		}
		if (($thumb == "") &&
			(!$_POST[EHT_PHOTOS_WIDGET_MOST_VIEWED_SUBMIT]))
		{
			$thumb = EHT_PHOTOS_WIDGET_MOST_VIEWED_THUMB_DEFAULT;
		}
		$thumb = htmlspecialchars ($thumb, ENT_QUOTES);
		
		$count = $newCount = get_option (EHT_PHOTOS_WIDGET_MOST_VIEWED_COUNT);
		if ($_POST[EHT_PHOTOS_WIDGET_MOST_VIEWED_SUBMIT])
		{
			$newCount = $_POST[EHT_PHOTOS_WIDGET_MOST_VIEWED_COUNT];
			if ($newCount == "")
			{
				$newCount = EHT_PHOTOS_WIDGET_MOST_VIEWED_COUNT_DEFAULT;
			}
		}
		if ($count != $newCount)
		{
			$count = $newCount;
			update_option (EHT_PHOTOS_WIDGET_MOST_VIEWED_COUNT, $count);
		}
		if (($count == "") &&
			(!$_POST[EHT_PHOTOS_WIDGET_MOST_VIEWED_SUBMIT]))
		{
			$count = EHT_PHOTOS_WIDGET_MOST_VIEWED_COUNT_DEFAULT;
		}
		$count = htmlspecialchars ($count, ENT_QUOTES);
		
		$columns = $newColumns = get_option (EHT_PHOTOS_WIDGET_MOST_VIEWED_COLUMNS);
		if ($_POST[EHT_PHOTOS_WIDGET_MOST_VIEWED_SUBMIT])
		{
			$newColumns = $_POST[EHT_PHOTOS_WIDGET_MOST_VIEWED_COLUMNS];
			if ($newColumns == "")
			{
				$newColumns = EHT_PHOTOS_WIDGET_MOST_VIEWED_COLUMNS_DEFAULT;
			}
		}
		if ($columns != $newColumns)
		{
			$columns = $newColumns;
			update_option (EHT_PHOTOS_WIDGET_MOST_VIEWED_COLUMNS, $columns);
		}
		if (($columns == "") &&
			(!$_POST[EHT_PHOTOS_WIDGET_MOST_VIEWED_SUBMIT]))
		{
			$columns = EHT_PHOTOS_WIDGET_MOST_VIEWED_COLUMNS_DEFAULT;
		}
		$columns = htmlspecialchars ($columns, ENT_QUOTES);
		
		$page = $newPage = get_option (EHT_PHOTOS_WIDGET_MOST_VIEWED_PAGE);
		if ($_POST[EHT_PHOTOS_WIDGET_MOST_VIEWED_SUBMIT])
		{
			$newPage = $_POST[EHT_PHOTOS_WIDGET_MOST_VIEWED_PAGE];
		}
		if ($page != $newPage)
		{
			$page = $newPage;
			update_option (EHT_PHOTOS_WIDGET_MOST_VIEWED_PAGE, $page);
		}
		$page = htmlspecialchars ($page, ENT_QUOTES);
		
		echo "<p>\n" .
			 "   <label for=\"" . EHT_PHOTOS_WIDGET_MOST_VIEWED_TITLE . "\">Title<br>\n" .
			 "   <input style=\"width: 250px;\" id=\"". EHT_PHOTOS_WIDGET_MOST_VIEWED_TITLE . "\"".
			 "    name=\"". EHT_PHOTOS_WIDGET_MOST_VIEWED_TITLE . "\" type=\"text\" value=\"$title\" /></label>\n" .
			 "</p>\n" .
			 "<p>\n" .
			 "   <label for=\"" . EHT_PHOTOS_WIDGET_MOST_VIEWED_THUMB . "\">Thumbnail size<br>\n" .
			 "   <input style=\"width: 250px;\" id=\"". EHT_PHOTOS_WIDGET_MOST_VIEWED_THUMB . "\"".
			 "    name=\"". EHT_PHOTOS_WIDGET_MOST_VIEWED_THUMB . "\" type=\"text\" value=\"$thumb\" /></label>\n" .
			 "</p>\n" .
			 "<p>\n" .
			 "   <label for=\"" . EHT_PHOTOS_WIDGET_MOST_VIEWED_COUNT . "\">Count of photos to show<br>\n" .
			 "   <input style=\"width: 250px;\" id=\"". EHT_PHOTOS_WIDGET_MOST_VIEWED_COUNT . "\"".
			 "    name=\"". EHT_PHOTOS_WIDGET_MOST_VIEWED_COUNT . "\" type=\"text\" value=\"$count\" /></label>\n" .
			 "</p>\n" .
			 "<p>\n" .
			 "   <label for=\"" . EHT_PHOTOS_WIDGET_MOST_VIEWED_COLUMNS . "\">Columns to show<br>\n" .
			 "   <input style=\"width: 250px;\" id=\"". EHT_PHOTOS_WIDGET_MOST_VIEWED_COLUMNS . "\"".
			 "    name=\"". EHT_PHOTOS_WIDGET_MOST_VIEWED_COLUMNS . "\" type=\"text\" value=\"$columns\" /></label>\n" .
			 "</p>\n" .
			 "<p>\n" .
			 "   <label for=\"" . EHT_PHOTOS_WIDGET_MOST_VIEWED_PAGE . "\">Photos page to link to<br>\n" .
			 "   <input style=\"width: 250px;\" id=\"". EHT_PHOTOS_WIDGET_MOST_VIEWED_PAGE . "\"".
			 "    name=\"". EHT_PHOTOS_WIDGET_MOST_VIEWED_PAGE . "\" type=\"text\" value=\"$page\" /></label>\n" .
			 "</p>\n" .
			 "<input type=\"hidden\" id=\"". EHT_PHOTOS_WIDGET_MOST_VIEWED_SUBMIT . "\"" .
			 " name=\"". EHT_PHOTOS_WIDGET_MOST_VIEWED_SUBMIT . "\" value=\"1\" />\n";
	}

	register_sidebar_widget (EHT_PHOTOS_WIDGET_MOST_VIEWED_CAPTION, "EHTPhotosWidgetMostViewed", null, EHT_PHOTOS_WIDGET_MOST_VIEWED_NAME);
	register_widget_control (EHT_PHOTOS_WIDGET_MOST_VIEWED_CAPTION, "EHTPhotosWidgetMostViewedControl", 300, 270, EHT_PHOTOS_WIDGET_MOST_VIEWED_NAME);
	
	endif;
}

function EHTPhotosWidgetPhotos ($count,
								$columns,
								$thumbWidth,
								$random)
{
	global $wpdb, $user_ID;
	
	$text = "";
	
	$sql = sprintf ($random ? EHT_PHOTOS_TABLE_PHOTO_SELECT_ALL : EHT_PHOTOS_TABLE_PHOTO_SELECT_MOST_VIEWED);
	$photos = $wpdb->get_results ($sql);
	$countPhotos = count ($photos);

	$countAchieved = 0;
	$attempts = 0;
	$maxAttempts = $count * EHT_PHOTOS_WIDGET_RANDOM_MAX_ATTEMPTS;
	$selecteds = array ();
	$page = get_option (EHT_PHOTOS_WIDGET_RANDOM_PAGE);

	$groups = array ();
	$sql = sprintf (EHT_PHOTOS_TABLE_USER_SELECT_GROUPS, $user_ID);
	$rows = $wpdb->get_results ($sql);
	foreach ($rows as $row)
	{
		$groups[$row->id] = $row->name;
	}
	
	$url = EHTPhotosQuitSlashes (get_option ("siteurl"), true);
	$path = EHTPhotosQuitSlashes ($_SERVER["DOCUMENT_ROOT"], true);
	$optionThumbs = EHTPhotosQuitSlashes (get_option (EHT_PHOTOS_OPTION_PATH_THUMBS));
	$optionImages = EHTPhotosQuitSlashes (get_option (EHT_PHOTOS_OPTION_PATH_IMAGES));
	$thumbBasePath = EHTPhotosConcatPaths ($path, $optionThumbs);
	$thumbBaseUrl = EHTPhotosConcatPaths ($url, $optionThumbs);
	$photoBasePath = EHTPhotosConcatPaths ($path, $optionImages);
	$lengthPhotoBasePath = strlen ($photoBasePath);
	
	$text .= "<table>";
	
	while (($countAchieved < $count) &&
		   ($attempts <= $maxAttempts))
	{
		$photo = $photos[$random ? rand (0, $countPhotos - 1) : $attempts];
		$countSelecteds = count ($selecteds);
		for ($i = 0, $goOn = true; ($i < $countSelecteds) && $goOn; $i++)
		{
			$goOn = ($selecteds[$i]["id"] != $photo->id);
		}
		if ($goOn)
		{
			$relativePath = substr ($photo->path, $lengthPhotoBasePath);
			
			$permissions = array ();
			EHTPhotosGetFullPermissions ($relativePath, $permissions);
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
			if ($goOn)
			{
				EHTPhotosExtractFile ($relativePath, $path, $filename);
				$path .= EHT_PHOTOS_SLASH;
				EHTPhotosExtractExtension ($relativePath, $file, $extension);
				$relativePath = $file . "_" . get_option (EHT_PHOTOS_OPTION_THUMB) . "." . $extension;

				EHTPhotosExtractFile ($photo->path, $photoPath, $photoName);
				$thumbPath = EHTPhotosConcatPaths ($thumbBasePath, $path);
				$thumbUrl = EHTPhotosConcatPaths ($thumbBaseUrl, $path);

				$image = EHTPhotosGetThumb ($photoPath,
											$thumbUrl,
											$thumbPath,
											$photoName,
											$thumbWidth);
								
				$selecteds[$countAchieved]["id"] = $photo->id;
				$selecteds[$countAchieved]["path"] = $image;
				$selecteds[$countAchieved]["views"] = $photo->views;
				
				if (($countAchieved % $columns) == 0)
				{
					$text .= "<tr valign=\"top\">";
				}
				$text .= "<td align=\"center\">";
				if ($page != "")
				{
					$text .= "<a href=\"$page?path0=$path&mode0=normal&photo0=$filename\">";
				}
				$text .= "<img src=\"" . $selecteds[$countAchieved]["path"] . "\">";
				if ($page != "")
				{
					$text .= "</a>";
				}
				$text .= "<br>(" . $selecteds[$countAchieved]["views"] . 
						 " view" . (($selecteds[$countAchieved]["views"] == 1) ? "" : "s") . ")";
				$text .= "</td>";
				
				$countAchieved++;
				if (($countAchieved % $columns) == 0)
				{
					$text .= "</tr>";
				}
			}
		}
		$attempts++;
	}
	if ((($countAchieved % $columns) != 0) && ($countAchieved > 0))
	{
		$text .= "</tr>";
	}
	
	$text .= "</table>";
	if ($page != "")
	{
		$text .= "<a href=\"$page\">More photos...</a><br>";
	}

	return ($text);
}

function EHTPhotosAdminOptions ()
{
	global $wpdb;
	global $currentUrl;
	global $inAdmin;
	
	$inAdmin = true;
	$href = $PHP_SELF . "?page=eht-photos-options&" . EHT_PHOTOS_FIELD_SUBPAGE . "=";
	echo "<div class=\"wrap\">\n" .
		 "<h2>EHT Photos</h2>\n" .
		 "<div id=\"menu\">\n" .
		 "<a href=\"$href" . EHT_PHOTOS_SUBPAGE_GENERAL . "\">" . EHT_PHOTOS_SUBPAGE_GENERAL . "</a> &middot;\n" .
		 "<a href=\"$href" . EHT_PHOTOS_SUBPAGE_PHOTOS . "\">" . EHT_PHOTOS_SUBPAGE_PHOTOS . "</a> &middot;\n" .
		 "<a href=\"$href" . EHT_PHOTOS_SUBPAGE_GALLERY . "\">" . EHT_PHOTOS_SUBPAGE_GALLERY . "</a> &middot;\n" .
		 "<a href=\"$href" . EHT_PHOTOS_SUBPAGE_GROUPS . "\">" . EHT_PHOTOS_SUBPAGE_GROUPS . "</a> &middot;\n" .
		 "<a href=\"$href" . EHT_PHOTOS_SUBPAGE_USERS . "\">" . EHT_PHOTOS_SUBPAGE_USERS . "</a>\n" .
		 "</div>\n" .
		 "<br>\n";
	$page = $_REQUEST[EHT_PHOTOS_FIELD_SUBPAGE];
	switch ($page)
	{
		case EHT_PHOTOS_SUBPAGE_GENERAL:
		default:
			EHTPhotosAdminSubpageGeneral ($href);
			break;
		case EHT_PHOTOS_SUBPAGE_PHOTOS:
			EHTPhotosAdminSubpagePhotos ($href);
			break;
		case EHT_PHOTOS_SUBPAGE_GALLERY:
			EHTPhotosAdminSubpageGallery ($href);
			break;
		case EHT_PHOTOS_SUBPAGE_GROUPS:
			EHTPhotosAdminSubpageGroups ($href);
			break;
		case EHT_PHOTOS_SUBPAGE_USERS:
			EHTPhotosAdminSubpageUsers ($href);
			break;
	}
	echo "</div>\n" .
		 "<p align=\"center\">" . EHT_PHOTOS_PLUGIN_DESCRIPTION . "</p>\n";
}

function EHTPhotosAdminSubpageGeneral ($href)
{
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

	$tables = array (EHT_PHOTOS_TABLE_PHOTO,
					 EHT_PHOTOS_TABLE_COMMENT,
					 EHT_PHOTOS_TABLE_GROUP,
					 EHT_PHOTOS_TABLE_USER,
					 EHT_PHOTOS_TABLE_PERMISSION);
	foreach ($tables as $table)
	{
		if (!EHTPhotosCheckTable ($table))
		{
			echo "<div class=\"error\">The table \"$table\" is NOT installed, please press the button " . EHT_PHOTOS_ACTION_INSTALL . ".</div>\n"; 
		}
	}
	echo "<form method=\"post\" action=\"" . str_replace( '%7E', '~', $_SERVER['REQUEST_URI']) . "\">\n" .
		 "<input type=\"hidden\" name=\"" . EHT_PHOTOS_FIELD_ACTION . "\" value=\"" . EHT_PHOTOS_ACTION_UPDATE . "\">\n" .
		 "<p>Relative path (from web root) to images:<br>\n" .
		 "<input type=\"text\" name=\"" . EHT_PHOTOS_OPTION_PATH_IMAGES . "\" value=\"$optionPathImages\"></p>\n" .
		 "<p>Relative path (from web root) to thumbnails:<br>\n" .
		 "<input type=\"text\" name=\"" . EHT_PHOTOS_OPTION_PATH_THUMBS . "\" value=\"$optionPathThumbs\"></p>\n" .
		 "<p>Thumbnail size (in pixels) [" . EHT_PHOTOS_MIN_THUMB . ", " . EHT_PHOTOS_MAX_THUMB . "]:<br>\n" .
		 "<input type=\"text\" name=\"" . EHT_PHOTOS_OPTION_THUMB . "\" value=\"$optionThumb\"></p>\n" .
		 "<p>Normal photo size (in pixels) [" . EHT_PHOTOS_MIN_NORMAL . ", " . EHT_PHOTOS_MAX_NORMAL . "]:<br>\n" .
		 "<input type=\"text\" name=\"" . EHT_PHOTOS_OPTION_NORMAL . "\" value=\"$optionNormal\"></p>\n" .
		 "<p>Count of photos in horizontal in thumbnail view [" . EHT_PHOTOS_MIN_WIDTH . ", " . EHT_PHOTOS_MAX_WIDTH . "]:<br>\n" .
		 "<input type=\"text\" name=\"" . EHT_PHOTOS_OPTION_WIDTH . "\" value=\"$optionWidth\"></p>\n" .
		 "<p>\n" .
		 "<input type=\"checkbox\" name=\"" . EHT_PHOTOS_OPTION_EXIF . "\" value=\"" . EHT_PHOTOS_YES . "\"";
	if ($optionExif == EHT_PHOTOS_YES)
	{
		echo " checked";
	}
	echo "> Show EXIF information in detailed photo view (normal size).\n" .
		 "</p>\n" .
		 "<p>Results per page into options menus [" . EHT_PHOTOS_MIN_RESULTS . ", " . EHT_PHOTOS_MAX_RESULTS . "]:<br>\n" .
		 "<input type=\"text\" name=\"" . EHT_PHOTOS_OPTION_RESULTS . "\" value=\"$optionResults\"></p>\n" .
		 "<p>\n" .
		 "<p class=\"submit\">\n" .
		 "<input type=\"submit\" name=\"" . EHT_PHOTOS_FIELD_ACTION . "\" value=\"" . EHT_PHOTOS_ACTION_INSTALL . "\" onclick=\"return confirm ('Do you really want to install the data base?');\">\n" .
		 "<input type=\"submit\" name=\"" . EHT_PHOTOS_FIELD_ACTION . "\" value=\"" . EHT_PHOTOS_ACTION_UNINSTALL . "\" onclick=\"return confirm ('Do you really want to uninstall the data base?');\">\n" .
		 "<input type=\"submit\" name=\"" . EHT_PHOTOS_FIELD_ACTION . "\" value=\"" . EHT_PHOTOS_ACTION_UPDATE . "\" default>\n" .
		 "</p>\n" .
		 "</form>\n";
}

function EHTPhotosAdminSubpagePhotos ($href)
{
	global $wpdb;
	
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
		case EHT_PHOTOS_ACTION_RESET_PHOTOS:
			if (!EHTPhotosResetPhotos ($message))
			{
	        	echo "<div class=\"error\">Fail to reset the photo datas: $message.</div>\n";
			}
			else
			{
	        	echo "<div class=\"updated\">The photo datas have been reset.</div>\n";
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
	
	$sql = sprintf (EHT_PHOTOS_TABLE_PHOTO_SELECT_ALL_PAGINABLE, $order, $direction, $offset, $size);
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

	echo "<form method=\"post\" action=\"" . str_replace( '%7E', '~', $_SERVER['REQUEST_URI']) . "\">\n" .
		 "<p class=\"submit\">\n" .
		 "<input type=\"submit\" name=\"" . EHT_PHOTOS_FIELD_ACTION . "\" value=\"" . EHT_PHOTOS_ACTION_RESET_PHOTOS . "\" onclick=\"return confirm ('Do you really want to reset the photo datas?');\">\n" .
		 "</p>\n" .
		 "</form>\n";
}

function EHTPhotosAdminSubpageGallery ($href)
{
	global $currentUrl;
	global $wpdb;

	$action = $_REQUEST[EHT_PHOTOS_FIELD_ACTION];
	switch ($action)
	{
		case EHT_PHOTOS_ACTION_UPDATE:
			$path = $_REQUEST[EHT_PHOTOS_FIELD_PATH];
			$sql = sprintf (EHT_PHOTOS_TABLE_GROUP_SELECT_ALL);
			$rows = $wpdb->get_results ($sql);
			foreach ($rows as $row)
			{
				$groupId = $_REQUEST[EHT_PHOTOS_FIELD_GROUP . $row->id];
				$sql = sprintf ($groupId ? EHT_PHOTOS_TABLE_PERMISSION_INSERT : EHT_PHOTOS_TABLE_PERMISSION_DELETE, $row->id, $path);					
				$wpdb->query ($sql);
			}
       		echo "<div class=\"updated\">Permissions updated into \"$path\"</div>\n";
			break;
	}
	
	$currentUrl = $href . EHT_PHOTOS_SUBPAGE_GALLERY . "&";
	echo EHTPhotosFilterTheContent ("[photos images= path=yes]");
}

function EHTPhotosAdminSubpageGroups ($href)
{
	global $wpdb;
	
	$action = $_REQUEST[EHT_PHOTOS_FIELD_ACTION];
	$id = $_REQUEST[EHT_PHOTOS_FIELD_ID];
	$name = $_REQUEST[EHT_PHOTOS_FIELD_NAME];
	$description = $_REQUEST[EHT_PHOTOS_FIELD_DESCRIPTION];
	switch ($action)
	{
		case EHT_PHOTOS_ACTION_CREATE:
			if ($name != "")
			{
				$sql = sprintf (EHT_PHOTOS_TABLE_GROUP_INSERT, $name, $description, $id);
				if (!($wpdb->query ($sql)))
				{
					echo "<div class=\"error\">Fail to insert: \"$sql\"</div>\n";
					$ok = false;
				}
				else
				{
        			echo "<div class=\"updated\">Group \"$name\" created</div>\n";
				}
			}
			$id = "";
			$name = "";
			$description = "";
			break;
		case EHT_PHOTOS_ACTION_UPDATE:
			if (($id != "") && ($name != "") && ($name != EHT_PHOTOS_GROUP_PUBLIC))
			{
				$sql = sprintf (EHT_PHOTOS_TABLE_GROUP_UPDATE, $name, $description, $id);
				if (!($wpdb->query ($sql)))
				{
					echo "<div class=\"error\">Fail to update: \"$sql\"</div>\n";
					$ok = false;
				}
				else
				{
        			echo "<div class=\"updated\">Group \"$name\" updated</div>\n";
				}
			}
			$id = "";
			$name = "";
			$description = "";
			break;
		case EHT_PHOTOS_ACTION_DELETE:
			if (($id != "") && ($name != "") && ($name != EHT_PHOTOS_GROUP_PUBLIC))
			{
				$sql = sprintf (EHT_PHOTOS_TABLE_GROUP_DELETE, $id);
				if (!($wpdb->query ($sql)))
				{
					echo "<div class=\"error\">Fail to delete: \"$sql\"</div>\n";
					$ok = false;
				}
				else
				{
        			echo "<div class=\"updated\">Group \"$name\" deleted</div>\n";
				}
			}
			$id = "";
			$name = "";
			$description = "";
			break;
	}

	$href .= EHT_PHOTOS_SUBPAGE_GROUPS;
	$sql = sprintf (EHT_PHOTOS_TABLE_GROUP_SELECT_ALL);
	$rows = $wpdb->get_results ($sql);
	echo "<div class=\"info\">\n" .
		 "   <b>Instructions:</b><br>\n" .
		 "   Press <img src=\"" . EHT_PHOTOS_PLUGIN_URL_BASE_IMAGES . EHT_PHOTOS_ICON_EDIT . "\"> to update a group.<br>\n" .
		 "   Press <img src=\"" . EHT_PHOTOS_PLUGIN_URL_BASE_IMAGES . EHT_PHOTOS_ICON_DELETE . "\"> to delete a group.<br>\n" .
		 "</div>\n" .
		 "<table>\n" .
		 "   <tr>\n" .
		 "      <th align=\"left\"></th>\n" .
		 "      <th align=\"left\"></th>\n" .
		 "      <th align=\"left\">ID</th>\n" .
		 "      <th align=\"left\">Name</th>\n" .
		 "      <th align=\"left\">Description</th>\n" .
		 "   </tr>\n";
	foreach ($rows as $row)
	{
		$class = ("alternate" == $class) ? "" : "alternate";
		
		echo "   <tr class=\"$class\">\n" .
			 "      <td valign=\"top\">\n";
		if ($row->name != EHT_PHOTOS_GROUP_PUBLIC)
		{
			echo "         <span onClick=\"window.location = '$href&" . EHT_PHOTOS_FIELD_ACTION . "=" . EHT_PHOTOS_ACTION_EDIT . "&" . EHT_PHOTOS_FIELD_ID . "=$row->id&" . EHT_PHOTOS_FIELD_NAME . "=$row->name&" . EHT_PHOTOS_FIELD_DESCRIPTION . "=$row->description';\" style=\"cursor: pointer;\">\n" .
				 "            <img src=\"" . EHT_PHOTOS_PLUGIN_URL_BASE_IMAGES . EHT_PHOTOS_ICON_EDIT . "\" border=\"0\" title=\"Edit the group\">\n" .
				 "         </span>\n";
		}
		echo "      </td>\n" .
			 "      <td valign=\"top\">\n";
		if ($row->name != EHT_PHOTOS_GROUP_PUBLIC)
		{
			echo "         <span onClick=\"if (confirm ('Do you really want to delete the group $row->name?')) window.location = '$href&" . EHT_PHOTOS_FIELD_ACTION . "=" . EHT_PHOTOS_ACTION_DELETE . "&" . EHT_PHOTOS_FIELD_ID . "=$row->id&" . EHT_PHOTOS_FIELD_NAME . "=$row->name';\" style=\"cursor: pointer;\">\n" .
				 "            <img src=\"" . EHT_PHOTOS_PLUGIN_URL_BASE_IMAGES . EHT_PHOTOS_ICON_DELETE . "\" border=\"0\" title=\"Delete the group\">\n" .
				 "         </span>\n";
		}
		echo "      </td>\n" .
			 "      <td valign=\"top\">$row->id</td>\n" .
			 "      <td valign=\"top\">$row->name</td>\n" .
			 "      <td valign=\"top\">$row->description</td>\n" .
			 "   </tr>\n";
	}
	echo "</table>\n";
	
	$formAction = (($action == EHT_PHOTOS_ACTION_EDIT) ? EHT_PHOTOS_ACTION_UPDATE : EHT_PHOTOS_ACTION_CREATE);
	echo "<form method=\"post\" action=\"$href\">\n" .
		 "<input type=\"hidden\" name=\"" . EHT_PHOTOS_FIELD_ACTION . "\" value=\"$formAction\">\n" .
		 "<input type=\"hidden\" name=\"" . EHT_PHOTOS_FIELD_ID . "\" value=\"$id\">\n" .
		 "<p>Group name:<br>\n" .
		 "<input type=\"text\" name=\"" . EHT_PHOTOS_FIELD_NAME . "\" value=\"$name\"></p>\n" .
		 "<p>Group description:<br>\n" .
		 "<input type=\"text\" name=\"" . EHT_PHOTOS_FIELD_DESCRIPTION . "\" value=\"$description\"></p>\n" .
		 "<p>\n" .
		 "<input type=\"submit\" name=\"" . EHT_PHOTOS_FIELD_ACTION . "\" value=\"$formAction\">\n" .
		 "</p>\n" .
		 "</form>\n";	
}

function EHTPhotosAdminSubpageUsers ($href)
{
	global $wpdb;
	
	$sql = sprintf (EHT_PHOTOS_TABLE_GROUP_SELECT_NAMES);
	$rowsGroup = $wpdb->get_results ($sql);
	$sql = sprintf (EHT_PHOTOS_TABLE_USER_SELECT_NAMES);
	$rowsUser = $wpdb->get_results ($sql);
	$matrix = array ();
	foreach ($rowsUser as $rowUser)
	{
		$matrix[$rowUser->id] = array ();
		foreach ($rowsGroup as $rowGroup)
		{
			$matrix[$rowUser->id][$rowGroup->id] = false;
		}
	}
	
	$sql = sprintf (EHT_PHOTOS_TABLE_USER_SELECT_ALL);
	$rows = $wpdb->get_results ($sql);
	foreach ($rows as $row)
	{
		$matrix[$row->idUser][$row->idGroup] = true;
	}
	
	$action = $_REQUEST[EHT_PHOTOS_FIELD_ACTION];
	switch ($action)
	{
		case EHT_PHOTOS_ACTION_UPDATE:
			$ok = true;
			foreach ($rowsUser as $rowUser)
			{
				foreach ($rowsGroup as $rowGroup)
				{
					$name = sprintf (EHT_PHOTOS_FIELD_USER, $rowUser->id, $rowGroup->id);
					$checked = isset ($_REQUEST[$name]);
					if ($checked != $matrix[$rowUser->id][$rowGroup->id])
					{
						$sql = sprintf (($checked ? EHT_PHOTOS_TABLE_USER_INSERT : EHT_PHOTOS_TABLE_USER_DELETE), $rowUser->id, $rowGroup->id);
						if (!($wpdb->query ($sql)))
						{
							$ok = false;
						}
						else
						{
							$matrix[$rowUser->id][$rowGroup->id] = $checked;
						}
					}
				}
			}
			if ($ok)
			{
        		echo "<div class=\"updated\">User asignation to groups updated</div>\n";
			}
			else
			{
        		echo "<div class=\"updated\">Fail to asignate users to groups</div>\n";
			}
			break;
	}
	
	$href .= EHT_PHOTOS_SUBPAGE_USERS;
	echo "<form method=\"post\" action=\"$href\">\n" .
		 "<table>\n" .
		 "   <tr valign=\"bottom\">\n" .
		 "      <th align=\"left\">User ID</th>\n" .
		 "      <th align=\"left\">User name</th>\n";
	foreach ($rowsGroup as $rowGroup)
	{
		echo "      <th align=\"center\">" . wordwrap ($rowGroup->name, EHT_PHOTOS_COLUMN_WRAP, "<br>", true) . "</th>\n";
	}
	echo "   </tr>\n";
	
	foreach ($rowsUser as $rowUser)
	{
		$class = ("alternate" == $class) ? "" : "alternate";
		echo "   <tr class=\"$class\">\n" .
			 "      <td align=\"center\" valign=\"top\">$rowUser->id</td>\n" .
			 "      <td valign=\"top\">$rowUser->name</td>\n";
		foreach ($rowsGroup as $rowGroup)
		{
			$value = $matrix[$rowUser->id][$rowGroup->id];
			$name = sprintf (EHT_PHOTOS_FIELD_USER, $rowUser->id, $rowGroup->id);
			echo "      <td align=\"center\"><input type=\"checkbox\" name=\"$name\"" . ($value ? " checked" : "") . "</td>\n";
		}
		echo "   </tr>\n";
	}
	echo "</table>\n" .
		 "<p>\n" .
		 "<input type=\"submit\" name=\"" . EHT_PHOTOS_FIELD_ACTION . "\" value=\"" . EHT_PHOTOS_ACTION_UPDATE . "\">\n" .
		 "</p>\n" .
		 "</form>\n";
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
	$others = array (EHT_PHOTOS_TABLE_PHOTO_CLEAN_PATH,
					 EHT_PHOTOS_TABLE_PHOTO_CLEAN_PATH,
					 EHT_PHOTOS_TABLE_PHOTO_CLEAN_PATH);
	
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
		foreach ($others as $other => $query)
		{
			$wpdb->query ($other);
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

function EHTPhotosResetPhotos ($message)
{
	global $wpdb;
	
	$ok = true;
	$message = "";
	
	$sql = sprintf (EHT_PHOTOS_TABLE_DELETE_ALL, EHT_PHOTOS_TABLE_PHOTO);
	$wpdb->query ($sql);
	
	return ($ok);
}

?>