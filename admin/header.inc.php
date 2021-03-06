
<header class="header">
    <?php if(isset($title)){ ?>
        <form method="GET" class="search">
            <input type="search" name="search" class="search__input" placeholder="Search <?= $title ?>">
            <button class="search__button">
                <svg class="search__icon">
                    <use xlink:href="img/sprite.svg#icon-magnifying-glass"></use>
                </svg>
            </button>
        </form>
    <?php } ?>

<nav class="user-nav">
    <!-- <div class="user-nav__icon-box">
        <svg class="user-nav__icon">
            <use xlink:href="img/sprite.svg#icon-bookmark"></use>
        </svg>
        <span class="user-nav__notification">7</span>
    </div>
    <div class="user-nav__icon-box">
        <svg class="user-nav__icon">
            <use xlink:href="img/sprite.svg#icon-chat"></use>
        </svg>
        <span class="user-nav__notification">13</span>
    </div> -->
    <div class="user-nav__user dropdown">
        <div class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="img/user-1.jpg" alt="User photo" class="user-nav__user-photo">
            <span class="user-nav__user-name">Admin</span>
        </div>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a href="video.php" class="dropdown-item"> 
                <i class="fa fa-upload" aria-hidden="true"></i> <span>Upload Video</span>
            </a>
            <a href="../logout.php" class="dropdown-item">
                <i class="fa fa-user" aria-hidden="true"></i>
                <span>Logout</span>
              
            </a>
         
         
        </div>
    </div>

</nav>
</header>
