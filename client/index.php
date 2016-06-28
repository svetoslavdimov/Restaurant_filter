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

	    <link href="styles.css" rel="stylesheet" media="all">
	</head>
	<body>

		<div id="filter">
			<?= $filter_html ?>
		</div>

		<div id="items">
			<?= $items_html ?>
		</div>

	</body>
</html>