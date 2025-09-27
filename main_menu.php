<!DOCTYPE html>
<html>
<head>
    <title>Library Management System</title>
    <style>
        body {
            background-color: #9DD4DA;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            background: #9DD4DA;
            padding: 20px;
            border-radius: 10px;
        }

        .home-icon {
            text-align: left;
            margin-bottom: 10px;
        }

        .home-icon a {
            font-size: 1.8rem;
            text-decoration: none;
            color: black;
        }

        .menu button {
            display: block;
            width: 200px;
            padding: 10px;
            margin: 15px auto;
            font-size: 1.1rem;
            border: 2px solid black;
            border-radius: 25px;
            background-color: white;
            cursor: pointer;
            transition: background 0.3s;
        }

        .menu button:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Home icon -->
        <div class="home-icon">
            <a href="main_menu.php">🏠</a>
        </div>

        <!-- Menu Buttons -->
        <div class="menu">
            <form action="browse_catalog.php" method="get">
                <button type="submit">Browse books</button>
            </form>
            <form action="add_books.php" method="get">
                <button type="submit">Add Book</button>
            </form>
            <form action="edit.php" method="get">
                <button type="submit">Edit Book Details</button>
            </form>
            <form action="remove.php" method="get">
                <button type="submit">Remove Book</button>
            </form>
        </div>
    </div>
</body>
</html>
