<?php
$conn = new mysqli("db", "root", "rootpassword", "PrelExam");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$validColumns = ["id", "title", "author", "publication_year", "isbn"];
$sort = isset($_GET["sort"]) && in_array($_GET["sort"], $validColumns) ? $_GET["sort"] : "id";
$order = isset($_GET["order"]) && $_GET["order"] === "ASC" ? "ASC" : "DESC";

$searchQuery = "";
$searchTerm = "";
if (isset($_GET["query"]) && $_GET["query"] !== "") {
    $searchTerm = $conn->real_escape_string($_GET["query"]);
    $searchQuery = " WHERE title LIKE '%$searchTerm%' OR author LIKE '%$searchTerm%' OR isbn LIKE '%$searchTerm%'";
}

$sql = "SELECT * FROM books $searchQuery ORDER BY $sort $order";
$books = $conn->query($sql);

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
        tr { background: white; }
        .center { text-align: center; }
        
        .header-bar-content {
            width: 60%;
            margin: 0 auto;
        }
        
        .header-bar {
            display: flex; 
            align-items: center;
            justify-content: space-between; 
            padding: 15px 0; 
        }

        .emoji_button {
            font-size: 2rem;
            text-decoration: none; 
            color: black;
        }
        
        .header-bar h1.center {
            flex-grow: 1; 
            margin-right: 2rem; 
            text-align: center;
        }

        .table-container {
            width: 60%;
            max-height: 800px;   
            overflow-y: auto; 
            margin: 0 auto;       
            border: 2px solid black;
            border-radius: 10px;
            background: white;
        }
        .search-box {
            text-align: left; 
            margin-bottom: 20px;
        }
        .search-box input[type="text"] {
            padding: 5px;
            width: 250px;
            border-radius: 5px;
            border: 1px solid #333;
        }
        .search-box input[type="submit"] {
            padding: 5px 10px;
            border-radius: 5px;
            border: none;
            background: #333;
            color: white;
            cursor: pointer;
        }
    </style>
</head>
<body>
    
    <div class="header-bar-content"> 
        
        <div class="header-bar">
            <a href="main_menu.php" class="emoji_button">🏠</a>
            <h1 class="center">Browse Catalog</h1>
        </div>
        
        <div class="search-box">
            <form method="get" action="">
                <input type="text" name="query" placeholder="Search by title, author, or ISBN" value="<?=htmlspecialchars($searchTerm)?>">
                <input type="hidden" name="sort" value="<?=$sort?>">
                <input type="hidden" name="order" value="<?=$order?>">
                <input type="submit" value="Search">
            </form>
        </div>

    </div>
    
    <div class="table-container">
        <table class="center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Publication Year</th>
                    <th>ISBN</th>
                </tr>
            </thead>
            <tbody>
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
            </tbody>
        </table>
    </div>
</body>
</html>
<?php 
if (isset($conn)) {
    $conn->close(); 
}
?>