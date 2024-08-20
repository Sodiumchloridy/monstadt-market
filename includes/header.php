<header>
    <a href="/monstadt-market/" id="logo"> <!-- Logo of the Market -->
        <h2 data-value="MONSTADT MARKET" id="name">Monstadt Market</h2>
    </a>

    <div id="search-bar"> <!-- Search bar -->
        <form id="search-form" action="/monstadt-market/search" method="GET"> <!--Search bar and icon-->
            <input type="text" name="search_query" placeholder="Search in Mondstadt Market..." maxlength="128">
            <button type="submit" title="search">
                <i class="fa-solid fa-magnifying-glass fa-xl"></i>
            </button>
        </form>

        <div id="cart"> <!-- Cart -->
            <a href="/monstadt-market/cart/index.php">
                <i class="fa-solid fa-cart-shopping fa-xl"></i>
            </a>
        </div>
    </div>



    <?php
    if (isset($_SESSION['username'])) {

        // user is logged in, display personalized content
        echo "
            <div>
            <a href='../monstadt-market/profile/index.php'>
                <img src='data:" .
            htmlspecialchars($_SESSION['profile_pic_type']) .
            ";base64," . base64_encode($_SESSION['profile_pic']) .
            "' width='20px'/>" .
            htmlspecialchars($_SESSION['username']) .
            "</a></div>";
        echo "
            <div id='signout-button'>
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
            </div>
            ";
    }

    ?>
    <script>
        // Animation for the logo
        const letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        let interval = null;
        const name = document.querySelector("#name");

        function shuffleText() {
            let iteration = 0;

            clearInterval(interval);

            interval = setInterval(() => {
                name.innerText = name.innerText
                    .split("")
                    .map((letter, index) => {
                        if (index < iteration) {
                            return name.dataset.value[index];
                        }

                        return letters[Math.floor(Math.random() * 26)]
                    })
                    .join("");

                if (iteration >= name.dataset.value.length) {
                    clearInterval(interval);
                }

                iteration += 1 / 3;
            }, 30);
        }

        name.onmouseenter = event => {
            shuffleText();
        }

        window.onload = () => {
            shuffleText();
        }
    </script>
</header>
