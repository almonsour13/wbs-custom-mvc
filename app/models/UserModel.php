<?php
// app/models/UserModel.php
require_once 'core/Database.php';
class UserModel
{
    public static function getConsumer(){
        $db = Database::connect();

        $sql = "SELECT c.cID, c.cFName, c.cMName, c.cLName, c.cSuffix, c.cEmailAd, c.cContactNo,
                ad.country, ad.region, ad.province, ad.municipality, ad.baranggay, ad.purok, ad.postalCode, c.cStatus
                FROM conscessionaries c
                JOIN address ad ON c.cID = ad.cID
                ORDER BY c.cID";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            return null;
        }

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public static function userList() {
        // Connect to the database
        $db = Database::connect();

        // Execute a query to fetch user data by ID
        $stmt = $db->prepare('SELECT * FROM users LIMIT 10');
        $stmt->execute();

        // Fetch and return the user data
        return $stmt->fetchall(PDO::FETCH_ASSOC);
    }
}

?>