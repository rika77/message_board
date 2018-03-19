<?php
session_start();

if (!isset($_SESSION["ID"])) {
    header("Location: logout.php");
    exit;
}
define('DB_DATABASE', 'board');
define('DB_USERNAME', 'rika');
define('DB_PASSWORD', 'nyaan');
define('PDO_DSN', 'mysql:host=127.0.0.1; dbname=' . DB_DATABASE);

$errorMessage = "";
/*
if (isset($_POST["make_thread"])) {
    if (empty($_POST["title"])) {  // 値が空のとき
        $errorMessage = 'タイトルが未入力です。';
    } else if (empty($_POST["content"])) {
        $errorMessage = '本文が未入力です。';
    }

    if (!empty($_POST["title"]) && !empty($_POST["content"]) ) {
        $title = $_POST["title"];
        $content = $_POST["content"];

        try {
            $pdo = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);

            $stmt = $pdo->prepare("INSERT INTO threads(title, content,user_id) VALUES (?, ?, ?)");

            $stmt->execute(array($title, $content, $_SESSION["ID"]));
            header("Location: myhome.php");
            exit();
          } catch (PDOException $e) {
            $errorMessage = 'データベースエラー';
            //echo $e->getMessage();
        }
    }
}
*/
?>

<!doctype html>
<html>
    <head>
            <meta charset="UTF-8">
            <title>新規登録</title>
            <link href="./assets/stylesheets/reset.css" rel="stylesheet">
            <link href="./assets/stylesheets/common.css" rel="stylesheet">
    </head>
    <body>
      <div class = "top">
        New Thread
      </div>
        <form id="loginForm" name="loginForm" action="done.php" method="POST">
            <fieldset>
                <div><font color="red"><?php echo htmlspecialchars($errorMessage); ?></font></div>
                <label for="title">タイトル</label><input type="text" id="title" name="title" placeholder="簡潔に書きましょう 例:今日の朝ごはん" value="<?php if (!empty($_POST["title"])) {echo htmlspecialchars($_POST["title"]);} ?>">
                <br>
                <br>
                <label for="content">本文</label><input type="text" id="content" name="content" placeholder="わかりやすく書きましょう 例:納豆" value="<?php if (!empty($_POST["content"])) {echo htmlspecialchars($_POST["content"]);} ?>">
                <br>
                <input type="hidden" name="token" value="<?php echo session_id(); ?>" >
                 <input type="submit" id="make_thread" name="make_thread" value="作成！">
            </fieldset>
        </form>
        <br>
        <form action="login.php">
            <input type="submit" value="戻る">
        </form>
    </body>
</html>
