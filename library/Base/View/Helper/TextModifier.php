<?php
class Base_View_Helper_TextModifier extends Zend_View_Helper_Abstract
{
	public $string;
	
	public function textModifierOld($string)
	{
		$result = "";
		$result = $string;
		//$string = html_entity_decode($string);
		//$string = htmlspecialchars_decode($string);		
		//$string = strip_tags($string);
		
		if(preg_match('/<a (.*?)>/s', $string, $matches))
		{
			//$result = str_replace('href', 'rel="nofollow" href', $text);
			$result = preg_replace('/<a (.*?)>/s', '<a $1 rel="nofollow">', $string);
			
			//$result = preg_replace('@(\s+https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?\s+)@', '<a href="$1">$1</a>', $string);
			//$result = preg_replace('/<a (.*?)>/s', '<a $1 rel="nofollow">', $result);
		}
		else
		{
			//$result = $this->noFollowUrls($string);
			$result = $this->makeClickableLinks($string);
		}
		
		
		//By Ritesh
		//$result = preg_replace('@(\s+https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?\s+)@', '<a href="$1">$1</a>', $string);
		//$result = preg_replace('/<a (.*?)>/s', '<a $1 rel="nofollow">', $result);
		
		//Example
		//$string = ereg_replace("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]", "<a href=\"\\0\" rel=\"nofollow\" target=\"_blank\">\\0</a>", $string);
		//return $this->string = $string;
		
		return $result;
	}
	
	public function	noFollowUrls($text)
	{
		$result = "";
		$rexProtocol = '(https?://)?';
		$rexDomain   = '((?:[-a-zA-Z0-9]{1,63}\.)+[-a-zA-Z0-9]{2,63}|(?:[0-9]{1,3}\.){3}[0-9]{1,3})';
		$rexPort     = '(:[0-9]{1,5})?';
		$rexPath     = '(/[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]*?)?';
		$rexQuery    = '(\?[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]+?)?';
		$rexFragment = '(#[!$-/0-9:;=@_\':;!a-zA-Z\x7f-\xff]+?)?';
		$rexUrlLinker = "{\\b$rexProtocol$rexDomain$rexPort$rexPath$rexQuery$rexFragment(?=[?.!,;:\"]?(\s|$))}";
		$validTlds = array_fill_keys(explode(" ", ".ac .ad .ae .aero .af .ag .ai .al .am .an .ao .aq .ar .arpa .as .asia .at .au .aw .ax .az .ba .bb .bd .be .bf .bg .bh .bi .biz .bj .bm .bn .bo .br .bs .bt .bv .bw .by .bz .ca .cat .cc .cd .cf .cg .ch .ci .ck .cl .cm .cn .co .com .coop .cr .cu .cv .cx .cy .cz .de .dj .dk .dm .do .dz .ec .edu .ee .eg .er .es .et .eu .fi .fj .fk .fm .fo .fr .ga .gb .gd .ge .gf .gg .gh .gi .gl .gm .gn .gov .gp .gq .gr .gs .gt .gu .gw .gy .hk .hm .hn .hr .ht .hu .id .ie .il .im .in .info .int .io .iq .ir .is .it .je .jm .jo .jobs .jp .ke .kg .kh .ki .km .kn .kp .kr .kw .ky .kz .la .lb .lc .li .lk .lr .ls .lt .lu .lv .ly .ma .mc .md .me .mg .mh .mil .mk .ml .mm .mn .mo .mobi .mp .mq .mr .ms .mt .mu .museum .mv .mw .mx .my .mz .na .name .nc .ne .net .nf .ng .ni .nl .no .np .nr .nu .nz .om .org .pa .pe .pf .pg .ph .pk .pl .pm .pn .pr .pro .ps .pt .pw .py .qa .re .ro .rs .ru .rw .sa .sb .sc .sd .se .sg .sh .si .sj .sk .sl .sm .sn .so .sr .st .su .sv .sy .sz .tc .td .tel .tf .tg .th .tj .tk .tl .tm .tn .to .tp .tr .travel .tt .tv .tw .tz .ua .ug .uk .us .uy .uz .va .vc .ve .vg .vi .vn .vu .wf .ws .xn--0zwm56d .xn--11b5bs3a9aj6g .xn--80akhbyknj4f .xn--9t4b11yi5a .xn--deba0ad .xn--fiqs8s .xn--fiqz9s .xn--fzc2c9e2c .xn--g6w251d .xn--hgbk6aj7f53bba .xn--hlcj6aya9esc7a .xn--j6w193g .xn--jxalpdlp .xn--kgbechtv .xn--kprw13d .xn--kpry57d .xn--mgbaam7a8h .xn--mgbayh7gpa .xn--mgberp4a5d4ar .xn--o3cw4h .xn--p1ai .xn--pgbs0dh .xn--wgbh1c .xn--xkc2al3hye2a .xn--ygbi2ammx .xn--zckzah .ye .yt .za .zm .zw"), true);
		
		
		$position = 0;
		while (preg_match($rexUrlLinker, $text, $match, PREG_OFFSET_CAPTURE, $position))
		{
			list($url, $urlPosition) = $match[0];
			
			// Add the text leading up to the URL.
			$result .= htmlspecialchars(substr($text, $position, $urlPosition - $position));
			
			$domain = $match[2][0];
			$port   = $match[3][0];
			$path   = $match[4][0];
			
			// Check that the TLD is valid or that $domain is an IP address.
			$tld = strtolower(strrchr($domain, '.'));
			if (preg_match('{^\.[0-9]{1,3}$}', $tld) || isset($validTlds[$tld]))
			{
				// Prepend http:// if no protocol specified
				$completeUrl = $match[1][0] ? $url : "http://$url";
				
				// Add the hyperlink.
				$result .= '<a href="' . htmlspecialchars($completeUrl) . '" rel="nofollow" target="_blank">'. htmlspecialchars("$domain$port$path"). '</a>';
			}
			else
			{
				// Not a valid URL.
				$result .= htmlspecialchars($url);
			}
			
			// Continue text parsing from after the URL.
			$position = $urlPosition + strlen($url);
		}

		// Add the remainder of the text.
		$result .= htmlspecialchars(substr($text, $position));
		return $result;
	}
	
	function makeClickableLinks($text)
	{
		
		$text = eregi_replace('(((f|ht){1}tp://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)',
        '<a href="\\1" target="__blank" rel="nofollow">\\1</a>', $text);
        $text = eregi_replace('([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_\+.~#?&//=]+)',
        '\\1<a href="http://\\2" target="__blank" rel="nofollow">\\2</a>', $text);
    
		$text = eregi_replace('([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})',
		'<a href="mailto:\\1">\\1</a>', $text); 
		
		//create links
		//$text = ereg_replace("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]","<a href=\"\\0\" rel=\"nofollow\">\\0</a>", $text);

		return $text;
	}
	
	
	//following are the new functions to built URL and Nofollow links
	public function textModifier($string)
	{
		return $string;
		
		/*
		$string = $this->make_clickable($string);		
		//$string = ereg_replace("[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]","<a href=\"\\0\" rel=\"nofollow\">\\0</a>", $string);
		$string = preg_replace('/<a (.*?)>/s', '<a $1 rel="nofollow">', $string);
		//print($string);
		return $string;
		*/
	}

	public function make_clickable($ret)
	{
		$ret = ' ' . $ret;
		// in testing, using arrays here was found to be faster
		$ret = preg_replace_callback('#([\s>])([\w]+?://[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]*)#is', '_make_url_clickable_cb', $ret);
		$ret = preg_replace_callback('#([\s>])((www|ftp)\.[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]*)#is', '_make_web_ftp_clickable_cb', $ret);
		$ret = preg_replace_callback('#([\s>])([.0-9a-z_+-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,})#i', '_make_email_clickable_cb', $ret);
		
		//this one is not in an array because we need it to run last, for cleanup of accidental links within links
		$ret = preg_replace("#(<a( [^>]+?>|>))<a [^>]+?>([^>]+?)</a></a>#i", "$1$3</a>", $ret);
		$ret = trim($ret);
		return $ret;
	}	
}//end class

function _make_url_clickable_cb($matches)
{
	$ret = '';
	$url = $matches[2];
 
	if ( empty($url) )
		return $matches[0];
	// removed trailing [.,;:] from URL
	if ( in_array(substr($url, -1), array('.', ',', ';', ':')) === true )
	{
		$ret = substr($url, -1);
		$url = substr($url, 0, strlen($url)-1);
	}
	return $matches[1] . "<a href=\"$url\" rel=\"nofollow\">$url</a>" . $ret;
}

function _make_web_ftp_clickable_cb($matches)
{
	$ret = '';
	$dest = $matches[2];
	$dest = 'http://' . $dest;
 
	if ( empty($dest) )
		return $matches[0];
	// removed trailing [,;:] from URL
	if ( in_array(substr($dest, -1), array('.', ',', ';', ':')) === true )
	{
		$ret = substr($dest, -1);
		$dest = substr($dest, 0, strlen($dest)-1);
	}
	return $matches[1] . "<a href=\"$dest\" rel=\"nofollow\">$dest</a>" . $ret;
}
 
function _make_email_clickable_cb($matches)
{
	$email = $matches[2] . '@' . $matches[3];
	return $matches[1] . "<a href=\"mailto:$email\">$email</a>";
}

