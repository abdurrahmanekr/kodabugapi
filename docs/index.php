<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8"/>
	<link rel="stylesheet" href="css/devdiv.min.css"/>
	<link rel="stylesheet" href="css/prism.css"/>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"/>
	<title>Kodabug Documentation</title>
	<style>
		html,
		body {
			margin: 0;
			padding: 0;
			font-family: 'Open Sans';
		} 
		.side-container {
			border-top: 2px dashed #ececec;
			padding: 5px !important;
		}
		.right-side {
			border-left: 2px dashed #ececec;
		}
		.container {
			margin-top: 20px;
			width: 85%;
		}
		.method-list li {
			background: #fafafa;
		}
		.method-list ol {
			border-left: 2px solid #ddd;
			margin: 5px 0px;
			position: relative;
		}
		.method-list ol li::after {
			content: "";
			left: 0px;
			margin-top: 10px;
			width: 45px;
			position: absolute;
			border: 1px solid #ddd;
		}
		.dev-table {
			border: 1px solid #ddd;
			width: 100%;
			position: relative;
			border-spacing: 0;
			border-collapse: collapse;
		}
		.dev-table td,
		.dev-table th {
		    box-sizing: border-box;
			border: 1px solid #ddd;
			padding: 10px
		}

		.dev-table tr:nth-child(2n) {
		    background-color: #f8f8f8
		}

		pre {
			padding: 5px 10px;
			border: 1px solid #ccc;
			background: #efefef;
			line-height: 1.5;
		}

		a {
			text-decoration: none;
			cursor: pointer;
		}
		a:hover {
			text-decoration: underline;
		}
		a.active-method {
			color: #f00;
		}
		.description-method {
			margin-top: 10px;
			font-size: 13px;
		}
	</style>
</head>
<?php
function getATag($service='', $method='')
{
	$result = 'href="?service=' . $service . '&method=' . $method . '"';
	if (isset($_GET["service"]) && isset($_GET["method"])) {
		$serviceGet = $_GET["service"];
		$methodGet  = $_GET["method"];
		if ($serviceGet = $service && $method == $methodGet)
			$result .= ' class="active-method"';
	}
	return $result;
}
?>
<body>
	<div class="container">
		<div class="row">
			<div class="col s12 m4 side-container">
				<div class="dev-list method-list">
					<li>
						<a href="">UserService</a>
						<ol>
							<li>
								<a <?=getATag('UserService', 'getUserVCard')?>>
									getUserVCard
								</a>
							</li>
							<li>
								<a <?=getATag('UserService', 'loginUser')?>>loginUser</a>
							</li>
						</ol>
					</li>
					<li>
						<a href="">RegisterService</a>
						<ol>
							<li><a <?=getATag('RegisterService', 'register')?>>register</a></li>
							<li><a <?=getATag('RegisterService', 'uploadGame')?>>uploadGame</a></li>
							<li><a <?=getATag('RegisterService', 'updateProfile')?>>updateProfile</a></li>
						</ol>
					</li>
					<li>
						<a href="">GameService</a>
						<ol>
							<li><a <?=getATag('GameService', 'getGame')?>>getGame</a></li>
							<li><a <?=getATag('GameService', 'getRandomGame')?>>getRandomGame</a></li>
							<li><a <?=getATag('GameService', 'getTrueOption')?>>getTrueOption</a></li>
							<li><a <?=getATag('GameService', 'getGameList')?>>getGameList</a></li>
							<li><a <?=getATag('GameService', 'startGame')?>>startGame</a></li>
						</ol>
					</li>
				</div>
			</div>
			<div class="col s12 m8 side-container right-side">
				<?php
					if (isset($_GET["service"])) {
						if (isset($_GET["method"])) {
							$service = $_GET["service"];
							$method  = $_GET["method"];
							$path = 'docs/' . $service . '/' . $method . '.php';
							if (file_exists($path)) {
								include $path;
							}
						}
					}
				?>
			</div>
		</div>
	</div>
</body>
</html>