<?php 
	if ($_SESSION['user']['valid'] == 'true') {
		if (!isset($action)) { $action = 1; }
		print '
		<h1>Editor</h1>
		<div id="editor">
			<ul>
				<li><a href="index.php?menu=10&amp;action=1">News</a></li>
			</ul>';
			
			if ($action == 1) { include("urednik/news.php"); }
			
			
		print '
		</div>';
	}
	else {
		$_SESSION['message'] = '<p>Please register or login using your credentials!</p>';
		header("Location: index.php?menu=6");
	}
?>