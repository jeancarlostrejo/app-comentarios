<?php

use Ferre\Comments\models\Comment;

$params = explode("&", $_SERVER["QUERY_STRING"]);

$url = "";

foreach($params as $param) {
    if(strpos($param,"view=") === 0){
        $url = explode("=", $param)[1];
    }
}

if(isset($_POST["username"], $_POST["text"]) && $url !== ""){
    $username = $_POST["username"];
    $text = $_POST["text"];

    $comment = new Comment($username, $text, $url);
    $comment->save();
}

$comments = Comment::getAll($url);

?>
<div class="comments-container">
    <form action="" method="POST">
        <input type="text" name="username" placeholder="Username..." required>
        <textarea name="text" id="" cols="30" rows="10" required placeholder="Your comment"></textarea>

        <input type="submit" value="Submit">
    </form>

    <div class="comments">
        <?php if($comments): ?>
            <?php foreach($comments as $comment): ?>
                <div class="comment">
                    <div class="username"><?= $comment->getUsername() ?></div>
                    <div class="text"><?= $comment->getText() ?></div>
                    <div class="date"><?= $comment->getDate() ?></div>
                </div>
            <?php endforeach ?>
        <?php endif ?>
    </div>
</div>
