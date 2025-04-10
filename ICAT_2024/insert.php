<?php
include('db.php');
include('function.php');

if (isset($_POST["operation"])) {
    if ($_POST["operation"] == "Add") {
        $statement = $connection->prepare("
            INSERT INTO tbl_applicants (appNo, firstname, lastname, midname, sex, strand, course, genAbility, verbal, numerical, s_patial, p_erceptual, m_anDexterity, date_taken) 
                 VALUES (:appNo, :firstname, :lastname, :midname, :sex, :strand, :course, :genAbility, :verbal, :numerical, :s_patial, :p_erceptual, :m_anDexterity, :date_taken)
        ");
        $result = $statement->execute(
            array(
                ':appNo' => $_POST["appNo"],
                ':firstname' => $_POST["firstname"],
                ':lastname' => $_POST["lastname"],
                ':midname' => $_POST["midname"],
                ':sex' => $_POST["sex"],
                ':strand' => $_POST["strand"],
                ':course' => $_POST["course"],
                ':genAbility' => $_POST["genAbility"],
                ':verbal' => $_POST["verbal"],
                ':numerical' => $_POST["numerical"],
                ':s_patial' => $_POST["s_patial"],
                ':p_erceptual' => $_POST["p_erceptual"],
                ':m_anDexterity' => $_POST["m_anDexterity"],
                ':date_taken' => $_POST["date_taken"]
            )
        );
        if (!empty($result)) {
            echo 'Data Inserted';
        }
    }
    if ($_POST["operation"] == "Edit") {
        $statement = $connection->prepare(
            "UPDATE tbl_applicants 
            SET 
            appNo = :appNo,
            lastname = :lastname,
            firstname = :firstname,
            midname = :midname,
            sex = :sex,
            strand = :strand,
            course = :course,
            genAbility = :genAbility,
            verbal = :verbal,
            numerical = :numerical,
            s_patial = :s_patial,
            p_erceptual = :p_erceptual,
            m_anDexterity = :m_anDexterity,
            date_taken = :date_taken

            WHERE

            id = :id
            "
        );
        $result = $statement->execute(
            array(
                ':appNo' => $_POST["appNo"],
                ':lastname' => $_POST["lastname"],
                ':firstname' => $_POST["firstname"],
                ':midname' => $_POST["midname"],
                ':sex' => $_POST["sex"],
                ':strand' => $_POST["strand"],
                ':course' => $_POST["course"],
                ':genAbility' => $_POST["genAbility"],
                ':verbal' => $_POST["verbal"],
                ':numerical' => $_POST["numerical"],
                ':s_patial' => $_POST["s_patial"],
                ':p_erceptual' => $_POST["p_erceptual"],
                ':m_anDexterity' => $_POST["m_anDexterity"],
                ':date_taken' => $_POST["date_taken"],

                ':id' => $_POST["user_id"]
            )
        );
        if (!empty($result)) {
            echo 'Data Updated';
        }
    }
}
?>
