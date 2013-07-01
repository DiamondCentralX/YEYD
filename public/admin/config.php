<?php
// Require init.php
require __DIR__ . '/../core/init.php';

// Set page title
$PAGE['title'] = 'config';

require __DIR__ . '/../inc/admin.php';

// Include top part of the admin template
include __DIR__ . '/../inc/template/admin/top.php';

if (isset($_POST) && !empty($_POST)) {
	$update_data = array(
		'title'			=>	$_POST['title'],
		'desc'			=>	$_POST['desc'],
		'keywords'		=>	$_POST['keywords'],
		'author'		=>	$_POST['author'],
		'hptt'			=>	$_POST['hptt'],
		'hptc'			=>	$_POST['hptc'],
		'hpimg'			=>	$_POST['hpimg']
	);
	
	foreach($update_data as $thingy=>$value) {
		$db->exec("UPDATE `site` SET `value` = '$value' WHERE `thingy` = '$thingy'");
	}
	
	header('Location: ?success');
}
?>
<div style="margin:10px 0;">
	<?php
	if (isset($_GET['success']) && empty($_GET['success'])) {
		echo '<span style="padding:5px 10px;border:1px solid #118C2A;background:#57EB74;">Successfully updated the site config! :D</span>';
	}
	?>
	<form action="" method="post">
		<p>
			Title<br>
			<input type="text" name="title" value="<?php echo $SITE['title']; ?>">
		</p>
		<p>
			Description<br>
			<input style="width:500px;" type="text" name="desc" value="<?php echo $SITE['desc']; ?>">
		</p>
		<p>
			Keywords<br>
			<input style="width:500px;" type="text" name="keywords" value="<?php echo $SITE['keywords']; ?>">
		</p>
		<p>
			Author<br>
			<input type="text" name="author" value="<?php echo $SITE['author']; ?>">
		</p>
		<p>
			Home page text title<br>
			<input type="text" name="hptt" value="<?php echo $SITE['hptt']; ?>">
		</p>
		<p>
			Home page text content<br>
			<textarea style="width:800px;height:100px;" name="hptc"><?php echo $SITE['hptc']; ?></textarea>
		</p>
		<p>
			Home page image<br>
			<input type="text" name="hpimg" value="<?php echo $SITE['hpimg']; ?>">
		</p>
		<p>
			<input style="background:#3d88c7;padding:5px 10px;color:#fff;border:0;" type="submit" value="Update config!">
		</p>
	</form>
</div>
<?php
// Include bottom part of the admin template
include __DIR__ . '/../inc/template/admin/bottom.php';
?>