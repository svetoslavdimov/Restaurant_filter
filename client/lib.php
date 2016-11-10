<?

class Items {
	
	// инициализиращ конструктор
	function __construct($db){
		
		// взимаме db обекта и го присвояваме на вътрешна променлива
		$this->db = $db;

	}

	private $db;

	// сглобяване на резултатите
	public function build(){
		
		// гледаме в GET изпратените параметри за филтъра
		// и ако има зададен филтър
		if ($_GET["action"] === "filter") {
			
			//$_filter = array();
			// обхождаме всички зададени филтри
			foreach ($_GET as $param => $value) {
				
				// разделяме всеки филтър по _
				$filter = explode("_", $param);
				
				// разбираме дали даденото prop е от тип filter (започва с filter_)
				if ($filter[0] === "filter") {
					// добавяме към набора от филтри, които ще бъдат приложени по-късно
					$_filter[] = $filter[1];
				}
				
			}
			
		}
		
		// филтрираме резултатите за избраните филтри
		$data = $this->get($_filter);
		
		// с филтрираните резултати генерираме html-a
		$html = $this->html($data);
		
		// връщаме готовия html
		return $html;

	}
	
	
	// взима всички записи от базата данни
	// и ги филтрира по избраните критерии
	private function get($filter = false){
		
		// взимаме всичко, което не е изтрито
		$sql = "SELECT * FROM items WHERE i_delete = 0";
		
		// резултата се слага в $items
		$items = $this->db->fetch($sql);
		
		// масив от всички items които ще ни mach-нат филтрите
		// първоначално нянма никой тук - празен масив
		$_items = array();
		
		// за всеки елемент от items
		foreach ($items as $item) {
			
			// взимаме всички props за съответния item
			$sql = "
				SELECT ip_id, p_name, ip_value
				  FROM items_props AS ip
			 LEFT JOIN filter_props AS fp ON (ip.ip_prop = fp.p_id)
			     WHERE p_status = 1
				   AND ip_item = " . $item[0];

			$props = $this->db->fetch($sql);
			
			$item[] = $props;
			
			// ако има активиран (избран) филтър
			if ($filter) {
				
				// първоначално няма съвпадения, които отговарят на критерия за филтриране
				$match = false;
				
				// за всеки приложен филтър
				foreach ($filter as $f) {
					
					// за всяко prop за текущия item
					foreach ($props as $p) {
						
						// ако filter->prop == item->prop = съвпадение
						if ($f === $p[0]) {
							// вдигаме флага за съвпадение на филтъра
							$match = true;
						}
						
					}
					
				}
				
				// ако за текущия item имаме поне един филтър съвпадение
				if ($match) {
					// слагаме в намерените
					$_items[] = $item;
				}
			
			// ако няма избран филтър - т.е. искаме всички резултати - пр. за началното презареждане и преброявене
			} else {
				// слагаме всеки item без да му прилагаме логиката за филтриране
				$_items[] = $item;
			}
			
		}
		
		// връщаме резултата с целия масив от намерени items
		return $_items;

	}
	
	
	// вътрешна сервизна функция, която сглобява html структура от подаден масив
	private function html($data){
		
		// инициализиараме празен стринг, в който ще събираме html-a
		$html = '';
		
		// за всеки елемент от подадената структура
		foreach($data as $item){
			
			// заглавие
			$html .= '<div><h3>' . $item[3] . "</h3><ul>";
			
			// обхождаме всички props за този item
			foreach($item[4	] as $prop){

				// добавяме prop към html-a
				$html .= "<li>" . $prop[1] . ": " . $prop[2] . "</li>";

			}
			
			// затваряме блока
			$html .= '</ul></div>';

			// debug
			//var_dump($filter);

		}
		
		// връщаме събрания html
		return $html;

	}


}

class Filter {

	function __construct($db){

		$this->db = $db;

	}

	private $db;

	public function build(){
		
		// взимаме информацията за филтрите
		$data = $this->get();
		
		// сглобяваме html с искаме
		$html = $this->html($data);

		return $html;

	}

	private function get(){
		
		// взимаме всички филтри от db, които са активни status = 1
		$sql = "SELECT f_id, f_name FROM filter WHERE f_status = 1";
		
		// слагаме инфото в масив data
		$data = $this->db->fetch($sql);

		$temp;
		
		// за всеки филтър
		foreach($data as $filter){
			
			// взимаме вички props за избрания филтър
			$props_sql = "SELECT p_id, p_name FROM filter_props WHERE p_status = 1 AND p_filter = $filter[0]";
			$props_data = $this->db->fetch($props_sql);
			
			// слагаме props в удобен вид
			$temp[$filter[0]] = array(
				"name" => $filter[1],
				"props" => $props_data
			);

		}
		
		// връщаме подготвените филтри
		return $temp;

	}

	private function html($data){

		$html = '';
		
		//за всеки ред от подадената информация
		foreach($data as $filter){
			
			// заглавие
			$html .= '<fieldset>';
			$html .= '<legend>' . $filter["name"] . '</legend>';
			
			// за всяко prop
			foreach($filter["props"] as $prop){
				
				//var_dump($_GET);
				// проверяваме дали checkbox-а да е чекнат
				$checked = $_GET["filter_" . $prop[0]] === "on" ? ' checked="true"' : "";
				
				$html .= '<input id="filter_prop_' . $prop[0] . '" name="filter_' . $prop[0] . '" type="checkbox"' . $checked . ' />';
				$html .= '<label for="filter_prop_' . $prop[0] . '">' . $prop[1] . '</label>';
				$html .= '<br>';

			}

			$html .= '</fieldset>';
			//var_dump($filter);

		}

		return $html;

	}

}


class DB {
	
	// при инициализиране на обекта
	function __construct($settings){
		
		// записваме settings лаколно
		$this->settings = $settings;
		
		// връзка с db
		$this->connect();

	}

	public $db;

	private $settings;

	private function connect(){
		
		// връзка към db с подадените параметри
		$db = new mysqli($this->settings["host"], $this->settings["user"], $this->settings["pass"], $this->settings["name"]);
		
		// ако има грешки - връщаме подходящ резултат
		if ($db->connect_errno) {
			echo "Error: Failed to make a MySQL connection: \n";
			echo "Errno: " . $db->connect_errno . "\n";
			echo "Error: " . $db->connect_error . "\n";
		}
		
		// запазваме локално за използване
		$this->db = $db;

	}
	
	// операция за взимане на информация
	public function fetch($sql){

		// ако не успееме да изпълним успешно
		if (!$result = $this->db->query($sql)) {
			// връщаме грешка
			echo "Error: Query failed to execute: \n";
			echo "Query: " . $sql . "\n";
			echo "Errno: " . $this->db->errno . "\n";
			echo "Error: " . $this->db->error . "\n";
			exit;
		}
		
		// ако няма резултати
		if ($result->num_rows === 0) {
			
			// todo: handle this
			// връщаме към потребителя информация

		}
		
		// ако има резултати
		$data = $result->fetch_all();
		
		// връщаме ги
		return $data;

	}

}

?>