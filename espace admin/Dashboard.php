<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Liens -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.0.7/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/admin.css">
</head>

<body>
    <div class="grid-container">

        <!-- Header -->
        <header class="header">
            <div class="menu-icon" onclick="openSidebar()">
                <span class="material-icons-outlined">menu</span>
            </div>

            <div class="header-right">
                <span class="material-icons-outlined">account_circle</span>
            </div>
        </header>
        <!-- End Header -->

        <!-- Sidebar -->
        <aside id="sidebar">
            <div class="sidebar-title">
                <div class="sidebar-brand">
                    <a href="#" class="nav__logo">
                        <i class="ri-book-line"></i>Education</a>
                </div>
                <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
            </div>

            <ul class="sidebar-list">
                <li class="sidebar-list-item">
                    <a href="./Dashboard.php" target="_blank">
                        <span class="material-icons-outlined">dashboard</span> Tableau de bord
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="./Formations.php" target="_blank">
                        <span class="material-icons-outlined">inventory_2</span> Formations
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="./Categories.php" target="_blank">
                        <span class="material-icons-outlined">category</span> Catégories
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="./Membres.php" target="_blank">
                        <span class="material-icons-outlined">groups</span> Membres
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="#" target="_blank">
                        <span class="material-icons-outlined">fact_check</span> Commandes
                    </a>
                </li>
                <li class="sidebar-list-item">
                    <a href="./Profil.php" target="_blank">
                        <span class="material-icons-outlined">person</span> Profile
                    </a>
                </li>
            </ul>
        </aside>
        <!-- End Sidebar -->

        <!-- Main -->
        <main class="main-container">
            <div class="main-title">
                <h2>DASHBOARD</h2>
            </div>

            <div class="main-cards">

                <div class="card">
                    <div class="card-inner">
                        <h3>Formations</h3>
                        <span class="material-icons-outlined">inventory_2</span>
                    </div>
                    <h1>249</h1>
                </div>

                <div class="card">
                    <div class="card-inner">
                        <h3>CATEGORIES</h3>
                        <span class="material-icons-outlined">category</span>
                    </div>
                    <h1>25</h1>
                </div>

                <div class="card">
                    <div class="card-inner">
                        <h3>MEMBRES</h3>
                        <span class="material-icons-outlined">groups</span>
                    </div>
                    <h1>1500</h1>
                </div>

                <div class="card">
                    <div class="card-inner">
                        <h3>Commandes</h3>
                        <span class="material-icons-outlined">notification_important</span>
                    </div>
                    <h1>56</h1>
                </div>

            </div>

            <div class="charts">

                <div class="charts-card">
                    <h2 class="chart-title">Nouvaux Formations </h2>
                    <div id="bar-chart"></div>
                </div>

                <div class="charts-card">
                    <h2 class="chart-title">Membres</h2>
                    <div id="area-chart"></div>
                </div>

            </div>
        </main>
        <!-- End Main -->

    </div>

    <!-- Scripts -->
    <!-- ApexCharts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.5/apexcharts.min.js"></script>
    <!-- Custom JS -->
    <script src="js/scripts.js"></script>
</body>

</html>