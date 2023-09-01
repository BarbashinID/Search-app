<!DOCTYPE html>
<html>
<head>
<title>Search | Поиск</title>
<meta charset="UTF-8">
<style>table, th, td {border: 1px solid black;border-collapse: collapse;}</style>
</head>
<body>
<form action="" method="GET">
        <input type="search" name="query" placeholder="Поиск"/>
		<input type="submit" name="submit" value="Найти" />
</form>
<?php 
$link = mysqli_connect('localhost', 'root', 'root', 'blog_db')
or die("Ошибка " . mysqli_error($link));

if (isset($_GET['submit'])) {
    $len = strlen($_GET['query']);
    if ($len >= 3){
        $search = "%" . $_GET['query'] . "%";
        $stmt = $link -> prepare("SELECT * FROM comment WHERE body LIKE ?");
        if ($stmt->errno) {
            die('Select Error (' . $stmt->errno . ') ' . $stmt->error);}
        $stmt -> bind_param('s', $search);
        $stmt -> execute();
        $array = $stmt -> get_result()->fetch_all(MYSQLI_ASSOC);
        
        $stmt -> close(); 
    }else {
        echo "Запрос должен состоять минимум из 3 символов";
    }

    if (isset($array)){
        if (count($array) > 0){
            echo "<h2>Результаты поиска (" . count($array) . ")</h2>";
            echo "<table><tr><th>Пост id</th><th>id</th><th>Название</th><th>email</th><th>Комментарий</th></tr>";
            foreach ($array as $item) {
                echo("<tr><td>{$item['postId']}</td><td>{$item['id']}</td><td>{$item['name']}</td><td>{$item['email']}</td><td>{$item['body']}</td></tr>"); 
            }
    } 	else {
            echo "Результаты не найдены";
        }
    
    echo "</table>";
    }
}
?>
</body>
</html>