<?php //把兩個關聯的資料庫連在一起

require_once("./db_violin_connect.php");

$sql = "SELECT course.*, course_category.level AS course_category_level FROM course
        JOIN course_category ON course.course_category_id = course_category.course_category_id
        ORDER BY course.course_id";
$result=$conn->query($sql);

$rows=$result->fetch_all(MYSQLI_ASSOC);

if ($result === false) {
    die("Error executing query: " . $conn->error);
}

$rows = $result->fetch_all(MYSQLI_ASSOC);


?>
<pre>
    <?php
    print_r($rows);
    ?>
</pre>
<?php

$conn->close();