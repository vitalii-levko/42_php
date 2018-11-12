<?php
// Server credits
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'password';
$logs = 'logs';
// Create connection
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);

file_put_contents($logs, "============= NEW INSTALLATION ============\r\n", FILE_APPEND);
// Check connection
if(! $conn ){
    file_put_contents($logs, "Connected failure". mysqli_connect_error() . "\r\n", FILE_APPEND);
    die();
}
file_put_contents($logs, "Connected successfully\r\n", FILE_APPEND);

// Create database
$sql = "CREATE DATABASE MINISHOP";
if (mysqli_query($conn, $sql)) {
    file_put_contents($logs, "Database created successfully\r\n", FILE_APPEND);
} else {
    file_put_contents($logs, "Error creating database: " . mysqli_error($conn) . "\r\n",FILE_APPEND);
}
// Select datacbase
mysqli_select_db($conn, "minishop");

// sql to create table Users
$sql = "CREATE TABLE USERS (
id INT(6) AUTO_INCREMENT PRIMARY KEY NOT NULL, 
login VARCHAR(30) NOT NULL UNIQUE,
password VARCHAR(255) NOT NULL,
username VARCHAR(255),
email VARCHAR(50),
role INT(6),
reg_date TIMESTAMP
)";
if (mysqli_query($conn, $sql)) {
    file_put_contents($logs, "Table 'Users' created successfully\r\n",FILE_APPEND);
} else {
    file_put_contents($logs, "Error creating table: 'Users'" . mysqli_error($conn) . "\r\n",FILE_APPEND);
}

// Insert admin data
$admin = 'admin';
$password = hash('whirlpool', '1111');
$sql = "INSERT INTO USERS (login, password, username, email)
VALUES ('${admin}', '${password}', 'John Doe', 'john@example.com')";
if (mysqli_query($conn, $sql)) {
    file_put_contents($logs, "User 'admin' created successfully\r\n",FILE_APPEND);
    file_put_contents($logs, "and set to login '${admin}' password '1111'\r\n",FILE_APPEND);
} else {
    file_put_contents($logs, "Error creating 'admin' user:" . $sql . "\r\n" . mysqli_error($conn) . "\r\n",FILE_APPEND);
}

// sql to create table Products
$sql = "CREATE TABLE PRODUCTS (
id INT(6) AUTO_INCREMENT PRIMARY KEY, 
prod_name VARCHAR(255) NOT NULL,
price INT(30) NOT NULL,
reg_date TIMESTAMP
)";
if (mysqli_query($conn, $sql)) {
    file_put_contents($logs, "Table 'Products' created successfully\r\n",FILE_APPEND);
} else {
    file_put_contents($logs, "Error creating table: 'Products'" . mysqli_error($conn) . "\r\n",FILE_APPEND);
}

// Insert product data
$prod_name = 'Apple';
$price = 23;
$sql = "INSERT INTO PRODUCTS (prod_name, price)
VALUES ('${prod_name}', '${price}')";
if (mysqli_query($conn, $sql)) {
    file_put_contents($logs, "Product created successfully\r\n",FILE_APPEND);
} else {
    file_put_contents($logs, "Error creating product:" . $sql . "\r\n" . mysqli_error($conn) . "\r\n",FILE_APPEND);
}
$prod_name = 'Potato';
$price = 14;
$sql = "INSERT INTO PRODUCTS (prod_name, price)
VALUES ('${prod_name}', '${price}')";
if (mysqli_query($conn, $sql)) {
    file_put_contents($logs, "Product created successfully\r\n",FILE_APPEND);
} else {
    file_put_contents($logs, "Error creating product:" . $sql . "\r\n" . mysqli_error($conn) . "\r\n",FILE_APPEND);
}
$prod_name = 'Peach';
$price = 35;
$sql = "INSERT INTO PRODUCTS (prod_name, price)
VALUES ('${prod_name}', '${price}')";
if (mysqli_query($conn, $sql)) {
    file_put_contents($logs, "Product created successfully\r\n",FILE_APPEND);
} else {
    file_put_contents($logs, "Error creating product:" . $sql . "\r\n" . mysqli_error($conn) . "\r\n",FILE_APPEND);
}


// sql to create table Categories
$sql = "CREATE TABLE CATEGORIES (
id INT(6) AUTO_INCREMENT PRIMARY KEY, 
cat_name VARCHAR(255) NOT NULL,
reg_date TIMESTAMP
)";
if (mysqli_query($conn, $sql)) {
    file_put_contents($logs, "Table 'Categories' created successfully\r\n",FILE_APPEND);
} else {
    file_put_contents($logs, "Error creating table: 'Categories'" . mysqli_error($conn) . "\r\n",FILE_APPEND);
}

// sql to create table Prod_Cat
$sql = "CREATE TABLE PROD_CAT (
id INT(6) AUTO_INCREMENT PRIMARY KEY, 
prod_id INT(6),
cat_id INT(6),
reg_date TIMESTAMP,
FOREIGN KEY (prod_id)
  REFERENCES products(id)
  ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (cat_id)
  REFERENCES categories(id)
  ON DELETE CASCADE ON UPDATE CASCADE
)";
if (mysqli_query($conn, $sql)) {
    file_put_contents($logs, "Table 'Prod_Cat' created successfully\r\n",FILE_APPEND);
} else {
    file_put_contents($logs, "Error creating table: 'Prod_Cat'" . mysqli_error($conn) . "\r\n",FILE_APPEND);
}

mysqli_close($conn);

$adm_category = <<<'EOD'
<?php
session_start();
include_once 'connect.php';

$name = $_GET['name'];
if (isset($_GET['add_category'])) {
    if ($name != "") {
        // Insert category data
        $sql = "INSERT INTO categories (cat_name)
        VALUES ('${name}')";
        if (mysqli_query($conn, $sql)) {
            file_put_contents($logs, "Category '${name}' created successfully\r\n", FILE_APPEND);
            echo "<script>alert('Category \'$name\' created successfully.');
        window.location.href='adm_category.php?manage_category=Manage+Categories';</script>";
        } else {
            file_put_contents($logs, "Error creating '${name}' category:" . $sql . "\r\n" . mysqli_error($conn) . "\r\n", FILE_APPEND);
            echo "<script>alert('Adding failed.\\nAll errors logged to \'logs\'.');
        window.location.href='adm_category.php?manage_category=Manage+Categories';</script>";
        }
    } else {
        echo "<script>alert('Empty category name.');
        window.location.href='adm_category.php?manage_category=Manage+Categories';</script>";
    }
}

if (isset($_GET['manage_category'])) {
    $sql = "SELECT * FROM categories";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo "Manage Categories<br><br>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<form action='manage_category.php' metod='get' name='manage_category' style='margin-bottom: 8px;'>";
            echo "<input type='text' name='id' value='" . $row['id'] . "' hidden>";
            echo "Name: <input type='text' name='cat_name' value='" . $row['cat_name'] . "'> ";
            echo "<input type='submit' name='save' value='Save'> ";
            echo "<input type='submit' name='delete' value='Delete'>";
            echo "</form>";
        }
    } else {
        file_put_contents($logs, "Empty 'Categories' table\r\n", FILE_APPEND);
        echo "<script>alert('Empty \'Categories\' table');
        window.location.href='adm_category.php?manage_category=Manage+Categories';</script>";
    }
    echo '
    <div id="adm_category">
    <form action="adm_category.php" method="get" name="adm_category">
        Name:
        <input type="text" name="name">
        <input type="submit" name="add_category" value="Add Category">
    </form>
    </div>';
    echo '<a href="index.php">Admin Panel</a>';
} else {
    echo "<script>alert('Empty product name and/or price.');
        window.location.href='adm_category.php?manage_category=Manage+Categories';</script>";
}
EOD;

file_put_contents('adm_category.php', $adm_category);

$adm_orders = <<<'EOD'
<?php
  if (!file_exists('orders.txt'))
    echo "Orders is empty";
  else {
    $data = (file('orders.txt'));
    foreach ($data as $key => $value) {
      $arr = (unserialize($value));
      ?>
      <table border="2">
        <tr>
          <td colspan="2">User: <?php echo $arr['login']?></td>
        </tr>
        <tr>
          <td>id: </td>
          <td>amount</td>
        </tr>
        <?php
          foreach ($arr['order'] as $key => $value) {
            ?>
            <tr>
              <td><?php echo $key ?></td>
              <td><?php echo $value ?></td>
            </tr>
            <?php
          }
        ?>
      </table>
      <?php
    }
  }
?>
EOD;

file_put_contents('adm_orders.php', $adm_orders);

$adm_prodcat = <<<'EOD'
<?php
session_start();
include_once 'connect.php';

if (isset($_GET['add_prodcat'])) {
    $name = $_GET['name'];
    $price = (int)$_GET['price'];
    if ($name != "" && $price != "") {
        // Insert prodcat data
        $sql = "INSERT INTO products (prod_name, price)
        VALUES ('${name}', '${price}')";
        if (mysqli_query($conn, $sql)) {
            file_put_contents($logs, "Product '${name}' created successfully\r\n", FILE_APPEND);
            echo "<script>alert('Product \'$name\' created successfully.');
        window.location.href='adm_prodcat.php?manage_prodcat=Manage+Products+Categories';</script>";
        } else {
            file_put_contents($logs, "Error creating '${name}' product:" . $sql . "\r\n" . mysqli_error($conn) . "\r\n", FILE_APPEND);
            echo "<script>alert('Adding failed.\\nAll errors logged to \'logs\'.');
        window.location.href='adm_prodcat.php?manage_prodcat=Manage+Products+Categories';</script>";
        }
    } else {
        echo "<script>alert('Empty product name and/or price.');
        window.location.href='adm_prodcat.php?manage_prodcat=Manage+Products+Categories';</script>";
    }
}

if (isset($_GET['manage_prodcat'])) {

    $sql = "SELECT * FROM products";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo "Manage Products Categories<br><br>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<form action='manage_prodcat.php' metod='get' name='manage_prodcat' style='margin-bottom: 8px;'>";
            echo "<input type='text' name='id' value='" . $row['id'] . "' hidden>";
            echo "Name: <input type='text' name='prod_name' value='" . $row['prod_name'] . "' readonly>";
            $sql2 = "SELECT * FROM categories";
            $result2 = mysqli_query($conn, $sql2);
            echo " Category: <select name='prodcat'>";
            while ($row2 = mysqli_fetch_assoc($result2)) {
                echo '<option value"'.$row2['id']."'>".$row2['cat_name']."</option>";
            }
            echo "</select> ";
            echo "<input type='submit' name='save' value='Save'> ";
            echo "<input type='submit' name='delete' value='Delete'>";
            echo "</form>";
        }
        file_put_contents($logs, "Product '${name}' created successfully\r\n", FILE_APPEND);
    } else {
        file_put_contents($logs, "Empty 'Products' table.\r\n", FILE_APPEND);
        echo "<script>alert('Empty \'Products\' table.');
        window.location.href='adm_prodcat.php?manage_prodcat=Manage+Products+Categories';</script>";
    }
    echo '<a href="index.php">Admin Panel</a>';
}
EOD;

file_put_contents('adm_prodcat.php', $adm_prodcat);

$adm_product = <<<'EOD'
<?php
session_start();
include_once 'connect.php';

if (isset($_GET['add_product'])) {
    $name = $_GET['name'];
    $price = (int)$_GET['price'];
    if ($name != "" && $price != "") {
        // Insert product data
        $sql = "INSERT INTO products (prod_name, price)
        VALUES ('${name}', '${price}')";
        if (mysqli_query($conn, $sql)) {
            file_put_contents($logs, "Product '${name}' created successfully\r\n", FILE_APPEND);
            echo "<script>alert('Product \'$name\' created successfully.');
        window.location.href='adm_product.php?manage_product=Manage+Products';</script>";
        } else {
            file_put_contents($logs, "Error creating '${name}' product:" . $sql . "\r\n" . mysqli_error($conn) . "\r\n", FILE_APPEND);
            echo "<script>alert('Adding failed.\\nAll errors logged to \'logs\'.');
        window.location.href='adm_product.php?manage_product=Manage+Products';</script>";
        }
    } else {
        echo "<script>alert('Empty product name and/or price.');
        window.location.href='adm_product.php?manage_product=Manage+Products';</script>";
    }
}

if (isset($_GET['manage_product'])) {
    $sql = "SELECT * FROM products";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo "Manage Products<br><br>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<form action='manage_product.php' metod='get' name='manage_product' style='margin-bottom: 8px;'>";
            echo "<input type='text' name='id' value='" . $row['id'] . "' hidden>";
            echo "Name: <input type='text' name='prod_name' value='" . $row['prod_name'] . "'>";
            echo " Price: <input type='number' name='price' value='" . $row['price'] . "'> ";
            echo "<input type='submit' name='save' value='Save'> ";
            echo "<input type='submit' name='delete' value='Delete'>";
            echo "</form>";
        }
    } else {
        file_put_contents($logs, "Empty 'Products' table.\r\n", FILE_APPEND);
        echo "<script>alert('Empty \'Products\' table.');
        window.location.href='adm_product.php?manage_product=Manage+Products';</script>";
    }
    echo '
    <div id="adm_product">
    <form action="adm_product.php?manage_product=Manage+Products" method="get" name="adm_product">
        Name:
        <input type="text" name="name">
        Price:
        <input type="number" name="price">
        <input type="submit" name="add_product" value="Add Product">
    </form>
    </div>';
    echo '<a href="index.php">Admin Panel</a>';
} else {
    echo "<script>alert('Empty product name and/or price.');
        window.location.href='adm_product.php?manage_product=Manage+Products';</script>";
}
EOD;

file_put_contents('adm_product.php', $adm_product);

$adm_user = <<<'EOD'
<?php
session_start();
include_once 'connect.php';

if (isset($_GET['add_user'])) {
    $login = $_GET['login'];
    $password = hash('whirlpool', $_GET['password']);
    $name = $_GET['name'];
    $email = $_GET['email'];
    $role = (int)$_GET['role'];
    if ($login != "" && $password != "") {
        // Insert user data
        $sql = "INSERT INTO users (login, password, username, role, email)
        VALUES ('${login}', '${password}', '${name}', '${role}', '${email}')";
        if (mysqli_query($conn, $sql)) {
            file_put_contents($logs, "User '${login}' created successfully\r\n", FILE_APPEND);
            echo "<script>alert('User \'$login\' created successfully.');
        window.location.href='adm_user.php?manage_user=Manage+Users';</script>";
        } else {
            file_put_contents($logs, "Error creating '${login}' user: " . $sql . "\r\n" . mysqli_error($conn) . "\r\n", FILE_APPEND);
            echo "<script>alert('Adding failed.\\nAll errors logged to \'logs\'.');
        window.location.href='adm_user.php?manage_user=Manage+Userss';</script>";
        }
    } else {
        echo "<script>alert('Empty user login and/or password.');
        window.location.href='adm_user.php?manage_user=Manage+Users';</script>";
    }
}

if (isset($_GET['manage_user'])) {
    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo "Manage Users<br><br>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<form action='manage_user.php' metod='get' name='manage_user' style='margin-bottom: 8px;'>";
            echo "<input type='text' name='id' value='" . $row['id'] . "' hidden>";
            echo "Login: <input type='text' name='login' value='" . $row['login'] . "'>";
            echo " Password: <input type='password' name='password' value='" . $row['password'] . "'>";
            echo " Role: <input type='number' name='role' value='" . $row['role'] . "'>";
            echo " Name: <input type='text' name='username' value='" . $row['username'] . "'>";
            echo " Email: <input type='email' name='email' value='" . $row['email'] . "'> ";
            echo "<input type='submit' name='save' value='Save'> ";
            echo "<input type='submit' name='delete' value='Delete'>";
            echo "</form>";
        }
    } else {
        file_put_contents($logs, "Empty 'Users' table.\r\n", FILE_APPEND);
        echo "<script>alert('Empty \'Users\' table.');
        window.location.href='adm_user.php?manage_user=Manage+Users';</script>";
    }
    echo '
    <div id="adm_user">
    <form action="adm_user.php?manage_user=Manage+Users" method="get" name="adm_user">
        Login:
        <input type="text" name="login">
         Password:
        <input type="password" name="password">
         Role:
        <input type="number" name="role">
         Name:
        <input type="text" name="name"> 
         Email:
        <input type="email" name="email">
        <input type="submit" name="add_user" value="Add User">
    </form>
    </div>';
    echo '<a href="index.php">Admin Panel</a>';
} else {
    echo "<script>alert('Empty product name and/or price.');
        window.location.href='adm_user.php?manage_user=Manage+Users';</script>";
}
EOD;

file_put_contents('adm_user.php', $adm_user);

$admin = <<<'EOD'
<?php
session_start();
include_once 'connect.php';
?>

<div id="adm_user">
    <form action="adm_user.php" method="get" name="adm_user">
        <input type="submit" name="manage_user" value="Manage Users">
    </form>
</div>

<div id="adm_product">
    <form action="adm_product.php" method="get" name="adm_product">
        <input type="submit" name="manage_product" value="Manage Products">
    </form>
</div>

<div id="adm_category">
    <form action="adm_category.php" method="get" name="adm_category">
        <input type="submit" name="manage_category" value="Manage Categories">
    </form>
</div>

<div id="adm_prodcat">
    <form action="adm_prodcat.php" method="get" name="adm_prodcat">
        <input type="submit" name="manage_prodcat" value="Manage Products Categories">
    </form>
</div>

<form action="adm_orders.php" method="GET">
    <input type="submit" name="amount" value="Orders">
</form>
EOD;

file_put_contents('admin.php', $admin);

$auth = <<<'EOD'
<?php
session_start();

include_once ('connect.php');

$login = $_POST['login'];
$password = hash('whirlpool', $_POST['password']);

// Sign In
if ($_POST['sign'] == "Sign In") {
    if ($login != "" && $password != "") {
        $sql = "SELECT * FROM USERS WHERE login = '${login}' AND password = '${password}'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $_SESSION['login'] = $login;
            $row = mysqli_fetch_assoc($result);
            $_SESSION['role'] = $row['role'];
            echo "<script>alert('Logged in successfully.');
            window.location.href='index.php';</script>";
        }
        else {
            file_put_contents('logs', "Error while Sign In user '${login}'" . mysqli_error($conn) . "\r\n",FILE_APPEND);
            echo "<script>alert('Authorization failed.\\nAll errors logged to \'logs\'.');
            window.location.href='index.php';</script>";
        }
    } else {
        echo "<script>alert('Authorization failed.\\nEmpty login and/or password.');
        window.location.href='index.php';</script>";
    }
}

// Sign Up
if ($_POST['sign'] == "Sign Up") {
    if ($login != "" && $password != "") {
        // Insert user data
        $sql = "INSERT INTO USERS (login, password)
        VALUES ('${login}', '${password}')";
        if (mysqli_query($conn, $sql)) {
            file_put_contents($logs, "User '${login}' created successfully\r\n", FILE_APPEND);
            $_SESSION['login'] = $login;
            echo "<script>alert('Authorization success.');
            window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Authorization failed.\\nAll errors logged to \'logs\'.');
            window.location.href='index.php';</script>";
            file_put_contents($logs, "Error creating '${login}' user:" . $sql . "\r\n" . mysqli_error($conn) . "\r\n", FILE_APPEND);
        }
    } else {
        echo "<script>alert('Authorization failed.\\nEmpty login and/or password.');
        window.location.href='index.php';</script>";
    }
}

// Sign Out
if ($_POST['sign'] == "Sign Out")
{
    unset($_SESSION['login']);
    unset($_SESSION['role']);
    echo "<script>alert('Logged out successfully.');
    window.location.href='index.php';</script>";
}

// Delete Account
if ($_POST['sign'] == "Delete Account")
{
    $login = $_SESSION['login'];
    $sql = "DELETE FROM users WHERE login='${login}'";
    if (mysqli_query($conn, $sql)) {
        unset($_SESSION['login']);
        unset($_SESSION['role']);
        file_put_contents($logs, "User '${login}' deleted successfully" . "\r\n", FILE_APPEND);
        echo "<script>alert('User \'$login\' deleted successfully.');
            window.location.href='index.php';</script>";
    } else {
        file_put_contents($logs, "Error deleting user '${login}': " . mysqli_error($conn) . "\r\n", FILE_APPEND);
        echo "<script>alert('Deleting failed.\\nAll errors logged to \'logs\'.');
            window.location.href='index.php';</script>";
    }
}
EOD;

file_put_contents('auth.php', $auth);

$connect = <<<'EOD'
<?php
// Server credits
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'password';
$logs = 'logs';
// Create connection
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);

file_put_contents($logs, "============= NEW AUTH ============\r\n", FILE_APPEND);
// Check connection
if (!$conn) {
    file_put_contents($logs, "Connected failure" . mysqli_connect_error() . "\r\n", FILE_APPEND);
    die();
}
file_put_contents($logs, "Connected successfully\r\n", FILE_APPEND);

// Select datacbase
mysqli_select_db($conn, "minishop");
EOD;

file_put_contents('connect.php', $connect);

$main = <<<'EOD'
<html>
<head>
    <title>miniShop</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>MiniSHOP</header>
<?php
session_start();
include_once "sign.php";
if ($_SESSION['role'] == 1)
    include "admin.php";
include_once 'connect.php';
?>
<form action="script_buy.php" method="GET">
    <input class="button2" type="submit" name="amount" value="Basket">
</form>
<?php
$sql = "SELECT id,  prod_name, price FROM products";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
      ?>
      <html><body>
        <div class="box">
            <h2 align="center"><?php echo $row["prod_name"]; ?></h2>
            <h4 align="right"><?php echo "price: ".$row["price"]."$"; ?></h4>
            <form action="script_buy.php" method="GET" align="center">
              <input class="input" type="number" name="amount" value="1">
              <input class="button" type="submit" name="<?php echo $row['id']; ?>" value="Buy">
            </form>
          </div>
      </body></html>
    <?php
    }
} else {
    echo "0 results";
}
?>
</body>
</html>
EOD;

file_put_contents('main.php', $main);

$manage_category = <<<'EOD'
<?php
session_start();
include_once 'connect.php';

$id = $_GET['id'];
$name = $_GET['cat_name'];

if (isset($_GET['save'])) {
    if ($name != "") {
        $sql = "UPDATE categories SET cat_name='${name}' WHERE id='${id}'";
        if (mysqli_query($conn, $sql)) {
            file_put_contents($logs, "Category '${name}' updated successfully" . "\r\n", FILE_APPEND);
            echo "<script>alert('Category \'$name\' updated successfully.');
            window.location.href='adm_category.php?manage_category=Manage+Categories';</script>";
        } else {
            file_put_contents($logs, "Error updating category '${name}': " . mysqli_error($conn) . "\r\n", FILE_APPEND);
            echo "<script>alert('Updating failed.\\nAll errors logged to \'logs\'.');
            window.location.href='adm_category.php?manage_category=Manage+Categories';</script>";

        }
    } else {
        echo "<script>alert('Empty category name.');
        window.location.href='adm_category.php?manage_category=Manage+Categories';</script>";
    }
}

if (isset($_GET['delete'])) {
    if ($name != "") {
        $sql = "DELETE FROM categories WHERE id='${id}'";
        if (mysqli_query($conn, $sql)) {
            file_put_contents($logs, "Category '${name}' deleted successfully" . "\r\n", FILE_APPEND);
            echo "<script>alert('Category \'$name\' deleted successfully.');
            window.location.href='adm_category.php?manage_category=Manage+Categories';</script>";
        } else {
            file_put_contents($logs, "Error deleting category '${name}': " . mysqli_error($conn) . "\r\n", FILE_APPEND);
            echo "<script>alert('Deleting failed.\\nAll errors logged to \'logs\'.');
            window.location.href='adm_category.php?manage_category=Manage+Categories';</script>";

        }
    } else {
        echo "<script>alert('Empty category name.');
        window.location.href='adm_category.php?manage_category=Manage+Categories';</script>";
    }
}
EOD;

file_put_contents('manage_category.php', $manage_category);

$manage_prodcat = <<<'EOD'
<?php
session_start();
include_once 'connect.php';

$id = (int)$_GET['id'];
$name = $_GET['prod_name'];
$prodcat = $_GET['prodcat'];

$sql2 = "SELECT id FROM categories WHERE cat_name='${prodcat}'";
$result2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_assoc($result2);
$id2 = (int)$row2['id'];

if (isset($_GET['save'])) {
    $sql = "INSERT INTO prod_cat (prod_id, cat_id)
    VALUES ('${id}', '${id2}')";
    if (mysqli_query($conn, $sql)) {
        file_put_contents($logs, "Product '${name}' binded successfully" . "\r\n", FILE_APPEND);
        echo "<script>alert('Product \'$name\' binded successfully.');
            window.location.href='adm_prodcat.php?manage_prodcat=Manage+Products+Categories';</script>";
    } else {
        file_put_contents($logs, "Error binding product '${name}': " . mysqli_error($conn) . "\r\n", FILE_APPEND);
        echo "<script>alert('Binding failed.\\nAll errors logged to \'logs\'.');
            window.location.href='adm_prodcat.php?manage_prodcat=Manage+Products+Categories';</script>";
    }
}

if (isset($_GET['delete'])) {
        $sql = "DELETE FROM prod_cat WHERE prod_id='${id}' AND cat_id='${id2}'";
        if (mysqli_query($conn, $sql)) {
            file_put_contents($logs, "Product '${name}' unbinded successfully" . "\r\n", FILE_APPEND);
            echo "<script>alert('Product \'$name\' unbinded successfully.');
            window.location.href='adm_prodcat.php?manage_prodcat=Manage+Products+Categories';</script>";
        } else {
            file_put_contents($logs, "Error unbinding product '${name}': " . mysqli_error($conn) . "\r\n", FILE_APPEND);
            echo "<script>alert('Unbinding failed.\\nAll errors logged to \'logs\'.');
            window.location.href='adm_prodcat.php?manage_prodcat=Manage+Products+Categories';</script>";
        }
}
EOD;

file_put_contents('manage_prodcat.php', $manage_prodcat);

$manage_product = <<<'EOD'
<?php
session_start();
include_once 'connect.php';

$id = $_GET['id'];
$name = $_GET['prod_name'];
$price = $_GET['price'];
if (isset($_GET['save'])) {
    if ($name != "" && $price != "") {
        $sql = "UPDATE products SET prod_name='${name}', price='${price}' WHERE id='${id}'";
        if (mysqli_query($conn, $sql)) {
            file_put_contents($logs, "Product '${name}' updated successfully" . "\r\n", FILE_APPEND);
            echo "<script>alert('Product \'$name\' updated successfully.');
            window.location.href='adm_product.php?manage_product=Manage+Products';</script>";
        } else {
            file_put_contents($logs, "Error updating product '${name}': " . mysqli_error($conn) . "\r\n", FILE_APPEND);
            echo "<script>alert('Updating failed.\\nAll errors logged to \'logs\'.');
            window.location.href='adm_product.php?manage_product=Manage+Products';</script>";
        }
    } else {
        echo "<script>alert('Empty product name and/or price.');
        window.location.href='adm_product.php?manage_product=Manage+Products';</script>";
    }
}

if (isset($_GET['delete'])) {
    if ($name != "" && $price != "") {
        $sql = "DELETE FROM products WHERE id='${id}'";
        if (mysqli_query($conn, $sql)) {
            file_put_contents($logs, "Product '${name}' deleted successfully" . "\r\n", FILE_APPEND);
            echo "<script>alert('Product \'$name\' deleted successfully.');
            window.location.href='adm_product.php?manage_product=Manage+Products';</script>";
        } else {
            file_put_contents($logs, "Error deleting product '${name}': " . mysqli_error($conn) . "\r\n", FILE_APPEND);
            echo "<script>alert('Deleting failed.\\nAll errors logged to \'logs\'.');
            window.location.href='adm_product.php?manage_product=Manage+Products';</script>";

        }
    } else {
        echo "<script>alert('Empty product name and/or price.');
        window.location.href='admin.php?manage_product=Manage+Products';</script>";
    }
}
EOD;

file_put_contents('manage_product.php', $manage_product);

$manage_user = <<<'EOD'
<?php
session_start();
include_once 'connect.php';

$id = $_GET['id'];
$login = $_GET['login'];
$password = $_GET['password'];
$name = $_GET['name'];
$email = $_GET['email'];
$role = (int)$_GET['role'];
if (isset($_GET['save'])) {
    if ($login != "" && $password != "") {
        $sql = "UPDATE users SET login='${login}', password='${password}', role='${role}', username='${name}', email='${email}' WHERE id='${id}'";
        if (mysqli_query($conn, $sql)) {
            file_put_contents($logs, "User '${login}' updated successfully" . "\r\n", FILE_APPEND);
            echo "<script>alert('User \'$login\' updated successfully.');
            window.location.href='adm_user.php?manage_user=Manage+Users';</script>";
        } else {
            file_put_contents($logs, "Error updating user '${login}': " . mysqli_error($conn) . "\r\n", FILE_APPEND);
            echo "<script>alert('Updating failed.\\nAll errors logged to \'logs\'.');
            window.location.href='adm_user.php?manage_user=Manage+Users';</script>";

        }
    } else {
        echo "<script>alert('Empty user login and/or password.');
        window.location.href='adm_user.php?manage_user=Manage+Users';</script>";
    }
}

if (isset($_GET['delete'])) {
    if ($login != "" && $password != "") {
        $sql = "DELETE FROM users WHERE id='${id}'";
        if (mysqli_query($conn, $sql)) {
            file_put_contents($logs, "User '${login}' deleted successfully" . "\r\n", FILE_APPEND);
            echo "<script>alert('User \'$login\' deleted successfully.');
            window.location.href='adm_user.php?manage_user=Manage+Users';</script>";
        } else {
            file_put_contents($logs, "Error deleting user '${login}': " . mysqli_error($conn) . "\r\n", FILE_APPEND);
            echo "<script>alert('Deleting failed.\\nAll errors logged to \'logs\'.');
            window.location.href='adm_user.php?manage_user=Manage+Users';</script>";

        }
    } else {
        echo "<script>alert('Empty user login and/or password.');
        window.location.href='adm_user.php?manage_user=Manage+Users';</script>";
    }
}
EOD;

file_put_contents('manage_user.php', $manage_user);

$script_buy = <<<'EOD'
<link rel="stylesheet" href="style.css">
<header>Basket</header>
<?php
include_once('connect.php');
include_once("sign.php");
session_start();
foreach ($_GET as $key => $value) {
  if ($key != "amount") {
    $id = $key;
    if ($value === "Buy")
      $act = 1;
  }
}
//add or dell position
if ($act) {
  if (isset($_SESSION['order']))
  $_SESSION['order'][$id] += $_GET['amount'];
else
  $_SESSION['order'][$id] = $_GET['amount'];
}
else
  unset($_SESSION['order'][$id]);
$sql = "SELECT id,  prod_name, price FROM products";
$rez = mysqli_query($conn, $sql);
?>
<div>
<form action="index.php" method="GET">
    <input class="button2" type="submit" name="submit" value="continue shopping">
</form>
<?php
if ($_SESSION['order'] && $_SESSION['login']) {
  ?>
  <form action="sucsess.php" method="GET">
        <input class="button2" type="submit" name="submit" value="order">
  </form>
  <?php
}
else if ($_SESSION['order'])
{
?>
<form action="" method="GET">
        <input class="button2" type="submit" name="submit" value="you must be login to order">
  </form>
<?php
}
?>
</div>
<?php
$total = 0;
while($row = mysqli_fetch_assoc($rez)) {
      ?>
      
            <?php
              foreach ($_SESSION['order'] as $key => $value)
                if ($key == $row["id"]) {
                  $total += $row['price'] * $_SESSION['order'][$key];
                  ?><html>
      
      <body>
        <div class="box">
                    <h1><?php echo $row["prod_name"]; ?> </h1>
                  <h4><?php echo "Price: ".$row["price"]; ?><br><?php echo "quantity: ".$_SESSION['order'][$key]; ?></h4>
                  <form action="script_buy.php" method="GET">
                    <input class="button" type="submit" name="<?php echo $row['id']; ?>" value="Del">
                  </form>

          </div>
      </body></html>
                  <?php
                }
    }
?>
<div>
  <h3><?php echo "total: ".$total."$"; ?></h3>
</div>
EOD;

file_put_contents('script_buy.php', $script_buy);

$sign = <<<'EOD'
<?php
session_start();
?>

<div id="sign">
    <form action="auth.php" method="post" name="auth">
        <?php
        if (isset($_SESSION['login'])) {
            echo('<input type="submit" name="sign" value="Sign Out"> ');
            echo('<input type="submit" name="sign" value="Delete Account">');
        }
        else {
            echo 'Login:
        <input type="text" name="login">
        <br>
        Password:
        <input type="password" name="password">
        <br>
        <input type="submit" name="sign" value="Sign In"> 
        <input type="submit" name="sign" value="Sign Up">';
        }
        ?>
    </form>
</div>
EOD;

file_put_contents('sign.php', $sign);

$style = <<<'EOD'
header {
  position: relative;
  font-family: Times;
    font-size: 40px;
}

body {
  background-color: yellow;
}

.box {
  border-radius: 9px;
  box-shadow: 10px 10px 10px #000000;
    background-color: lightblue;
    width: 300px;
    height: 150px;
    text-align: center;
}

.input {
  border-radius:  5px;
  width: 40px;
}

.button {
  width: 80px;
  border-radius: 9px;
}
.button2 {
  width: 180px;
  border-radius: 9px;
}
EOD;

file_put_contents('style.css', $style);

$sucsess = <<<'EOD'
<?php
    include_once('index.php');
    file_put_contents('orders.txt', serialize($_SESSION)."\r\n", FILE_APPEND);
    echo "<script> alert('Your order is processed!'); </script>";
    unset($_SESSION['order']);
?>
EOD;

file_put_contents('sucsess.php', $sucsess);

echo "<script>
alert('Installation complete.\\nAll errors logged to \'logs\'.');
window.location.href='index.php';
</script>";
