        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-dark bg-primary text-light border-bottom-0">
            <a href="" class="navbar-brand ml-2">
                <img src="../dist/img/pcad_logo.ico" alt="Logo" class="brand-image img-circle elevation-3 bg-light p-1"
                    style="opacity: .8">
                <span class="brand-text font-weight-light text-light">PCAD</span>
            </a>

            <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle active"><i class="fas fa-bars"></i> Menu</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li><a href="andon_details.php" class="dropdown-item">Andon Details</a></li>
                            <li><a href="inspection_output.php" class="dropdown-item">Inspection Output</a></li>
                            <li><a href="hourly_output.php" class="dropdown-item active">Hourly Output</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

            <!-- Right navbar links -->
            <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->