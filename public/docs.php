<?php
// php-site - Docs
// Last update: 12.07.2013

// Require init.php
require 'core/init.php';

// Set page variables
$PAGE['title']		= 'docs';
$PAGE['scripts'][]	= '/ckeditor/ckeditor.js';

// Protect the page
protect_page();

if ( isset( $_GET['dl'] ) && !empty( $_GET['dl'] ) ) {
	if ( doc_owner( $db, $_GET['dl'] ) == $session_user_id ) {
		$doc_info = doc_info( $db, $_GET['dl'] );

		echo '<!doctype html><html><head><title>'.$doc_info['title'].'</title><style>';
		echo readfile('css/docs.css');
		echo '</style></head><body class="doc-content" style="border:none;">'.$doc_info['content'] . '</body></html>';

		header("Content-Disposition: attachment; filename=\"" . $doc_info['title'] . ".html\"");
		header("Content-Type: application/force-download");
		header("Content-Length: " . mb_strlen($doc_info['content']));
		header("Connection: close");
	} else {
		echo 'Error: You don\'t own that document!';
	}
} else {
	// Include template top
	include 'inc/template/top.php';
	?>
	<div class="container">
		<?php
		// Check if a document should be opened for edit
		if ( isset( $_GET['edit'] ) && !empty( $_GET['edit'] ) ) {
			if ( doc_owner( $db, $_GET['edit'] ) ==  $session_user_id ) {
				$doc_info = doc_info( $db, $_GET['edit'] );
				?>
				<div class="navbar" style="margin-top:10px;">
					<div class="navbar-inner">
						<ul class="nav">
							<li><a href="docs<?php echo $SITE['fileext']; ?>"><i class="icon-arrow-left"></i> Back</a></li>
							<li><a href="?view=<?php echo $_GET['edit']; ?>">View</a></li>
							<li><a href="?del=<?php echo $_GET['edit']; ?>">Delete Document</a></li>
						</ul>
					</div>
				</div>
				<div class="doc-edit">
					<form action="?save=<?php echo $_GET['edit']; ?>" method="post">
						<input type="text" name="title" value="<?php echo $doc_info['title']; ?>">
						<textarea style="min-width:100%;max-width:100%;min-height:250px;" id="ckeditor" name="content"><?php echo $doc_info['content']; ?></textarea>
						<input class="btn btn-primary btn-large" type="submit" value="Save" style="width:100%;margin-top:10px;">
					</form>
				</div>
				<?php
			} else {
				echo 'Error: You don\'t own that document!';
			}
		// Check if a document should be viewed
		} else if ( isset( $_GET['view'] ) && !empty( $_GET['view'] ) ) {
			if ( doc_owner( $db, $_GET['view'] ) ==  $session_user_id ) {
				?>
				<div class="navbar" style="margin-top:10px;">
					<div class="navbar-inner">
						<ul class="nav">
							<li><a href="docs<?php echo $SITE['fileext']; ?>"><i class="icon-arrow-left"></i> Back</a></li>
							<li><a href="?edit=<?php echo $_GET['view']; ?>">Edit</a></li>
							<li><a href="?dl=<?php echo $_GET['view']; ?>">Download</a></li>
							<li><a href="?del=<?php echo $_GET['view']; ?>">Delete Document</a></li>
						</ul>
					</div>
				</div>
				<?php
				echo view_doc( $db, $_GET['view'] );
			} else {
				echo 'Error: You don\'t own that document!';
			}
		} else if ( isset( $_GET['save'] ) && !empty( $_GET['save'] ) ) {
			if ( doc_owner( $db, $_GET['save'] ) ==  $session_user_id ) {
				doc_save( $db, $_GET['save'], $_POST['title'], $_POST['content'] );
				?>
				<div class="navbar" style="margin-top:10px;">
					<div class="navbar-inner">
						<ul class="nav">
							<li><a href="docs<?php echo $SITE['fileext']; ?>"><i class="icon-arrow-left"></i> Back</a></li>
							<li><a href="?view=<?php echo $_GET['save']; ?>">View</a></li>
							<li><a href="?edit=<?php echo $_GET['save']; ?>">Edit</a></li>
						</ul>
					</div>
				</div>
				Your document have been saved
				<?php
			} else {
				echo 'Error: You don\'t own that document!';
			}
		} else if ( isset( $_GET['del'] ) && !empty( $_GET['del'] ) ) {
			if ( doc_owner( $db, $_GET['del'] ) ==  $session_user_id ) {
				?>
				<div class="navbar" style="margin-top:10px;">
					<div class="navbar-inner">
						<ul class="nav">
							<li><a href="docs<?php echo $SITE['fileext']; ?>"><i class="icon-arrow-left"></i> Back</a></li>
						</ul>
					</div>
				</div>
				<?php
				$cont = true;
				if ( isset($_POST['im_sure']) ) {
					$cont = true;
					if ( $_POST['im_sure'] == 'delete' ) {
						doc_del( $db, $_GET['del'] );
						echo 'Document deleted';
						$cont = false;
					} else {
						echo 'You weren\'t sure!';
						$cont = true;
					}
				}
				if ($cont) {
					?>
					<form action="?del=<?php echo $_GET['del']; ?>" method="post">
						Write "delete" in the box below to show that you're sure<br>
						<input type="text" name="im_sure" placeholder="delete">
						<br>
						<input type="submit" value="I'm sure">
					</form>
					<?php
				}
			} else {
				echo 'Error: You don\'t own that document!';
			}
		} else if ( isset($_GET['new']) && empty( $_GET['new'] ) ) {
			/*if (isset($_GET['folder']) && !empty($_GET['folder'])) {
				$folder = $_GET['folder'];
			} else {
				$folder = '/';
			}
			//if (folder_exists($db,$session_user_id,$_GET['folder'])) {
				doc_new( $db, $session_user_id, $folder );
			//} else {
			//	echo 'Folder does not exist.';
			//}*/
			doc_new($db,$session_user_id);
			?>
			<div class="navbar" style="margin-top:10px;">
				<div class="navbar-inner">
					<ul class="nav">
						<li><a href="docs<?php echo $SITE['fileext']; ?>"><i class="icon-arrow-left"></i> Back</a></li>
					</ul>
				</div>
			</div>
			Document successfully created :)
			<?php
		} else if ( isset($_GET['q']) && !empty( $_GET['q'] ) ) {
			?>
			<div class="navbar" style="margin-top:10px;">
				<div class="navbar-inner">
					<ul class="nav">
						<li><a href="docs<?php echo $SITE['fileext']; ?>"><i class="icon-arrow-left"></i> Back</a></li>
						<li><a href="?new">New</a></li>
					</ul>
				</div>
			</div>
			<?php
			/*
				Comment out the little html section above if you want to enable drive not just docs :D
			*/
			$q = $_GET['q'];
			echo '<h1>Docs matching "'.$q.'"</h1>';
			echo display_docs_as_table($db,$session_user_id,"AND `title` LIKE '%$q%'");
		} else {
			?>
			<div class="navbar" style="margin-top:10px;">
				<div class="navbar-inner">
					<ul class="nav">
						<li><a href="?new">New</a></li>
					</ul>
				</div>
			</div>
			<h1>My Docs</h1>
			<form action="" method="get">
				<input style="width:100%;" type="text" name="q" placeholder="Search Docs">
			</form>
			<?php
			echo display_docs_as_table($db, $session_user_id, '');
			/*	Uncomment and comment the small section above to enable drive
			header('Location: drive'.$SITE['fileext']);
			exit();
			*/
		}
		?>
	</div>
	<?php

	// Include template bottom
	include 'inc/template/bottom.php';

	?>
	<script>
		// Replace the <textarea id="editor1"> with an CKEditor instance.
		$(document).ready(function(){
			CKEDITOR.replace( 'ckeditor', {
				on: {
					// Check for availability of corresponding plugins.
					pluginsLoaded: function( evt ) {
						var doc = CKEDITOR.document, ed = evt.editor;
						if ( !ed.getCommand( 'bold' ) )
							doc.getById( 'exec-bold' ).hide();
						if ( !ed.getCommand( 'link' ) )
							doc.getById( 'exec-link' ).hide();

					}
				}
			});
		});
	</script>
	<?php
}
?>