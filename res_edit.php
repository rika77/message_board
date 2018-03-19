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
            $id = $_GET['id'];

              if (isset($_POST['done'])) {
                if (empty($_POST['edit'])) {  // 値が空のとき
                    $errorMessage = '内容が未入力です。';
                }
              }
              if (isset($_POST['edit'])) {


                $edit_id = $_POST['edit'];
                $stmt = $pdo->prepare("select * from res where id = ?");
                $stmt->execute(array($edit_id));
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                <form  action="show_thread.php?id=
                <?php echo $id ?>
                " method="POST">
                <input type="text" id="edit" name="edit" value="
                <?php echo htmlspecialchars($row['content']);?>
                ">
                  <button type="submit" name="done" value="<?php echo $edit_id; ?>">編集完了！</button>
                </form>
                <?php
              }


        } catch (PDOException $e) {
            $errorMessage = 'データベースエラー';
            // echo $e->getMessage();
        }

?>

  <div><font color="red"><?php echo htmlspecialchars($errorMessage); ?></font></div>
<ul>

    <li><a href="logout.php">ログアウト</a></li>
</ul>
</body>
</html>
