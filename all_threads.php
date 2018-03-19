<?php
session_start();

if (!isset($_SESSION["NAME"])) {
    header("Location: Logout.php");
    exit;
}
?>


<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>メイン</title>
        <link href="./assets/stylesheets/reset.css" rel="stylesheet">
        <link href="./assets/stylesheets/common.css" rel="stylesheet">
    </head>
    <body>
        <h1>メイン画面</h1>
        <p>ようこそ
          <?php echo htmlspecialchars($_SESSION["NAME"]); ?>さん
		</p> 


<?php

define('DB_DATABASE', 'board');
define('DB_USERNAME', 'rika');
define('DB_PASSWORD', 'nyaan');
define('PDO_DSN', 'mysql:host=127.0.0.1; dbname=' . DB_DATABASE);

$errorMessage = "";

        try {
            $pdo = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);


            if (isset($_POST['delete'])) {
              $delete_id = $_POST['delete'];
              $stmt = $pdo->prepare("DELETE from threads where id = ?");
              $stmt->execute(array($delete_id));
            }

            if (isset($_POST['done'])) {
              $thread_id = $_POST['done'];
              $edit_title = $_POST['thread_title'];
              $edit_content = $_POST['thread_content'];
              $stmt = $pdo->prepare("UPDATE threads set title=? , content=?  where id = ?");
              $stmt->execute(array($edit_title, $edit_content,$thread_id));
            }

            $stmt = $pdo->prepare('SELECT * FROM threads');
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <a href="show_thread.php?id=
                <?php echo $row['id']; ?> ">
                <?php echo $row['title']; ?>
                <br>
                    </a>
                    <!自分の作成したスレッドにだけ削除、編集buttonが表示される>
                    <?php
                    if ($row['user_id'] == $_SESSION['ID']) {
                    ?>
                    <!削除>
                    <form action="" method="post">
                    <button type="submit" name = "delete" value="<?php echo $row['id'] ?>">delete</button>
                    </form>
                    <!編集>
                    <form action="thread_edit.php" method="post">
                    <button type="submit" name="edit" value="<?php echo $row['id'] ?>">edit</button>
                    </form>
                    <?php
                  }
                    echo "<br>";

             }
        } catch (PDOException $e) {
            $errorMessage = 'データベースエラー';
            // echo $e->getMessage();
        }

?>

<ul>
    <li><a href="Logout.php">ログアウト</a></li>
</ul>
</body>
</html>
