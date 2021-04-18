<?php

try {
    $connect = new PDO('mysql:host=localhost;dbname=test', 'root', 'root');
} catch (PDOException $e) {
    die($e->getMessage());
}

$data = $connect->query('SELECT 
       users.name,
       users.surname,
       articles.title,
       articles.img,
       articles.short_description,
       articles.url
       FROM articles INNER JOIN users ON articles.users_id = users.users_id');
$posts = $data->fetchAll();

?>

<?php foreach ($posts as $post): ?>
    <p><a href="/articles/<?= $post['articles_id'] . '/' . $post['url']?>"><?= $post['title'] ?></a></p>
    <p><?= mb_strimwidth($post['short_description'],0,100,'...') ?></p>
    <p><img src="<?= $post['img'] ?>" alt=""></p>
    <p style="text-align: right" t><?= $post['name'] . ' ' . $post['surname'] ?></p>
    <hr>
<?php endforeach; ?>