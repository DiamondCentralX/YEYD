		<div class="container">
			<hr>
			<div>
				Powered by <?php echo '<a target="_blank" href="' . $PROJECT['web'] . '">' . $PROJECT['title'] . ' v' . $PROJECT['version'] . '</a>'; ?>
				<span class="pull-right" id="footer-more-btn"><i class="icon-expand-alt"></i></span>
			</div>
			<br>
			<div style="display:none;" id="footer-more" class="well">
				<div class="row-fluid">
					<div class="span4">
						<ul class="nav nav-list">
							<li class="nav-header">Cool stuff used</li>
							<li><a target="_blank" href="http://jquery.com/">jQuery</a></li>
							<li><a target="_blank" href="http://twitter.github.io/bootstrap/">Twitter Bootstrap</a></li>
						</ul>
					</div>
					<div class="span4">
						<ul class="nav nav-list">
							<li class="nav-header">More cool stuff used</li>
							<li><a target="_blank" href="http://ckeditor.com/">CKEditor</a></li>
							<li><a target="_blank" href="http://www.phpmyadmin.net/">PhpMyAdmin (PMA)</a></li>
						</ul>
					</div>
					<div class="span4">
						<ul class="nav nav-list">
							<li class="nav-header">Even more cool stuff used!</li>
							<li><a target="_blank" href="http://fortawesome.github.io/Font-Awesome/">Font Awesome</a></li>
							<li>My brain ...</li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<?php
		// Awesome-footer :D
		/*if (logged_in()) {
			if ($user_data['footer_style'] != 'disabled') {
				include 'awesome-footer.php';
			}
		}*/

		// Include footer.php file
		include 'footer.php';
		?>
	</body>
</html>