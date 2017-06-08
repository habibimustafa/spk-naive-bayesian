<?php /* no direct access */ defined ( 'MILA' ) or die ( 'Restricted access' ); ?>
<!doctype HTML>
<html>
<head>
	<title>Sistem Pendukung Keputusan Penyeleksian Mahasiswa Penerima Beasiswa</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css">
	<link rel="stylesheet" type="text/css" href="css/mila-dashboard.css">
	<link rel="stylesheet" type="text/css" href="css/morris-0.5.1.css">
</head>
<body>
<div class="container">
	<nav class="navbar navbar-inverse" role="navigation">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span><span
					class="icon-bar"></span><span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="./">Sistem Beasiswa</a>
		</div>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="./"><span class="glyphicon glyphicon-home"></span>Home</a></li>
                <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span
                    class="glyphicon glyphicon-list-alt"></span>Data Master <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Jurusan</a></li>
                        <li><a href="#">Prodi</a></li>
                        <li><a href="#">Beasiswa</a></li>
                    </ul>
                </li>
                <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span
                    class="glyphicon glyphicon-list-alt"></span>Data Training <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Data Sample</a></li>
                        <li><a href="#">Probabilitas</a></li>
                    </ul>
                </li>
                <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span
                    class="glyphicon glyphicon-list-alt"></span>Data Testing <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Data Mahasiswa</a></li>
                        <li><a href="#">Rekomendasi</a></li>
                    </ul>
                </li>
                <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span
                    class="glyphicon glyphicon-list-alt"></span>Laporan <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Rekap Rekomendasi</a></li>
                    </ul>
                </li>
           </ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span
					class="glyphicon glyphicon-user"></span>Admin <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="#"><span class="glyphicon glyphicon-user"></span>Profile</a></li>
						<li><a href="#"><span class="glyphicon glyphicon-cog"></span>Settings</a></li>
						<li class="divider"></li>
						<li><a href="./?logout"><span class="glyphicon glyphicon-off"></span>Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>
		<!-- /.navbar-collapse -->
	</nav>
    <div class="row">
        <div id="main" class="col-sm-12 col-md-12">
            <div class="well">
                <h2>Selamat datang, <?php echo $_SESSION['mila_user_name'];?>!</h2>
				<div id="myCarousel" class="carousel slide" data-ride="carousel">
					<!-- Wrapper for slides -->
					<div class="carousel-inner">
						<div class="item active">
							<img src="http://placehold.it/1200x400/2980b9/ffffff&text=<?php echo $_SESSION['mila_user_name'];?>">
							<div class="carousel-caption">
								<h3>NIM: 12345678</h3>
								<p>Mahasiswi S1 Teknik Informatika Universitas Islam Blitar</p>
							</div>
						</div>
						<!-- End Item -->
						<div class="item">
							<img src="http://placehold.it/1200x400/16a085/ffffff&text=Sistem%20Pendukung%20Keputusan">
							<div class="carousel-caption">
								<h2>Penyeleksian Mahasiswa Penerima Beasiswa</h2>
								<h3>Menggunakan Algoritma Bayesian Classification</h3>
							</div>
						</div>
						<!-- End Item -->
						<div class="item">
							<img src="http://placehold.it/1200x400/e67e22/ffffff&text=<?php echo $_SESSION['mila_user_name'];?>">
							<div class="carousel-caption">
								<h3>NIM: 12345678</h3>
								<p>Mahasiswi S1 Teknik Informatika Universitas Islam Blitar</p>
							</div>
						</div>
						<!-- End Item -->
						<div class="item">
							<img src="http://placehold.it/1200x400/8e44ad/ffffff&text=Sistem%20Pendukung%20Keputusan">
							<div class="carousel-caption">
								<h2>Penyeleksian Mahasiswa Penerima Beasiswa</h2>
								<h3>Menggunakan Algoritma Bayesian Classification</h3>
							</div>
						</div>
						<!-- End Item -->
					</div>
					<!-- End Carousel Inner -->
					<ul class="nav nav-pills nav-justified">
					  <li data-target="#myCarousel" data-slide-to="0" class="active"><a href="#">About</a></li>
					  <li data-target="#myCarousel" data-slide-to="1"><a href="#">Projects</a></li>
					  <li data-target="#myCarousel" data-slide-to="2"><a href="#">Portfolio</a></li>
					  <li data-target="#myCarousel" data-slide-to="3"><a href="#">Services</a></li>
					</ul>
				</div>
				<!-- End Carousel -->
			</div>
        </div>
    </div>
</div>
<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/mila-dashboard.js"></script>
<!-- script type="text/javascript" src="js/jquery.jslatex.js"></script -->
<script type="text/javascript" src="js/raphael-min.js"></script>
<script type="text/javascript" src="js/morris-0.5.1.min.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.js"></script>
</body>
</html>