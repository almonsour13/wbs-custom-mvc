<?php
// app/models/UserModel.php
require_once 'core/Database.php';
class consumerModel
{
    public static function getConsumer(){
        $db = Database::connect();

        $sql = "SELECT c.cID, c.cFName, c.cMName, c.cLName, c.cSuffix, c.cEmailAd, c.cContactNo,
                ad.country, ad.region, ad.province, ad.municipality, ad.baranggay, ad.purok, ad.postalCode, c.cStatus
                FROM conscessionaries c 
                JOIN address ad ON c.cID = ad.cID 
                ORDER BY c.cID;";
                
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
       // var_dump($data);
        return $data;

    }

}

?>