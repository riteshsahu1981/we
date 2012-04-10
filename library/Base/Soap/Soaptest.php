<?php
class Base_Soap_Soaptest {
	/**
	 * Add method
	 *
	 * @param Int $param1
	 * @param Int $param2
	 * @return Int
	 */
	public function math_add($param1, $param2) {
		return $param1+$param2; 
	}
	
	/**
	 * Logical not method
	 *
	 * @param boolean $param1
	 * @return boolean
	 */
	public function logical_not($param1) {
		return !$param1;
	}
	
	/**
	 * Simple array sort
	 *
	 * @param Array $array
	 * @return Array
	 */
	public function simple_sort($array) {
		asort($array);
		return $array;
	}
	
}