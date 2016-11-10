<?

// php-то да репортва всички грешки без nitice
error_reporting(E_ALL & ~E_NOTICE);

// настройки за вртъзка с db
$db_settings = array(
	"host" => "localhost",
	"name" => "restaurant",
	"user" => "root",
	"pass" => ""
);

// още настройки свързани с глобалното поведение на филтъра

?>