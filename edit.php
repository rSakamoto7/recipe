<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>レシピの更新</title>
</head>
<body>   
    <div class="container">
        <?php
            $user = "Keith";
            $pass = "1111";
            try {
                if (empty($_GET["id"])) throw new Exception("ID不正");
                $id = (int) $_GET["id"];
                $dbh = new PDO("mysql:host=localhost;dbname=Recipe;charset=utf8", $user, $pass);
                $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "SELECT * FROM recipe WHERE id = ?";
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(1, $id, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $dbh = null;
            } catch(Exception $e){
                echo "エラー発生：".htmlspecialchars($e->getMessage(),ENT_QUOTES, "UTF-8")."<br>";
                die();
            }
        ?>
        
            <!DOCTYPE html>
            <html lang="ja">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>レシピ更新用フォーム</title>
                <link rel="stylesheet" href="style.css">
            </head>
            <body>
                <p>レシピ入力フォーム</p>
                <form action="update.php" method="post">
                    <span>料理名:</span>
                    <input type="text" name="recipe_name" value="<?php echo htmlspecialchars($result["recipe_name"], ENT_QUOTES, "UTF-8");?>"><br>
                    <span>カテゴリ：</span>
                    <select name="category" id="cateogry">
                        <option value="">※選択してください</option>
                        <option value="1" <?php if($result["category"]=== 1) echo "selected" ?>>和食</option>
                        <option value="2" <?php if($result["category"]=== 2) echo "selected" ?>>洋食</option>
                        <option value="3" <?php if($result["category"]=== 3) echo "selected" ?>>中華</option>
                    </select><br>
                    <span>難易度：</span>
                    <label><input type="radio" name="difficulty" value="1" <?php if ($result["difficulty"] === 1) echo "checked" ?>>簡単</label>
                    <label><input type="radio" name="difficulty" value="2" <?php if ($result["difficulty"] === 2) echo "checked" ?>>普通</label>
                    <label><input type="radio" name="difficulty" value="3" <?php if ($result["difficulty"] === 3) echo "checked" ?>>難しい</label><br>
                    <span>予算：</span>
                    <input type="number" name="budget" value="<?php echo htmlspecialchars($result["budget"], ENT_QUOTES, "UTF-8");?>">円<br>
                    <span>作り方：</span>
                    <textarea name="howto" id="howto" cols="40" rows="4" maxlength="150"><?php echo htmlspecialchars($result["howto"],ENT_QUOTES, "UTF-8");?></textarea><br>
                    <input type="hidden" name="id" class="bg-info" value="<?php echo htmlspecialchars($result["id"], ENT_QUOTES, "UTF-8"); ?>">
                    <input type="submit" value="送信">
                </form>
    </div> 
</body>
</html>
