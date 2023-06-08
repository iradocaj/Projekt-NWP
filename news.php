<?php
if (isset($action) && $action != '') {
    // Prikaz pojedinačne vijesti
    $query  = "SELECT * FROM news";
    $query .= " WHERE id=" . $_GET['action'];
    $result = @mysqli_query($MySQL, $query);
    $row = @mysqli_fetch_array($result);

    print '
    <div class="news">
        <img src="news/' . $row['picture'] . '" alt="' . $row['title'] . '" title="' . $row['title'] . '">
        <h2>' . $row['title'] . '</h2>
        <p>'  . $row['description'] . '</p>
        <time datetime="' . $row['date'] . '">' . pickerDateToMysql($row['date']) . '</time>
        <hr>
    </div>';

    // Forma za unos komentara
    if (isset($_SESSION['user']['valid']) && $_SESSION['user']['valid'] == 'true') {
        $username = $_SESSION['user']['username']; 

        print '
        <h3>Add a Comment</h3>
        <form action="" method="POST">
            <input type="hidden" name="news_id" value="' . $_GET['action'] . '">
            <div>
                <label for="comment">Comment:</label>
                <textarea id="comment" name="comment" required></textarea>
            </div>
            <div>
                <input type="submit" value="Submit">
            </div>
        </form>';

        // Logika za unos komentara
        if (isset($_POST['comment']) && isset($_POST['news_id'])) {
            $comment = $_POST['comment'];
            $newsId = $_POST['news_id'];
            $datec = date('Y-m-d H:i:s');

            $query  = "INSERT INTO comments (name, comment, news_id, date)";
            $query .= " VALUES ('" . $username . "', '" . $comment . "', " . $newsId . ", '" . $datec . "')";

            if (@mysqli_query($MySQL, $query)) {
                echo '<p>Comment added successfully.</p>';

            

            } else {
                echo '<p>Error adding comment.</p>';
            }
        }
    } else {
        print '<p><a href="index.php?menu=6">Sign In</a> to leave a comment.</p>';
    }

    // Prikaz komentara za tu vijest
    $query = "SELECT * FROM comments";
    $query .= " WHERE news_id=" . $_GET['action'];
    $result = @mysqli_query($MySQL, $query);

    if (mysqli_num_rows($result) > 0) {
        print '<h3>Comments</h3>';

        while ($comment = mysqli_fetch_array($result)) {
            print '<div class="comment">';
            print '<p><strong><span style="font-size: 20px;">' . $comment['name'] . '</span></strong></p>';
            print '<p>' . $comment['comment'] . '</p>';
			print '<p class="comment-date"><span style="font-size: 13px;">Posted on: ' . $comment['date'] . '</p>';
            print '<hr>'; 
            print '</div>';
        }
    }
} else {
    // Prikaz svih vijesti
    print '<h1>NEWS</h1>';
    $query  = "SELECT * FROM news";
    $query .= " WHERE archive='N'";
    $query .= " ORDER BY date DESC";
    $result = @mysqli_query($MySQL, $query);

    while ($row = @mysqli_fetch_array($result)) {
        print '
        <div class="news">
            <img src="news/' . $row['picture'] . '" alt="' . $row['title'] . '" title="' . $row['title'] . '">
            <h2><a href="index.php?menu=' . $menu . '&amp;action=' . $row['id'] . '">' . $row['title'] . '</a></h2>';

        if (strlen($row['description']) > 300) {
            echo substr(strip_tags($row['description']), 0, 300).'... <a href="index.php?menu=' . $menu . '&amp;action=' . $row['id'] . '">More</a>';
        } else {
            echo strip_tags($row['description']);
        }

        print '
            <time datetime="' . $row['date'] . '">' . pickerDateToMysql($row['date']) . '</time>
            <hr>
        </div>';
    }
}
?>