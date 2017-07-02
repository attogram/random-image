<?php
// Random Image page

$width  = @$_GET['w'] ? $_GET['w'] : 512;
$height = @$_GET['h'] ? $_GET['h'] : 128;
$method = @$_GET['m'] ? $_GET['m'] : 'rand';

$image_url = '//'
. $_SERVER['HTTP_HOST'] 
. dirname($_SERVER['PHP_SELF'])
. '/image.php?w=' . $width . '&amp;h=' . $height . '&amp;m=' . $method;

?><!doctype html>
<html><head><title>Random Image</title>
<meta charset="utf-8" />
<meta name="viewport" content="initial-scale=1" />
<style>
body {
   background-color:white; 
   color:black; 
   margin:10px 20px 20px 20px; 
   font-family:sans-serif,helvetica,arial;
}
h1 { font-size:150%; margin:0px 0px 5px 0px; padding:0px; }
h2 { font-size:95%; font-weight:normal; margin:0px; padding:0px; }
a { text-decoration:none; color:black; background-color:#ffb; }
a:visited { color:black; background-color:#ffa; }
a:hover { background-color:yellow; color:black; }
</style>
</head><body>
<h1>Random Image</h1>
<form action="" method="GET">
Method: <select name="m">
<option value="rand" <?php if( @$_GET['m'] == 'rand' ) { print ' selected="selected"'; } ?>>PHP rand()</option>
<option value="mt_rand" <?php if( @$_GET['m'] == 'mt_rand' ) { print ' selected="selected"'; } ?>>PHP mt_rand()</option>
</select>
 &nbsp; 
Width: <input type="text" name="w" size="4" maxlength="4" value="<?php print $width; ?>"> 
 &nbsp; 
Height <input type="text" name="h" size="4" maxlength="4" value="<?php print $height; ?>">
 &nbsp; 
<input type="submit" value="   Generate Random Image   ">
 &nbsp;
<a href="./">reset</a>
</form>

<p>URI: <a href="<?php print $image_url; ?>"><?php print $image_url; ?></a></p>

<img src="<?php print $image_url; ?>" width="<?php print $width; ?>" height="<?php print $height; ?>" alt="Random Image">

<footer>
<br /><br /><hr />
<p>Fork me: <a href="https://github.com/attogram/random-image">https://github.com/attogram/random-image</a></p>

</body></html>
