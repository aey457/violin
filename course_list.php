<?php
session_start();
require_once("./db_violin_connect.php");


$sql_course_category = "SELECT * FROM course_category ";
$result_course_category = $conn->query($sql_course_category);
$course_categories = $result_course_category->fetch_all();

if(isset($_GET["cate"])){
    $cate=$_GET["cate"];
    // $sql="SELECT product.*, category.name AS category_name FROM product 
    // JOIN category ON product.category_id = category.id =$cate
    // ORDER BY product.id";
    $whereClause="WHERE course.course_category.course_category_id = $cate";
    var_dump($cate);
}else{
    // $sql="SELECT product.*, category.name AS category_name FROM product 
    // JOIN category ON product.category_id = category.id 
    // ORDER BY product.id";
    $whereClause="";
}



$sql = "SELECT course.*, course_category.level AS course_category_level, 
        teacher.name AS course_teacher_name, course_style.style_name AS course_style_id
        FROM course
        JOIN course_category ON course.course_category_id = course_category.course_category_id 
        JOIN teacher ON course.teacher_id = teacher.teacher_id 
        JOIN course_style ON course.style_id = course_style.style_id
        -- AND valid=1
        ORDER BY course.course_id";

// 如果有指定 category_id，修改 SQL 查詢以僅檢索特定類別的課程
$category_id = null;
if (isset($_GET["category_id"])) {
    $category_id = $_GET["category_id"];

    $sql = "SELECT course.*, course_category.level AS course_category_level, 
            teacher.name AS course_teacher_name, course_style.style_name AS course_style_id
            FROM course
            JOIN course_category ON course.course_category_id = course_category.course_category_id 
            JOIN teacher ON course.teacher_id = teacher.teacher_id 
            JOIN course_style ON course.style_id = $course_style.style_id
            WHERE course.course_category_id = $category_id 
            ORDER BY course.course_id";
}
// var_dump($category_id);
$result = $conn->query($sql);
$rowCount = $result->num_rows;
$rows = $result->fetch_all(MYSQLI_ASSOC);
// var_dump($rows);

$perPage = 15;

// 如果有搜尋字詞
if (isset($_GET["search"])) {
    $search = $_GET["search"];
    $sqlsearch = "SELECT course.*, course_category.level AS course_category_level, 
            teacher.name AS course_teacher_name, course_style.style_name AS course_style_id
            FROM course
            JOIN course_category ON course.course_category_id = course_category.course_category_id 
            JOIN teacher ON course.teacher_id = teacher.teacher_id 
            JOIN course_style ON course.style_id = course_style.style_id
            WHERE (course.name LIKE '%$search%' OR teacher.name LIKE '%$search%' OR course_style.style_name LIKE '%$search%' OR course_category.level LIKE '%$search%') 
            ORDER BY course.course_id";

    $searchResult = $conn->query($sqlsearch);

    if ($searchResult) {
        // 處理查詢結果
        while ($searchValues = $searchResult->fetch_assoc()) {
            // 處理每一筆資料
            // var_dump($searchValues); 用來檢查抓到什麼資料
        }

        // 計算搜尋結果的總行數和分頁數目
        // $courseTotalCount = $searchResult->num_rows;
        // $pageCount = ceil($courseTotalCount / $perPage);
        // echo $pageCount;
    } else {
        echo "SQL 錯誤: " . $conn->error;
    }
} else {
    // 如果沒有搜尋字詞，則顯示分頁後的所有資料
    if (isset($_GET["p"])) {
        $p = $_GET["p"];
        $startIndex = ($p - 1) * $perPage;

        // SQL 查詢課程資料，並加上 JOIN 的部分
        $sqlAll = "SELECT course.*, course_category.level AS course_category_level, 
                teacher.name AS course_teacher_name, course_style.style_name AS course_style_id
                FROM course
                JOIN course_category ON course.course_category_id = course_category.course_category_id 
                JOIN teacher ON course.teacher_id = teacher.teacher_id 
                JOIN course_style ON course.style_id = $course_style.style_id
                ORDER BY course.course_id
                LIMIT $startIndex, $perPage";

        $resultAll = $conn->query($sqlAll);
        $courseTotalCount = $resultAll->num_rows;
        $pageCount = ceil($courseTotalCount / $perPage);
        // echo $pageCount;

        // 處理查詢結果
        while ($searchValues = $resultAll->fetch_assoc()) {
            // 處理每一筆資料
            // var_dump($searchValues); 用來檢查抓到什麼資料
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Static Navigation - SB Admin</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.php">阿爾札工作室</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="#!">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Interface</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            課程
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="course_list.php">課程列表</a>
                                <a class="nav-link" href="course_management.php">已下架課程列表</a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            Pages
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                    Authentication
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="login.php">Login</a>
                                        <a class="nav-link" href="register.php">Register</a>
                                        <a class="nav-link" href="password.php">Forgot Password</a>
                                    </nav>
                                </div>
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                    Error
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="401.php">401 Page</a>
                                        <a class="nav-link" href="404.php">404 Page</a>
                                        <a class="nav-link" href="500.php">500 Page</a>
                                    </nav>
                                </div>
                            </nav>
                        </div>
                        <div class="sb-sidenav-menu-heading">Addons</div>
                        <a class="nav-link" href="charts.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Charts
                        </a>
                        <a class="nav-link" href="tables.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Tables
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    Admin Eleganza
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>

                <div class="container-fluid px-4">
                    <h1 class="mt-4">課程列表</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a class="text-decoration-none text-dark" href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">課程列表</li>
                    </ol>
                    <div class="d-flex justify-content-between mb-3">
                        <ul class="nav nav-pills">
                            
                                
                                <!-- <li class="nav-item"> 
                                    <a class="nav-link
                                    <?php if(!isset($_GET["cate"]))echo "active";?>
                                    " aria-current="page" href="course-list.php">全部</a>
                                </li>
                      
                                <?php foreach ($course_categories as $category): ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?php if (isset($_GET["cate"]) && $_GET["cate"] == $category[0]) echo "active";?>"
                                        aria-current="page"
                                        href="course-list.php?cate=<?= $category[0] ?>">
                                        <?= $category[1] ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul> -->
                        <!-- <ul class="nav nav-pills">
                            <?php foreach ($course_categories as $category) : ?>
                                <li class="nav-item">
                                    
                                    <a class="nav-link mx-2 bg-dark text-white" href="course-list.php?category_id=<?= $category[0] ?>"><?= $category[1] ?></a>
                                </li>
                            <?php endforeach; ?> -->
                        </ul>
                        <a class="btn btn-dark" href="course-upload.php">新增課程</a>
                    </div>
                    <div class="py-2">
                        <form action="">
                            <div class="row g-3 align-items-center">
                                <form action="" method="get">
                                    <div class="container mt-2 mb-1">
                                        <div class="row d-flex justify-content-end">
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="課程搜尋" aria-label="Recipient's username" aria-describedby="button-addon2" name="search" <?php
                                                                                                                                                                                                if (isset($_GET["search"])) :
                                                                                                                                                                                                    $searchValue = $_GET["search"];
                                                                                                                                                                                                ?> value="<?= $searchValue ?>" <?php endif; ?>>
                                                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><i class="fa-solid fa-magnifying-glass"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </form>
                        <div class="card mt-3 mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                課程清單
                            </div>
                            <div class="card-body">
                                <table class="table" id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>課程圖片</th>
                                            <th>課程名稱</th>
                                            <th>課程風格</th>
                                            <th>課程種類</th>
                                            <th>指導教師</th>
                                            <th>費用</th>
                                            <th>限額</th>
                                            <th>開始時間</th>
                                            <th>結束時間</th>
                                            <th>開始日期</th>
                                            <th>結束日期</th>
                                            <th>狀態</th>
                                            <th>編輯</th>
                                            <th>下架</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // 如果有搜尋結果，顯示搜尋結果；否則顯示所有課程
                                        $displayRows = isset($searchResult) ? $searchResult : $rows;

                                        foreach ($displayRows as $course_list) :
                                        ?>
                                            <tr>
                                                <td><img style="max-width:100px; max-height: 100px;" src="./course_images/<?= $course_list["img"] ?>" alt="課程圖片"></td>
                                                <td><a class=" text-decoration-none text-dark fw-bold fs-5" href="course.php?id=<?= $course_list["course_id"] ?>"><?= $course_list["name"] ?></a></td>
                                                <td><?= $course_list["course_style_id"] ?></td>
                                                <td><?= $course_list["course_category_level"] ?></td>
                                                <td><?= $course_list["course_teacher_name"] ?></td>
                                                <td>新台幣<?= number_format($course_list["price"]) ?>元</td>
                                                <td><?= $course_list["quota"] ?></td>
                                                <td><?= $course_list["start_time"] ?></td>
                                                <td><?= $course_list["end_time"] ?></td>
                                                <td><?= $course_list["start_date"] ?></td>
                                                <td><?= $course_list["end_date"] ?></td>
                                                <td class="text-danger">
                                                    <?php
                                                    if ($course_list["valid"] == 1) {
                                                        echo '上架';
                                                    } else {
                                                        echo '下架';
                                                    }
                                                    ?>
                                                </td>
                                                <td><a class="text-decoration-none text-dark" href="course-edit.php?id=<?= $course_list["course_id"] ?>"><i class="fa-regular fa-pen-to-square"></i></a></td>
                                                <td><a class="text-decoration-none text-dark" data-bs-toggle="modal" data-bs-target="#id<?= $course_list['course_id'] ?>"><i class="fa-regular fa-square-caret-down"></i></a></td>
                                            </tr>
                                            <div class="modal fade" id="id<?= $course_list['course_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">注意：下架課程</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            您確定要下架此筆課程資料嗎？
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">取消</button>
                                                            <button type="button" class="btn btn-danger" onclick="deletecourse(<?= $course_list['course_id'] ?>)">確定下架</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>

                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <div class="py-2 text-center">
                            共<?= $rowCount ?>筆課程
                        </div>
                        <!-- <?php if (!isset($_GET["search"])) : ?>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination">
                                    <?php for ($i = 1; $i <= $pageCount; $i++) : ?>
                                        <li class="page-item 
                                        <?php
                                        if ($i == $p) echo "active";
                                        ?>"><a class="page-link" href="course-list.php?order=<?= $order ?>&p=<?= $i ?>"><?= $i ?></a></li>
                                    <?php endfor; ?>
                                </ul>
                            </nav>
                        <?php endif; ?> -->


                    </div>
                    <div style="height: 100vh"></div>
                    <div class="card mb-4">
                        <div class="card-body">When scrolling, the navigation stays at the top of the page. This is the end of the static navigation demo.</div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script>
        function deletecourse(id) {
            window.location.replace("DoDeleteCourse.php?id=" + id);
            // console.log(id);
        }
    </script>
</body>

</html>