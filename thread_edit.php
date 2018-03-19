<?php
session_start();

if (!isset($_SESSION["NAME"])) {
    header("Location: logout.php");
    exit;
}
?>


<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>編集</title>
        <link href="./assets/stylesheets/reset.css" rel="stylesheet">
        <link href="./assets/stylesheets/common.css" rel="stylesheet">
    </head>
    <body>

<?php

define('DB_DATABASE', 'board');
define('DB_USERNAME', 'rika');
define('DB_PASSWORD', 'nyaan');
define('PDO_DSN', 'mysql:host=127.0.0.1; dbname=' . DB_DATABASE);

$errorMessage = "";

        try {
            $pdo = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);

              if (isset($_POST['edit'])) {
                $edit_id = $_POST['edit'];

                $stmt = $pdo->prepare("select * from threads where id = ?");
                $stmt->execute(array($edit_id));
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                <form  action="myhome.php" method="POST">
                  <div>タイトル:</div>
                <input type="text" id="thread_title" name="thread_title" value="
                <?php echo htmlspecialchars($row['title']);?>
                ">
                <br>
                <div>本文:</div>
                <input type="text" id="thread_content" name="thread_content" value="
                <?php echo htmlspecialchars($row['content']);?>
                ">
                <br>
                <br>
                  <button type="submit" name="done" value="<?php echo $edit_id; ?>">編集完了！</button>
                </form>
                <?php
              }


        } catch (PDOException $e) {
            $errorMessage = 'データベースエラー';
            // echo $e->getMessage();
        }

?>


<ul>
  <div><font color="red"><?php echo htmlspecialchars($errorMessage); ?></font></div>
    <li><a href="logout.php">ログアウト</a></li>
</ul>
</body>
</html>
