<?php
session_start();
require_once("./db_violin_connect.php");

// $perPage=4; //定義變數 

// $sqlAll="SELECT * FROM course WHERE valid=1";
// $resultAll = $conn->query($sqlAll); 
// $userTotalCount = $resultAll->num_rows; //新：看多少筆數量來算需多少頁 本來：不是在搜尋的情況下應顯示總共有多少人 搜尋後頁面也顯示共多少人

// $pageCount= ceil($userTotalCount / $perPage); //多一筆要多一頁 相除後是小數點就無條件進位 JS:ceil()
// // echo $pageCount;

$sqlCategory="SELECT * FROM course_category";
$resultCategory = $conn->query($sqlCategory);
$rowsCategory = $resultCategory->fetch_all(MYSQLI_ASSOC);

// $sql = "SELECT course.*, course_category.level AS course_category_level, teacher.name AS course_teacher_name, course_style.style_name AS course_style_name FROM course
//         JOIN course_category ON course.course_category_id = course_category.course_category_id 
//         JOIN teacher ON course.teacher_id = teacher.teacher_id 
//         JOIN course_style ON course.style_id = course_style.style_id
//         ORDER BY course.course_id";

$sql = "SELECT course.*, course_category.level AS course_category_level, teacher.name AS course_teacher_name FROM course 
        JOIN course_category ON course.course_category_id = course_category.course_category_id 
        JOIN teacher ON course.teacher_id = teacher.teacher_id 
        WHERE course.valid = 0
        ORDER BY course.course_id";

$result=$conn->query($sql);
$rowCount=$result->num_rows;
$rows=$result->fetch_all(MYSQLI_ASSOC);
// var_dump($rows);
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Sidenav Light - SB Admin</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
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
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="#!">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
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
                                    <a class="nav-link" href="course_management.php">課程管理</a>
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
                        Start Bootstrap
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                <div class="container-fluid px-4">
                        <h1 class="mt-4">已下架課程列表</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">已下架課程列表</li>
                        </ol>
                        <div class="d-flex justify-content-between">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link active " aria-current="page" href="course_list.php">全部課程</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">初階個別課</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">中階個別課</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">高階個別課</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">團體課</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">大師班</a>
                                </li>
                            </ul>
                            <a class="btn btn-dark" href="course-upload.php">新增課程</a>
                        </div>
                        <div class="py-2">
                        <form action="">
                            <div class="row g-3 align-items-center">
                                <!-- 增加一個回去的按鈕 -->
                                <?php if(isset($_GET["min"]) && isset($_GET["max"])):?>
                                    <div class="col-auto">
                                    <a href="#"
                                    name=""
                                    id=""
                                    class="btn btn-primary"
                                    role="button"><i class="fa-solid fa-arrow-left"></i>
                                    </a>
                                    </div>
                                <?php endif; ?> 
                                <!-- 為何按回去是not found? -->
                                <div class="col-auto">
                                    <?php $minvalue=0;  //當最小值為0的時候
                                    if(isset($_GET["min"])){
                                        $minValue=$min;
                                    }
                                    ?>
                                    <input type="number" class="form-control" name="min" value="<?=$minValue?>" min="0">
                                </div>
                                <div class="col-auto">
                                    ~
                                </div>
                                <div class="col-auto">
                                    <input type="number" class="form-control" name="max" value="<?=$maxValue?>" min="0">
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-dark" type="submit">搜尋</button>
                                </div>
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
                                            <th>課程名稱</th>
                                            <th>課程種類</th>
                                            <th>指導教師</th>
                                            <th>費用</th>
                                            <th>限額</th>
                                            <th>課程時間</th>
                                            <th>開始日期</th>
                                            <th>結束日期</th>
                                            <th>編輯</th>
                                            <th>上架</th>
                                            <th>刪除</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($rows as $course_list): ?>
                                        <tr>
                                            
                                            <td><a class="text-decoration-none" href="course.php?id=<?=$course_list["course_id"]?>"><?=$course_list["name"]?></a></td>
                                            <td><?=$course_list["course_category_level"]?></td>
                                            <td><?=$course_list["course_teacher_name"]?></td>
                                            <td><?=$course_list["price"]?></td>
                                            <td><?=$course_list["quota"]?></td>
                                            <td><?=$course_list["time"]?></td>
                                            <td><?=$course_list["start_date"]?></td>
                                            <td><?=$course_list["end_date"]?></td>
                                            <td><a class="text-decoration-none" href="course-edit.php?id=<?=$course_list["course_id"]?>">編輯圖標</a></td>
                                            <td><a class="text-decoration-none" href="#">上架圖標</a></td>
                                            <td><a class="text-decoration-none" href="#">刪除圖標</a></td>
                                            
                                        </tr>
                                        </tbody>
                                    <?php endforeach; ?> 
                                    </tbody>
                                </table>
                            </div>
                        
                        
                        
                        
                        </div>
                        <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                        </ul>
                        </nav>
                    </div>
                        <div style="height: 100vh"></div>
                        <div class="card mb-4"><div class="card-body">When scrolling, the navigation stays at the top of the page. This is the end of the static navigation demo.</div></div>
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
    </body>
</html>
