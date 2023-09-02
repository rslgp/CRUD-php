<?php

function sanitize($data) {
    return htmlspecialchars(strip_tags($data));
}

$host = "localhost";
$username = "root";
$password = "";
$database = "test";

$conn = mysqli_connect($host, $username, $password, $database) OR die("Error connecting to MySQL: " . mysqli_connect_error());;

//$conn = new PDO("mysql:host=".$host.";dbname=".$database, $username, $password);
//$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//$sql = "CREATE TABLE dishes (
//    dish_id INT KEY AUTO_INCREMENT,
//    dish_name VARCHAR(255),
//    price DECIMAL(4,2),
//    is_spicy INT
//)";


//$result = mysqli_query($conn, $sql);
//
//if ($result === false) {
//  die("Error executing SQL query: " . mysqli_error($conn));
//}
/* 
$sql = "INSERT INTO dishes (
    dish_name,
    price,
    is_spicy
)
VALUES ('sorvete', 5, 0)";


$result = mysqli_query($conn, $sql);

if ($result === false) {
  die("Error executing SQL query: " . mysqli_error($conn));
}
 */
/* 
//to avoid sql injection
$info="sorvete";
$sql = "SELECT * FROM dishes WHERE dish_name = :info";

$stmt = $conn->prepare($sql);
$stmt->bindParam(":info", $info);
$stmt->execute();
$rows = $stmt->fetchAll();

print '<table><tr><th>numero</th><th>string</th></tr>';
foreach ($rows as $row){
    print "<tr><td>$row[0]</td><td>$row[1]</td></tr>";
}
print '</table>';
 */

$info="sorvete";
$sql = "SELECT * FROM dishes WHERE dish_name = '$info'";
$result = mysqli_query($conn, $sql) OR die("Error: " . mysqli_error($mysqli));

while ($row = mysqli_fetch_assoc($result)) {
    echo "name: " . $row["dish_name"] . ", price: " . $row["price"] . "<br>";
}

?>