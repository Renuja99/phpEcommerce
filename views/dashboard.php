<?php

?>


<html>

<head>
    <title>Login Form</title>
    <link rel="stylesheet" type="text/css" href="dashboardStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css" integrity="sha512-vebUliqxrVkBy3gucMhClmyQP9On/HAWQdKDXRaAlb/FKuTbxkjPKUyqVOxAcGwFDka79eTF+YXwfke1h3/wfg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;400;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">

</head>

<body>
    <div class="sidebar">
        <div class="sidebar-brand">

            <span class="lab la-accusoft" style="font-size:32px;"></span>
            <h1 style="display:inline-block; font-family: 'Lobster', cursive; padding-left: 10px; letter-spacing:1px;">Viena</h1>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href=""><span class="las la-igloo"></span>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href=""><span class="las la-users"></span><span>Customers</span>
                </li>
                <li>
                    <a href=""><span class="las la-clipboard-list"></span><span>Products</span>
                </li>
                <li>
                    <a href=""><span class="las la-shopping-bag"></span><span>Orders</span>
                </li>
                <li>
                    <a href=""><span class="las la-receipt"></span><span>Inventory</span>
                </li>
            </ul>
        </div>
    </div>

    <div class="main-content">
        <header>
            <h2>

                <label for="">
                    <span class="las la-bars"></span>
                </label>
                Dashboard
            </h2>

            <div class="search-wrapper">
                <span class="las la-search"></span>
                <input type="search" placeholder="Search here" />
            </div>
            <div class="user-wrapper">
                <img src="profileImage.jpg" alt="" width="40px" height="40px" alt="">
                <div>
                    <h4>John Doe</h4>
                    <small>Super admin</small>

                </div>
            </div>

        </header>

        <main>
            <div class="cards">
                <div class="card-single">
                    <h1>54</h1>
                    <span>Customers</span>
                </div>
                <div>
                    <span class="las la-users"></span>
                </div>



                <div class="card-single">
                    <h1>54</h1>
                    <span>Projects</span>
                </div>
                <div>
                    <span class="las la-clipboard-list"></span>
                </div>



                <div class="card-single">
                    <h1>124</h1>
                    <span>Orders</span>
                </div>
                <div>
                    <span class="las la-shopping-bag"></span>
                </div>



                <div class="card-single">
                    <h1>$6k</h1>
                    <span>Income</span>
                </div>
                <div>
                    <span class="las la-google-wallet"></span>
                </div>
            </div>
        </main>
    </div>

</body>

</html>