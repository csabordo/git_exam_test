<?php
$conn = new mysqli("db", "root", "rootpassword", "PrelExam");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$validColumns = ["id", "title", "author", "publication_year", "isbn"];
$sort = isset($_GET["sort"]) && in_array($_GET["sort"], $validColumns) ? $_GET["sort"] : "id";
$order = isset($_GET["order"]) && $_GET["order"] === "ASC" ? "ASC" : "DESC";

$sql = "SELECT * FROM books ORDER BY $sort $order";
$books = $conn->query($sql);


function getNextOrder($column, $currentSort, $currentOrder) {
    if ($column === $currentSort) {
        return $currentOrder === "ASC" ? "DESC" : "ASC";
    }
    return "ASC";
}

function getArrow($column, $currentSort, $currentOrder) {
    if ($column === $currentSort) {
        return $currentOrder === "ASC" ? " ▲" : " ▼";
    }
    return "";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Library Management System</title>
    <style>
        body {
            background-color: #9DD4DA;
            font-family: Arial, sans-serif;
        }
        table { 
            border: 3px solid black;
            border-collapse: separate; 
            border-spacing: 0;         
            width: 100%;     
            border-radius: 10px;     
            overflow: hidden;     
            box-shadow: 2px 2px 10px rgba(0,0,0,0.2);
        }

        th, td { 
            border-left: none;      
            border-right: none; 
            border-bottom: 1px solid #ccc; 
            padding: 10px;
            text-align: center; 
        }

        th { 
            background: #e6e6e6;   
            font-weight: bold;
        }
        tr {
             background: white;
        }
    
        .center {
            text-align: center;
            margin-left: auto;
            margin-right: auto;
        }
        .emoji_button {
            padding-left: 20%;
            font-size: 2rem;
        }
        a.sort-link {
            text-decoration: none;
            color: black;
        }
        .table-container {
            width: 60%;
            max-height: 800px;   
            overflow-y: auto; 
            overflow-x: auto; 
            margin: 0 auto;      
            border: 2px solid black;
            border-radius: 10px;
        }

    </style>
</head>
<body>
    <div class="header-bar">
        <a href="main_menu.php" class="emoji_button">🏠</a>
        <h1 class="center">Browse Catalog</h1>
    </div>

    <div class="table-container">
        <table class="center">
            <tr>
                <th><a class="sort-link" href="?sort=id&order=<?=getNextOrder("id", $sort, $order)?>">ID<?=getArrow("id", $sort, $order)?></a></th>
                <th><a class="sort-link" href="?sort=title&order=<?=getNextOrder("title", $sort, $order)?>">Title<?=getArrow("title", $sort, $order)?></a></th>
                <th><a class="sort-link" href="?sort=author&order=<?=getNextOrder("author", $sort, $order)?>">Author<?=getArrow("author", $sort, $order)?></a></th>
                <th><a class="sort-link" href="?sort=publication_year&order=<?=getNextOrder("publication_year", $sort, $order)?>">Publication Year<?=getArrow("publication_year", $sort, $order)?></a></th>
                <th><a class="sort-link" href="?sort=isbn&order=<?=getNextOrder("isbn", $sort, $order)?>">ISBN<?=getArrow("isbn", $sort, $order)?></a></th>
            </tr>
            <?php
            if ($books->num_rows > 0) {
                while ($row = $books->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["title"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["author"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["publication_year"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["isbn"]) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No books found</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
<?php $conn->close(); ?>
