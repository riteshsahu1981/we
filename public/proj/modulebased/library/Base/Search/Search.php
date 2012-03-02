<?php
/**
 * Base_Search_Search
 * 
 * @author : Mahipal Singh Adhikari
 * @version  
 */
  
class Base_Search_Search {	
	
	public function searchResult($searchText)
    {
		$searchText = trim($searchText);
		
		if(!get_magic_quotes_gpc())
		{
			$searchText = addslashes($searchText);
            $stack = array();
			$db = Zend_Registry::get("db");

            $qry = "SELECT * FROM search_view WHERE (title LIKE '%".$searchText."%' OR location LIKE '%".$searchText."%' OR description LIKE '%".$searchText."%') ORDER BY title";
            $stmt = $db->query($qry);
            $stmt->setFetchMode(Zend_Db::FETCH_ASSOC);
            $data = $stmt->fetchAll();
            return $data;
		}
	}
	
	public function searchDestination($searchText)
    {
		$searchText = trim($searchText);
		
		if(!get_magic_quotes_gpc())
		{
			$searchText = addslashes($searchText);
            $stack = array();
			$db = Zend_Registry::get("db");

            //$qry = "SELECT * FROM search_destination_view WHERE title LIKE'%".$searchText."%' OR destination LIKE'%".$searchText."%' OR description LIKE'%".$searchText."%'";
			$qry  = "SELECT * FROM search_destination_view WHERE (title LIKE '%".$searchText."%' OR description LIKE '%".$searchText."%')";
			$qry .= " ORDER BY title";
            $stmt = $db->query($qry);
            $stmt->setFetchMode(Zend_Db::FETCH_ASSOC);
            $data = $stmt->fetchAll();
            return $data;
		}
	}	
} 
