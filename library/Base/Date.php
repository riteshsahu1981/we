<?php
class Base_Date extends Zend_Date 
{

	protected $_sysDateFormat;
	public function __construct($date = null, $part = null, $locale = null)
        {
            
            parent::__construct($date = null, $part = null, $locale = null);
            $this->setTimezone('Asia/Calcutta');
        }
	public function getSysDate($timestamp, $full=true)
	{
		$timestamp=(int)$timestamp;
		$this->setOptions(array('format_type' => 'php'));
		$this->setTimestamp($timestamp);
                if($full==false)
                {
                    $this->setSysDateFormat("M jS Y");
                }
                return $this->toString($this->getSysDateFormat());
	}
	
	public function getSysDateFormat()
	{
		if (null === $this->_sysDateFormat)
		{
			$this->setSysDateFormat("M jS Y h:i:s a");
		}
		return $this->_sysDateFormat;
	}
	
	public function setSysDateFormat($format)
	{
		$this->_sysDateFormat=$format;
	}

        public function hourAgo($secs)
        {
            $secs=time()-$secs;
            $m = (int)($secs / 60); $s = $secs % 60;
            $h = (int)($m / 60); $m = $m % 60;
            
            return $h;
        }

        public function minutesAgo($secs)
        {
            $secs=time()-$secs;
            $m = (int)($secs / 60); 
            return $m;
        }

	public function timeAgo($secs){
		$secs=time()-$secs;
		$m = (int)($secs / 60); $s = $secs % 60;
		$h = (int)($m / 60); $m = $m % 60;
		$d = (int)($h / 24); $h = $h % 24;
		if($d>0 && $d==1)
		{
			$strTime="$d day ago";
		}
		else if($d>1)
		{
			$strTime="$d days ago";
		}
		else if($h>0 && $h==1)
		{
			$strTime="$h hour ago";
		}
		else if($h>1)
		{
			$strTime="$h hours ago";
		}
		else if($m>0 && $m==1)
		{
			$strTime="$m minute ago";
		}
		else if($m>1)
		{
			$strTime="$m minutes ago";
		}
		else if($secs>0 && $secs==1)
		{
			$strTime="$secs second ago";
                }
		else
		{
			$strTime="$secs seconds ago";
		}
		return $strTime;
	}
}
?>
