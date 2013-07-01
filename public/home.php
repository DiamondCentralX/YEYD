<?php
// YEYD - Home
// Last updated: 01.07.2013

// Require init.php
require 'core/init.php';

// Set page variables
$PAGE['title'] = 'home';

// Include template top
include 'inc/template/top.php';
?>
<div style="border-radius:0;" class="hero-unit">
	<div class="container">
		<img style="float:right;height:163px;" src="<?php echo $SITE['hpimg']; ?>">
		<h1><?php echo $SITE['title']; ?></h1>
		<p>
		<?php echo $SITE['desc']; ?>
		</p>
		<p>
			<?php
			if (logged_in()) {
				?>
				<a class="btn btn-primary btn-large" href="<?php echo $domain . '/u/' . $user_data['username']; ?>">My Profile</a>
				<?php
			} else {
				?>
				<a class="btn btn-primary btn-large" href="<?php echo $domain.'/register' . $SITE['fileext']; ?>">Sign up</a> or <a class="btn btn-primary btn-large" href="<?php echo $domain.'/login'.$SITE['fileext']; ?>">Sign in</a>
				<?php
			}
			?>
		</p>
	</div>
</div>

<div class="container">
	<div class="well"><h4><?php echo $SITE['hptt']; ?></h4><?php echo nl2br($SITE['hptc']); ?></div>
</div>
<?php
// Include template bottom
include 'inc/template/bottom.php';
?>