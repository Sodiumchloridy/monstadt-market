<header>
    <div id="menu-icon">
        <i class="fa-solid fa-bars fa-xl"></i>
    </div>

    <a href="/monstadt-market/" id="logo"> <!-- Logo of the Market -->
        <h2>Monstadt Market</h2>
    </a>

    <div id="search-bar"> <!-- Search bar -->
        <form id="search-form" action="/monstadt-market/search" method="GET"> <!--Search bar and icon-->
            <input type="text" name="search_query" placeholder="Search in Mondstadt Market..." maxlength="128">
            <button type="submit">
                <i class="fa-solid fa-magnifying-glass fa-xl"></i>
            </button>
        </form>
    </div>

    <div id="cart"> <!-- Cart -->
        <a href="cart/view_cart.php">
            <i class="fa-solid fa-cart-shopping fa-xl"></i>
        </a>
    </div>

    <?php
    if (isset($_SESSION['username'])) {

        // user is logged in, display personalized content
        echo "
            <div>
                <img src='data:" .
            htmlspecialchars($_SESSION['profile_pic_type']) .
            ";base64," . base64_encode($_SESSION['profile_pic']) .
            "' width='20px'/>" .
            htmlspecialchars($_SESSION['username']) .
            "</div>";
        echo "
            <div>
                <a href='auth/logout.php'> Logout </a>
            </div>";
    } else {

        // user is not logged in
        echo "
            <div id='auth-button-group'>
                <a href='/monstadt-market/auth/signup.php' id='signup'>
                    Sign Up
                </a>
                <a href='/monstadt-market/auth/login.php'>
                    Login
                </a>
            </button>
            ";
    }

    ?>

</header>
