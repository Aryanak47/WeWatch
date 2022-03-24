<div class="topBar">

<div class="logoContainer">
    <a href="index.php">
        <img src="assets/images/websitelogo.png" alt="Logo">
    </a>
</div>

<ul class="navLinks">
    <li class="navlink"><a href="index.php">Home</a></li>
    <li class="navlink"><a href="shows.php">TV Shows</a></li>
    <li class="navlink"><a href="movies.php">Movies</a></li>
    <li class="navlink"><a href="recent.php">Recently Watched</a></li>
</ul>

<div class="rightItems">
    <a href="wishlist.php" class="wish">
    <i class="fa fa-heart" aria-hidden="true"></i>
    <span class="wish__num"> <?php echo "$total_wish" ?></span>
    </a>
    <a href="search.php">
        <i class="fas fa-search"></i>
    </a>
    <?php if (isset($_SESSION["userLoggedIn"])){  ?>
        <a href="profile.php">
        <i class="fas fa-user"></i>
    </a>

    <a href="logout.php">
        <i class="fas fa-sign-out-alt"></i>
    </a>
    
    
    <?php } ?>
    
</div>

</div>