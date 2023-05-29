<?php
require_once 'classes/TextPost.class.php'; // Include the TextPost class file from the "classes" directory

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $alias = $_POST['alias'];
    $content = $_POST['content'];

    // Read the contents of the posts.txt file
    $posts = [];
    if (file_exists('writable/posts.txt')) {
        $fileContent = file_get_contents('writable/posts.txt');
        $serializedPosts = explode(PHP_EOL, $fileContent);

        // Unserialize each post and store them in the $posts array
        foreach ($serializedPosts as $serializedPost) {
            $post = unserialize($serializedPost);
            if ($post instanceof TextPost) {
                $posts[] = $post;
            }
        }
    }

    // Create a new TextPost object
    $post = new TextPost($alias, $content);

    // Append the new post to the posts array
    $posts[] = $post;

    // Update the posts.txt file with the updated posts
    $serializedPosts = array_map('serialize', $posts);
    $fileContent = implode(PHP_EOL, $serializedPosts);
    file_put_contents('writable/posts.txt', $fileContent);

    // Redirect to the posts.php page
    header('Location: posts.php');
    exit();
}

include("includes/header.php");?>
    <h1>Create a Post</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="alias">Alias:</label>
        <input type="text" id="alias" name="alias" required><br>

        <label for="content">Content:</label>
        <textarea id="content" name="content" required></textarea><br>

        <input type="submit" value="Send">
    </form>
    <form action="posts.php" method="get">
        <input type="submit" value="View current posts">
    </form>
<?php include("includes/footer.php");

