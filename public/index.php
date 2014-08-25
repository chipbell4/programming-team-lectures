<!doctype html>
<html lang="en">

	<head>
		<meta charset="utf-8">

		<title>Binary Bears Lectures</title>

		<meta name="description" content="Mercer Binary Bears Programming Team Lectures">
		<meta name="author" content="Chip Bell">

		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />

		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<link rel="stylesheet" href="css/reveal.min.css">
		<link rel="stylesheet" href="css/theme/sky.css" id="theme">

		<!-- For syntax highlighting -->
		<link rel="stylesheet" href="lib/css/zenburn.css">

		<!-- If the query includes 'print-pdf', use the PDF print sheet -->
		<script>
			document.write( '<link rel="stylesheet" href="css/print/' + ( window.location.search.match( /print-pdf/gi ) ? 'pdf' : 'paper' ) + '.css" type="text/css" media="print">' );
		</script>

		<!--[if lt IE 9]>
		<script src="lib/js/html5shiv.js"></script>
		<![endif]-->
	</head>

	<body>

		<div class="reveal">
			<div class="slides">
<?php
/*
 * See if a lecture was provided
 */

if(! isset($_GET['lecture'])) {
	$base_url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	$files = array();
	exec('ls lectures', $files);
	$files = array_map(function($elem) {
		$query_param = str_replace('.html', '', $elem);
		list($year, $month, $day) = explode('-', $query_param);
		return array($query_param, "$month/$day/$year");
	}, $files);
?>
<section>
	<h2>Programming Team Lectures</h2>
	<p>
		Hello! Here are our past lectures:
	</p>
	<ul>
<?php
	foreach($files as $index => $entry) {
		list($query_param, $pretty_date) = $entry;
		echo "<li><a href='$base_url?lecture=$query_param'>$pretty_date</a></li>\n";
	}
?>
	</ul>
</section>
<?php
}

// they provided a lecture, but the format is wrong
else if(! preg_match('/\d\d\d\d-\d\d-\d\d/', $_GET['lecture'])) {
?>
	<section>
		<h2>Programming Team Lectures</h2>
		<p>
			Nice try! <?php echo $_GET['lecture']; ?> doesn't really look like a
			date does it? Remember, <code>yyyy-mm-dd</code> is the format to use (a date
			essentially).
		</p>
	</section>
<?php
}

// they matched the format
else {
	// check that they file exists
	$file_name = 'lectures/' . $_GET['lecture'] . '.html';
	if(file_exists($file_name)) {
		require $file_name;
	}
	else {
?>
		<section>
			<h2>Programming Team Lectures</h2>
			<p>
				Sorry, but there's not a lecture for <?php echo $_GET['lecture']; ?>.
			</p>
		</section>
<?php		
	}
}

?>
			</div>
		</div>

		<script src="lib/js/head.min.js"></script>
		<script src="js/reveal.min.js"></script>

		<script>

			// Full list of configuration options available here:
			// https://github.com/hakimel/reveal.js#configuration
			Reveal.initialize({
				controls: true,
				progress: true,
				history: true,
				center: true,

				//theme: Reveal.getQueryHash().theme, // available themes are in /css/theme
				transition: Reveal.getQueryHash().transition || 'default', // default/cube/page/concave/zoom/linear/fade/none

				// Optional libraries used to extend on reveal.js
				dependencies: [
					{ src: 'lib/js/classList.js', condition: function() { return !document.body.classList; } },
					{ src: 'plugin/markdown/marked.js', condition: function() { return !!document.querySelector( '[data-markdown]' ); } },
					{ src: 'plugin/markdown/markdown.js', condition: function() { return !!document.querySelector( '[data-markdown]' ); } },
					{ src: 'plugin/highlight/highlight.js', async: true, callback: function() { hljs.initHighlightingOnLoad(); } },
					{ src: 'plugin/zoom-js/zoom.js', async: true, condition: function() { return !!document.body.classList; } },
					{ src: 'plugin/notes/notes.js', async: true, condition: function() { return !!document.body.classList; } },
					{ src: 'plugin/math/math.js', async: true },
				]
			});

		</script>

	</body>
</html>
