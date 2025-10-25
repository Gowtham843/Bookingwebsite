<?php
$hname = 'localhost';
$uname = 'root';
$pass = '';
$db = 'hbwebsite';
$port = 3309;   // 👈 added your new port

$conn = mysqli_connect($hname, $uname, $pass, $db, $port);

$conn = mysqli_connect($hname, $uname, $pass, $db, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// make it available globally
$GLOBALS['con'] = $conn;


function Filteration($data)
{
    foreach ($data as $key => $value) {
        $value = trim($value);
        $value = stripslashes($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value);

        $data[$key] = $value;
    }
    return $data;
}

function select($sql, $values, $datatypes)
{

    $con = $GLOBALS['con'];
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);

        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);

            return $res;
        } else {
            mysqli_stmt_close($stmt);

            die("Query cannot be executed - Select");
        }
    } else {
        die("Query cannot be prepared - Select");
    }
}


function  selectAll($table)
{
    $con = $GLOBALS['con'];
    $res = mysqli_query($con, "Select  * from $table");
    return $res;
}

function update($sql, $values, $datatypes)
{

    $con = $GLOBALS['con'];
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);

        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);

            return $res;
        } else {
            mysqli_stmt_close($stmt);

            die("Query cannot be executed - Update");
        }
    } else {
        die("Query cannot be prepared - Update");
    }
}
function insert($sql, $values, $datatypes)
{

    $con = $GLOBALS['con'];
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);

        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);

            return $res;
        } else {
            mysqli_stmt_close($stmt);

            die("Query cannot be executed - Insert");
        }
    } else {
        die("Query cannot be prepared - Insert");
    }
}


function delete($sql, $values, $datatypes)
{

    $con = $GLOBALS['con'];
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);

        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);

            return $res;
        } else {
            mysqli_stmt_close($stmt);

            die("Query cannot be executed - Delete");
        }
    } else {
        die("Query cannot be prepared - Delete");
    }
}
