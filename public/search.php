<?php
// php-site - Search
// Last updated: 13.06.2013

// Require init.php
require 'core/init.php';

protect_page();

// Set page title
$PAGE['title'] = 'Search';

// Include template top
include 'inc/template/top.php';
?>
<div class="container">
	<!--<div style="position:fixed;">
		<a class="btn" href="#docs">My Docs</a><a class="btn" href="#messages">Messages</a><a class="btn" href="#users">Users</a>
	</div>
	<br>-->
	<h1>Search</h1>
	<form action="" method="get">
		<input style="width:100%;" type="text" name="q" placeholder="Search for something :D" <?php echo (isset($_GET['q']) && !empty($_GET['q'])) ? 'value="'.$_GET['q'].'"' : ''; ?>>
	</form>
	<?php
	if (isset($_GET['q']) && !empty($_GET['q'])) {
		echo '<p>You searched for <b>"'.$_GET['q'].'"</b></p>';

		// Documents
		echo '<h2 id="docs">My Docs</h2>';
		echo  display_docs_as_table($db,$session_user_id,"AND `title` LIKE '%".$_GET['q']."%'");

		// Users
		$user_results = searchUsersQuery($db,$_GET['q']);
		echo '<h2 id="users">Users</h2>';
		echo '<table class="table">';
		echo '<tr><th>Username</th><th>Name</th><th></th></tr>';
		foreach ($user_results as $row) {
			?>
			<tr>
				<td>
					<?php echo $row['username']; ?>
				</td>
				<td>
					<?php echo $row['first_name'] . ' ' . $row['last_name']; ?>
				</td>
				<td>
					<a class="btn" href="<?php echo $domain . '/u/' . $row['username']; ?>">View</a>
					<a class="btn" href="<?php echo $domain . '/messages?send&to=' . $row['username']; ?>">Send Message</a>
				</td>
			</tr>
			<?php
		}
		echo '</table>';

		// Messages
		echo '<h2 id="messages">Messages</h2>';
		echo display_messages_as_table($db,$session_user_id,"AND `title` LIKE '%".$_GET['q']."%'");
	}
	?>
</div>
<?php
// Include template bottom
include 'inc/template/bottom.php';
?>