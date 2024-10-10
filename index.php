<?php

function connection(){
    $host = "localhost:3306";
    $user = "root";
    $pass = "ROOT";

    $bd = "northwind";

    $connect=mysqli_connect($host, $user, $pass);

    mysqli_select_db($connect, $bd);

    return $connect;

}

$con = connection();

$sql = "SELECT p.ProductName AS Product_Name,
            (SELECT c.CategoryName  
            FROM Categories c 
            WHERE c.CategoryID = p.CategoryID) AS Name_Category,p.UnitPrice AS Unit_Price
            FROM Products p
            WHERE p.UnitPrice > (
    SELECT
        AVG(p2.UnitPrice)
    FROM
        products p2
    WHERE
        p2.CategoryID = p.CategoryID);";
                            
$query = mysqli_query($con, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso a datos</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
<div class="container mt-5">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
                <?php while ($row = mysqli_fetch_array($query)): ?>
                <tr>
                    <td> <?= $row["Product_Name"] ?> </td>
                    <td> <?= $row["Name_Category"] ?> </td>
                    <td> <?= $row["Unit_Price"] ?> </td>
                </tr>
                <?php endwhile; ?>  
            </tbody>
        </table>
    </div>
</body>
</html>