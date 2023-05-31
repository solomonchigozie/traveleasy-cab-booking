<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-body-tertiary sidebar collapse">
    <div class="position-sticky pt-3 sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.php">
                <span data-feather="home" class="align-text-bottom"></span>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="orders.php">
                <span data-feather="file" class="align-text-bottom"></span>
                My Orders
                </a>
            </li>
            <?php
                if($_SESSION['type'] == "passenger"){
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="driver.php">
                        <span data-feather="shopping-cart" class="align-text-bottom"></span>
                        Become a driver 
                        </a>
                    </li>
                    <?php
                }else{
                    ?>
                    
                <li class="nav-item">
                    <a class="nav-link" href="cars.php">
                    <span data-feather="shopping-cart" class="align-text-bottom"></span>
                    My Cars 
                    </a>
                </li>
            <?php
                }
            
            ?>
            <li class="nav-item">
                <a class="nav-link" href="profile">
                <span data-feather="shopping-cart" class="align-text-bottom"></span>
                Profile
                </a>
            </li>
        </ul>
    </div>
</nav>