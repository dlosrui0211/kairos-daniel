<?php include("includes/a_config.php");?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>About - Kairos</title>
    <?php include("includes/head-tag-contents.php");?>
</head>

<body>

    <header>
        <?php include("includes/navigation.php");?>
        <?php include("includes/carrito.php");?>
    </header>

    <main id="main-content">
        <!-- About Section-->
        <section class="page-section bg-primary text-white mb-0" id="about">
            <div class="container">
                <!-- About Section Heading-->
                <h1 class="page-section-heading text-center text-uppercase text-white">About</h1>
                <!-- Icon Divider-->
                <div class="divider-custom divider-light">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-star" aria-hidden="true"></i></div>
                    <div class="divider-custom-line"></div>
                </div>
                <!-- About Section Content-->
                <div class="row">
                    <div class="col-lg-4 ms-auto">
                        <p class="lead">Freelancer is a free bootstrap theme created by Start Bootstrap. The download
                            includes the complete source files including HTML, CSS, and JavaScript as well as optional
                            SASS
                            stylesheets for easy customization.</p>
                    </div>
                    <div class="col-lg-4 me-auto">
                        <p class="lead">You can create your own custom avatar for the masthead, change the icon in the
                            dividers, and add your email address to the contact form to make it fully functional!</p>
                    </div>
                </div>
                <!-- About Section Button-->
                <div class="text-center mt-4">
                    <a class="btn btn-xl btn-outline-light" href="https://startbootstrap.com/theme/freelancer/">
                        <i class="fas fa-download me-2" aria-hidden="true"></i>
                        Free Download!
                    </a>
                </div>

            </div>
        </section>
    </main>

    <?php include("includes/footer.php");?>

</body>

</html>