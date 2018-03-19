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
        <title>スレッド</title>
        <link href="./assets/stylesheets/reset.css" rel="stylesheet">
        <link href="./assets/stylesheets/common.css" rel="stylesheet">
    </head>
    <body>
        <h1>スレッド詳細</h1>


<?php

define('DB_DATABASE', 'board');
define('DB_USERNAME', 'rika');
define('DB_PASSWORD', 'nyaan');
define('PDO_DSN', 'mysql:host=127.0.0.1; dbname=' . DB_DATABASE);

$errorMessage = "";

        try {
            $pdo = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
            $id = $_GET['id'];
            $stmt = $pdo->prepare('SELECT * FROM threads WHERE id = ?');
            $stmt->bindParam(1, $id);

            $stmt->execute();

			$row = $stmt->fetch(PDO::FETCH_ASSOC);
              echo "タイトル: ";
              echo htmlspecialchars($row['title']);
              echo "<br>";
              echo "本文: ";
              echo htmlspecialchars($row['content']);
              echo "<br>";

              if (isset($_POST['delete'])) {
                $delete_id = $_POST['delete'];
                $stmt = $pdo->prepare("DELETE from res where id = ?");
                $stmt->execute(array($delete_id));
              }

              if (isset($_POST['done'])) {
                $edit_id = $_POST['done'];
                $edit_content = $_POST['edit'];
                $stmt = $pdo->prepare("UPDATE res set content=? where id = ?");
                $stmt->execute(array($edit_content,$edit_id));
              }

              if (isset($_POST['make_res'])) {
                  if (empty($_POST["content"])) {  // 値が空のとき
                      $errorMessage = 'レス内容が未入力です。';
                  }
                  else {

              //レスを登録
              $content = $_POST['content'];
              $stmt = $pdo->prepare("INSERT INTO res(content,user_id,thread_id) VALUES (?, ?, ?)");

              $stmt->execute(array($content,$_SESSION['ID'],$id));
              }
            }
              //レスを表示

              $stmt = $pdo->prepare('SELECT * FROM res WHERE thread_id = ?');
              $stmt->bindParam(1, $id);

              $stmt->execute();
              echo "<br>";
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                  echo htmlspecialchars($row['content']);
                  echo "<br>";

                  if ($row['user_id'] == $_SESSION['ID']) {
                ?>
                <!削除>
                <form action="" method="post">
                <button type="submit" name = "delete" value="<?php echo $row['id'] ?>">delete</button>
                </form>
                <!編集>
                <form action="res_edit.php?id=
                <?php echo $id ?>
                " method="post">
                <button type="submit" name="edit" value="<?php echo $row['id'] ?>">edit</button>
                </form>

<?php
                }
                  echo "<br>";
                }
              }
              catch (PDOException $e) {
            $errorMessage = 'データベースエラー';
            // echo $e->getMessage();
        }

?>

<form id="res" name="res" action="" method="POST">
    <fieldset>
        <div><font color="red"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
      
        <br>
        <label for="content">レスを投稿する</label><input type="text" id="content" name="content" placeholder="思いやりを持ってかきましょう 例:大好き♡" value="">
        <br>

        <input type="submit" id="make_res" name="make_res" value="投稿！">
    </fieldset>
</form>
<ul>
    <li><a href="logout.php">ログアウト</a></li>
</ul>
</body>
</html>
