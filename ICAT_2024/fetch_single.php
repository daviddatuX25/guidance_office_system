<?php
include('db.php');
include('function.php');
if (isset($_POST["user_id"])) {
    $output = array();
    $statement = $connection->prepare(
        "SELECT * FROM tbl_applicants
        WHERE id = :user_id
        LIMIT 1"
    );
    $statement->bindParam(':user_id', $_POST["user_id"]);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        $output["appNo"] = $row["appNo"];
        $output["lastname"] = $row["lastname"];
        $output["firstname"] = $row["firstname"];
        $output["midname"] = $row["midname"];
        $output["sex"] = $row["sex"];
        $output["strand"] = $row["strand"];
        $output["course"] = $row["course"];
        $output["genAbility"] = $row["genAbility"];
        $output["verbal"] = $row["verbal"];
        $output["numerical"] = $row["numerical"];
        $output["s_patial"] = $row["s_patial"];
        $output["p_erceptual"] = $row["p_erceptual"];
        $output["m_anDexterity"] = $row["m_anDexterity"];
        $output["date_taken"] = $row["date_taken"];
    }
    echo json_encode($output);
}
?>
