<?php
require_once("./db_violin_connect.php");

$id = $_GET["id"]; //獲取傳遞過來的課程id id長這樣是自己設定的

$sql = "SELECT course.*, course_category.level AS course_category_level, 
        teacher.name AS course_teacher_name, course_style.style_name AS course_style_id
        FROM course
        JOIN course_category ON course.course_category_id = course_category.course_category_id 
        JOIN teacher ON course.teacher_id = teacher.teacher_id 
        JOIN course_style ON course.style_id = course_style.style_id
        WHERE course.course_id = $id
        ORDER BY course.course_id";

$result=$conn->query($sql);
$row=$result->fetch_assoc();
// $rowCount=$result->num_rows;
// var_dump($row);

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
                        <li><hr class="dropdown-divider" /></li>
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
                        <h1 class="mt-4">課程簡介</h1>
                        <div class="d-flex justify-content-end mt-3 mb-3">
                                <div>
                                    <a class="btn btn-dark mx-2" data-bs-toggle="modal" data-bs-target="#exampleModal" >下架課程</a> 
                                    <a class="btn btn-dark" href="course-edit.php?id=<?=$row["course_id"]?>">編輯課程</a>
                                </div>
                            </div>
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    <a class="btn btn-danger" href="DoDeleteCourse.php?id=<?=$row["course_id"]?>">確定下架</a>
                                </div>
                                </div>
                            </div>
                            </div>
                            <!-- 可能要新增課程的簡介 編輯那邊要改成簡介  -->
                            <ol class="breadcrumb mb-4">
                                <li class="breadcrumb-item"><a class="text-decoration-none text-dark" href="index.php">Dashboard</a></li>
                                <li class="breadcrumb-item"><a class="text-decoration-none text-dark" href="course_list.php">課程列表</a></li>
                                <li class="breadcrumb-item active">課程簡介</li>
                            </ol>
                            
                            <div class="col-md-12">
                                <div class="d-flex justify-content-center">
                                    <div class="col-md-6 col-sm-12" >
                                        <img style="width: 80%;" class="img-fluid" src="./course_images/<?=$row["img"]?>" alt="<?=$row["name"]?>"> 
                                    </div>
                                    <!-- 有時間再調整一下手機版時候的UI -->
                                    <div class="col-md-6 col-sm-12" >
                                        <div class="d-flex justify-content-start h2">
                                            <div class="mb-2 mx-2">
                                                <?=$row["course_category_level"]?>
                                            </div>
                                            <div class="mb-2">
                                                <?=$row["course_style_id"]?>
                                            </div>
                                        </div>
                                        <h1><?=$row["name"]?></h1>
                                        <div class="text-secondary text-start h4">指導教師：<?=$row["course_teacher_name"]?></div>
                                        <div class="text-danger text-end h4">新台幣$<?=number_format($row["price"])?>元</div>
                                        <div style="font-size: 1.5rem"><?=$row["description"]?></div>
                                        <div>限額：<?=$row["quota"]?></div>
                                        <div>狀態：
                                            <?php
                                            if ($row["valid"] == 1) {
                                                echo '<span style="color: red;">上架</span>';
                                            } else {
                                                echo '<span style="color: red;">下架</span>';
                                            }
                                            ?>
                                        </div>
                                        <div>課程開始：<?=$row["start_date"]?></div>
                                        <div>課程結束：<?=$row["end_date"]?></div>
                                        <div>課程開始：<?=$row["start_time"]?></div>
                                        <div>課程結束：<?=$row["end_time"]?></div>
                                        <div><?=$row["comment"]?></div>
                                    </div>
                                </div>
                                
                            </div>
                         

                    <h1></h1>
                    <img src="" alt="">
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
