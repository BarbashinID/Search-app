<?php 

$count_post = 0;
$count_comment = 0;

$link = mysqli_connect('localhost', 'root', 'root', 'blog_db')
or die("Ошибка " . mysqli_error($link));

$res_comments = file_get_contents('https://jsonplaceholder.typicode.com/comments');
$arr_comments = json_decode($res_comments, true);

foreach ($arr_comments as $key) 
{	
	$command = $link -> prepare("INSERT INTO comment (postId, id, name, email, body) VALUES (?, ?, ?, ?, ?)");
	$command -> bind_param("iisss", $key['postId'], $key['id'], $key['name'], $key['email'], $key['body']);	
	$command -> execute();
	$count_comment +=1;
}

$res_post = file_get_contents('https://jsonplaceholder.typicode.com/posts');
$arr_post = json_decode($res_post, true);

foreach ($arr_post as $key) 
{	

	$command = $link -> prepare("INSERT INTO post (userId, id, title, body) VALUES (?, ?, ?, ?)");
	$command -> bind_param("iiss", $key['userId'], $key['id'], $key['title'], $key['body']);	
	$command -> execute();
	$count_post +=1;
}
mysqli_close($link);
echo "Загружено " . $count_post . " записей и " . $count_comment . " комментариев.";
?>