<?php

function sanitize($data) {
    return htmlspecialchars(strip_tags($data));
}

$host = "localhost";
$username = "root";
$password = "";
$database = "test";

//$conn = mysqli_connect($host, $username, $password, $database) OR die("Error connecting to MySQL: " . mysqli_connect_error());;

$conn = new PDO("mysql:host=".$host.";dbname=".$database, $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


//PEPARE TABLE from zero
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

//CREATE simple sql injection vulnerability 
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

//CREATE
//to avoid sql injection
function insertDish($pdo, $dish_name, $price, $is_spicy) {
    try {
        // Prepare the INSERT statement with named placeholders
        $stmt = $pdo->prepare("INSERT INTO dishes (dish_name, price, is_spicy) 
                    VALUES (:dish_name, :price, :is_spicy)");
        
        // Bind parameters
        $stmt->bindParam(':dish_name', $dish_name, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_INT);
        $stmt->bindParam(':is_spicy', $is_spicy, PDO::PARAM_INT);
        
        // Execute the statement
        $stmt->execute();
        
        return true; // Insertion successful
    } catch (PDOException $e) {
        // Handle any errors here
        die("Error: " . $e->getMessage());
    }
}

// Usage
$dish_name = 'maca';
$price = 2.99;
$is_spicy = 0;

if (insertDish($conn, $dish_name, $price, $is_spicy)) {
    echo "User inserted successfully.<br>";
} else {
    echo "Error inserting user.<br>";
}


////SIMPLE READ
//$sql = "SELECT * FROM dishes";
//
//$stmt = $conn->prepare($sql);
//$stmt->execute();
//$rows = $stmt->fetchAll();
//
//print '<table><tr><th>numero</th><th>string</th></tr>';
//foreach ($rows as $row){
//    print "<tr><td>$row[0]</td><td>$row[1]</td></tr>";
//}
//print '</table>';

//READ SIMPLE
/* 
$info="sorvete";
$sql = "SELECT * FROM dishes WHERE dish_name = '$info'";
$result = mysqli_query($conn, $sql) OR die("Error: " . mysqli_error($mysqli));

while ($row = mysqli_fetch_assoc($result)) {
    echo "name: " . $row["dish_name"] . ", price: " . $row["price"] . "<br>";
}
 */

//READ ONCE
// Function to retrieve data securely
function getDishByDishName($pdo, $dish_name) {
    try {
        // Prepare the statement with a named placeholder
        $stmt = $pdo->prepare("SELECT * FROM dishes WHERE dish_name = :dish_name");
        
        // Bind the parameter
        $stmt->bindParam(':dish_name', $dish_name, PDO::PARAM_STR);
        
        // Execute the statement
        $stmt->execute();
        
        // Fetch the result as an associative array
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $user;
    } catch (PDOException $e) {
        // Handle any errors here
        die("Error: " . $e->getMessage());
    }
}

// Usage
$usernameToRetrieve = 'sorvete';
$user = getDishByDishName($conn, $usernameToRetrieve);
echo $user;

//READ ALL
function getAllDishes($pdo) {
    try {
        // Prepare the statement
        $stmt = $pdo->prepare("SELECT * FROM dishes");
        
        // Execute the statement
        $stmt->execute();
        
        // Fetch all results as an associative array
        $dishes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $dishes;
    } catch (PDOException $e) {
        // Handle any errors here
        die("Error: " . $e->getMessage());
    }
}
print '<table><tr><th>nome</th><th>preco</th></tr>';
foreach (getAllDishes($conn) as $row){
    foreach($row as $r) echo $r." ";
    echo "<br/>";
}
print '</table>';


//UPDATE
function update($conn, $dishId, $dishName, $price, $isSpicy){
// Use prepared statements to avoid SQL injection
    $stmt = $conn->prepare("UPDATE dishes SET dish_id=:dish_id, dish_name=:dish_name, price=:price, is_spicy=:is_spicy 
    WHERE dish_id=:dish_id");

    // Bind parameters
    $stmt->bindParam(':dish_id', $dishId);
    $stmt->bindParam(':dish_name', $dishName);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':is_spicy', $isSpicy);

    // Execute the query
    if ($stmt->execute()) {
    echo "Dish updated successfully!";
    } else {
    echo "Failed to add dish.";
    }
}
update($conn,"2","mousse",4,0);


//DELETE
function deleteDishByDishName($pdo, $dish_name) {
    try {
        // Prepare the statement with a named placeholder
        $stmt = $pdo->prepare("DELETE FROM dishes WHERE dish_name = :dish_name");
        
        // Bind the parameter
        $stmt->bindParam(':dish_name', $dish_name, PDO::PARAM_STR);
        
        // Execute the statement
        $stmt->execute();

    } catch (PDOException $e) {
        // Handle any errors here
        die("Error: " . $e->getMessage());
    }
}

$usernameToRetrieve = 'sorvete';
deleteDishByDishName($conn, $usernameToRetrieve);



?>
