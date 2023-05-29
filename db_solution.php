<?php
include("includes/header.php");
require_once 'classes/TextPost.class.php'; // Include the TextPost class file from the "classes" directory
// Connect to the MySQL database
$connection = mysqli_connect("localhost", "root", "", "mydatabase");

// Check the connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Delete a post if the delete parameter is set
    if (isset($_POST['delete'])) {
        $timestamp = $_POST['delete'];
        $sql = "DELETE FROM users WHERE timestamp = '$timestamp'";
        mysqli_query($connection, $sql);
    } else {
        // Create a new post
        // Retrieve form data
        $alias = $_POST['alias'];
        $content = $_POST['content'];

        // Create a new TextPost object
        $post = new TextPost($alias, $content);

        // Insert the post into the database
        $sql = "INSERT INTO users (timestamp, alias, content) VALUES (NOW(), '$alias', '$content')";
        mysqli_query($connection, $sql);
    }
}

// Retrieve the posts from the database
$sql = "SELECT * FROM users";
$result = mysqli_query($connection, $sql);

// Check if there are any posts
if (mysqli_num_rows($result) > 0) {
    // Display the posts
    while ($row = mysqli_fetch_assoc($result)) {
        // Output the post details
        echo "Alias: " . $row['alias'] . "<br>";
        echo "Timestamp: " . $row['timestamp'] . "<br>";
        echo "Content: " . $row['content'] . "<br>";
        echo "<form action='" . $_SERVER['PHP_SELF'] . "' method='post' style='display:inline;'>";
        echo "<input type='hidden' name='delete' value='" . $row['timestamp'] . "'>";
        echo "<input type='submit' value='Delete'>";
        echo "</form>";
        echo "<hr>";
    }
} else {
    echo "No posts available.";
}

// Close the database connection
mysqli_close($connection);
 ?>
    <h1>Create a Post</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="alias">Alias:</label>
        <input type="text" id="alias" name="alias" required><br>

        <label for="content">Content:</label>
        <textarea id="content" name="content" required></textarea><br>

        <input type="submit" value="Send">
    </form>
<?php include("includes/footer.php");