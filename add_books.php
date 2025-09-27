
<?php
$conn = new mysqli("db", "root", "rootpassword", "PrelExam");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST["title"]);
    $author = $conn->real_escape_string($_POST["author"]);
    $year = (int) $_POST["publication_year"]; // cast to int for safety
    $isbn = $conn->real_escape_string($_POST["isbn"]);

    $sql = "INSERT INTO books (title, author, publication_year, isbn) 
            VALUES ('$title', '$author', $year, '$isbn')";

    if ($conn->query($sql)) {
        $message = "✅ Book added successfully!";
    } else {
        $message = "❌ Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Book</title>
</head>
<body>
    <h1 style="text-align:center;">Add Book</h1>

    <?php if ($message) echo "<p><b>$message</b></p>"; ?>

    <form method="POST" style="max-width:400px; margin:auto; padding:20px; border:1px solid #ccc; border-radius:5px; text-align:center;">
        <label>Title:</label><br>
        <input type="text" name="title" required><br><br>

        <label>Author:</label><br>
        <input type="text" name="author" required><br><br>

        <label>Publication Year:</label><br>
        <input type="number" min="1000" max="9999" name="publication_year" required><br><br>

        <label>ISBN:</label><br>
        <input type="text" name="isbn" required><br><br>

        <button type="submit">Add Book</button>
    </form>

    <h2 style="text-align:center;"><a href="index.php"><button>⬅ Back to Library</button></a></h2>
</body>
</html>
<?php $conn->close(); ?>


