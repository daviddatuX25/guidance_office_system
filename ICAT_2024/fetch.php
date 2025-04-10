<?php
    include('db.php');
    include('function.php');
    $query = '';
    $output = array();
    $query .= "SELECT * FROM tbl_applicants"; // Assuming your table is named 'products'
    if(isset($_POST["search"]["value"]))
    {
        $query .= ' where firstname LIKE "%'.$_POST["search"]["value"].'%" ';
    }
    if(isset($_POST["order"]))
    {
        $query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
    }
    else
    {
        $query .= 'ORDER BY id DESC '; // Adjusted for the 'productID' column
    }
    if($_POST["length"] != -1)
    {
        $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    }
    $statement = $connection->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $data = array();
    $filtered_rows = $statement->rowCount();
    foreach($result as $row)
    {
        $sub_array = array();
        $sub_array[] = $row["appNo"];
        $sub_array[] = $row["firstname"];
        $sub_array[] = $row["lastname"];
        $sub_array[] = $row["midname"];
        $sub_array[] = $row["sex"];

        $sub_array[] = '<button type="button" class="btn btn-outline-warning btn-sm view" id="'.$row["id"].'">
            <i class="bx bxs-show bx-tada-hover"></i></button>

            <button type="button" name="update" id="'.$row["id"].'" class="btn btn-outline-primary btn-sm update"><i class="bx bxs-pencil bx-tada-hover"></i></button>

            <button type="button" name="delete" id="'.$row["id"].'" class="btn btn-outline-danger btn-sm delete"><i class="bx bxs-trash bx-tada-hover"></i></button>';
        $data[] = $sub_array;
    }
    $output = array(
        "draw"              =>  intval($_POST["draw"]),
        "recordsTotal"      =>  $filtered_rows,
        "recordsFiltered"   =>  get_total_all_records(),
        "data"              =>  $data
    );
    echo json_encode($output);
?>
