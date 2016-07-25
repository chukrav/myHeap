<?
$host=$_SERVER['HTTP_HOST'];
/*
Directory Listing Script - Version 2
====================================
Script Author: Ash Young <ash@evoluted.net>. www.evoluted.net
Layout: Manny <manny@tenka.co.uk>. www.tenka.co.uk
*/
$startdir = '.';
$showthumbnails = false;
$showdirs = true;
$forcedownloads = false;
$hide = array(
				'dlf',
				'public_html',
				'index.php',
				'Thumbs',
				'.htaccess',
				'.htpasswd'
			);
$displayindex = false;
$allowuploads = false;
$overwrite = false;

$indexfiles = array (
				'index.html',
				'index.htm',
				'default.htm',
				'default.html'
			);

$filetypes = array (
				'png' => 'jpg.gif',
				'jpeg' => 'jpg.gif',
				'bmp' => 'jpg.gif',
				'jpg' => 'jpg.gif',
				'gif' => 'gif.gif',
				'zip' => 'archive.png',
				'rar' => 'archive.png',
				'exe' => 'exe.gif',
				'setup' => 'setup.gif',
				'txt' => 'text.png',
				'htm' => 'html.gif',
				'html' => 'html.gif',
				'php' => 'php.gif',
				'fla' => 'fla.gif',
				'swf' => 'swf.gif',
				'xls' => 'xls.gif',
				'doc' => 'doc.gif',
				'sig' => 'sig.gif',
				'fh10' => 'fh10.gif',
				'pdf' => 'pdf.gif',
				'psd' => 'psd.gif',
				'rm' => 'real.gif',
				'mpg' => 'video.gif',
				'mpeg' => 'video.gif',
				'mov' => 'video2.gif',
				'avi' => 'video.gif',
				'eps' => 'eps.gif',
				'gz' => 'archive.png',
				'asc' => 'sig.gif',
			);

error_reporting(0);
if(!function_exists('imagecreatetruecolor')) $showthumbnails = false;
$leadon = $startdir;
if($leadon=='.') $leadon = '';
if((substr($leadon, -1, 1)!='/') && $leadon!='') $leadon = $leadon . '/';
$startdir = $leadon;

if($_GET['dir']) {
	//check this is okay.

	if(substr($_GET['dir'], -1, 1)!='/') {
		$_GET['dir'] = $_GET['dir'] . '/';
	}

	$dirok = true;
	$dirnames = split('/', $_GET['dir']);
	for($di=0; $di<sizeof($dirnames); $di++) {

		if($di<(sizeof($dirnames)-2)) {
			$dotdotdir = $dotdotdir . $dirnames[$di] . '/';
		}

		if($dirnames[$di] == '..') {
			$dirok = false;
		}
	}

	if(substr($_GET['dir'], 0, 1)=='/') {
		$dirok = false;
	}

	if($dirok) {
		 $leadon = $leadon . $_GET['dir'];
	}
}



$opendir = $leadon;
if(!$leadon) $opendir = '.';
if(!file_exists($opendir)) {
	$opendir = '.';
	$leadon = $startdir;
}

clearstatcache();
if ($handle = opendir($opendir)) {
	while (false !== ($file = readdir($handle))) {
		//first see if this file is required in the listing
		if ($file == "." || $file == "..")  continue;
		$discard = false;
		for($hi=0;$hi<sizeof($hide);$hi++) {
			if(strpos($file, $hide[$hi])!==false) {
				$discard = true;
			}
		}

		if($discard) continue;
		if (@filetype($leadon.$file) == "dir") {
			if(!$showdirs) continue;

			$n++;
			if($_GET['sort']=="date") {
				$key = @filemtime($leadon.$file) . ".$n";
			}
			else {
				$key = $n;
			}
			$dirs[$key] = $file . "/";
		}
		else {
			$n++;
			if($_GET['sort']=="date") {
				$key = @filemtime($leadon.$file) . ".$n";
			}
			elseif($_GET['sort']=="size") {
				$key = @filesize($leadon.$file) . ".$n";
			}
			else {
				$key = $n;
			}
			$files[$key] = $file;

			if($displayindex) {
				if(in_array(strtolower($file), $indexfiles)) {
					header("Location: $file");
					die();
				}
			}
		}
	}
	closedir($handle);
}

//sort our files
if($_GET['sort']=="date") {
	@ksort($dirs, SORT_NUMERIC);
	@ksort($files, SORT_NUMERIC);
}
elseif($_GET['sort']=="size") {
	@natcasesort($dirs);
	@ksort($files, SORT_NUMERIC);
}
else {
	@natcasesort($dirs);
	@natcasesort($files);
}

//order correctly
if($_GET['order']=="desc" && $_GET['sort']!="size") {$dirs = @array_reverse($dirs);}
if($_GET['order']=="desc") {$files = @array_reverse($files);}
$dirs = @array_values($dirs); $files = @array_values($files);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Lets learn some english! </title>
<style type="text/css">
.myBookTitle {
	font-size: 36px;
	color: #C0C0C0;
	font-family: "Times New Roman", Times, serif;
}
.LokalLinks {
	font-size: 24px;
	color: #333;
	font-family: "Times New Roman", Times, serif;
}
body {
	background-color: black;
	color: white;
}
</style>
</head>

<body>

	<blockquote>
	  <p><img src="HP_1.jpg" width="191" height="264" /></p>
	  <p class="myBookTitle">1 Harry Potter and the Sorcerers Stone. </p>
      <p class="LokalLinks"><a href="HP1_1-4.html">Dictionary of Parts 1-4. </a></p>
      <p class="LokalLinks"><a href="HP1_5-8.html">Dictionary of Parts 5-8. </a></p>
			<p class="LokalLinks"><a href="HP1_9-12.html">Dictionary of Parts 9-11 </a></p>
			<p class="LokalLinks"><a href="HP1_11-15.html">Dictionary of Parts 12-15 </a></p>
      <p class="LokalLinks"><a href="Phrases.html">Phrases (HP-1). </a></p>
</blockquote>
</body>
</html>
