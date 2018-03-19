<?php
session_start();

define('DB_DATABASE', 'board');
define('DB_USERNAME', 'rika');
define('DB_PASSWORD', 'nyaan');
define('PDO_DSN', 'mysql:host=127.0.0.1; dbname=' . DB_DATABASE);

$errorMessage = "";

if (isset($_POST["login"])) {
    if (empty($_POST["name"])) {  // emptyは値が空のとき
        $errorMessage = 'ユーザー名が未入力です。';
    } else if (empty($_POST["pass"])) {
        $errorMessage = 'パスワードが未入力です。';
    }

    if (!empty($_POST["name"]) && !empty($_POST["pass"])) {
        $name = $_POST["name"];
        $pass = $_POST["pass"];


        try {
            $pdo = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
            $stmt = $pdo->prepare('SELECT * FROM users WHERE name = ? and pass = ?');
            $stmt->bindParam(1, $name);
            $stmt->bindParam(2, $pass);
            $stmt->execute();


            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $id = $row['id'];
                    $sql = "SELECT * FROM users WHERE id = $id";
                    $stmt = $pdo->query($sql);
                    foreach ($stmt as $row) {
                       $row['name'];  // ユーザー名
                    }
                    $_SESSION["NAME"] = $row['name'];
                    $_SESSION["ID"] = $row['id'];



                    header("Location: myhome.php");  // メイン画面へ遷移
                    exit();  // 処理終了
            } else {
                $errorMessage = 'ユーザーIDあるいはパスワードに誤りがあります。';
            }
        } catch (PDOException $e) {
            $errorMessage = 'データベースエラー';
            // echo $e->getMessage();
        }
    }
}
?>

<!doctype html>
<html>
    <head>
            <meta charset="UTF-8">
            <title>ログイン</title>
            <link href="./assets/stylesheets/reset.css" rel="stylesheet">
            <link href="./assets/stylesheets/common.css" rel="stylesheet">
    </head>
    <body>
        <h1>ログイン画面</h1>
        <form id="loginForm" name="loginForm" action="" method="POST">
            <fieldset>
                <legend>ログインフォーム</legend>
                <div><font color="red"><?php echo htmlspecialchars($errorMessage); ?></font></div>
                <label for="name">ユーザーID</label><input type="text" id="name" name="name" placeholder="ユーザーIDを入力" value="<?php if (!empty($_POST["name"])) {echo htmlspecialchars($_POST["name"], ENT_QUOTES);} ?>">
                <br>
                <label for="pass">パスワード</label><input type="pass" id="pass" name="pass" value="" placeholder="パスワードを入力">
                <br>
                <input type="submit" id="login" name="login" value="ログイン">
            </fieldset>
        </form>
        <br>
        <form action="signup.php">
            <fieldset>
                <legend>新規登録フォーム</legend>
                <input type="submit" value="新規登録">
            </fieldset>
        </form>
    </body>
</html>
