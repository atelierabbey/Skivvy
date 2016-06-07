<?php #24Jan14

	// !! Important - be sure to drop this file in the 'wp-content' directory.


	// Image location
	$imagelocation="/wp-content/themes/Skivvy/img/logo.png";

	// Text copy
	$sitetitle = 'Maintenance update';
	$ptag = "Hello, We're sorry but the site is going through routine maintenance at the moment. We are doing our best to bring everything back online,<br />Bookmark us and come back later. We apologize for the inconvenience.";

	// Styling
	$bodystyling = "background:#ddd; text-align:center; padding-top:20px;";
	$divstyling = "margin:auto; margin-top: 30px; width:500px; background-color:#fff; padding:10px; border: 1px solid #A0B35C; text-align:center;";


	echo // OUTPUT HTML
	'<!DOCTYPE html>'.
	'<html dir="ltr" lang="en-US">'.
		'<head>'.
			'<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />'.
			'<title>'. $sitetitle . '</title>'.
		'</head>'.
		'<body style="' . $bodystyling . '">'.
			'<img src="' . $imagelocation . '" alt="' . $sitetitle . '" />'.
			'<div style="' . $divstyling . '">'.
				'<h1>' . $sitetitle . '</h1>'.
				'<p>' . $ptag . '</p>'.
			'</div>'.
		'</body>' .
	'</html>';
?>