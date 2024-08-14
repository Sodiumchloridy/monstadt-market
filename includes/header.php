<header>
    <!-- Top part of the header -->
    <nav id="pageHeaderTop">
        <div id="notification"> <!-- Notification link -->
            <a href="">
                <i class="fa-regular fa-bell"></i>
                <span>Notifications</span>
            </a>
        </div>

        <!-- Contact Link -->
        <div>
            <a href="">
                <i class="fa-regular fa-phone"></i>
                <span>Contact</span>
            </a>
        </div>
        <!-- About Link -->
        <div>
            <a href="">
                <i class="fa-regular fa-circle-info"></i>
                <span>About</span>
            </a>
        </div>


        <div id="help"> <!-- Help link -->
            <a href="">
                <i class="fa-regular fa-circle-question"></i>
                <span>Help</span>
            </a>
        </div>

        <div> <!-- Language Selector -->
            <i class="fa-solid fa-globe"></i>
            <select name="" id="">
                <option value="en">English</option>
                <option value="ms">Bahasa Melayu</option>
                <option value="zh">Chinese</option>
            </select>
        </div>

        <div> <!-- Sign up & login link -->
            <a href="auth/signup.php" id="signup">
                Sign Up
            </a>
            <a href="auth/login.php">
                Login
            </a>
        </div>
    </nav>

    <!-- Bottom part of the header -->
    <div id="pageHeaderBottom">

        <div id="logo"> <!-- Logo of the Market -->
            <a href="/monstadt-market/">
                <i class="fa-solid fa-basket-shopping fa-2xl"></i>
                <h2>Mondstadt Market</h2>
            </a>
        </div>

        <div id="search-bar"> <!-- Search bar -->
            <form id="search-form" action="/monstadt-market/search" method="GET"> <!--Search bar and icon-->
                <input type="text" name="search_query" placeholder="Search in Mondstadt Market..." maxlength="128">
                <button type="submit">
                    <i class="fa-solid fa-magnifying-glass fa-lg"></i>
                </button>
            </form>
        </div>

        <div id="cart"> <!-- Cart -->
            <a href="">
                <i class="fa-solid fa-cart-shopping fa-lg"></i>
            </a>
        </div>
    </div>
</header>