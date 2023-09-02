<html>
    <?php echo 'hello' ?>
    <?php 
        $hello = 'test';
        echo $hello;

    ?>
    <?php

        // Function to sanitize input data
        function sanitize($data) {
            return htmlspecialchars(strip_tags($data));
        }

        if(isset($_POST["user"])) {
            $userName = sanitize($_POST["user"]);
            echo "Hello, $userName!";
            
            //mysql**, postgresql, oracle, sqlite*, odbc,sybase
            //*mais simples, **tem no xampp

            //PDO php data objects
            $db = new PDO('sqlite:database01.db'); //tratar exposicao da database na rede publica
            //$db = new PDO('sqlite:../../db/database01.db'); //tratar exposicao da database na rede publica
            //$dados = array('numero', 'texto');

            $stmt = $db->prepare("select * from table01 where string01 = :username");
            $stmt->bindParam(':username', $userName);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            
            print '<table><tr><th>numero</th><th>string</th></tr>';
            foreach ($rows as $row){
                print "<tr><td>$row[0]</td><td>$row[1]</td></tr>";
            }
            print '</table>';

            $option = $_POST["Add"] ?? $_POST["Read"] ?? $_POST["Update"] ?? $_POST["Update"] ?? '';
            if($userName=="create"){
                $db->exec("CREATE TABLE dishes (
                    dish_id INT,
                    dish_name VARCHAR(255),
                    price DECIMAL(4,2),
                    is_spicy INT
                )");
            }
            $pieces = explode(" ", $option . " " . $userName);
            if($pieces[0]=="add"){
                $dishId = $pieces[1];
                $dishName = $pieces[2];
                $price = $pieces[3];
                $isSpicy = $pieces[4];

                // Use prepared statements to avoid SQL injection
                $stmt = $db->prepare("INSERT INTO dishes (dish_id, dish_name, price, is_spicy) 
                                    VALUES (:dish_id, :dish_name, :price, :is_spicy)");

                // Bind parameters
                $stmt->bindParam(':dish_id', $dishId);
                $stmt->bindParam(':dish_name', $dishName);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':is_spicy', $isSpicy);

                 // Execute the query
                if ($stmt->execute()) {
                    echo "Dish added successfully!";
                } else {
                    echo "Failed to add dish.";
                }
            }

            if($pieces[0]=="update"){
                $dishId = $pieces[1];
                $dishName = $pieces[2];
                $price = $pieces[3];
                $isSpicy = $pieces[4];

                // Use prepared statements to avoid SQL injection
                $stmt = $db->prepare("UPDATE dishes SET dish_id=:dish_id, dish_name=:dish_name, price=:price, is_spicy=:is_spicy 
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

            
            if($pieces[0]=="delete"){
                $dishId = $pieces[1];

                // Use prepared statements to avoid SQL injection
                $stmt = $db->prepare("DELETE FROM dishes 
                                    WHERE dish_id=:dish_id OR dish_name=:dish_id");

                // Bind parameters
                $stmt->bindParam(':dish_id', $dishId);

                 // Execute the query
                if ($stmt->execute()) {
                    echo "Dish deleted successfully!";
                } else {
                    echo "Failed to add dish.";
                }
            }

            if($pieces[0]=="read"){
                $dishId = $pieces[1];                
                $stmt = $db->prepare("SELECT * FROM dishes 
                                    WHERE dish_id=:dish_id OR dish_name=:dish_id");
                $stmt->bindParam(':dish_id', $dishId);
                $stmt->execute();
                $rows = $stmt->fetchAll();

                print '<table><tr><th>nome</th><th>preco</th></tr>';
                foreach ($rows as $row){
                    print "<tr><td>$row[1]</td><td>$row[2]</td></tr>";
                }
                print '</table>';
            }
        }
        
    ?>

    
    <?php 
        class Prato {
            public $nome;
            public $ingredients= array();
            
            public function hasIngredient($ingredient) {
                return in_array($ingredient, $this->ingredients);
            }
            
        }

        $sopa = new Prato;
        $sopa->nome = "sopa de frango";
        $sopa->ingredients = array("frango", "agua");

        $sanduiche = new Prato;
        $sanduiche->nome = "sopa de frango";
        $sanduiche->ingredients = array("frango", "pao");

        foreach (['frango','limao','pao','agua'] as $ing){
            if ($sopa->hasIngredient($ing)) print "sopa contem $ing\n";
            if ($sanduiche->hasIngredient($ing)) print "sanduiche contem $ing\n";
        }

        try{

        }catch (Exception $e){

        }

        print<<<_HTML_
        <p>teste</p> 
        _HTML_;

        //site.php/?q=KEY1&api=TTT
        //$_GET['q']
        
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Layout Example</title>
  <link rel="stylesheet" href="./style.css"/>
</head>
<body>
  <nav>
    <h1>Navigation Bar</h1>
    <!-- Add navigation links or buttons here -->
  </nav>

  <div class="container">
    <aside class="aside">
      <h2>Aside Column</h2>
      <!-- Add aside content here -->
    </aside>

    <main class="main">
      <div class="section">
        <h2>Section 1</h2>
        
            <form method="post" action="./">

                Seu nome: <input type="text" name="user"/><br>

                <label>
                <input type="radio" name="Add" value="add">
                Add
                </label><br>
                
                <label>
                <input type="radio" name="Read" value="read">
                Read
                </label><br>
                
                <label>
                <input type="radio" name="Update" value="update">
                Update
                </label><br>
                
                <label>
                <input type="radio" name="Delete" value="delete">
                Delete
                </label><br>

                <button type="submit">Say Hello</button>

            </form>
        <!-- Add content for section 1 here -->
      </div>

      <div class="section">
        <h2>Section 2</h2>
        <?php
            $userName = sanitize($_POST["user"]);
            echo "Hello, $userName!";
        ?>
        <!-- Add content for section 2 here -->
      </div>

      <!-- Add more sections as needed -->
    </main>
  </div>
</body>    
</html>