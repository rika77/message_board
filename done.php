<?php
session_start();

if (!isset($_SESSION["ID"])) {
    header("Location: logout.php");
    exit;
}

//csrf対策！
if (session_id() != $_POST["token"]) {
  die("正規の画面からご使用下さい");
}
define('DB_DATABASE', 'board');
define('DB_USERNAME', 'rika');
define('DB_PASSWORD', 'nyaan');
define('PDO_DSN', 'mysql:host=127.0.0.1; dbname=' . DB_DATABASE);

$errorMessage = "";
$doneMessage = "";


    if (empty($_POST["title"])) {  // 値が空のとき
        $errorMessage = 'タイトルが未入力です。';
    } else if (empty($_POST["content"])) {
        $errorMessage = '本文が未入力です。';
    }

    if (!empty($_POST["title"]) && !empty($_POST["content"]) ) {
        $title = $_POST["title"];
        $content = $_POST["content"];

        try {
          $doneMessage = '投稿完了しました';
            $pdo = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);

            $stmt = $pdo->prepare("INSERT INTO threads(title, content,user_id) VALUES (?, ?, ?)");

            $stmt->execute(array($title, $content, $_SESSION["ID"]));

          } catch (PDOException $e) {
            $errorMessage = 'データベースエラー';
            //echo $e->getMessage();
        }
    }

?>

<!doctype html>
<html>
    <head>
            <meta charset="UTF-8">
            <title>にゃん</title>
            <link href="./assets/stylesheets/reset.css" rel="stylesheet">
            <link href="./assets/stylesheets/common.css" rel="stylesheet">
    </head>
    <body>
            <fieldset>
                <div><font color="red"><?php echo htmlspecialchars($errorMessage); ?></font></div>
                <div><font color="blue"><?php echo htmlspecialchars($doneMessage); ?></font></div>

                <a href="myhome.php">ホーム画面に戻る</a>
            </fieldset>
        <br>
        <form action="login.php">
            <input type="submit" value="戻る">
        </form>
    </body>
</html>
