<?php
/**
 * Bad Word Validator
 */
class Base_Validate_Badwords extends Zend_Validate_Abstract
{
    /**
     * Validation failure message key for when the value contains foul language
     */
    const BAD_WORDS = 'badWords';

    /**
     * Validation failure message template definitions
     *
     * @var array
     */
    protected $_messageTemplates = array(
        self::BAD_WORDS => "The text uses some foul language or words."
    );
        
     /**
     * Badword array - change as required by your application
     */
     private $badwords = array('scheiss','scheiß','arsch','fick','fuck','drecks','fotze','votze', 'viagra', 'cialis', 'casino', 'store', 'gambling', 'homosex', 'amateur', 'ppc', 'celebrity', '[url', 'http', '.htm', '</a>', 'sex', 'dildo', 'gay', 'pussy', 'anal', 'gangbang', 'teen', 'gerger', 'hardcore', 'blowjob', 'boobs', 'schoolgirl', 'mature', 'nude', 'milf', 'cock', 'dick', 'breast', 'tits', 'suck', 'virgin', 'oral', 'lesb', 'games', 'business', 'college', 'prewrcar', 'parrot', 'lodging', 'xx');

    /**
     * Defined by Zend_Validate_Interface
     *
     * Returns true if and only if $value does not contain bad words as defined by array
         * [TODO: highlight bad words]
     *
     * @param  string $value
     * @return boolean
     */
    public function isValid($value)
    {
        $this->badwords = $this->getBadwords();
		//echo  "<pre>";
		//print_r($this->badwords);
		//echo "</pre>";
		
		$valueString = (string) $value;

        $this->_setValue($valueString);

        for($i=0; $i<count($this->badwords); $i++)
		{
			//Match the word in all string
			/*if(strstr(strtoupper($valueString), strtoupper(trim($this->badwords[$i]))))
			{
				$this->_error(self::BAD_WORDS);
				return false;
			}*/
			
			//match exact word
			$badWord = strtoupper(trim($this->badwords[$i]));
			$valueStr = strtoupper($valueString);
			if(preg_match("/\b{$badWord}\b/i", $valueStr))
			{
				$this->_error(self::BAD_WORDS);
				return false;
			}
        }
        return true;
    }
	
	public function getBadwords()
	{
		$settings		= new Admin_Model_GlobalSettings();
		$badwordsStr	= $settings->settingValue('bad_words');
		$badwordsArr	= explode(",",$badwordsStr);
		return $badwordsArr;
	}

}
?>
