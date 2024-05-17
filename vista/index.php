<?php
ob_start();
?>
<?php
include_once '../control/configBd.php';
include_once '../control/ControlEntidad.php';
include_once '../control/ControlConexionPdo.php';
include_once '../modelo/Entidad.php';
session_start();
$loginEmail = "";
$loginContrasena = "";
$loginBoton = "";
if (isset($_POST['txtLoginEmail']))
  $loginEmail = $_POST['txtLoginEmail'];
if (isset($_POST['txtLoginContrasena']))
  $loginContrasena = $_POST['txtLoginContrasena'];
if (isset($_POST['btnLogin']))
  $loginBoton = $_POST['btnLogin'];
if ($loginBoton == "Login") {
  $validar = false;
  $sql = "SELECT * FROM usuario WHERE email=? AND contrasena=?";
  $objControlEntidad = new ControlEntidad('usuario');
  $objUsuario = $objControlEntidad->consultar($sql, [$loginEmail, $loginContrasena]);
  if ($objUsuario) {
    $_SESSION['email'] = $loginEmail;
    //$datosUsuario = ['email' => $email, 'contrasena' => $contrasena];
    //$objUsuario = new Entidad($datosUsuario);
    $objControlRolUsuario = new ControlEntidad('rol_usuario');
    $sql = "SELECT rol.id as id, rol.nombre as nombre
        FROM rol_usuario INNER JOIN rol ON rol_usuario.fkidrol = rol.id
        WHERE fkemail = ?";
    $parametros = [$loginEmail];
    $listaRolesDelUsuario = $objControlRolUsuario->consultar($sql, $parametros);
    $_SESSION['listaRolesDelUsuario'] = $listaRolesDelUsuario;
    var_dump($listaRolesDelUsuario);
    header('Location: index.php');
  } else
    header('Location: index.php');
}
?>

<?php include 'header.html'; ?>
<?php include 'body.php'; ?>
<?php include 'modalLogin.php'; ?>

<!-- ======= Hero Section ======= -->
<section id="hero">
  <div class="hero-container" data-aos="fade-up" data-aos-delay="150">
    <h1>Innovar. Desarrollar. Optimizar</h1>
    <h2>Somos un equipo de diseñadores talentosos haciendo sitios web con Bootstrap</h2>
    <div class="d-flex">
      <a href="#about" class="btn-get-started scrollto">Comenzar</a>
      <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
    </div>
  </div>
</section><!-- End Hero -->

<main id="main">

  <!-- ======= About Section ======= -->
  <section id="about" class="about">
    <div class="container" data-aos="fade-up">

      <div class="row justify-content-end">
        <div class="col-lg-11">
          <div class="row justify-content-end">

            <div class="col-lg-3 col-md-5 col-6 d-md-flex align-items-md-stretch">
              <div class="count-box">
                <i class="bi bi-emoji-smile"></i>
                <span data-purecounter-start="0" data-purecounter-end="125" data-purecounter-duration="1" class="purecounter"></span>
                <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
                <p>Clientes Felices</p>
              </div>
            </div>

            <div class="col-lg-3 col-md-5 col-6 d-md-flex align-items-md-stretch">
              <div class="count-box">
                <i class="bi bi-journal-richtext"></i>
                <span data-purecounter-start="0" data-purecounter-end="85" data-purecounter-duration="1" class="purecounter"></span>
                <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
                <p>Proyectos</p>
              </div>
            </div>

            <div class="col-lg-3 col-md-5 col-6 d-md-flex align-items-md-stretch">
              <div class="count-box">
                <i class="bi bi-clock"></i>
                <span data-purecounter-start="0" data-purecounter-end="35" data-purecounter-duration="1" class="purecounter"></span>
                <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
                <p>Años de experiencia</p>
              </div>
            </div>

            <div class="col-lg-3 col-md-5 col-6 d-md-flex align-items-md-stretch">
              <div class="count-box">
                <i class="bi bi-award"></i>
                <span data-purecounter-start="0" data-purecounter-end="48" data-purecounter-duration="1" class="purecounter"></span>
                <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
                <p>Premios</p>
              </div>
            </div>

          </div>
        </div>
      </div>

      <div class="row">

        <div class="col-lg-6 video-box align-self-baseline" data-aos="zoom-in" data-aos-delay="100">
          <img src="assets/img/about.jpg" class="img-fluid" alt="">
          <a href="https://youtu.be/ZHv4MBWj5wM" class="glightbox play-btn mb-4"></a>
          <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
        </div>

        <div class="col-lg-6 pt-3 pt-lg-0 content">
          <h3>Nuestra Historia</h3>
          <p class="fst-italic">
            Desde nuestra fundación, en 2012, en Medellin, hemos estado comprometidos con la excelencia en el desarrollo
            de software. En devCrypt, nos esforzamos por ofrecer soluciones innovadoras y de alta calidad que impulsen
            el crecimiento y el éxito de nuestros clientes.
          </p>
          <ul>
            <li><i class="bx bx-check-double"></i> Innovación constante en cada proyecto.</li>
            <li><i class="bx bx-check-double"></i> Compromiso con la calidad y la excelencia.</li>
            <li><i class="bx bx-check-double"></i> Colaboración estrecha con nuestros clientes.</li>
            <li><i class="bx bx-check-double"></i> Pasión por la tecnología y el desarrollo de software.</li>
          </ul>
          <p>
            Con un equipo de expertos apasionados por la tecnología, estamos aquí para ayudarte a alcanzar tus objetivos
            y superar tus expectativas en cada proyecto. En devCrypt, creemos que cada desafío es una oportunidad para
            crecer y aprender, y estamos emocionados de embarcarnos en este viaje contigo.
          </p>
        </div>

      </div>

    </div>
  </section><!-- End About Section -->

  <!-- ======= About Boxes Section ======= -->
  <section id="about-boxes" class="about-boxes">
    <div class="container" data-aos="fade-up">

      <div class="row">
        <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
          <div class="card">
            <img src="assets/img/about-boxes-1.jpg" class="card-img-top" alt="...">
            <div class="card-icon">
              <i class="ri-brush-4-line"></i>
            </div>
            <div class="card-body">
              <h5 class="card-title"><a href="">Nuestra Misión</a></h5>
              <p class="card-text">Ofrecer soluciones de software innovadoras y de alta calidad que impulsen el éxito de
                nuestros clientes. Trabajaremos en colaboración con ellos, comprendiendo sus necesidades y superando sus
                expectativas en cada proyecto.</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
          <div class="card">
            <img src="assets/img/about-boxes-2.jpg" class="card-img-top" alt="...">
            <div class="card-icon">
              <i class="ri-calendar-check-line"></i>
            </div>
            <div class="card-body">
              <h5 class="card-title"><a href="">Nuestro Plan</a></h5>
              <p class="card-text">Nos comprometemos a ofrecer soluciones innovadoras y de alta calidad, trabajando
                estrechamente con nuestros clientes para entender y satisfacer sus necesidades. Buscamos un crecimiento
                constante y sostenible como líderes en el desarrollo de software, atrayendo y desarrollando talento
                excepcional.</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="300">
          <div class="card">
            <img src="assets/img/about-boxes-3.jpg" class="card-img-top" alt="...">
            <div class="card-icon">
              <i class="ri-movie-2-line"></i>
            </div>
            <div class="card-body">
              <h5 class="card-title"><a href="">Nuestra Visión</a></h5>
              <p class="card-text">Nos vemos como líderes en el desarrollo de software, reconocidos por nuestra
                excelencia en la innovación tecnológica y el compromiso con la calidad. Buscamos ser el socio preferido
                de empresas que buscan soluciones digitales de vanguardia para potenciar su crecimiento y éxito en un
                mundo cada vez más digitalizado.</p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section><!-- End About Boxes Section -->

  <!-- ======= Clients Section ======= -->
  <section id="clients" class="clients">
    <div class="container" data-aos="zoom-in">

      <div class="row">

        <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
          <img src="assets/img/clients/client-1.png" class="img-fluid" alt="">
        </div>

        <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
          <img src="assets/img/clients/client-2.png" class="img-fluid" alt="">
        </div>

        <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
          <img src="assets/img/clients/client-3.png" class="img-fluid" alt="">
        </div>

        <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
          <img src="assets/img/clients/client-4.png" class="img-fluid" alt="">
        </div>

        <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
          <img src="assets/img/clients/client-5.png" class="img-fluid" alt="">
        </div>

        <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
          <img src="assets/img/clients/client-6.png" class="img-fluid" alt="">
        </div>

      </div>

    </div>
  </section><!-- End Clients Section -->

  <!-- ======= Features Section ======= -->
  <section id="features" class="features">
    <div class="container" data-aos="fade-up">

      <ul class="nav nav-tabs row d-flex">
        <li class="nav-item col-3">
          <a class="nav-link active show" data-bs-toggle="tab" href="#tab-1">
            <i class="ri-gps-line"></i>
            <h4 class="d-none d-lg-block">Desarrollo a Medida</h4>
          </a>
        </li>
        <li class="nav-item col-3">
          <a class="nav-link" data-bs-toggle="tab" href="#tab-2">
            <i class="ri-body-scan-line"></i>
            <h4 class="d-none d-lg-block">Seguridad Integral</h4>
          </a>
        </li>
        <li class="nav-item col-3">
          <a class="nav-link" data-bs-toggle="tab" href="#tab-3">
            <i class="ri-sun-line"></i>
            <h4 class="d-none d-lg-block">Optimización de Procesos</h4>
          </a>
        </li>
        <li class="nav-item col-3">
          <a class="nav-link" data-bs-toggle="tab" href="#tab-4">
            <i class="ri-store-line"></i>
            <h4 class="d-none d-lg-block">Soporte Continuo</h4>
          </a>
        </li>
      </ul>

      <div class="tab-content">
        <div class="tab-pane active show" id="tab-1">
          <div class="row">
            <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0">
              <h3>Soluciones personalizadas adaptadas a las necesidades específicas de tu negocio.</h3>
              <p class="fst-italic">
                Nuestro equipo de expertos en desarrollo de software se especializa en crear soluciones personalizadas
                que se ajustan a las necesidades específicas de tu empresa. Nos comprometemos a:
              </p>
              <ul>
                <li><i class="ri-check-double-line"></i> Comprender a fondo tus requerimientos y objetivos.</li>
                <li><i class="ri-check-double-line"></i> Diseñar y desarrollar aplicaciones que se integren
                  perfectamente con tus sistemas existentes.</li>
                <li><i class="ri-check-double-line"></i> Probar exhaustivamente cada producto para garantizar su calidad
                  y funcionamiento óptimo.</li>
                <li><i class="ri-check-double-line"></i> Brindar soporte y mantenimiento continuo para asegurar la
                  satisfacción a largo plazo.</li>
              </ul>
            </div>
            <div class="col-lg-6 order-1 order-lg-2 text-center">
              <img src="assets/img/features-1.png" alt="" class="img-fluid">
            </div>
          </div>
        </div>
        <div class="tab-pane" id="tab-2">
          <div class="row">
            <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0">
              <h3>Implementación de medidas de seguridad avanzadas para proteger tus datos y sistemas.</h3>
              <p>
                En devCrypt, nos tomamos la seguridad muy en serio. Nuestras soluciones incluyen:
              </p>
              <ul>
                <li><i class="ri-check-double-line"></i> Implementación de prácticas de desarrollo seguro desde el
                  inicio del proyecto.</li>
                <li><i class="ri-check-double-line"></i> Uso de las últimas tecnologías y herramientas de seguridad.
                </li>
                <li><i class="ri-check-double-line"></i> Auditorías regulares y pruebas de penetración para identificar
                  y mitigar vulnerabilidades.</li>
                <li><i class="ri-check-double-line"></i> Capacitación para tu equipo en buenas prácticas de seguridad.
                </li>
              </ul>
            </div>
            <div class="col-lg-6 order-1 order-lg-2 text-center">
              <img src="assets/img/features-2.png" alt="" class="img-fluid">
            </div>
          </div>
        </div>
        <div class="tab-pane" id="tab-3">
          <div class="row">
            <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0">
              <h3>Automatización de tareas repetitivas para mejorar la eficiencia y productividad.</h3>
              <p>
                Buscamos mejorar la eficiencia y productividad de tu empresa a través de:
              </p>
              <ul>
                <li><i class="ri-check-double-line"></i> Análisis detallado de tus procesos actuales para identificar
                  áreas de mejora.</li>
                <li><i class="ri-check-double-line"></i> Desarrollo e implementación de soluciones automatizadas para
                  tareas repetitivas.</li>
                <li><i class="ri-check-double-line"></i> Integración de sistemas para una gestión de datos más eficaz.
                </li>
                <li><i class="ri-check-double-line"></i> Monitoreo y análisis continuo para ajustar y mejorar las
                  soluciones implementadas.</li>
              </ul>
            </div>
            <div class="col-lg-6 order-1 order-lg-2 text-center">
              <img src="assets/img/features-3.png" alt="" class="img-fluid">
            </div>
          </div>
        </div>
        <div class="tab-pane" id="tab-4">
          <div class="row">
            <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0">
              <h3>Asistencia técnica y actualizaciones regulares para garantizar el funcionamiento óptimo de tus
                aplicaciones.</h3>
              <p>
                Nuestro compromiso va más allá de la implementación inicial. Ofrecemos:
              </p>
              <ul>
                <li><i class="ri-check-double-line"></i> Asistencia técnica rápida y eficiente para resolver cualquier
                  problema que puedas enfrentar.</li>
                <li><i class="ri-check-double-line"></i> Actualizaciones periódicas para mantener tus aplicaciones
                  seguras y al día.</li>
                <li><i class="ri-check-double-line"></i> Capacitación para tu equipo en el uso y mantenimiento de las
                  soluciones implementadas.</li>
                <li><i class="ri-check-double-line"></i> Monitoreo continuo para identificar y solucionar problemas
                  antes de que afecten tu operación.</li>
                <li><i class="ri-check-double-line"></i> Evaluaciones regulares de tus sistemas para identificar
                  oportunidades de mejora.</li>
              </ul>
            </div>
            <div class="col-lg-6 order-1 order-lg-2 text-center">
              <img src="assets/img/features-4.png" alt="" class="img-fluid">
            </div>
          </div>
        </div>
      </div>

    </div>
  </section><!-- End Features Section -->

  <!-- ======= Services Section ======= -->
  <section id="services" class="services section-bg">
    <div class="container" data-aos="fade-up">

      <div class="section-title">
        <h2>Servicios</h2>
        <p>Descubre nuestros servicios</p>
      </div>

      <div class="row" data-aos="fade-up" data-aos-delay="200">
        <div class="col-md-6">
          <div class="icon-box">
            <i class="bi bi-laptop"></i>
            <h4><a href="#">Desarrollo a Medida</a></h4>
            <p>Creación de soluciones personalizadas que se adaptan a las necesidades específicas de tu empresa.</p>
          </div>
        </div>
        <div class="col-md-6 mt-4 mt-md-0">
          <div class="icon-box">
            <i class="bi bi-bar-chart"></i>
            <h4><a href="#">Seguridad Integral</a></h4>
            <p>Implementación de medidas de seguridad avanzadas para proteger tus datos y sistemas.</p>
          </div>
        </div>
        <div class="col-md-6 mt-4 mt-md-0">
          <div class="icon-box">
            <i class="bi bi-brightness-high"></i>
            <h4><a href="#">Optimización de Procesos</a></h4>
            <p>Automatización de tareas repetitivas para mejorar la eficiencia y productividad.</p>
          </div>
        </div>
        <div class="col-md-6 mt-4 mt-md-0">
          <div class="icon-box">
            <i class="bi bi-briefcase"></i>
            <h4><a href="#">Soporte Continuo</a></h4>
            <p>Asistencia técnica y actualizaciones regulares para garantizar el funcionamiento óptimo de tus
              aplicaciones.</p>
          </div>
        </div>
        <div class="col-md-6 mt-4 mt-md-0">
          <div class="icon-box">
            <i class="bi bi-cloud-check"></i>
            <h4><a href="#">Computación en la Nube</a></h4>
            <p>Implementación y gestión de soluciones basadas en la nube para mejorar la flexibilidad y escalabilidad de
              tu infraestructura tecnológica.</p>
          </div>
        </div>
        <div class="col-md-6 mt-4 mt-md-0">
          <div class="icon-box">
            <i class="bi bi-code-slash"></i>
            <h4><a href="#">Desarrollo Web</a></h4>
            <p>Diseño y desarrollo de sitios web y aplicaciones web a medida, utilizando las últimas tecnologías y
              mejores prácticas.</p>
          </div>
        </div>
        <div class="col-md-6 mt-4 mt-md-0">
          <div class="icon-box">
            <i class="bi bi-cpu"></i>
            <h4><a href="#">Consultoría Tecnológica</a></h4>
            <p>Asesoramiento especializado en tecnología de la información para ayudarte a tomar decisiones informadas y
              estratégicas para tu empresa.</p>
          </div>
        </div>
      </div>

    </div>
  </section>
  <!-- End Services Section -->

  <!-- ======= Testimonials Section ======= -->
  <section id="testimonials" class="testimonials">
    <div class="container" data-aos="zoom-in">

      <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
        <div class="swiper-wrapper">

          <div class="swiper-slide">
            <div class="testimonial-item">
              <img src="assets/img/testimonials/testimonials-1.jpg" class="testimonial-img" alt="">
              <h3>Juan Pérez</h3>
              <h4>CEO</h4>
              <p>
                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                DevCrypt ha sido un socio invaluable para nuestro negocio. Su equipo ha demostrado un alto nivel de
                profesionalismo y expertise en el desarrollo de software.
                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
              </p>
            </div>
          </div><!-- End testimonial item -->

          <div class="swiper-slide">
            <div class="testimonial-item">
              <img src="assets/img/testimonials/testimonials-2.jpg" class="testimonial-img" alt="">
              <h3>Mei Ling</h3>
              <h4>CTO</h4>
              <p>
                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                Estamos muy satisfechos con los resultados que hemos obtenido trabajando con devCrypt. Su enfoque en la
                calidad y la innovación ha sido clave para el éxito de nuestros proyectos.
                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
              </p>
            </div>
          </div><!-- End testimonial item -->

          <div class="swiper-slide">
            <div class="testimonial-item">
              <img src="assets/img/testimonials/testimonials-3.jpg" class="testimonial-img" alt="">
              <h3>Luisa Martínez</h3>
              <h4>Director de Proyectos</h4>
              <p>
                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                La colaboración con devCrypt ha sido excepcional. Su capacidad para entender nuestras necesidades y
                traducirlas en soluciones efectivas ha sido fundamental para el logro de nuestros objetivos.
                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
              </p>
            </div>
          </div><!-- End testimonial item -->

          <div class="swiper-slide">
            <div class="testimonial-item">
              <img src="assets/img/testimonials/testimonials-4.jpg" class="testimonial-img" alt="">
              <h3>Jorge Fernández</h3>
              <h4>Gerente de IT</h4>
              <p>
                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                devCrypt ha demostrado ser un aliado estratégico para nuestro departamento de IT. Su compromiso con la
                excelencia y la innovación nos ha permitido alcanzar nuevos niveles de eficiencia y calidad en nuestros
                sistemas.
                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
              </p>
            </div>
          </div><!-- End testimonial item -->

          <div class="swiper-slide">
            <div class="testimonial-item">
              <img src="assets/img/testimonials/testimonials-5.jpg" class="testimonial-img" alt="">
              <h3>Edgar Lozano</h3>
              <h4>Director de Marketing</h4>
              <p>
                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                Trabajar con devCrypt ha sido una experiencia excepcional. Su equipo ha sido muy receptivo a nuestras
                necesidades y ha entregado soluciones de software de alta calidad de manera oportuna.
                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
              </p>
            </div>
          </div>

        </div>
        <div class="swiper-pagination"></div>
      </div>
    </div>
  </section><!-- End Testimonials Section -->
  <!-- ======= Portfolio Section ======= -->
  <section id="portfolio" class="portfolio">
    <div class="container" data-aos="fade-up">

      <div class="section-title">
        <h2>Portafolio</h2>
        <p>Consulta nuestro portafolio</p>
      </div>

      <div class="row" data-aos="fade-up" data-aos-delay="100">
        <div class="col-lg-12 d-flex justify-content-center">
          <ul id="portfolio-flters"> <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
            <li data-filter="*" class="filter-active">Todos</li>
            <li data-filter=".filter-app">App</li>
            <li data-filter=".filter-card">Tarjeta</li>
            <li data-filter=".filter-web">Web</li>
          </ul>
        </div>
      </div>

      <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">

        <div class="col-lg-4 col-md-6 portfolio-item filter-app">
          <img src="assets/img/portfolio/portfolio-1.jpeg" class="img-fluid" alt="">
          <div class="portfolio-info">
            <h4>FitTracker</h4>
            <p>Una aplicación que realiza un seguimiento de tus actividades físicas diarias, como correr, caminar y
              hacer ejercicio, y te ayuda a mantenerte en forma.</p>
            <a href="assets/img/portfolio/portfolio-1.jpeg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="FitTracker"><i class="bx bx-plus"></i></a>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 portfolio-item filter-web">
          <img src="assets/img/portfolio/portfolio-2.jpeg" class="img-fluid" alt="">
          <div class="portfolio-info">
            <h4>AdventureSeekers.net</h4>
            <p>Un sitio web para amantes de la aventura que ofrece guías de viaje, consejos de aventura y reseñas de
              destinos.</p>
            <a href="assets/img/portfolio/portfolio-2.jpeg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="AdventureSeekers.net"><i class="bx bx-plus"></i></a>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 portfolio-item filter-app">
          <img src="assets/img/portfolio/portfolio-3.jpeg" class="img-fluid" alt="">
          <div class="portfolio-info">
            <h4>CookEasy</h4>
            <p>Una aplicación de cocina que ofrece recetas fáciles de seguir, listas de compras y consejos útiles para
              cocinar en casa.</p>
            <a href="assets/img/portfolio/portfolio-3.jpeg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="CookEasy"><i class="bx bx-plus"></i></a>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 portfolio-item filter-card">
          <img src="assets/img/portfolio/portfolio-4.jpeg" class="img-fluid" alt="">
          <div class="portfolio-info">
            <h4>BizConnect</h4>
            <p>Una tarjeta digital diseñada para profesionales que facilita la conexión y el intercambio de información
              de contacto de forma rápida y sencilla.</p>
            <a href="assets/img/portfolio/portfolio-4.jpeg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="BizConnect"><i class="bx bx-plus"></i></a>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 portfolio-item filter-web">
          <img src="assets/img/portfolio/portfolio-5.jpeg" class="img-fluid" alt="">
          <div class="portfolio-info">
            <h4>EcoGreenLiving.com</h4>
            <p>Un sitio web dedicado a proporcionar información sobre prácticas sostenibles y consejos para un estilo de
              vida ecológico.</p>
            <a href="assets/img/portfolio/portfolio-5.jpeg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="EcoGreenLiving.com"><i class="bx bx-plus"></i></a>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 portfolio-item filter-app">
          <img src="assets/img/portfolio/portfolio-6.jpeg" class="img-fluid" alt="">
          <div class="portfolio-info">
            <h4>MindfulMoments</h4>
            <p>Una aplicación de meditación que te ayuda a encontrar momentos de calma y tranquilidad en tu día a día.
            </p>
            <a href="assets/img/portfolio/portfolio-6.jpeg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="MindfulMoments"><i class="bx bx-plus"></i></a>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 portfolio-item filter-card">
          <img src="assets/img/portfolio/portfolio-7.jpeg" class="img-fluid" alt="">
          <div class="portfolio-info">
            <h4>CreativeCard</h4>
            <p>Una tarjeta digital para creativos que muestra su trabajo, experiencia y contacto de manera interactiva y
              atractiva.</p>
            <a href="assets/img/portfolio/portfolio-7.jpeg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="CreativeCard"><i class="bx bx-plus"></i></a>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 portfolio-item filter-card">
          <img src="assets/img/portfolio/portfolio-8.jpeg" class="img-fluid" alt="">
          <div class="portfolio-info">
            <h4>HealthCard</h4>
            <p>Una tarjeta digital que contiene información de salud personal, como alergias y medicamentos recetados,
              para emergencias médicas.</p>
            <a href="assets/img/portfolio/portfolio-8.jpeg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="HealthCard"><i class="bx bx-plus"></i></a>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 portfolio-item filter-web">
          <img src="assets/img/portfolio/portfolio-9.jpeg" class="img-fluid" alt="">
          <div class="portfolio-info">
            <h4>TechHub.com</h4>
            <p>Un sitio web que ofrece noticias de tecnología, reseñas de productos y tutoriales para entusiastas de la
              tecnología.</p>
            <a href="assets/img/portfolio/portfolio-9.jpeg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="TechHub.com"><i class="bx bx-plus"></i></a>
          </div>
        </div>

      </div>

    </div>
  </section><!-- End Portfolio Section -->

  <!-- ======= Team Section ======= -->
  <section id="team" class="team section-bg">
    <div class="container" data-aos="fade-up">

      <div class="section-title">
        <h2>Equipo</h2>
        <p>Conoce nuestro equipo</p>
      </div>

      <div class="row">

        <div class="col-lg-4 col-md-6">
          <div class="member" data-aos="fade-up" data-aos-delay="100">
            <div class="pic"><img src="assets/img/team/team-1.jpg" class="img-fluid" alt=""></div>
            <div class="member-info">
              <h4>Miguel Santa</h4>
              <span>Chief Executive Officer</span>
              <div class="social">
                <a href=""><i class="bi bi-twitter"></i></a>
                <a href=""><i class="bi bi-facebook"></i></a>
                <a href=""><i class="bi bi-instagram"></i></a>
                <a href=""><i class="bi bi-linkedin"></i></a>
                <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
          <div class="member">
            <div class="pic"><img src="assets/img/team/team-2.jpg" class="img-fluid" alt=""></div>
            <div class="member-info">
              <h4>Isabel Velez</h4>
              <span>Product Manager</span>
              <div class="social">
                <a href=""><i class="bi bi-twitter"></i></a>
                <a href=""><i class="bi bi-facebook"></i></a>
                <a href=""><i class="bi bi-instagram"></i></a>
                <a href=""><i class="bi bi-linkedin"></i></a>
                <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
          <div class="member">
            <div class="pic"><img src="assets/img/team/team-3.jpg" class="img-fluid" alt=""></div>
            <div class="member-info">
              <h4>William Anderson</h4>
              <span>CTO</span>
              <div class="social">
                <a href=""><i class="bi bi-twitter"></i></a>
                <a href=""><i class="bi bi-facebook"></i></a>
                <a href=""><i class="bi bi-instagram"></i></a>
                <a href=""><i class="bi bi-linkedin"></i></a>
                <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>
  </section><!-- End Team Section -->

  <!-- ======= Contact Section ======= -->
  <section id="contact" class="contact">
    <div class="container" data-aos="fade-up"">

  <div class=" section-title">
      <h2>Contacto</h2>
      <p>Contactanos</p>
    </div>

    <div class="row">

      <div class="col-lg-6">

        <div class="row">
          <div class="col-md-12">
            <div class="info-box">
              <i class="bx bx-map"></i>
              <h3>Nuestra dirección</h3>
              <p>A2311 North Los Robles Avenue, Apartment 4A</p>
              <p>Pasadena, California, 91104</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="info-box mt-4">
              <i class="bx bx-envelope"></i>
              <h3>Envianos un email</h3>
              <p>info@example.com<br>contact@example.com</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="info-box mt-4">
              <i class="bx bx-phone-call"></i>
              <h3>Llamanos</h3>
              <p>+1 5589 55488 55<br>+1 6678 254445 41</p>
            </div>
          </div>
        </div>

      </div>

      <div class="col-lg-6 mt-4 mt-lg-0">
        <form action="forms/contact.php" method="post" role="form" class="php-email-form">
          <div class="row">
            <div class="col-md-6 form-group">
              <input type="text" name="name" class="form-control" id="name" placeholder="Su Nombre" required>
            </div>
            <div class="col-md-6 form-group mt-3 mt-md-0">
              <input type="email" class="form-control" name="email" id="email" placeholder="Su Email" required>
            </div>
          </div>
          <div class="form-group mt-3">
            <input type="text" class="form-control" name="subject" id="subject" placeholder="Asunto" required>
          </div>
          <div class="form-group mt-3">
            <textarea class="form-control" name="message" rows="5" placeholder="Mensaje" required></textarea>
          </div>
          <div class="my-3">
            <div class="loading">Cargando</div>
            <div class="error-message"></div>
            <div class="sent-message">Su mensaje se ha enviado, muchas gracias!</div>
          </div>
          <div class="text-center"><button type="submit">Enviar mensaje</button></div>
        </form>
      </div>

    </div>

    </div>
  </section><!-- End Contact Section -->

</main><!-- End #main -->



<?php include 'footer.html'; ?>

<?php
ob_end_flush();
?>