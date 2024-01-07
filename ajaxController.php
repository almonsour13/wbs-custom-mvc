<?php

require_once 'core/Database.php';

// Initialize $db in the global scope
$db = Database::connect();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //get consumers
    session_start();
    if ($_GET['url'] == "getConsumer") {
        getConsumers();
    }
    //get consumer by id
    if ($_GET['url'] == "getConsumerById") {
        $id = $_GET['id'];

        getConsumerById($id);
    }
    if ($_GET['url'] == "getLoggedAccount") {
        $id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
        $account = getLoggedAccount($id);
    }
    if ($_GET['url'] == "logOut") {
        // Unset the 'id' session variable
        unset($_SESSION['id']);

        // Check if 'id' session variable is not set
        if (!isset($_SESSION['id'])) {
            echo json_encode(['status' => 'success', 'message' => 'Logout successful']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error during logout']);
        }
    }

}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//--consumer --------------------------------
    //check consumer
    if ($_GET['url'] === 'checkConsumer') {
        $firstName = $_POST['firstName'];
        $middleName = $_POST['middleName'];
        $lastName = $_POST['lastName'];
        $suffix = $_POST['suffix'];
    
        $consumerExists = checkConsumerExists($firstName, $middleName, $lastName, $suffix);
        
        echo json_encode(['exists' => $consumerExists]);
    }
    //add consumer
    if (isset($_POST['url']) && $_POST['url'] == "addConsumer") {
        
        $firstName = $_POST['firstName'];
        $middleName = $_POST['middleName'];
        $lastName = $_POST['lastName'];
        $suffix = $_POST['suffix'];
        $contactNo = $_POST['contactNo'];
        $emailAddress = $_POST['emailAddress'];
        $purok = $_POST['purok'];
        $postalCode = $_POST['postalCode'];
        try {
            insertAddConsumer($firstName, $middleName, $lastName, $suffix, $contactNo, $emailAddress, $purok, $postalCode, 1);

            echo json_encode(['status' => 'success', 'message' => 'Consumer added successfully']);
            exit;
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
            exit;
        }
    }
    //update consumer
    if (isset($_POST['url']) && $_POST['url'] == "updateConsumer") {
        $consumerId = $_POST['id'];
        $firstName = $_POST['firstName'];
        $middleName = $_POST['middleName'];
        $lastName = $_POST['lastName'];
        $suffix = $_POST['suffix'];
        $contactNo = $_POST['contactNo'];
        $emailAddress = $_POST['emailAddress'];
        $purok = $_POST['purok'];
        $postalCode = $_POST['postalCode'];
    
        try {
            updateConsumer($consumerId, $firstName, $middleName, $lastName, $suffix, $contactNo, $emailAddress, $purok, $postalCode, 1);
    
            echo json_encode(['status' => 'success', 'message' => 'Consumer Updated successfully']);
            exit;
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
            exit;
        }
    }
    //archive consumer
    if (isset($_POST['url']) && $_POST['url'] == "archiveConsumer") {
        $consumerId = $_POST['id'];
        try {
            achiveConsumer($consumerId);
    
            echo json_encode(['status' => 'success', 'message' => 'Consumer Updated successfully']);
            exit;
        } catch (PDOException $e) {
            echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
            exit;
        }
    }
//--login form -----------------------------
    //check user credentials
    if ($_POST['url'] == "checkUserCredentials") {
        $userName = $_POST['userName'];
        $passWord = $_POST['passWord'];
        $credentialsExists = checkUserCredentials($userName, $passWord);
        if($credentialsExists != 0){
            echo json_encode(['status' => 'success','exists' => $credentialsExists]);
        }else{
            echo json_encode(['status' => 'error']);
        }
    }

}
function getLoggedAccount($id){
    global $db;

    try {
        $sql = "SELECT aFName, aMName FROM accounts WHERE aID = :aID";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':aID', $id);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response = [
            "status" => "success",
            "account" => $data
        ];

        echo json_encode($response);
    } catch (PDOException $e) {
        // Handle the exception, log, or throw it again based on your needs
        throw $e;
    }
}
function checkUserCredentials($userName, $passWord) {
    session_start();
    global $db; 

    try {
        $sql = "SELECT COUNT(*) AS count, aID FROM accounts WHERE aUserName = :aUserName AND aPassword = :aPassword;";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':aUserName', $userName);
        $stmt->bindParam(':aPassword', $passWord);

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $_SESSION['id'] = $result['aID'];
        
        $stmt->closeCursor();


        return $result['count'];
    } catch (PDOException $e) {
        throw $e;
    }
}
function achiveConsumer($consumerId){
    global $db;
    $sql = "UPDATE conscessionaries 
            SET cStatus = 3 
            WHERE cID = :consumerId";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':consumerId', $consumerId);

    $stmt->execute();
}
function updateConsumer($consumerId, $fName, $mName, $lName, $suffix, $contactNo, $emailAd, $purok, $postalCode){
    global $db;
    
    $sql = "UPDATE conscessionaries 
            SET cFName = :firstName, cMName = :middleName, cLName = :lastName, 
                cSuffix = :suffix, cContactNo = :contactNo, cEmailAd = :emailAddress
            WHERE cID = :consumerId";

    $fName = strtoupper($fName);
    $mName = strtoupper($mName);
    $lName = strtoupper($lName);
    $suffix = strtoupper($suffix);
    $contactNo = strtoupper($contactNo);
    $emailAd = strtoupper($emailAd);
    $purok = strtoupper($purok);
    $postalCode = strtoupper($postalCode);

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':firstName', $fName);
    $stmt->bindParam(':middleName', $mName);
    $stmt->bindParam(':lastName', $lName);
    $stmt->bindParam(':suffix', $suffix);
    $stmt->bindParam(':contactNo', $contactNo);
    $stmt->bindParam(':emailAddress', $emailAd);
    $stmt->bindParam(':consumerId', $consumerId);

    $stmt->execute();

    $updateAddressSQL = "UPDATE address SET purok = ?, postalCode = ? WHERE cID = ?";
    $addressStatement = $db->prepare($updateAddressSQL);
    $addressStatement->execute([$purok, $postalCode, $consumerId]);

    echo json_encode(['status' => 'success', 'message' => 'Consumer updated successfully']);
    exit;
}

function insertAddConsumer($fName, $mName, $lName, $suffix, $contactNo, $emailAd, $purok, $postalCode, $status) {
    global $db; // Access the global $db variable

    try {
        $fName = strtoupper($fName);
        $mName = strtoupper($mName);
        $lName = strtoupper($lName);
        $suffix = strtoupper($suffix);
        $emailAd = strtoupper($emailAd);
        $purok = strtoupper($purok);
        $postalCode = strtoupper($postalCode);

        $sql = "INSERT INTO conscessionaries (cFName, cMName, cLName, cSuffix, cContactNo, cEmailAd, dateAdded, cStatus) 
                VALUES ( :firstName, :middleName, :lastName, :suffix, :contactNo, :emailAddress, CURRENT_DATE, :status)";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':firstName', $fName);
        $stmt->bindParam(':middleName', $mName);
        $stmt->bindParam(':lastName', $lName);
        $stmt->bindParam(':suffix', $suffix);
        $stmt->bindParam(':contactNo', $contactNo);
        $stmt->bindParam(':emailAddress', $emailAd);
        $stmt->bindParam(':status', $status);

        $stmt->execute();

        $cID = $db->lastInsertId();

        $insertAddressSQL = "INSERT INTO address (cID, purok, postalCode) VALUES ( ?, ?,?)";
        $addressStatement = $db->prepare($insertAddressSQL);
        $addressStatement->execute([$cID, $purok, $postalCode]);
    } catch (PDOException $e) {
        throw $e;
    }
}
function getConsumerById($id){
    global $db;
    
    $sql = "SELECT * FROM get_consumers
    WHERE cID = :consumerId
    ORDER BY cFName";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':consumerId', $id, PDO::PARAM_INT);
    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response = [
        "consumer" => $data
    ];

    echo json_encode($response);
}
function checkConsumerExists($firstName, $middleName, $lastName, $suffix) {
    global $db; 

    try {
        $firstName = strtoupper($firstName);
        $middleName = strtoupper($middleName);
        $lastName = strtoupper($lastName);
        $suffix = strtoupper($suffix);

        $sql = "SELECT COUNT(*) AS count FROM conscessionaries 
                WHERE UPPER(cFName) = :firstName 
                AND UPPER(cMName) = :middleName 
                AND UPPER(cLName) = :lastName 
                AND UPPER(cSuffix) = :suffix";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':middleName', $middleName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':suffix', $suffix);

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['count'] > 0;
    } catch (PDOException $e) {
        throw $e;
    }
}
function getConsumers() {
    global $db;

    try {
        $sql = "SELECT * FROM get_consumers WHERE cStatus != 3 ORDER BY cFName;";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Wrap the data in an associative array with a key named "consumer"
        $response = [
            "status" => "success",
            "consumer" => $data
        ];

        echo json_encode($response);
    } catch (PDOException $e) {
        // Handle the exception, log, or throw it again based on your needs
        $response = [
            "status" => "error",
            "message" => "Error retrieving consumer data."
        ];

        echo json_encode($response);
    }
}
?>
