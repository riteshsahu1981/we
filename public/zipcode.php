<?php

mysql_connect("localhost","root", "g00dluck") or die("unable to connect the db server.");
mysql_select_db("uszipcode");

if(isset($_GET['zip']))
    $zipcode=$_GET['zip'];
else
    $zipcode='99925';


/*
DELIMITER $$  
 
DROP  FUNCTION  IF EXISTS `GetDistance`$$  
 
CREATE   FUNCTION  `GetDistance`(  
 lat1  numeric (9,6),  
 lon1  numeric (9,6),  
 lat2  numeric (9,6),  
 lon2  numeric (9,6)  
)  RETURNS   decimal (10,5)  
BEGIN  
  DECLARE  x  decimal (20,10);  
  DECLARE  pi  decimal (21,20);  
  SET  pi = 3.14159265358979323846;  
  SET  x = sin( lat1 * pi/180 ) * sin( lat2 * pi/180  ) + cos(  
 lat1 *pi/180 ) * cos( lat2 * pi/180 ) * cos(  abs ( (lon2 * pi/180) -  
 (lon1 *pi/180) ) );  
  SET  x = atan( ( sqrt( 1- power( x, 2 ) ) ) / x );  
  RETURN  ( 1.852 * 60.0 * ((x/pi)*180) ) / 1.609344;  
END $$  
 
DELIMITER ;


DELIMITER $$  

    DROP   PROCEDURE  IF EXISTS `GetNearbyZipCodes`$$  

    CREATE PROCEDURE GetNearbyZipCodes(zipbase  varchar(6), myrange   numeric(15) ) 
    BEGIN  
    DECLARE  lat1  decimal (5,2);  
    DECLARE  long1  decimal (5,2);  
    DECLARE  rangeFactor  decimal (7,6);  
    SET  rangeFactor = 0.014457;  
    SELECT  latitude,longitude  into  lat1,long1  FROM  zipcodesusa WHERE  zipcode = zipbase;  
    SELECT  distinct B.zipcode, GetDistance(lat1,long1,B.latitude,B.longitude) as distance  
    FROM  zipcodesusa AS  B   
    WHERE    
    B.latitude  BETWEEN  lat1-(myrange*rangeFactor)  AND  lat1+(myrange*rangeFactor)  
    AND  B.longitude  BETWEEN  long1-(myrange*rangeFactor)  AND  long1+(myrange*rangeFactor)  
    AND  GetDistance(lat1,long1,B.latitude,B.longitude) <= myrange order by distance;  
    END $$  

    DELIMITER ;
*/


$varMiles = "100";
$sql="CALL GetNearbyZipCodes( '$zipcode' , $varMiles);";
    $res=mysql_query($sql);
    $total=mysql_num_rows($res);
    if($total>0)
    {
        echo "<br>".$total ." zipcodes found. <br>";
        while($row =  mysql_fetch_array($res))
        {
            echo $row['zipcode']."--".$row['distance'];
            echo "<BR>";
        }
    }
    else
    {
        exit("Records not found.");
    }
    
exit;













































echo $zipcode;
$res=mysql_query("select *from zipcodesusa where zipcode='$zipcode'");
if(mysql_num_rows($res)>0)
{
    $row=mysql_fetch_array($res);
    $varLatitude = $row['latitude']; // latitude of $zipcode
    $varLongitude = $row['longitude']; // longitude of $zipcode
    $varMiles = "100";
    echo $sql=" SELECT DISTINCT zipcode, cityname,
        sqrt(power(69.1*(latitude - ($varLatitude)),2)+ power(69.1*(longitude-($varLongitude))*cos(latitude/57.3),2)) as dist
        FROM zipcodesusa
        WHERE sqrt(power(69.1*(latitude - ($varLatitude)),2)+ power(69.1*(longitude-($varLongitude))*cos(latitude/57.3),2)) <  $varMiles
        ORDER by dist";
    $res=mysql_query($sql);
    $total=mysql_num_rows($res);
    if($total>0)
    {
        echo "<br>".$total ." zipcodes found. <br>";
        while($row =  mysql_fetch_array($res))
        {
            echo $row['zipcode'];
            echo "<BR>";
        }
    }
    else
    {
        exit("Records not found.");
    }
}
else
{
    exit("Invalide zipcode.");
}
?>
