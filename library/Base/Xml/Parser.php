<?php 
class Base_Xml_Parser extends Base_Xml_Entity
{ 
    public $Data = array(); 
 
    private $stack = array(); 
    private $xml_parser; 
    private $cdata = ''; 
    private $tag_count = 0; 
    private $include_first_tag = false; 
    private $XmlData = ''; 
    private $xmlerror_code = 0; 
    private $xmlerror_line = 0; 
    private $file_path="";
 
    /**
     * Load the XML document
     * 
     * Either a string in the first parameter or a filepath
     * in the second
     *
     * @param string $xml_string
     * @param string $file_to_load
     */ 
    function __construct( $xml_string='', $file_to_load = '') 
    { 
        if ( $xml_string != '' ) 
        { 
            $this->XmlData = $xml_string; 
        } 
        else 
        { 
            if ( !$file_to_load || $file_to_load == '' ) 
            { 
            	
                throw new Zend_Exception("There was no string passed to the xml class and no filename specified"); 
            } 
 
            # File exists? 
            if( !file_exists( $file_to_load ) ) 
            { 
            	exit("test$file_to_load");
                //throw new Zend_Exception("The file '{$file_to_load}' was not found."); 
            }

            $this->file_path=$file_to_load;
 $filecontentstr=file_get_contents($file_to_load);
 //$filecontentstr=str_replace("&ocirc;","",$filecontentstr);
 //var_dump($filecontentstr);
 $this->XmlData=$filecontentstr;
            if (!$this->XmlData)
            { 
                //throw new Zend_Exception("Could not load the file '{$file_to_load}'"); 
            } 
        } 
         
        # Parse the document 
        $this->parseDocument(); 
    } 
 
    /**
     * Parse the document
     *
     * @param unknown_type $encoding
     * @param unknown_type $emptydata
     * @return unknown
     */ 
    public function &parseDocument($encoding = 'UTF-8', $emptydata = true) 
    { 
        # Do we have anything to load at all? 
        if ( !$this->XmlData ) 
        { 
            throw new Zend_Exception("There was nothing to parse"); 
            return false; 
        } 
 
        # Attempt to create 
        if (!($this->xml_parser = xml_parser_create($encoding))) 
        { 
            throw new Zend_Exception("Could not parse the xml document."); 
            return false; 
        } 
 
        # Build out parser 
        xml_parser_set_option($this->xml_parser, XML_OPTION_SKIP_WHITE, 0); 
        xml_parser_set_option($this->xml_parser, XML_OPTION_CASE_FOLDING, 0); 
        xml_set_character_data_handler($this->xml_parser, array(&$this, 'cropCDATA')); 
        xml_set_element_handler($this->xml_parser, array(&$this, 'startElement'), array(&$this, 'endElement')); 
 
        xml_parse($this->xml_parser, $this->XmlData); 
        $error_occured = xml_get_error_code($this->xml_parser); 
 
        # Dump all 
        if ($emptydata) 
        { 
            $this->XmlData = ''; 
            $this->stack = array(); 
            $this->cdata = ''; 
        } 
 
        # Any errors occured with parsing the document? 
        if ($error_occured) 
        { 
            $this->xmlerror_code = @xml_get_error_code($this->xml_parser); 
            $this->xmlerror_line = @xml_get_current_line_number($this->xml_parser); 
            xml_parser_free($this->xml_parser);

            $db=Zend_Registry::get("db");
            $data['message']=$this->file_path;
            $data['type']='zone_feeds';
            $data['log_date']=date("Y-m-d H:i:s");
            $log_id=$db->insert( "error_log", $data);

            copy($this->file_path, 'error/'.$this->file_path);
            //throw new Zend_Exception("There was an error parsing the document, The error returned was: '{$this->error_code}' on Line: '{$this->xmlerror_line}'.");
            return $this;
        } 
 
        xml_parser_free($this->xml_parser); 
 
        return $this; 
    } 
     
    /**
     * Show the parsed XML data as an array
     *
     */ 
    public function show() 
    { 
        return $this->Data; 
    } 
 
    /**
     *
     *
     * @param unknown_type $parser
     * @param unknown_type $data
     */ 
    private function cropCDATA(&$parser, $data) 
    { 
        $this->cdata .= $data; 
    } 
 
    /**
     * Xml Parser start element
     *
     * @param unknown_type $parser
     * @param unknown_type $name
     * @param unknown_type $attribs
     */ 
    private function startElement(&$parser, $name, $attribs) 
    { 
        $this->cdata = ''; 
 
        foreach ($attribs AS $key => $val) 
        { 
            if (preg_match('#&[a-z]+;#i', $val)) 
            { 
                $attribs["$key"] = $this->unConvertHtmlTags($val);
            } 
        } 
 
        array_unshift($this->stack, array('name' => $name, 'attribs' => $attribs, 'tag_count' => ++$this->tag_count)); 
    } 
    /**
     * Convert entities to there html tags
     *
     * @param string $string
     * @return string
     */ 
    private function unConvertHtmlTags($string='') 
    { 
        return str_replace(array('&lt;', '&gt;', '&quot;', '&amp;'), array('<', '>', '"', '&'), $text); 
    } 
 
    /**
     * Xml parser end element
     *
     * @param unknown_type $parser
     * @param unknown_type $name
     */ 
    private function endElement(&$parser, $name) 
    { 
        $tag = array_shift($this->stack); 
        if ($tag['name'] != $name) 
        { 
            return; 
        } 
 
        $output = $tag['attribs']; 
 
        if (trim($this->cdata) !== '' OR $tag['tag_count'] == $this->tag_count) 
        { 
            if (sizeof($output) == 0) 
            { 
                $output = $this->unEscapeCDATA($this->cdata); 
            } 
            else 
            { 
                $this->addNode($output, 'value', $this->unEscapeCDATA($this->cdata)); 
            } 
        } 
 
        if (isset($this->stack[0])) 
        { 
            $this->addNode($this->stack[0]['attribs'], $name, $output); 
        } 
        else 
        { 
            if ($this->include_first_tag) 
            { 
                $this->Data = array($name => $output); 
            } 
            else 
            { 
                $this->Data = $output; 
            } 
        } 
        $this->cdata = ''; 
    } 
 
    /**
     * Adds a node into the array, based on the elements inside the array
     * it determines if to add the new element key, add it to an exisiting key
     * 
     *
     * @param array $children
     * @param string $name
     * @param string $value
     */ 
    private function addNode(&$children, $name, $value) 
    { 
        if (!is_array($children) OR !in_array($name, array_keys($children))) 
        { 
            $children[$name] = $value; 
        } 
        else if (is_array($children[$name]) AND isset($children[$name][0])) 
        { 
            $children[$name][] = $value; 
        } 
        else 
        { 
            $children[$name] = array($children[$name]); 
            $children[$name][] = $value; 
        } 
    } 
 
    /**
     * Custom convert nested Cdata tags
     *
     * @param string $xml
     * @return string
     */ 
    private function unEscapeCDATA($xml) 
    { 
        $find = array('|![CDATA[', ']]|', "\r\n", "\n"); 
        $replace = array('<![CDATA[', ']]>', "\n", "\r\n"); 
 
        return str_replace($find, $replace, $xml); 
    } 
} 