<?php

    include("includes/header.php");

    require_once 'classes/TextPost.class.php'; // Include the TextPost class file from the "classes" directory

    // Check if the delete parameter is provided
    if (isset($_GET['delete'])) {
        $deleteIndex = $_GET['delete'];

        // Read the contents of the posts file
        $posts = [];
        if (file_exists('writable/posts.txt')) {
            $fileContent = file_get_contents('writable/posts.txt');
            $serializedPosts = explode(PHP_EOL, $fileContent); //splits each TextPost at EOL

            // Unserialize each post and store them in the $posts array
            foreach ($serializedPosts as $serializedPost) {
                $post = unserialize($serializedPost);
                if ($post instanceof TextPost) {
                    $posts[] = $post;
                }
            }

            // Delete the specified post
            if (is_numeric($deleteIndex) && isset($posts[$deleteIndex])) {
                unset($posts[$deleteIndex]);

                // Re-index the array
                $posts = array_values($posts);

                // Update the posts.txt file with the remaining posts
                $serializedPosts = array_map('serialize', $posts);
                $fileContent = implode(PHP_EOL, $serializedPosts);
                file_put_contents('writable/posts.txt', $fileContent);
            }
        }
    }

    // Read the contents of the posts file
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
    ?>

    <?php if (!empty($posts)) : ?>
        <ul>
            <?php foreach ($posts as $index => $post) : ?>
                <li>
                    <strong>Alias:</strong> <?php echo $post->getAlias(); ?><br>
                    <strong>Timestamp:</strong> <?php echo date('Y-m-d H:i:s', $post->getTimestamp()); ?><br>
                    <strong>Content:</strong> <?php echo $post->getContent(); ?><br>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" style="display:inline;">
                        <input type="hidden" name="delete" value="<?php echo $index; ?>">
                        <input type="submit" value="Delete">
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p>No posts available.</p>
    <?php endif; ?>

    <form action="serial_solution.php" method="get">
        <input type="submit" value="Create New Post">
    </form>

<?php include("includes/footer.php"); ?>
