<?php

require "../../Config/config.php";
class crud
{
    function addNewUser($objUser){

        global $conn;

        $sql_query = "CALL SP_ADD_NEW_USER('". mysqli_real_escape_string($conn, $objUser->getFirstName()) ."',
                                                '". mysqli_real_escape_string($conn, $objUser->getLastName())."',
                                                '".$objUser->getRoleID()."',
                                                '".$objUser->getEmail()."',
                                                '".$objUser->getGender()."',
                                                '".$objUser->getPhone()."',
                                                '".$objUser->getDOB()."',
                                                '".$objUser->getPassword()."')";

        $result = mysqli_query($conn, $sql_query) or die("Query fail: " . mysqli_error());

        // Associative array
        $row=mysqli_fetch_array($result,MYSQLI_ASSOC);

        mysqli_close($conn);

        echo  $row["result"];
    }

    function checkMailIsExists($Email){
        global $conn;

        $sql_query = "CALL SP_CHECK_EMAIL_IS_EXIXTS('". mysqli_real_escape_string( $conn ,$Email) ."')";

        $result = mysqli_query($conn, $sql_query) or die("Query fail: " . mysqli_error());

        // Associative array
        $row=mysqli_fetch_array($result,MYSQLI_ASSOC);

        mysqli_close($conn);

        return  $row["result"];

    }

    function verificationAccountByEmail($email){
        global $conn;

        $sql_query = "CALL SP_VERIFICATION_ACCOUNT('". mysqli_real_escape_string( $conn ,$email) ."')";

        $result = mysqli_query($conn, $sql_query) or die("Query fail: " . mysqli_error());

        // Associative array
        $row=mysqli_fetch_array($result,MYSQLI_ASSOC);

        mysqli_close($conn);

        return  $row["result"];

    }

    function  authenticateUserLogin($email, $password){
        global $conn;

        $sql_query = "CALL SP_CHECK_USER_LOGIN('". mysqli_real_escape_string( $conn ,$email) ."','". mysqli_real_escape_string( $conn ,$password) ."')";

        $result = mysqli_query($conn, $sql_query) or die("Query fail: " . mysqli_error());

        // Associative array
        $row=mysqli_fetch_array($result,MYSQLI_ASSOC);

        return $row;

    }

    function getUserByEmail($email){
        global $conn;


        $sql_query = "CALL SP_GET_USER_BY_EMAIL('". mysqli_real_escape_string( $conn ,$email) ."')";


        $result = mysqli_query($conn, $sql_query) or die("Query fail: " . mysqli_error());

        // Associative array
        $row=mysqli_fetch_array($result,MYSQLI_ASSOC);

        return $row;

    }

    function getUserByID($userID){
        global $conn;


        $sql_query = "CALL GET_USER_BY_ID('". mysqli_real_escape_string( $conn ,$userID) ."')";


        $result = mysqli_query($conn, $sql_query);

        // Associative array
        $row=mysqli_fetch_array($result,MYSQLI_ASSOC);

        return $row;

    }

    function  getUserListForAdminPanel(){
        global $conn;


        $sql_query = "CALL SP_GET_USERS_FOR_ADMIN_VIEW()";


        $result = mysqli_query($conn, $sql_query);


        $array = array();

        while ($row = mysqli_fetch_assoc($result))
        {
            array_push($array, $row);
        }

        // Associative array
        //$row=mysqli_fetch_array($result,MYSQLI_ASSOC);

        return $array;
    }

    function  getAllRoles($currentUserRoleID){
        global $conn;


        $sql_query = "CALL SP_GET_ALL_ROLES('".$currentUserRoleID."')";


        $result = mysqli_query($conn, $sql_query);


        $array = array();

        while ($row = mysqli_fetch_assoc($result))
        {
            array_push($array, $row);
        }

        // Associative array
        //$row=mysqli_fetch_array($result,MYSQLI_ASSOC);

        return $array;
    }

    function updateUserByAdmin($objUser){
        global $conn;
        $sql_query = "CALL SP_UPDATE_USER_BY_ADMIN('". mysqli_real_escape_string($conn, $objUser->getUserName()) ."',
                    '". mysqli_real_escape_string($conn, $objUser->getRoleID()) ."',
                    '". mysqli_real_escape_string($conn, $objUser->getFirstName()) ."',
                    '". mysqli_real_escape_string($conn, $objUser->getLastName()) ."',
                    '". mysqli_real_escape_string($conn, $objUser->getGender()) ."',
                    '". mysqli_real_escape_string($conn, $objUser->getPhone()) ."',
                    '". mysqli_real_escape_string($conn, $objUser->getDOB()) ."',
                    '". mysqli_real_escape_string($conn, $objUser->getIsActive()) ."')";

        $result = mysqli_query($conn, $sql_query);
        $row=mysqli_fetch_array($result,MYSQLI_ASSOC);

        return $row;
    }

    function  getTrainListForAdminPanel(){
        global $conn;


        $sql_query = "CALL SP_GET_TRAIN_DETAILS_FOR_ADMINPANEL()";


        $result = mysqli_query($conn, $sql_query);


        $array = array();

        while ($row = mysqli_fetch_assoc($result))
        {
            array_push($array, $row);
        }

        // Associative array
        //$row=mysqli_fetch_array($result,MYSQLI_ASSOC);

        return $array;
    }

    function  getAllActiveClasses(){
        global $conn;


        $sql_query = "CALL SP_GET_ALL_ACTIVE_CLASSES()";


        $result = mysqli_query($conn, $sql_query);


        $array = array();

        while ($row = mysqli_fetch_assoc($result))
        {
            array_push($array, $row);
        }

        // Associative array
        //$row=mysqli_fetch_array($result,MYSQLI_ASSOC);

        return $array;
    }

    function  updateTokenRecords($userID, $type, $token){
        global $conn;


        //perverting Query fail: Commands out of sync; you can't run this command now
        while($conn->more_results())
        {
            $conn->next_result();
            if($res = $conn->store_result())
            {
                $res->free();
            }
        }


        $sql_query = "CALL SP_RESET_USER_PASSWORD('".$userID."','".$type."','".$token."');";

        //echo $sql_query;

        mysqli_query($conn, $sql_query) or die("Query fail: " . mysqli_error($conn));


    }

    function updateUserPassword($token, $Password){
        global $conn;

        $sql_query = "CALL SP_RESET_USER_PASSWORD_BY_TOKEN('".$token."','".$Password."');";

        //echo $sql_query;

        mysqli_query($conn, $sql_query) or die("Query fail: " . mysqli_error($conn));
    }


    function getAllStations(){
        global $conn;

        $sql_query = "SELECT StationID,Description,DescriptionLong,DistanceFromMainStation, CONCAT(DistanceFromMainStation, ' KM') as DistanceFromMainStationKM,isActive, case when isActive = '1' then 'YES' else 'NO' end as Active FROM station;";

        //echo $sql_query;

        $result = mysqli_query($conn, $sql_query) or die("Query fail: " . mysqli_error($conn));

        $array = array();

        while ($row = mysqli_fetch_assoc($result))
        {
            array_push($array, $row);
        }


        return $array;
    }

    function addNewStation($station, $discriptionLong, $Distance){
        global $conn;

        $sql_query = "CALL SP_NEW_STATION('".$station."','".$discriptionLong."','".$Distance."');";

        mysqli_query($conn, $sql_query) or die("Query fail: " . mysqli_error($conn));
    }

    function getStationByID($stationID){
        global $conn;


        $sql_query = "CALL SP_GET_STATION_BY_ID('". mysqli_real_escape_string( $conn ,$stationID) ."')";


        $result = mysqli_query($conn, $sql_query);

        // Associative array
        $row=mysqli_fetch_array($result,MYSQLI_ASSOC);

        return $row;
    }

    function UpdateStation($stationID, $station, $discriptionLong, $Distance){
        global $conn;

        $sql_query = "CALL SP_UPDATE_STATION('".$stationID."','".$station."','".$discriptionLong."','".$Distance."');";

        mysqli_query($conn, $sql_query) or die("Query fail: " . mysqli_error($conn));
    }

    function RemoveStation($stationID){
        global $conn;

        $sql_query = "DELETE FROM station WHERE StationID = '".$stationID."';";

        mysqli_query($conn, $sql_query) or die("Query fail: " . mysqli_error($conn));
    }


}

?>