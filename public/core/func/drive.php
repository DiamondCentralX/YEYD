<?php
$okglo = '';

function rename_folder ($conn,$dir_id,$name) {
	$dir_id = (int)$dir_id;
	$name = sanitize($name);
	
	$conn->exec("UPDATE `drive_folders` SET `name` = '$name' WHERE `folder_id` = $dir_id");
}

function del_folder ($conn,$dir_id) {
	$dir_id = (int)$dir_id;
	
	$conn->exec("DELETE FROM `drive_folders` WHERE `folder_id` = $dir_id");
	
	$result = $conn->query("SELECT `folder_id` FROM `drive_folders` WHERE `subdir_of` = $dir_id");
	
	$result->setFetchMode(PDO::FETCH_ASSOC);
	
	foreach ($result as $row) {
		del_folder($row['folder_id']);
	}
}

function folder_exists ($conn,$user_id,$name,$subdir_of) {
	$user_id = (int)$user_id;
	$name = sanitize($name);
	$subdir_of = sanitize($subdir_of);
	
	$subdir_of = dir_id_from_string($conn,$user_id,$subdir_of);
	
	$result = $conn->query("SELECT COUNT(`folder_id`) as `count` FROM `drive_folders` WHERE `owner_id` = $user_id AND `name` = '$name'");
	// Removed from query AND `subdir_of` = '$subdir_of'
	
	return ($result->fetch(PDO::FETCH_ASSOC)['count'] >= 1) ? true : false;
}

function create_folder ($conn, $user_id, $name, $subdir_of) {
	$user_id = (int)$user_id;
	$name = sanitize($name);
	$subdir_of = sanitize($subdir_of);
	
	$subdir_of = dir_id_from_string($conn,$user_id,$subdir_of);
		
	if ( !folder_exists($conn,$user_id,$name,$subdir_of) ) {
		$conn->exec("INSERT INTO `drive_folders` (`folder_id`,`name`,`owner_id`,`subdir_of`) VALUES (NULL,'$name',$user_id,$subdir_of)");
	} else {
		return false;
	}
}

function dir_name_from_id ($conn,$dir_id) {
	$dir_id = (int)$dir_id;
	
	$result = $conn->query("SELECT `name` FROM `drive_folders` WHERE `folder_id` = $dir_id");
	
	return $result->fetch(PDO::FETCH_ASSOC)['name'];
}

function display_dir_content_as_table ($conn, $user_id, $dirstr) {
	$user_id = (int)$user_id;
	$dirstr = sanitize($dirstr);
	$dir_id = dir_id_from_string($conn,$user_id,$dirstr);
	
	//echo "SELECT `name`,`subdir_of` FROM `drive_folders` WHERE `folder_id` = '$dir_id'";
	$cur_dir = $conn->query("SELECT `name`,`subdir_of` FROM `drive_folders` WHERE `folder_id` = '$dir_id'");
	$cur_dir->setFetchMode(PDO::FETCH_ASSOC);
	foreach ($cur_dir as $row) {
		$cur_dir_name = $row['name'];
		$cur_dir_subdir_of = $row['subdir_of'];
	}
	
	if (!endsWith($cur_dir_str, '/')) {
		$cur_dir_str .= '/';
	}
	
	/*if ($cur_dir_str == '') {
		$cur_dir_str = '/';
	} else {
		$cur_dir_str .= $cur_dir->fetch(PDO::FETCH_ASSOC)['name'];
	}*/
	
	$return = '<div>';
	
	// Folders
	$return .= '<table>';
	
	$result = $conn->query("SELECT `subdir_of`,`name` FROM `drive_folders` WHERE `owner_id` = $user_id AND `subdir_of` = '$dir_id' ORDER BY `name`");
	
	$result->setFetchMode(PDO::FETCH_ASSOC);
	
	//echo 's:'.$cur_dir_str;
	
	//echo '<p>t:'.substr_count($cur_dir_str, '/').'</p>';
	if ($dirstr != '/') {
		if (substr_count($dirstr, '/') == 2) {
			$return .= '<td><a class="btn" style="width:100px;" href="'.$domain.'/drive">../</a></td>';
		} else {
			$return .= '<td><a class="btn" style="width:100px;" href="'.$domain.'/drive'.$dirstr.'../">../</a></td>';
		}
	} else {
		$cur_dir_str = '/';
	}
	//echo 's:'.$cur_dir_str;
	
	foreach ($result as $row) {
		$return .= '<tr>';
		$return .= '<td><a href="'.$domain.'/drive'.$dirstr.$row['name'].'">' . $row['name'] . '</a></td>';
		$return .= '</tr>';
	}
	
	$return .= '</table>';
	
	// Docs
	$return .= display_docs_as_table($conn,$user_id,"AND `folder` = '$dir_id'");
	
	// Files
	$return .= '<table>';
	
	
	
	$return .= '</table>';
	
	$return .= '</div>';
	return $return;
}

function dir_id_from_string ($conn,$user_id,$dirstr) {
	// Sanitize the parsed variables for security
	$user_id = (int)$user_id;
	$dirstr = sanitize($dirstr);
	
	//echo '$dirstr:'.$dirstr.'<br>';
	
	// Check if the dir is not "/"
	if ($dirstr != '/') {
		// Remove "/" in the dir string
		$dirarray = explode('/',$dirstr);
		//print_r($dirarray);
		
		// Remove empty elements from array
		for ($x = 0; $x <= count($dirarray); $x++) {
			if ($dirarray[$x] == '') {
				unset($dirarray[$x]);
			}
		}
		
		// Get the name of the current dir
		$dirname = $dirarray[count($dirarray)];
		//echo '<br>$dirname:'.$dirname.'<br>';
		//print_r($dirarray);
		
		$dirstr = '/'.str_replace($dirname,'',implode('/',$dirarray));
		//echo '<br>D:'.$dirstr.'<br>';
		
		//$return = dir_id_from_string($conn,$user_id,$dirstr);
		//echo '$return = ' . $return;
		
		$result = $conn->query("SELECT `folder_id` FROM `drive_folders` WHERE `name` = '$dirname' AND `owner_id` = $user_id");
		// ADD SUBDIR_OF CHECK
		return $result->fetch(PDO::FETCH_ASSOC)['folder_id'];
	} else {
		// Return "/" if the dir is "/"
		return $dirstr;
	}
	
	/*echo '<p>tp<br>';
	
	if ($dirstr != '/') {
		$dirstr = explode('/',$dirstr);
		
		print_r($dirstr);
		
		unset($dirstr[count($dirstr)-1]);
		
		print_r($dirstr);
		
		$subdir_of = $conn->query("SELECT `folder_id` FROM `drive_folders` WHERE `subdir_of` = '".$dirstr[count($dirstr)-1]."'");
		
		echo $dirname;
		
		unset($dirstr[count($dirstr)-1]);
		
		$dirstr = implode('/',$dirstr);
		
		echo $dirstr;
		
		$dirstr .= '/';
		
		echo "SELECT folder_id FROM drive_folders WHERE owner_id = $user_id AND subdir_of = '$subdir_of' AND name = '$dirname'";
		$result = $conn->query("SELECT folder_id FROM drive_folders WHERE owner_id = $user_id AND subdir_of = '$subdir_of' AND name = '$dirname'");
		
		echo $result->fetch(PDO::FETCH_ASSOC)['folder_id'];
		
		return $result->fetch(PDO::FETCH_ASSOC)['folder_id'];
	} else {
		return $dirstr;
	}
	
	echo '</p>';*/
}
?>