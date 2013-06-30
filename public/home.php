<?php
// php-site - Home
// Last updated: 28.06.2013

// Require init.php
require 'core/init.php';

// Set page variables
$PAGE['title'] = 'home';

// Include template top
include 'inc/template/top.php';
?>
<div class="hero-unit">
	<div class="container">
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
	<div class="row-fluid">
		<div class="span4">
			<h4>Total Users</h4>
			<p><?php //echo get_amount_of_users($db); ?></p>
		</div>
		<div class="span4">
			<h4>Total clicks</h4>
			<p><?php //echo get_amount_of_clicks($db); ?></p>
		</div>
		<div class="span4">
			<h4>Average clicks</h4>
			<p><?php //echo get_average_clicks_per_user($db); ?></p>
		</div>
	</div>
	<div class="well"><h4>Cupcake Ipsum</h4>Candy cupcake tiramisu applicake. Sweet pudding souffle applicake cookie chocolate marshmallow apple pie. Halvah croissant candy. Marshmallow jujubes bear claw halvah topping. Tiramisu macaroon topping dragee sweet roll sesame snaps oat cake. Marzipan muffin brownie biscuit topping chupa chups powder. Jelly candy canes carrot cake. Tiramisu cake danish. Danish wypas dragee dragee caramels macaroon jelly-o jelly-o. Sweet lemon drops gummi bears applicake. Gummi bears carrot cake chocolate bar. Tiramisu cake apple pie cookie wafer pastry wypas jelly chupa chups. Cotton candy toffee lemon drops chocolate cake liquorice liquorice topping faworki.</div>
	<blockquote>
		<p>Be nice to nerds. Chances are you'll end up working for one.</p>
		<small>Bill Gates</small>
	</blockquote>
	<blockquote class="pull-right">
		<p>If you can't make it good, at least make it look good.</p>
		<small>Bill Gates</small>
	</blockquote>
	<br><br>
	<blockquote>
		<p>I'm a geek.</p>
		<small>Bill Gates</small>
	</blockquote>
</div>
<?php
// Include template bottom
include 'inc/template/bottom.php';
?>