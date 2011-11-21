<?
phpinfo();
exit;
$string="
<a href = 'http://www.google.com'>google</a>
<a href = 'http://www.google.com'>http://www.google.com</a>
https://google.com
";

//$string = preg_replace('@(\s+https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?\s+)@', '<a href="$1">$1</a>', $string);

//$string=preg_replace('/<a (.*?)>/s', '<a $1 rel="nofollow">', $string);
//$string = ereg_replace("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]","<a href=\"\\0\" rel=\"nofollow\">\\0</a>", $string);
///$string  = ereg_replace("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]","<a href=\"\\0\">\\0</a>", $string );
//$pattern = "@\b(https?://)?(([0-9a-zA-Z_!~*'().&=+$%-]+:)?[0-9a-zA-Z_!~*'().&=+$%-]+\@)?(([0-9]{1,3}\.){3}[0-9]{1,3}|([0-9a-zA-Z_!~*'()-]+\.)*([0-9a-zA-Z][0-9a-zA-Z-]{0,61})?[0-9a-zA-Z]\.[a-zA-Z]{2,6})(:[0-9]{1,4})?((/[0-9a-zA-Z_!~*'().;?:\@&=+$,%#-]+)*/?)@";

//$string = preg_replace($pattern, '<a href="\0">\0</a>', $string);

$string=make_clickable($string);
//$string = ereg_replace("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]","<a href=\"\\0\" rel=\"nofollow\">\\0</a>", $string);
$string=preg_replace('/<a (.*?)>/s', '<a $1 rel="nofollow">', $string);
print($string);



function make_clickable($ret) {
	$ret = ' ' . $ret;
	// in testing, using arrays here was found to be faster
	$ret = preg_replace_callback('#([\s>])([\w]+?://[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]*)#is', '_make_url_clickable_cb', $ret);
	$ret = preg_replace_callback('#([\s>])((www|ftp)\.[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]*)#is', '_make_web_ftp_clickable_cb', $ret);
	$ret = preg_replace_callback('#([\s>])([.0-9a-z_+-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,})#i', '_make_email_clickable_cb', $ret);
 
	// this one is not in an array because we need it to run last, for cleanup of accidental links within links
	$ret = preg_replace("#(<a( [^>]+?>|>))<a [^>]+?>([^>]+?)</a></a>#i", "$1$3</a>", $ret);
	$ret = trim($ret);
	return $ret;
}





function _make_url_clickable_cb($matches) {
	$ret = '';
	$url = $matches[2];
 
	if ( empty($url) )
		return $matches[0];
	// removed trailing [.,;:] from URL
	if ( in_array(substr($url, -1), array('.', ',', ';', ':')) === true ) {
		$ret = substr($url, -1);
		$url = substr($url, 0, strlen($url)-1);
	}
	return $matches[1] . "<a href=\"$url\" rel=\"nofollow\">$url</a>" . $ret;
}
 
function _make_web_ftp_clickable_cb($matches) {
	$ret = '';
	$dest = $matches[2];
	$dest = 'http://' . $dest;
 
	if ( empty($dest) )
		return $matches[0];
	// removed trailing [,;:] from URL
	if ( in_array(substr($dest, -1), array('.', ',', ';', ':')) === true ) {
		$ret = substr($dest, -1);
		$dest = substr($dest, 0, strlen($dest)-1);
	}
	return $matches[1] . "<a href=\"$dest\" rel=\"nofollow\">$dest</a>" . $ret;
}
 
function _make_email_clickable_cb($matches) {
	$email = $matches[2] . '@' . $matches[3];
	return $matches[1] . "<a href=\"mailto:$email\">$email</a>";
}

?>
