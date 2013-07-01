<?php
// YEYD - Profile page
// Last updated: 01.07.2013

// Require init.php
require 'core/init.php';

$PAGE['scripts'][] = '/js/chart.min.js';

if (user_exists($db, $_GET['u'])) {
	// Get profile data
	$profile_id = user_id_from_username($db, $_GET['u']);
	$profile_data = get_all_user_data($db, $profile_id);

	// Set page variables
	$PAGE['title'] = $profile_data['first_name'];

	// Include template top
	include 'inc/template/top.php';
	echo '<div class="container">';

	echo '<h1>'.$profile_data['first_name'].'\'s profile</h1>';

	if ($profile_data['is_banned'] == 1) {
		echo 'This user is banned!';
	} else {
		if (logged_in()) {
			// Check if you should do anything special
			if ($profile_id == $session_user_id) {
				if (isset($_GET['poststatus']) && empty($_GET['poststatus'])) {
					if (!empty($_POST['status'])) {
						post_status($db,$session_user_id,$_POST['status']);
						echo 'Status posted!';
					} else {
						echo 'No data recieved.';
					}
				}
			}

			if ($profile_data['profile_privacy'] == 2 /* Add more friend stuff here ... */) {
				// Add friend stuff here ... :D
				$errors[] = 'This profile is friends only ...';
			} else if ($profile_data['profile_privacy'] == 3) {
				$errors[] = 'This profile is private';
			}
			if ($session_user_id == $profile_id) {
				$errors = array();
			}
		} else if ($profile_data['profile_privacy'] == 1 || $profile_data['profile_privacy'] == 2 || $profile_data['profile_privacy'] == 2) {
			protect_page();
		}
		if (empty($errors)) {
			?>
			<p>
				<?php
				if (file_exists('img/profile/' . $profile_data['username'] . '.png')) {
					echo '<img style="float:left;" src="'.$domain.'/img/getProfileImg.php?u='.$profile_data['username'].'" title="Profile Image">';
				} else {
					echo '<img style="float:left;" src="'.$domain.'/img/getProfileImg.php?u=default" title="Profile Image">';
				}
				if (!empty($profile_data['website'])) {
					echo '<a target="_blank" href="'.$profile_data['website'].'"><span title="'.$profile_data['website'].'" class="icons profile web"></span></a>';
				}
				if (!empty($profile_data['google+'])) {
					echo '<a target="_blank" href="https://plus.google.com/'.$profile_data['google+'].'/"><span title="'.$profile_data['google+'].'" class="icons profile google-plus"></span></a>';
				}
				if (!empty($profile_data['email'])) {
					echo '<a href="mailto:'.$profile_data['email'].'"><span title="'.$profile_data['email'].'" class="icons profile email"></span></a>';
				}
				if (!empty($profile_data['youtube'])) {
					echo '<a target="_blank" href="https://youtube.com/'.$profile_data['youtube'].'/"><span title="'.$profile_data['youtube'].'" class="icons profile youtube"></span></a>';
				}
				if (!empty($profile_data['facebook'])) {
					echo '<a target="_blank" href="https://facebook.com/'.$profile_data['facebook'].'/"><span title="'.$profile_data['facebook'].'" class="icons profile facebook"></span></a>';
				}
				if (!empty($profile_data['twitter'])) {
					echo '<a target="_blank" href="https://twitter.com/'.$profile_date['twitter'].'/"><span title="'.$profile_data['twitter'].'" class="icons profile twitter"></span></a>';
				}
				if (!empty($profile_data['skype'])) {
					echo '<a href="skype:'.$profile_data['skype'].'"><span title="'.$profile_data['skype'].'" class="icons profile skype"></span></a>';
				}
				if (!empty($profile_data['steam'])) {
					echo '<a target="_blank" href="http://steamcommunity.com/id/'.$profile_data['steam'].'/"><span title="'.$profile_data['steam'].'" class="icons profile steam"></span></a>';
				}
				if (!empty($profile_data['minecraft'])) {
					echo '<span title="'.$profile_data['minecraft'].'" class="icons profile minecraft"></span>';
				}
				?>
			</p>
			<div>
				<a class="btn btn-large" href="<?php echo $domain . '/messages?send&to=' . $profile_data['username']; ?>">Send Message</a>
			</div>
			<div class="row-fluid">
				<div class="span4">
					<h2>About</h2>
					<p>
						<?php echo nl2br($profile_data['about']); ?>
					</p>
					<p>
						<table class="table">
							<tr>
								<th>
									Full Name
								</th>
								<td>
									<?php echo $profile_data['first_name'] . ' ' . $profile_data['last_name']; ?>
								</td>
							</tr>
							<tr>
								<th>
									Gender
								</th>
								<td>
									<a title="Search this gender" href="<?php echo $domain . '/search' . $SITE['fileext'] . '?gender=' . $profile_data['gender']; ?>"><?php echo $profile_data['gender']; ?></a>
								</td>
							</tr>
							<tr>
								<th>
									Species
								</th>
								<td>
									<a title="Search this species" href="<?php echo $domain . '/search' . $SITE['fileext'] . '?species=' . $profile_data['species']; ?>"><?php echo $profile_data['species']; ?>
								</td>
							</tr>
							<tr>
								<th>
									Clicks
								</th>
								<td <?php echo (logged_in()) ? (($profile_id == $session_user_id) ? 'class="clicks"' : '') : ''; ?>>
									<?php echo get_user_clicks($db,$profile_id); ?>
								</td>
							</tr>
							<tr>
								<th>
									Address
								</th>
								<td>
									<?php echo $profile_data['address']; ?>
								</td>
							</tr>
							<tr>
								<th>
									Job
								</th>
								<td>
									<?php echo $profile_data['job']; ?>
								</td>
							</tr>
							<?php
							if ($profile_data['app_logoquiz'] == 1) {
								?>
								<tr>
									<th>
										<a href="<?php echo $domain . '/logoquiz' . $SITE['fileext']; ?>">Logoquiz</a> score
									</th>
									<td>
										<?php echo getLogoQuizScore($db,$profile_id) . ' of ' . getLogoAmount($db); ?>
									</td>
								</tr>
								<?php
							}
							?>
						</table>
					</p>
					<h2>Clicks</h2>
					<canvas style="background:#fff;" id="clicksChart" width="240" height="240"></canvas>
				</div>
				<div class="span4">
					<h2>Posts</h2>
					<?php
					if (logged_in()) {
						if ($profile_id == $session_user_id) {
							?>
							<div>
								<a class="btn" href="<?php echo $domain .'/post'. $SITE['fileext']; ?>?write">Write Post</a>
							</div>
							<?php
						}
					}

					echo get_latest_posts($db,$profile_id,10);
					?>
				</div>
				<div class="span4">
					<h2>Status</h2>
					<?php
					if (logged_in()) {
						if ($profile_id == $session_user_id) {
							?>
							<div>
								<form action="?poststatus" method="post">
									<textarea style="min-width:100%;max-width:100%;min-height:50px;max-height:150px;" name="status" placeholder="Write status here" maxlength="200"></textarea>
									<br>
									<input class="btn" type="submit" value="Post Status"><span class="pull-right">Max 200 characters</span>
								</form>
							</div>
							<?php
						}
					}

					echo display_states_as_ul($db,"owner_id = $profile_id");
					?>
				</div>
				<div class="profile-content-footer"></div>
			</div>
			<?php
		} else {
			echo output_errors($errors);
		}
	}
} else {
	// Set page variables
	$page_title = 'error';

	// Include template top
	include 'inc/template/top.php';

	?>
	The user "<?php echo $_GET['u'] ?>" doesn't exist.
	<?php
}
echo '</div>';				// End "container" div

// Include template bottom
include 'inc/template/bottom.php';

$results = array(
	1	=>	array(
				'date'	=>	'\''.date('j-n-Y').'\',',
				'clicks'=>	$db->query("SELECT COUNT(`click_id`) as `clicks` FROM `clicks` WHERE `user_id` = $profile_id AND `date` = '".date('d-m-Y')."'")->fetch(PDO::FETCH_ASSOC)['clicks'].','
			),
	2	=>	array(
				'date'	=>	'\''.date('j-n-Y', time() - 60 * 60 * 24).'\',',
				'clicks'=>	$db->query("SELECT COUNT(`click_id`) as `clicks` FROM `clicks` WHERE `user_id` = $profile_id AND `date` = '".date('d-m-Y', time() - 60 * 60 * 24)."'")->fetch(PDO::FETCH_ASSOC)['clicks'].','
			),
	3	=>	array(
				'date'	=>	'\''.date('j-n-Y', time() - 60 * 60 * 24 * 2).'\',',
				'clicks'=>	$db->query("SELECT COUNT(`click_id`) as `clicks` FROM `clicks` WHERE `user_id` = $profile_id AND `date` = '".date('d-m-Y', time() - 60 * 60 * 24 * 2)."'")->fetch(PDO::FETCH_ASSOC)['clicks'].','
			),
	4	=>	array(
				'date'	=>	'\''.date('j-n-Y', time() - 60 * 60 * 24 * 3).'\',',
				'clicks'=>	$db->query("SELECT COUNT(`click_id`) as `clicks` FROM `clicks` WHERE `user_id` = $profile_id AND `date` = '".date('d-m-Y', time() - 60 * 60 * 24 * 3)."'")->fetch(PDO::FETCH_ASSOC)['clicks'].','
			),
	5	=>	array(
				'date'	=>	'\''.date('j-n-Y', time() - 60 * 60 * 24 * 4).'\',',
				'clicks'=>	$db->query("SELECT COUNT(`click_id`) as `clicks` FROM `clicks` WHERE `user_id` = $profile_id AND `date` = '".date('d-m-Y', time() - 60 * 60 * 24 * 4)."'")->fetch(PDO::FETCH_ASSOC)['clicks']
			)
);
?>
<script>
	var data = {
		labels:[<?php foreach($results as $result) echo $result['date']; ?>],
		datasets:[
			{
				fillColor : "rgba(27,161,226,0.2)",
				strokeColor : "rgba(27,161,226,1)",
				pointColor : "rgba(27,161,226,1)",
				pointStrokeColor : "#fff",
				data : [<?php foreach($results as $result)echo $result['clicks']; ?>]
			}
		]
	}

	var ctx = document.getElementById('clicksChart').getContext('2d');
	var myNewChart = new Chart(ctx).Line(data);
</script>