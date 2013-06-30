<?php
// Require init.php
require 'core/init.php';

// Set page variables
$page_title = 'drive';

// Drive isn't in use yet so
header('Location: docs' . $SITE['fileext']);
exit();

// Protect the page
protect_page();

if ( isset( $_GET['dl'] ) && !empty( $_GET['dl'] ) ) {
	// Download stuff ...
} else {
	// Include template top
	include 'inc/template/top.php';
	?>
	<div class="container">
		<?php
		if (isset($_GET['dir']) && !empty($_GET['dir']) ) {
			$dir = '/'.$_GET['dir'];

			if (!endsWith($dir,'/')) {
				$dir .= '/';
			}
		} else {
			$dir = '/';
		}

		if (!empty($dir)) {
			if (isset($_GET['newfolder'])) {
				?>
				<div>
					<a class="btn" href="<?php echo $domain . '/drive' . (($dir != '/') ? $dir : ''); ?>">&larr; Back</a>
				</div>
				<h1>New Folder in <?php echo $dir; ?></h1>
				<?php
				if (empty($_GET['newfolder'])) {
					?>
					<form action="" method="get">
						<input type="text" name="newfolder" placeholder="Folder name">
						<br>
						<input type="submit" value="Create Folder">
					</form>
					<?php
				} else {
					if (strlen($_GET['newfolder']) <= 1 ) {
						echo 'You folder name must be longer than 1 character.';
					} else {
						if (folder_exists($db,$session_user_id,$_GET['newfolder'],$dir)) {
							echo 'A folder with that name already exist.';
						} else {
							create_folder($db,$session_user_id,$_GET['newfolder'],$dir);
							echo 'Folder created!';
						}
					}
				}
			} else if (isset($_GET['del'])) {
				if ($_GET['del'] == 'delete') {
					del_folder($db,dir_id_from_string($db,$session_user_id,$dir));
					?>
					<div>
						<a class="btn" href="<?php echo $domain; ?>/drive">&larr; Back</a>
					</div>
					<h1>Delete Folder <?php echo $dir; ?></h1>
					Folder deleted!
					<?php
				} else {
					?>
					<div>
						<a class="btn" href="<?php echo $domain . '/drive' . (($dir != '/') ? $dir : ''); ?>">&larr; Back</a>
					</div>
					<h1>Delete Folder <?php echo $dir; ?></h1>
					<form action="" method="get">
						Write "delete" in the box below to show you are sure<br>
						<input type="text" name="del" placeholder="delete">
						<br>
						<input type="submit" value="I'm sure">
					</form>
					<?php
				}
			} else if (isset($_GET['rename'])) {
				if (!empty($_GET['rename'])) {
					rename_folder($db,dir_id_from_string($db,$session_user_id,$dir),$_GET['rename']);
					?>
					<div>
						<a class="btn" href="<?php echo $domain; ?>/drive">&larr; Back</a>
					</div>
					<h1>Rename Folder <?php echo $dir; ?></h1>
					Folder renamed!
					<?php
				} else {
					?>
					<div>
						<a class="btn" href="<?php echo $domain . '/drive' . (($dir != '/') ? $dir : ''); ?>">&larr; Back</a>
					</div>
					<h1>Rename Folder <?php echo $dir; ?></h1>
					<form action="" method="get">
						Write a name in the box below<br>
						<input type="text" name="rename" placeholder="name here">
						<br>
						<input type="submit" value="Rename">
					</form>
					<?php
				}
			} else {
				?>
				<div>
					<a class="btn" href="<?php echo $domain; ?>/drive<?php echo ($dir != '/') ? $dir : ''; ?>?newfolder">New Folder</a><a class="btn" style="width:100px;" href="<?php echo $domain.'/docs'.$SITE['fileext'].'?new&folder='.$dir; ?>">New Document</a>
					<a class="btn float-right" style="background:rgb(229,20,0);" href="<?php echo $domain; ?>/drive<?php echo ($dir != '/') ? $dir : ''; ?>?del">Delete Folder</a>
				</div>

				<h1><?php echo $dir; ?></h1>
				<?php
				//echo '<p>dir_id:'.$dir_id.'</p>';

				echo display_dir_content_as_table($db,$session_user_id,$dir);
			}
		} else {
			echo 'This is a big bug ...';
		}
		?>
	</div>
	<?php

	// Include template bottom
	include 'inc/template/bottom.php';
}
?>
