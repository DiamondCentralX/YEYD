<?php
// YEYD - Top file
// Last updated: 30.06.2013
?>
<!doctype html>
<html>
	<head>
		<?php
		// Include head.php file
		include 'head.php';
		?>
	</head>
	<body>
		<div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-th-list"></span>
					</a>
					<a href="<?php echo $domain.'/home' . $SITE['fileext']; ?>" class="brand"><?php echo $SITE['title']; ?></a>
					<div class="nav-collapse collapse">
						<?php
						if (logged_in()) {
							?>
							<ul class="nav pull-right">
								<li class="dropdown">
									<a class="dropdown-toggle" data-toggle="dropdown" href="#">Me <?php echo (get_message_count($db, $session_user_id) != 0) ? '<b>('.get_message_count($db, $session_user_id).')</b>' : ''; ?> <i class="icon-caret-down"></i></a>
									<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
										<li><a href="/u/<?php echo $user_data['username']; ?>"><i class="icon-user"></i> My Profile</a></li>
										<li class="divider"></li>
										<li><a href="<?php echo $domain; ?>/settings<?php echo $SITE['fileext']; ?>"><i class="icon-gear"></i> Settings</a></li>
										<li><a href="<?php echo $domain; ?>/messages<?php echo $SITE['fileext']; ?>"><i class="icon-envelope"></i> Messages <?php echo (get_message_count($db, $session_user_id) != 0) ? '<b>('.get_message_count($db, $session_user_id).')</b>' : ''; ?></a></li>
										<li><a href="<?php echo $domain; ?>/post<?php echo $SITE['fileext']; ?>?write"><i class="icon-file-alt"></i> Write Post</a></li>
										<li class="divider"></li>
										<li><a href="<?php echo $domain; ?>/logout"><i class="icon-signout"></i> Sign Out</a></li>
									</ul>
								</li>
								<li><a href="<?php echo $domain; ?>/search">Search</a></li>
								<?php
								$show_apps_dropdown = false;
								foreach ($user_data as $key => $value) {
									if (!$show_apps_dropdown) {
										if (substr($key,0,4) == 'app_') {
											if ($value == 1) {
												$show_apps_dropdown = true;
											}
										}
									}
								}
								if ($show_apps_dropdown) {
									?>
									<li class="dropdown">
										<a class="dropdown-toggle" data-toggle="dropdown" href="#">Apps <i class="icon-caret-down"></i></a>
										<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
											<?php
											foreach ($user_data as $key => $value) {
											    if (substr($key, 0, 4) == "app_") {
											    	if ($value == 1) {
											    		echo '<li><a href="' . $domain . '/apps/' . str_replace('app_','',$key) . '/"> ' . ucwords(str_replace('_',' ',str_replace('app_','',$key))) . '</a></li>';
											    	}
											    }
											}
											?>
										</ul>
									</li>
									<?php
								}

								// Admin stuff
								if ($session_user_id == 1) {
									?>
									<li class="dropdown">
										<a class="dropdown-toggle" data-toggle="dropdown" href="#">Admin <i class="icon-caret-down"></i></a>
										<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
											<li><a href="<?php echo $domain; ?>/admin/"><i class="icon-dashboard"></i> Main Admin Control Panel</a></li>
											<li class="divider"></li>
											<li><a target="_blank" href="<?php echo $domain; ?>/admin/pma/">PhpMyAdmin (PMA)</a></li>
											<li class="divider"></li>
											<li><a target="_blank" href="<?php echo $domain; ?>/admin/phpinfo()<?php echo $SITE['fileext']; ?>">phpinfo()</a></li>
										</ul>
									</li>
									<?php
									}
								?>
							</ul>
							<?php
						} else {
							?>

							<form action="<?php echo $domain; ?>/login<?php echo $SITE['fileext']; ?>" method="post" class="navbar-form pull-right visible-desktop">
								<div class="input-prepend" style="margin-bottom:0;">
									<span class="add-on"><i class="icon-user"></i></span>
									<input name="username" type="text" placeholder="Username">
								</div>
								<div class="input-prepend" style="margin-bottom:0;">
									<span class="add-on"><i class="icon-key"></i></span>
									<input name="password" type="password" placeholder="Password">
								</div>
								<button type="submit" class="btn"><span class="add-on"><i class="icon-signin"></i></span> Sign in</button>
								<a class="btn" href="<?php echo $domain; ?>/register<?php echo $SITE['fileext']; ?>">Sign up</a>
							</form>
							<ul class="nav pull-right hidden-desktop">
								<li><a href="<?php echo $domain; ?>/login<?php echo $SITE['fileext']; ?>">Sign in</a></li>
								<li><a href="<?php echo $domain; ?>/register<?php echo $SITE['fileext']; ?>">Sign up</a></li>
							</ul>
							<?php
						}
						?>
					</div>
				</div>
			</div>
		</div>