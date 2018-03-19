<?php
session_start();
define('DB_DATABASE', 'board');
define('DB_USERNAME', 'rika');
define('DB_PASSWORD', 'nyaan');
define('PDO_DSN', 'mysql:host=127.0.0.1; dbname=' . DB_DATABASE);

$errorMessage = "";
$signUpMessage = "";

if (isset($_POST["signUp"])) {
    if (empty($_POST["name"])) {  // 値が空のとき
        $errorMessage = 'ユーザーIDが未入力です。';
    } else if (empty($_POST["pass"])) {
        $errorMessage = 'パスワードが未入力です。';
    } else if (empty($_POST["password2"])) {
        $errorMessage = 'パスワードが未入力です。';
    }

    if (!empty($_POST["name"]) && !empty($_POST["pass"]) && !empty($_POST["password2"]) && $_POST["pass"] === $_POST["password2"]) {
        $name = $_POST["name"];
        $pass = $_POST["pass"];

        try {
            $pdo = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);

            $stmt = $pdo->prepare("INSERT INTO users(name, pass) VALUES (?, ?)");

            $stmt->execute(array($name, $pass));

            $signUpMessage = '登録が完了しました';
        } catch (PDOException $e) {
            $errorMessage = 'データベースエラー';
            echo $e->getMessage();
        }
    } else if($_POST["pass"] != $_POST["password2"]) {
        $errorMessage = 'パスワードに誤りがあります。';
    }
}
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
        <h1>新規登録画面</h1>
        <form id="loginForm" name="loginForm" action="" method="POST">
            <fieldset>
                <legend>新規登録フォーム</legend>
                <div><font color="red"><?php echo htmlspecialchars($errorMessage); ?></font></div>
                <div><font color="blue"><?php echo htmlspecialchars($signUpMessage); ?></font></div>
                <label for="name">ユーザー名</label><input type="text" id="name" name="name" placeholder="ユーザー名を入力" value="<?php if (!empty($_POST["name"])) {echo htmlspecialchars($_POST["name"]);} ?>">
                <br>
                <label for="pass">パスワード</label><input type="pass" id="pass" name="pass" value="" placeholder="パスワードを入力">
                <br>
                <label for="password2">パスワード(確認用)</label><input type="password" id="password2" name="password2" value="" placeholder="再度パスワードを入力">
                <br>
                <input type="submit" id="signUp" name="signUp" value="新規登録">
            </fieldset>
        </form>
        <br>
        <form action="login.php">
            <input type="submit" value="戻る">
        </form>
    </body>
</html>
