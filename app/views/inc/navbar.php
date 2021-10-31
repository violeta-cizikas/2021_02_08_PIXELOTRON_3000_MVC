<!-- kuriamas navigacija -->

<nav class="navbar navbar-expand-sm navbar-dark bg-dark">

    <!-- <a class="navbar-brand" href="<?php echo URLROOT ?>"><?php echo SITENAME ?></a> -->
    <!-- sukuriamas automtinis button'as 9scalinant ekrana) -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-link" href="<?php echo URLROOT ?>/index">All Pixels</a>
            
            <!-- 53 _ rodomas skirtingas menu prisijungusiems ir atsijungusiems (php) -->
            <?php if (isset($_SESSION['user'])) :?>                
                <a class="nav-link" href="<?php echo URLROOT ?>/users/logout">Logout</a>
            <?php else: ?>
                <a class="nav-link" href="<?php echo URLROOT ?>/users/register">Register</a>
                <a class="nav-link" href="<?php echo URLROOT ?>/users/login">Login</a>
            <?php endif; ?>

        </div>

        <div class="navbar-nav ml-auto">
            <!-- 62 _ rodomas skirtingas menu (pacioje pradzioje nebus my account ir play) -->           
            <?php if (isset($_SESSION['user'])) :?>  
            <a class="nav-link" href="<?php echo URLROOT ?>/pages/my_pixels">My Pixels</a>
            <a class="nav-link" href="<?php echo URLROOT ?>/pages/add_new_pixels">Add New Pixels</a>
            <a class="nav-link" href="<?php echo URLROOT ?>/pages/activity_log">Activity Log</a>
            <!-- <a class="nav-link" href="<?php echo URLROOT ?>/pages/profile">Profile</a> -->
            <?php endif; ?>
        </div>
    </div>
</nav>