<?php
// Require init.php
require 'core/init.php';

// Set page variables
$page_title = 'post';
$page_scripts[] = '/ckeditor/ckeditor.js';

// Protect the page
protect_page();

// Include template top
include 'inc/template/top.php';
?>
<div class="container">
	<?php
	if (isset($_GET) && !empty($_GET)) {
		if (isset($_GET['view']) && !empty($_GET['view'])) {
			$post_id = (int)$_GET['view'];
			
			if (post_exists($sqlite, $post_id)) {
				$post = getPost($sqlite, $post_id);
				$owner_username = user_data($sqlite,$post['owner_id'],'username')['username'];
				?>
				<h1><?php echo $post['title']; ?></h1>
				<p>
					Written by <b><a href="<?php echo $domain; ?>/u/<?php echo $owner_username; ?>"><?php echo $owner_username; ?></a></b><br>
					<i><?php echo $post['date']; ?></i>
				</p>
				<p>
					<?php echo nl2br($post['content']); ?>
				</p>
				<?php
			} else {
				echo '<h1>An error occured ...</h1>';
				echo 'There is no post with the id of "'.$post_id.'".';
			}
		} else if (isset($_GET['write']) && empty($_GET['write'])) {
			?>
			<h1>Write Post</h1>
			<form action="?post" method="post">
				<input type="text" name="title" placeholder="title">
				<textarea style="min-width:100%;max-width:100%;min-height:400px;" id="ckeditor" name="content" placeholder="content"></textarea>
				<input class="btn btn-primary btn-large" style="width:100%;" type="submit" value="Post">
			</form>
			<p>
				<b>Note: </b> <i>All posts are public and can be view be anyone who got a profile on this site!</i>
			</p>
			<?php
		} else if (isset($_GET['post']) && empty($_GET['post'])) {
			if (isset($_POST) && !empty($_POST)) {
				$trimmed = trim($_POST['title']);
				if (empty($trimmed)) {
					$errors[] = 'The title can\'t be empty';
				}
				$trimmed = trim($_POST['content']);
				if (empty($trimmed)) {
					$errors[] = 'The post must have content';
				}
			} else {
				$errors[] = 'No data recieved.';
			}
			
			if (empty($errors)) {
				post_post($sqlite,$session_user_id,$_POST['title'],$_POST['content']);
				
				echo '<h1>Post posted!</h1>';
			} else {
				echo '<h1>We tried to post your post, but ...</h1>';
				echo output_errors($errors);
			}
		} else {
			?>
			<h1>post.php</h1>
			This is wierd ...
			<?php
		}
	} else {
		?>
		<h1>post.php</h1>
		This is wierd ...
		<?php
	}
	?>
</div>
<?php
// Include template bottom
include 'inc/template/bottom.php';
?>
<script>
	// Replace the <textarea id="editor1"> with an CKEditor instance.
	
	// You can enable this safely, but it will cause your profile to look buggy! :(
	// Trying to fix it! :D
	
	/*$(document).ready(function(){
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
	});*/
</script>