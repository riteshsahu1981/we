<?php
class Base_Xml_Writer 
{ 
    protected $charset = 'utf-8'; 
    protected $content_type = 'text/xml'; 
 
    private $tags = ""; 
    private $current_open_tags = array(); 
    private $xml_document = ''; 
    private $indent = ''; 
 
    /**
     * Constructor:
     * 
     * Change the charset and content type of the xml document
     *
     * @param string $charset
     * @param string $content_type
     */ 
    public function __construct( $charset = '', $content_type = '') 
    { 
        # Custom Charset 
        if( $charset ) 
        { 
            $this->charset = strtolower($charset); 
        } 
 
        # Custom Content Type 
        if( $content_type ) 
        { 
            $this->charset = strtolower($content_type); 
        } 
    } 
 
    /**
     * Send specific headers to display or download the xml document
     *
     * @param boolean $download_headers
     * @param string $filename
     */ 
    private function sendHeaders($download_headers = false, $filename = '') 
    { 
        @header('Content-Type: ' . $this->content_type . '; charset=' . $this->charset); 
        @header('Content-Length: ' . strlen($this->xml_document) + strlen($this->getXmlTag())); 
 
        if( $download_headers ) 
        { 
            $document_name = $filename ? $filename : 'xmldocument-' . date('d_m_Y_H_i', time()) . '.xml'; 
            @header("Content-Disposition: attachment; filename=\"{$document_name}\""); 
            @header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT"); 
            @header("Cache-Control: no-cache, must-revalidate"); 
            @header("Pragma: no-cache"); 
        } 
    } 
 
    /**
     * Get the XML document tag
     *
     * @return string
     */ 
    private function getXmlTag() 
    { 
        return '<?xml version="1.0" encoding="' . $this->charset . '"?>' . "\n"; 
    } 
 
    /**
     * Add an xml tag group
     *
     * @param string $tag_name
     * @param array $attributes
     */ 
    public function addGroup($tag_name, $attributes = array()) 
    { 
        $this->current_open_tags[] = $tag_name; 
        $this->xml_document .= $this->tags . $this->createTag($tag_name, $attributes) . "\n"; 
        $this->tags .= "\t"; 
    } 
 
    /**
     * Indent the tags
     *
     * @param int $numer
     * @return string
     */ 
    private function indent( $numer = false ) 
    { 
        if( intval($number) ) 
        { 
            return str_repeat("\t", $number); 
        } 
 
        return; 
    } 
 
    /**
     * Close last opened group
     *
     */ 
    public function closeGroup() 
    { 
        $tag = array_pop($this->current_open_tags); 
        $this->tags = substr($this->tags, 0, -1); 
        $this->xml_document .= $this->tags . "</$tag>\n"; 
    } 
 
    /**
     * Add Tag to the current xml document
     *
     * @access public
     * 
     * @param string $tag_name
     * @param string $tag_content
     * @param array $attributes
     * @param boolean $safe_cdata
     * @param boolean $htmlspecialchars
     */ 
    public function addTag($tag_name, $tag_content = '', $attributes = array(), $safe_cdata = false, $htmlspecialchars = false) 
    { 
        $this->xml_document .= $this->tags . $this->createTag($tag_name, $attributes, ($tag_content == '')); 
        if ($tag_content != '') 
        { 
            if ($htmlspecialchars) 
            { 
                $this->xml_document .= $this->safeHtmlConvert($tag_content); 
            } 
            else if ($safe_cdata OR preg_match('/[\<\>\&\'\"\[\]]/', $tag_content)) 
            { 
                $this->xml_document .= '<![CDATA[' . $this->escapeCDATA($tag_content) . ']]>'; 
            } 
            else 
            { 
                $this->xml_document .= $tag_content; 
            } 
            $this->xml_document .= "</$tag_name>\n"; 
        } 
    } 
 
    /**
     * Create the actual tag internal
     *
     * @access private
     * 
     * @param string $tag_name
     * @param array $attributes
     * @param boolean $closing_tag
     * @return unknown
     */ 
    private function createTag($tag_name, $attributes, $closing_tag = false) 
    { 
        $this_tag = "<$tag_name"; 
        if (count($attributes)) 
        { 
            foreach ($attributes AS $attribute_key => $attribute_value) 
            { 
                if (strpos($attribute_key, '"') !== false) 
                { 
                    $attribute_key = $this->safeHtmlConvert($attribute_value); 
                } 
                $this_tag .= " $attribute_key=\"$attribute_value\""; 
            } 
        } 
        $this_tag .= ($closing_tag ? " />\n" : '>'); 
        return $this_tag; 
    } 
 
    /**
     * Escape Cdata tags within itself
     *
     * @param string $string
     * @return string
     */ 
    private function escapeCDATA( $string='' ) 
    { 
        $string = preg_replace('#[\\x00-\\x08\\x0B\\x0C\\x0E-\\x1F]#', '', $string); 
 
        return str_replace(array('<![CDATA[', ']]>'), array('|![CDATA[', ']]|'), $string); 
    } 
 
    /**
     * Convert Safehtml
     *
     * @param string $text
     * @param boolean $entities
     * @return string
     */ 
    private function safeHtmlConvert($text, $entities = true) 
    { 
        return str_replace( array('<', '>', '"'), array('&lt;', '&gt;', '&quot;'), preg_replace( '/&(?!' . ($entities ? '#[0-9]+|shy' : '(#[0-9]+|[a-z]+)') . ';)/si', '&amp;', $text )); 
    } 
 
    /**
     * Display everything to the browser or download
     *
     * @param boolean $download_document
     * @return string
     */ 
    public function display( $download_document = false, $filename = '' ) 
    { 
        if (count($this->current_open_tags)) 
        { 
            throw new Zend_Xml_Exception("Error: There are still open tags left in the document."); 
            return false; 
        } 
 
        $this->sendHeaders($download_document, $filename); 
        echo $this->getXmlTag(); 
        echo $this->xml_document; 
        exit; 
    } 
 
}