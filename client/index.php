<?

// конфигурационен файл с настройки за цялата система
include("config.php");

// библиотеката, съдържаща бизнес логиката на приложението
// има различни по вид функции
include("lib.php");

// инижиализираме връзка към db
// прави се нова инстанция на обект DB (от lib/) като се подават настройките от конфигурацията
$db = new DB($db_settings);


// инициализираме Items
$items = new Items($db);

// инициализираме Filters
$filter = new Filter($db);

// генерираме html-а за items § filters
// по-късни го слагаме в html страницата
$items_html = $items->build();
$filter_html = $filter->build();

?>

<?

// подход за взимане на информация от външен източник
// взима се съдържанието на страницата за Барове в София - от foursquare.com
// може да се прави периодично (през 1 час) и да се пълни в локална база данни


//$url = "https://foursquare.com/explore?cat=drinks&mode=url&near=Sofia%2C%20Bulgaria&nearGeoId=72057594038654947";
//$data = file_get_contents($url);
//echo $data;
//return;

?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Restaurants Filter</title>
		<link rel="shortcut icon" href="css/images/favicon.ico">
		<link rel="stylesheet" href="css/vendors.css">
		<link rel="stylesheet" href="css/main.css">
	</head>
		<body class="nav-md">
			<div class="container body">
				<div class="main_container">

					<div class="col-md-3 left_col menu_fixed">
						<div class="left_col scroll-view">
							<div class="navbar nav_title" style="border: 0;">
								<a href="" class="site_title">
									<img src="css/images/logo.png" alt="OnlineTrading.bg">
									<span>Restaurants Filter</span>
								</a>
							</div>
							<div class="clearfix"></div><br />
							<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
								<div class="menu_section">
									<h3>Контролен панел</h3>
									<ul class="nav side-menu">
										<li>
											<a><i class="fa fa-wrench"></i> Инструменти <span class="fa fa-chevron-down"></span></a>
											<ul class="nav child_menu">
												<li><a href="#tools/dhl-awb"><i class="fa fa-braille"></i> DHL AWB Тефтер</a></li>
											</ul>
										</li>
										<li>
											<a><i class="fa fa-sliders"></i> Настройки <span class="fa fa-chevron-down"></span></a>
											<ul class="nav child_menu">
												<li><a href="#settings/general"><i class="fa fa-cog"></i> Общи</a></li>
												<li><a href="#settings/security"><i class="fa fa-lock"></i> Сигурност</a></li>
												<li><a href="#settings/system"><i class="fa fa-server"></i> Системни</a></li>
											</ul>
										</li>
										<li>
											<a><i class="fa fa-line-chart"></i> Статистика <span class="fa fa-chevron-down"></span></a>
											<ul class="nav child_menu">
												<li><a href="#stats/1"><i class="fa fa-area-chart"></i> Статистика 1</a></li>
												<li><a href="#stats/2"><i class="fa fa-bar-chart"></i> Статистика 2</a></li>
												<li><a href="#stats/3"><i class="fa fa-pie-chart"></i> Статистика 3</a></li>
											</ul>
										</li>
									</ul>
								</div>
								<div class="menu_section">
									<h3>Външни системи</h3>
									<ul class="nav side-menu">
										<li>
											<a><i class="fa fa-barcode"></i> Продукти <span class="fa fa-chevron-down"></span></a>
											<ul class="nav child_menu">
												<li><a href="#products/orders"><i class="fa fa-shopping-cart"></i> Поръчки</a></li>
												<li><a href="#products/sd"><i class="fa fa-credit-card"></i> SD</a></li>
												<li><a href="#products/dhl"><i class="fa fa-plane"></i> DHL</a></li>
												<li><a href="#products/store"><i class="fa fa-cubes"></i> Склад</a></li>
												<li><a href="#products/speedy"><i class="fa fa-truck"></i> Спиди</a></li>
												<li><a href="#products/clients"><i class="fa fa-user"></i> Клиенти</a></li>
											</ul>
										</li>
										<li>
											<a><i class="fa fa-cogs"></i> Други <span class="fa fa-chevron-down"></span></a>
											<ul class="nav child_menu">
												<li><a href="#misc/finance"><i class="fa fa-bank"></i> Финанси</a></li>
												<li><a href="#misc/information"><i class="fa fa-database"></i> Информация</a></li>
												<li><a href="#misc/errors"><i class="fa fa-bug"></i> Проблеми</a></li>
											</ul>
										</li>
									</ul>
								</div>
							</div>
							<div class="sidebar-footer hidden-small">
								<a data-toggle="tooltip" data-placement="top" title="Settings">
									<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
								</a>
								<a data-toggle="tooltip" data-placement="top" title="FullScreen">
									<span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
								</a>
								<a data-toggle="tooltip" data-placement="top" title="Lock">
									<span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
								</a>
								<a id="logout" data-toggle="tooltip" data-placement="top" title="Logout">
									<span class="glyphicon glyphicon-off" aria-hidden="true"></span>
								</a>
							</div>
						</div>
					</div>
					
					
					<div class="top_nav">
						<div class="nav_menu">
							<nav>
								<div class="nav toggle">
									<a id="menu_toggle"><i class="fa fa-bars"></i></a>
								</div>
								<ul class="nav navbar-nav navbar-right">
									<li>
										<a href="#user" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
											<img src="css/images/logo.png" alt="Restaurant Filter"><?= $user["user"] ?><span class=" fa fa-angle-down"></span>
										</a>
										<ul class="dropdown-menu dropdown-usermenu pull-right">
											<li><a href="#user/profile"><span class="badge bg-red pull-right">66%</span><span>Profile</span></a></li>
											<li><a href="#user/settings">Settings<i title="Profile Settings" class="fa fa-cog pull-right"></i></a></li>
											<li><a href="#user/help">Help<i title="Help, About, Informaton" class="fa fa-info pull-right"></i></a></li>
											<li><a id="user_logout" href="#user/logout">Log Out<i title="Exit" class="fa fa-sign-out pull-right"></i></a></li>
										</ul>
									</li>
									<li role="presentation" class="dropdown">
										<a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
											<i class="fa fa-envelope-o"></i><span class="badge bg-green">6</span>
										</a>
										<ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
											<li>
												<a>
													<span class="image"><img src="css/images/onlinetrading-logo.png" alt="Profile Image" /></span>
													<span><span>Restaurant Filter</span><span class="time">3 mins ago</span></span>
													<span class="message">Content updated!</span>
												</a>
											</li>
										</ul>
									</li>
								</ul>
							</nav>
						</div>
					</div>
					
					
					<div class="right_col" role="main">
						
													

						<div id="module_tools_dhl-awb" class="module_container">
							<div class="page-title">
							  <div class="title_left">
								<h3 class="pull-left">DHL AWB!</h3>
								<div class="input-group pull-left">
									<input id="awb_week" type="text" class="form-control" placeholder="Select Week" />
								</div>	
							  </div>
							  <div class="title_right" title="DHL Express Tracking">
								<div class="col-md-6 col-sm-6 col-xs-12 form-group pull-right top_search">
								  <div class="input-group">
									<input id="newAWB_value" type="text" class="focus_first form-control" placeholder="AWB, JJD, ..">
									<span class="input-group-btn">
									  <button id="newAWB_check" class="btn btn-default" type="button">CHECK</button>
									</span>
								  </div>
								</div>
							  </div>
							</div>
							
							

							<div class="row">
							
							  <div class="col-md-12">
								<div class="x_panel">
								  <div class="x_content">
								  
								  
								   
									
									
									<div id="filter">
										<form action="" method="GET">
											<?= $filter_html ?>
											<input type="hidden" name="action" value="filter" />
											<input type="checkbox">smart
											<button type="submit">FILTER</button>
											<a href="index.php">CLEAR</a>
										</form>
									</div>

									<div id="items">
										<?= $items_html ?>
									</div>
									
									
								  </div>
								</div>
							  </div>

							</div>
						  </div>

						
						
					</div>
					
				<footer>
					<div id="loading">
						<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
						<span class="sr-only">Loading...</span>
					</div>
					<div class="pull-right" title="Restaurant Filter - Control Panel">
						Restaurant Filter - Control Panel
					</div>
					<div class="clearfix"></div>
				</footer>
			</div>
		</div>
		<script src="js/vendors.js"></script>
		<script src="js/main.js"></script>
	</body>
</html>