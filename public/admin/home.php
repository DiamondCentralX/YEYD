<?php
// Require init.php
require __DIR__ . '/../core/init.php';

// Set page title
$PAGE['title'] = 'home';

require __DIR__ . '/../inc/admin.php';

// Include top part of the admin template
include __DIR__ . '/../inc/template/admin/top.php';
?>
<div class="links">
	<h3>Links</h3>
	<ul>
		<li><a target="_blank" href="<?php echo $domain; ?>/admin/pma/index.php">PhpMyAdmin (PMA)</a></li>
		<li><a target="_blank" href="<?php echo $domain; ?>/admin/phpinfo()">phpinfo()</a></li>
	</ul>
	<hr>
	<h3>Privacy Index</h3>
	<ul>
		<li>0 = Public</li>
		<li>1 = Logged in users only</li>
		<li>2 = Friends only</li>
		<li>3 = Private</li>
	</ul>
</div>
<div style="min-height:400px;">
	<h3>Users</h3>
	<table>
		<tr>
			<th>id</th>
			<th>username</th>
			<th>email</th>
			<th>first name</th>
			<th>last name</th>
			<th>tools</th>
		</tr>
		<?php
		$result = $db->query("SELECT `user_id`,`username`,`email`,`first_name`,`last_name`,`is_banned` FROM `users`");
		$result->setFetchMode(PDO::FETCH_ASSOC);
		foreach ($result as $row) {
			echo '<tr>';
			echo '<td>'.$row['user_id'].'</td>';
			echo '<td><a target="_blank" href="'.$domain.'/u/'.$row['username'].'">'.$row['username'].'</a></td>';
			echo '<td>'.$row['email'].'</td>';
			echo '<td>'.$row['first_name'].'</td>';
			echo '<td>'.$row['last_name'].'</td>';
			echo '<td>';
			if ($row['is_banned'] == 0) {
				echo '<a href="do?action=ban&user='.$row['username'].'" title="ban user">Ban</a>';
			} else if ($row['is_banned'] == 1) {
				echo '<a href="do?action=pardon&user='.$row['username'].'" title="pardon user">Unban</a>';
			}
			echo '</td>';
			echo '</tr>';
		}
		?>
	</table>
</div>
<?php
// Include bottom part of the admin template
include __DIR__ . '/../inc/template/admin/bottom.php';
?>