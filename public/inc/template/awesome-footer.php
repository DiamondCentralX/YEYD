<div id="footer" class="visible-desktop">
	<ul id="footer_menu">
		<li class="homeButton"><a href="/"></a></li>
		
		<li>
			<a href="/u/<?php echo $user_data['username']; ?>">My Profile</a>
			
			<div class="one_column_layout">
				<div class="col_1">
					<a class="headerLinks" href="/u/<?php echo $user_data['username']; ?>">My Profile</a>
					<a class="listLinks" href="/settings<?php echo $site_fileext; ?>">Settings</a>
					<a class="listLinks" href="/messages<?php echo $site_fileext; ?>">Messages <?php echo (get_message_count($sqlite, $session_user_id) != 0) ? '<b>('.get_message_count($sqlite, $session_user_id).')</b>' : ''; ?></a>
					<a class="listLinks" href="/drive<?php echo $site_fileext; ?>">Drive</a>
					
					<a class="headerLinks">Posts</a>
					<a class="listLinks" href="/post<?php echo $site_fileext; ?>?write">Write Post</a>
				</div>
			</div>
		</li>
		
		<li>
			<a href="/search<?php echo $site_fileext; ?>">Search</a>
			
			<div class="three_column_layout" style="padding:0;">
				<div class="col_3">
					<form action="/search<?php echo $site_fileext; ?>" method="get" style="margin:10px 0 0 0;">
						<input style="width:390px;" type="text" name="q" placeholder="Search">
					</form>
				</div>
			</div>
		</li>
		
		<li>
			<a href="<?php echo $domain . '/logoquiz' . $site_fileext; ?>">LogoQuiz</a>
		</li>
		
		<!-- Other stuff -->
		
		<?php
		// Admin stuff
		if ($session_user_id == 1) {
		?>
		<li>
			<a href="/admin/">Admin</a>
			
			<div class="two_column_layout">
				<div class="col_1">
					<a class="headerLinks">DB stuff</a>
					<a class="listLinks" target="_blank" href="/admin/pma/">phpMyAdmin (PMA)</a>
					<a class="listLinks" target="_blank" href="/admin/pla/phpliteadmin.php">phpLiteAdmin (PLA)</a>
					
					<a class="headerLinks">Other stuff</a>
					<a class="listLinks" href="/admin/phpinfo()<?php echo $site_fileext; ?>">phpinfo()</a>
				</div>
				<div class="col_1">
					<h2>About</h2>
					<p>You're awesome cause you're an admin! :D You're awesome cause you're an admin! :D You're awesome cause you're an admin! :D</p>
				</div>
			</div>
		</li>
		<?php
		}
		?>
		
		<li>
			<a>Games</a>
			
			<ul class="dropup">
				<?php
				$dir = $_SERVER['DOCUMENT_ROOT'] . '/proj/part/SWFGames/swf/';
				$games = glob($dir . '*.swf');
				
				foreach ($games as $game) {
					$game = str_replace('.swf','',str_replace($dir,'',$game));
					
					echo '<li><a href="/proj/part/SWFGames/?id='.$game.'">'.$game.'</a></li>';
				}
				?>
			</ul>
		</li>
		
		<li class="right"><a href="/logout<?php echo $site_fileext; ?>">Sign out</a></li>
	</ul>
</div>