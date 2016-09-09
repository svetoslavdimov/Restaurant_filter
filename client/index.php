<?

include("config.php");
include("lib.php");

$db = new DB($db_settings);

$items = new Items($db);
$filter = new Filter($db);



$items_html = $items->build();
$filter_html = $filter->build();

?>

<!DOCTYPE html>
<html lang="en">
	<head>
	    <meta charset="utf-8">

	    <title>Restaurants Filter</title>

	    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	    <link href="css/styles.css" rel="stylesheet" media="all">
	    <link href="css/bootstrap/bootstrap.css" rel="stylesheet" media="all">
	</head>
	<body>

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
		
		<script type="text/javascript" src="js/bootstrap.js"></script>
		
	</body>
</html>