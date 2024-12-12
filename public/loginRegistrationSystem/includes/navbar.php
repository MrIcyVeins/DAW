<nav class="navbar navbar-expand-sm navbar-light bg-success">
    <div class="container">
        <a class="navbar-brand" href="/loginRegistrationSystem/pages/dashboard.php" style="font-weight:bold; color:white;">Dashboard</a>
        <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav m-auto mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/loginRegistrationSystem/pages/category1.php">Category1</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/loginRegistrationSystem/pages/category2.php">Category2</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/loginRegistrationSystem/pages/category3.php">Category3</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/loginRegistrationSystem/pages/category4.php">Newsletter</a>
                </li>
            </ul>
            <form class="d-flex my-2 my-lg-0">
                <a href="/loginRegistrationSystem/pages/logout.php" class="btn btn-light my-2 my-sm-0"
                   type="submit" style="font-weight:bolder;color:green;">
                    Logout
                </a>
            </form>
        </div>
    </div>
</nav>
<?php if (!$user['verified']): ?>
        <div class="alert alert-warning">
            Your email is not verified. Please verify it to enjoy all features.
            <form method="POST" action="resend_verification.php">
                <button type="submit" class="btn btn-primary mt-2">Resend Verification Email</button>
            </form>
        </div>
<?php endif; ?>
