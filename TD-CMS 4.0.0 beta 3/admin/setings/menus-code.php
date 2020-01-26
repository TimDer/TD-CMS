<?php

session_start();

if (!isset($start)) {
    require_once '../../start.php';
}

if (isset($_SESSION['user'])) {

	require BASE_DIR . '/db.php';

    $idPermission = $_SESSION['id'];

    $sqlUserid      = "SELECT * FROM users WHERE id='$idPermission'";
    $queryUserid    = mysqli_query($conn, $sqlUserid);

    if ($queryUserid->num_rows > 0) {
        if ($rowPermission = mysqli_fetch_assoc($queryUserid)) {
            if ($rowPermission['menus'] === 'yes') {
                if (isset($_POST['menuArray'])) {
                    foreach ($_POST['menuArray'] as $menuArray) {
                        // 0 = db_id
                        // 1 = the_order
                        // 2 = parent_id
                        // 3 = input_name
                        // 4 = input_url

                        $db_id      = $menuArray[0];
                        $the_order  = $menuArray[1];
                        $parent_id  = $menuArray[2];
                        $input_name = $menuArray[3];
                        $input_url  = $menuArray[4];

                        $sql = "UPDATE menus SET the_name = '$input_name',
                                                    the_url = '$input_url',
                                                    the_order = '$the_order',
                                                    parent_id = '$parent_id'
                                                    WHERE id=$db_id";

                        mysqli_query($conn, $sql);
                    }

                    exit('Success ');
                }
                elseif (isset($_POST['addNew'])) {
                    $addNewLink     = mysqli_real_escape_string($conn, $_POST['addNewLink']);
                    $addNewUrl      = mysqli_real_escape_string($conn, $_POST['addNewUrl']);
                    $addNewMenu     = mysqli_real_escape_string($conn, $_POST['addNewMenu']);


                    $addNewCallDataSql      = "SELECT * FROM menus WHERE parent_id=0 AND menu_name='$addNewMenu' ORDER BY the_order DESC LIMIT 1";
                    $addNewCallDataSqlQuery = mysqli_query($conn, $addNewCallDataSql);

                    if ($addNewCallDataSqlQuery->num_rows > 0) {
                        while ($addNewCallDataRows = mysqli_fetch_assoc($addNewCallDataSqlQuery)) {
                            $addNewCallDataNumber = $addNewCallDataRows['the_order'];
                        }
                        $addNewCallDataNumber = $addNewCallDataNumber + 1;
                    }
                    else {
                        $addNewCallDataNumber = 1;
                    }
                    
                    $addNewSql      = "INSERT INTO menus (the_name,
                                                            the_url,
                                                            the_order,
                                                            parent_id,
                                                            menu_name)
                                                            VALUES (
                                                                '$addNewLink',
                                                                '$addNewUrl',
                                                                '$addNewCallDataNumber',
                                                                0,
                                                                '$addNewMenu'
                                                            )
                                                            ";
                    
                    if (mysqli_query($conn, $addNewSql)) {
                        header("Location: " . ADMIN_URL . "/setings.php?command=menus&menu_name=" . $addNewMenu);
                    }
                    else {
                        echo "Error: " . $conn->error;
                    }
                    

                    

                }
                elseif (isset($_GET['deleteById'])) {
                    $getId = mysqli_real_escape_string($conn, $_GET['deleteById']);
                    
                    // select all children
                    function selectMenuById($selectByIdArray = array(), $disableFirst = 0) {

                        // get all children if exists

                        global $conn;

                        if ($disableFirst === 0) {
                            foreach ($selectByIdArray AS $deleteById) {
                                $id = $deleteById;
                                
                                $selectByIdCallDataSql      = "SELECT * FROM menus WHERE parent_id=$id";
                                $selectByIdCallDataSqlQuery = mysqli_query($conn, $selectByIdCallDataSql);

                                if ($selectByIdCallDataSqlQuery->num_rows > 0) {
                                    while ($selectByIdRows  = mysqli_fetch_assoc($selectByIdCallDataSqlQuery)) {
                                        if (!in_array($selectByIdRows['id'], $selectByIdArray)) {
                                            $selectByIdArray[]  = $selectByIdRows['id'];
                                        }
                                    }
                                    $stop = "false";
                                }
                                else {
                                    $stop = "true";
                                }
                            }
                        }
                        else {
                            $id = $disableFirst;
                                
                            $selectByIdCallDataSql      = "SELECT * FROM menus WHERE parent_id=$id";
                            $selectByIdCallDataSqlQuery = mysqli_query($conn, $selectByIdCallDataSql);
        
                            if ($selectByIdCallDataSqlQuery->num_rows > 0) {
                                while ($selectByIdRows  = mysqli_fetch_assoc($selectByIdCallDataSqlQuery)) {
                                    $selectByIdArray[]  = $selectByIdRows['id'];
                                }
                                $stop = "false";
                            }
                            else {
                                $stop = "true";
                            }
                        }
                        
                        // store children to an array
                        if ($stop === "true") {
                            return $selectByIdArray;
                        }
                        else {
                            $selectByIdArrayNew = selectMenuById($selectByIdArray);
                            return $selectByIdArrayNew;
                        }
                    }
                    $selectByIdArrayNew = selectMenuById(array(), $getId);

                    // get the menu name
                    $getMenu_nameSQL        = "SELECT menu_name FROM menus WHERE id=$getId";
                    $getMenu_nameSQLQuery   = mysqli_query($conn, $getMenu_nameSQL);
                    if ($getMenu_nameSQLQuery->num_rows > 0) {
                        if ($getMenu_nameRow = mysqli_fetch_assoc($getMenu_nameSQLQuery)) {
                            $menuName      = $getMenu_nameRow['menu_name'];
                        }
                    }

                    // delete all
                    $deleteSQL              = "DELETE FROM menus WHERE id=$getId";
                    mysqli_query($conn, $deleteSQL);
                    foreach ($selectByIdArrayNew as $deleteArray) {
                        $deleteID           = $deleteArray;
                        $deleteSQL          = "DELETE FROM menus WHERE id=$deleteID";
                        mysqli_query($conn, $deleteSQL);
                    }

                    // redirect back
                    $redirectSQL            = "SELECT * FROM menus WHERE menu_name='$menuName'";
                    $redirectSQLQuery       = mysqli_query($conn, $redirectSQL);
                    if ($redirectSQLQuery->num_rows > 0) {
                        header("Location: " . ADMIN_URL . "/setings.php?command=menus&menu_name=" . $menuName);
                    }
                    else {
                        header("Location: " . ADMIN_URL . "/setings.php?command=menus");
                    }
                }
            }
        }
    }

}
else {
    header('Location: ' . ADMIN_URL . '/login.php');
}

?>