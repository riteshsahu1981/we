<?php
class Base_View_Helper_GoogleWeather extends Zend_View_Helper_Abstract
{
	
	public $view;
  
    public function __construct()
    {   }
   
    public function setView(Zend_View_Interface $view)
    {
        $this->view = $view;
    }
  
    public function googleWeather($location)
    {
    
		$xml = simplexml_load_file('http://www.google.com/ig/api?weather=' . $location);
		$information = $xml->xpath("/xml_api_reply/weather/forecast_information");
		$current = $xml->xpath("/xml_api_reply/weather/current_conditions");
		$forecast_list = $xml->xpath("/xml_api_reply/weather/forecast_conditions");

		$weatheroutput = "
		<div class='weather'>       
		<img src='http://www.google.com" . $current[0]->icon['data'] . "' alt='weather' />
            <span class='condition'>
            " .  $current[0]->temp_c['data'] . "&deg; C,
            " . $current[0]->condition['data'] . "iooooooo
            </span>
                    </div>";
            return $weatheroutput;
    }
}