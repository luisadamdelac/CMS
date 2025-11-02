<?php
require_once dirname(__DIR__) . '/helpers/functions.php';
?>
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <i class="fas fa-utensils"></i> Platia Restaurant
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <?php
            // Hide main navigation on login and register pages
            $currentPage = basename($_SERVER['PHP_SELF']);
            $hideNav = in_array($currentPage, ['login.php', 'register.php']);
            ?>
            <?php if (!$hideNav): ?>
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="menu.php">Menu</a>
                </li>
                <?php if (isLoggedIn() && getUserRole() === 'customer'): ?>
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="#" id="cartBtn">
                            <i class="fas fa-shopping-cart"></i> Cart
                            <span class="badge bg-danger position-absolute top-0 start-100 translate-middle" id="cartCount" style="display: none;">0</span>
                        </a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="reservations.php">Reservations</a>
                </li>
                <?php if (isLoggedIn() && getUserRole() === 'staff'): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="staffDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-tie"></i> Staff Panel
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="staff/orders.php">Orders & Reservations</a></li>
                            <li><a class="dropdown-item" href="dashboard.php">Dashboard</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (isLoggedIn() && getUserRole() === 'admin'): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-cog"></i> Admin Panel
                        </a>
                        <ul class="dropdown-menu">
                            <?php
                            // Check if we're currently in an admin page by looking for 'admin' in the path
                            $isInAdmin = strpos($_SERVER['REQUEST_URI'], '/admin/') !== false;
                            $adminPath = $isInAdmin ? '' : 'admin/';
                            $menuPath = $isInAdmin ? '../menu.php' : 'menu.php';
                            ?>
                            <li><a class="dropdown-item" href="<?php echo $adminPath; ?>dashboard.php">Dashboard</a></li>
                            <li><a class="dropdown-item" href="<?php echo $menuPath; ?>">Menu</a></li>
                            <li><a class="dropdown-item" href="<?php echo $adminPath; ?>reservations.php">Reservations</a></li>
                            <li><a class="dropdown-item" href="<?php echo $adminPath; ?>settings.php">Settings</a></li>
                            <li><a class="dropdown-item" href="<?php echo $adminPath; ?>profile.php">Profile</a></li>
                            <li><a class="dropdown-item" href="<?php echo $adminPath; ?>contact.php">Contact</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
                <?php if (isLoggedIn() && in_array(getUserRole(), ['customer', 'staff', 'admin'])): ?>
                    <?php
                    // Hide general dashboard link when on admin pages to avoid duplicate
                    $isInAdmin = strpos($_SERVER['REQUEST_URI'], '/admin/') !== false;
                    if (!$isInAdmin || getUserRole() !== 'admin'):
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo getUserRole() === 'admin' ? 'admin/dashboard.php' : 'dashboard.php'; ?>">Dashboard</a>
                    </li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
            <?php endif; ?>
            <ul class="navbar-nav">
                <?php if (!isLoggedIn()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo isset($isInAdmin) && $isInAdmin ? '../logout.php' : 'logout.php'; ?>">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
