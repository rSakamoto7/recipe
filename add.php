<?php
    $user = "Keith";
    $pass = "1111";
    $recipe_name = $_POST["recipe_name"];
    $howto = $_POST["howto"];
    $category = (int)$_POST["category"];
    $difficulty = (int)$_POST["difficulty"];
    $budget = (int)$_POST["budget"];

    try {
        $dbh = new PDO("mysql:host=localhost;dbname=Recipe;charset=utf8", $user, $pass);
        $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO recipe (recipe_name, category,difficulty, budget, howto) VALUES (?, ?, ?, ?, ?)";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1, $recipe_name, PDO::PARAM_STR);
        $stmt->bindValue(2, $category, PDO::PARAM_INT);
        $stmt->bindValue(3, $difficulty, PDO::PARAM_INT);
        $stmt->bindValue(4, $budget, PDO::PARAM_INT);
        $stmt->bindValue(5, $howto, PDO::PARAM_STR);
        $stmt->execute();
        $dbh = null;
        echo "レシピが登録されました。";
    } catch(Exception $e) {
        echo "エラー発生". htmlspecialchars($e->getMessage(),ENT_QUOTES, "UTF-8")."<br>";
        die();
    }
?>