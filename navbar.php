<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar navbar-expand-lg bg-light shadow-lg">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="images/logo.png" class="logo img-fluid" alt="LearnTogether">
            <span>
                LearnTogether
                <small>Study support for students</small>
            </span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php if ($current_page === '404.php'): ?>
                    <!-- Only profile button -->
                <?php elseif ($current_page === 'profilo.php' or $current_page === 'test.php'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="test.php">Test</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#section_2">About us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#section_3">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#section_4">Become a Tutor</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#section_5">Contacts</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item ms-3 dropdown">
                    <button class="nav-link dropdown-toggle custom-btn custom-border-btn btn" href="#profilo" id="navbarLightDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false" title="Profile">
                        <i class="bi-person-circle"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarLightDropdownMenuLink">
                        <?php if (empty($_SESSION['logged_in'])): ?>
                            <li class="dropdown-item">
                                <a  href="#" data-bs-toggle="modal" data-bs-target="#loginModal">
                                    <i class="bi bi-box-arrow-in-right me-2"></i> Login
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="dropdown-item">
                                <a href="profilo.php">
                                    <i class="bi bi-person-circle me-2"></i> Profile
                                </a>
                            </li>
                            <hr style="margin: 0;">
                            <li class="dropdown-item">
                                <a href="logout.php">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Login Modal -->
<?php if (empty($_SESSION['logged_in'])): ?>
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="custom-form volunteer-form mb-0" action="login.php" method="post" role="form" id="loginForm">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="loginModalLabel">Login to your account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0 pb-0">
                        <div class="row">
                            <div class="col-12">
                                <input type="email" name="login-email" id="loginEmail" class="form-control" placeholder="Email" required="">
                            </div>
                            <div class="col-12 ">
                                <input type="password" name="login-password" id="loginPassword" class="form-control" placeholder="Password" required="">
                            </div>
                        </div>
                        <?php if (isset($_SESSION['login_error'])): ?>
                            <span style="color: #dc3545;">Invalid email or password.</span>
                            <?php unset($_SESSION['login_error']); ?>
                        <?php endif; ?>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="submit" class="form-control">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
    // Script to open login modal if error=1 is present in the URL
    if (isset($_GET['error']) && $_GET['error'] == 1): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var loginModalEl = document.getElementById('loginModal');
                var loginModal = new bootstrap.Modal(loginModalEl);
                loginModal.show();

                // When the modal is closed, remove error=1 from the URL
                loginModalEl.addEventListener('hidden.bs.modal', function() {
                    if (window.history.replaceState) {
                        const url = new URL(window.location);
                        url.searchParams.delete('error');
                        window.history.replaceState({}, document.title, url.pathname + url.search);
                    }
                });
            });
        </script>
    <?php endif; ?>
<?php endif; ?>