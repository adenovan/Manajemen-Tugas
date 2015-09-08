<?php
session_start();
include '/backend/lib-connection.php';
$navbar ="";
$plus ="";
$notice="";
$htmlnotif="";
$acctab="";
$content="";
if(isset($_GET['content'])){
	$content=$_GET['content'];
}

if(isset($_GET['notice'])){
	$notice= $_GET['notice'];
	$htmlnotif.='<div class="notice" id="sis-notice"><div class="container">
			<div class="col-md-10 col-md-offset-1 sis-notice alert alert-success">
			<strong>Information: </strong>';
    $htmlnotif.=$notice;
	$htmlnotif.='</div></div></div>';
}
if(isset($_SESSION['login'])){
	$sql  ="SELECT dibaca FROM `notifikasi` WHERE karyawan_id = ".$_SESSION['karyawan']." and dibaca=0";
	$stmt=$dbh->prepare($sql);
	$stmt->execute();
	$open="";
	if ($stmt->rowCount() > 0) {
	$open .='<label id="notif-count" class="label label-danger">'.$stmt->rowCount().'</label>';
	}
	$navbar .='<ul class="nav navbar-nav navbar-default li-left">';
	$navbar .= '
	  <li><a href="index" id="home"><i class="glyphicon glyphicon-home"></i> Beranda</a></li>
	  <li><a href="#" id="anda"><i class="glyphicon glyphicon-th-list"></i> Tugas Anda</a></li>
	  <li><a href="#" id="notif" role="button" ><i class="glyphicon glyphicon-bell"></i> Notifikasi '.$open.'</a></li>
	  <li><a href="#" id="aksi" role="button" ><i class="glyphicon glyphicon-pawn"></i> Aktivitas</a></li>
	  ';
	$navbar.='</ul>';
	$navbar.='<ul class="nav navbar-nav li-right">';
	$navbar.='<li class="dropdown"><a href="#" data-toggle="dropdown" class="dropdown-toggle" 
	 id="profile"><b class="caret"></b> <img src="'.$_SESSION['foto'].'" class="foto-index" alt="foto"> '.$_SESSION['login'].'</a>';
	$navbar.='<ul class="dropdown-menu dropwidth">';
	if($_SESSION['karyawan']==2){
		$navbar.='<li><a href="/partial/admin.area.php" id="super"><i class="glyphicon glyphicon-user"></i> Admin Area</a></li>';
	}
	$navbar.='<li><a href="/partial/edit-acc.php" id="account"><i class="glyphicon glyphicon-cog"></i> Pengaturan Akun</a></li>';
	$navbar.='<li><a href="/backend/logout.proses.php" id="logout"><i class="glyphicon glyphicon-off"></i> Logout</a></li></ul>';
	$navbar.='</li></ul>';
	$plus = '<li><a href="/partial/tugasplus.php" id="plus"><i class="glyphicon glyphicon-plus"></i></a></li>';

	//@desc acctab //task remaining
	$sql  ="SELECT tugas_id, status FROM tugas ";
	$sql .=" WHERE karyawan_untuk = ".$_SESSION['karyawan'];
	$sql .=" ORDER BY tugas_id DESC";
	$stmt=$dbh->prepare($sql);
	$stmt->execute();
	$task ='<label class="label label-default">'.$stmt->rowCount().'</label>';
	//open remaining
	$sql  ="SELECT tugas_id, status FROM tugas ";
	$sql .=" WHERE karyawan_untuk = ".$_SESSION['karyawan'];
	$sql .=" AND status = 0 ORDER BY tugas_id DESC";
	$stmt=$dbh->prepare($sql);
	$stmt->execute();
	$open ='<label class="label label-danger">'.$stmt->rowCount().'</label>';
	//ongoing remaining
	$sql  ="SELECT tugas_id, status FROM tugas ";
	$sql .=" WHERE karyawan_untuk = ".$_SESSION['karyawan'];
	$sql .=" AND status = 1 ORDER BY tugas_id DESC";
	$stmt=$dbh->prepare($sql);
	$stmt->execute();
	$ongoing ='<label class="label label-warning">'.$stmt->rowCount().'</label>';
	//complete
	$sql  ="SELECT tugas_id, status FROM tugas ";
	$sql .=" WHERE karyawan_untuk = ".$_SESSION['karyawan'];
	$sql .=" AND status = 2 ORDER BY tugas_id DESC";
	$stmt=$dbh->prepare($sql);
	$stmt->execute();
	$complete ='<label class="label label-success">'.$stmt->rowCount().'</label>';
	$acctab.='
		<ul class="nav nav-tabs nav-acc">';
	$acctab.='<li><a href="/backend/tugas-acc.proses.php?tugas=0" id="all-acc" class="acc-active" >Semua '.$task.'</a></li>';
  	$acctab.='<li><a href="/backend/tugas-acc.proses.php?tugas=0&status=0" id="open-acc">Terbuka '.$open.'</a></li>';
  	$acctab.='<li><a href="/backend/tugas-acc.proses.php?tugas=0&status=1" id="on-going-acc">Dikerjakan '.$ongoing.'</a></li>';
  	$acctab.='<li><a href="/backend/tugas-acc.proses.php?tugas=0&status=2" id="complete-acc">Selesai '.$complete.'</a></li>';
	$acctab.='</ul>';	
}else{
	$navbar .='<ul class="nav navbar-nav navbar-default">';
	$navbar .='
	  <li><a href="index" id="home"><i class="glyphicon glyphicon-home"></i> Home</a></li>
	  <li><a href="#sis-content-login" id="login"><i class="glyphicon glyphicon-log-in"></i> Login</a></li>
	';
	$navbar.='</ul>';
}

	 
?>

<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="UTF-8">
	<script src="/js/jquery.min.js"></script>
	<script src="/js/bootstrap.min.js"></script>
	<script src="/js/bootpag.min.js"></script>
    <script src="/js/frontend.js" type="text/javascript"></script>
    <script type="text/javascript" src="/js/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
    <script type="text/javascript" src="/js/jqueryvalidation/jquery.validate.min.js" charset="UTF-8"></script>
    <script type="text/javascript" src="/js/jqueryvalidation/localization/messages_id.js" charset="UTF-8"></script>
	<link rel="stylesheet" href="/css/bootstrap.min.css">
	<link rel="stylesheet" href="/css/style-index.css">
	<link rel="stylesheet" href="/css/responsive.css">
    <link href="/css/bootstrap-datetimepicker.css" rel="stylesheet" media="screen">
    <link rel="icon" href="/img/ic_header.png">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

	</head>
	<body>
	<div id="direction" data-content="<?php echo $content;?>"></div>
	<!-- HEADER !-->
	<div class="sis-nav">
		<div class="container">
			<div class="navbar-header">
				<button 
					class="navbar-toggle collapsed navbar-burger" 
					data-toggle="collapse" 
					data-target="#navbar" 
					aria-expanded="false" 
					aria-controls="navbar">
					<i class="glyphicon glyphicon-menu-hamburger"></i>
				</button>
				<a href="#home" class="navbar-brand"><img src="/img/logo-sisjar.png" /></a>
			</div>

			<div id="navbar" class="navbar-collapse collapse">
				
				<!-- Navbar !-->
				<?php echo $navbar?>
				</ul>
			</div>
		</div>
	</div>
	
	<?php echo $htmlnotif;?>

	<div class="login" id="sis-content-login">
		<div class="container">
			<div class="col-md-6 col-md-offset-2 col-login">
				<form action="/backend/login.proses.php" class="form-horizontal input-wrap" role="form" method="post">
					<div class="form-group">
						<label for="username" class="col-sm-3 control-label">Username:</label>
						<div class="col-sm-8">
						<input type="text" placeholder="Your Username" class="form-control" name="username">						
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="col-sm-3 control-label">Password:</label>
						<div class="col-sm-8">
						<input type="password" placeholder="Your Password" name="password" class="form-control">					
						</div>
					</div>
				    <div class="form-group"> 
   						 <div class="col-sm-offset-3 col-sm-8">
     					 <button type="submit" class="btn btn-default">Submit</button>
    				</div>
  					</div>
				</form>
			</div>
		</div>
	</div>		
		

	<!-- TAB TUGAS !-->
	<div class="sis-tugas-tab" id="sis-tugas-tab">
		<div class="container">
		<div class="col-md-10 col-md-offset-1 sis-sub-nav" id="sis-sub-nav">
		<?php echo $acctab ?>
		<ul class="nav nav-tabs nav-home">
			<form action="/backend/search.proses.php" method="get" id="formsearch">
			<li class="col-md-4 col-search" id="col-search">
                
					<div class="form-group form-tab-search">
						<div class="input-group input-group-md">
							<span class="input-group-addon" id="magni">
								<i class="glyphicon glyphicon-search"></i>
							</span>
							<input 
								class="form-control"
								type="text" 
								name="q" 
								id="searchbox" 
								placeholder="Pencarian"
								aria-describedby="magni" />	
						</div>
					</div>
					
			</li>
  			<li class="col-label col-md-2" id="col-label">
			<label class="checkbox"><input type="checkbox" name="cariuntuk">Cari Untuk</label>
			<label class="checkbox"><input type="checkbox" name="caritags">Cari Tags</label>
			</li>
			</form>
			<?php echo $plus;?>
  			<li><a href="/backend/list.proses.php?tugas=1&status=0" id="open">Terbuka</a></li>
  			<li><a href="/backend/list.proses.php?tugas=1&status=1" id="on-going">Dikerjakan</a></li>
  			<li><a href="/backend/list.proses.php?tugas=1&status=2" id="complete">Selesai</a></li>
  			<li><a href="/backend/list.proses.php?tugas=0" id="all" class="act" >Semua</a></li>
		</ul>
		<div class="clearfix"></div>
		</div>
		</div>
	</div>
	
	<!-- CONTENT !-->
	<div class="sis-content" id="sis-content">
		<div class="container">	
			<div class="col-md-10 col-md-offset-1 col-content" id="content-page">
			<!-- backend list.proses.php !-->

			</div>
		</div>
	</div>
	<div class="container">
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
	</div>
	</div>


	<div class="sis-paging" id="sis-paging">
		<div class="container">
			<!-- Pagination !-->
			<div class="col-md-6 col-md-offset-3" id="pagewrap">
				<div id="pagination-all" class="pagination">

				</div>
                <div id="pagination-open" class="pagination">

                </div>
                <div id="pagination-going" class="pagination">

                </div>

                <div id="pagination-complete" class="pagination">
                </div>

                <div id="pagination-acc" class="pagination">
                </div>
				

                <div id="pagination-open-acc" class="pagination">
                </div>


                <div id="pagination-ongoing-acc" class="pagination">
                </div>


                <div id="pagination-complete-acc" class="pagination">
                </div>

                </div>
			</div>
		</div>
	</div>

	<div class="sis-footer">
		<div class="container">
			<div class="col-md-8 col-md-offset-1">
			<h4 class="">[Dev] by &#169; Sistem dan Jaringan STIKOM Bali</h4>
			</div>
		</div>
	</div>
	</body>
</html>