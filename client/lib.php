<?

class Items {

	function __construct($db){

		$this->db = $db;

	}

	private $db;

	public function build(){

		$data = $this->get();

		$html = $this->html($data);

		return $html;

	}

	private function get(){

		$sql = "SELECT * FROM items WHERE i_delete = 0";

		$items = $this->db->fetch($sql);

		return $items;

	}

	private function html($data){

		$html = '';

		foreach($data as $item){

			$html .= '<div>' . $item[3];

			/*foreach($filter["props"] as $prop){


				$html .= '<input id="filter_prop_' . $prop[0] . '" type="checkbox" />';
				$html .= '<label for="filter_prop_' . $prop[0] . '">' . $prop[1] . '</label>';
				$html .= '<br>';


			}*/


			$html .= '</div>';

			//var_dump($filter);



		}

		return $html;

	}


}

class Filter {

	function __construct($db){

		$this->db = $db;

	}

	private $db;

	public function build(){

		$data = $this->get();

		$html = $this->html($data);

		return $html;

	}

	private function get(){

		$sql = "SELECT f_id, f_name FROM filter WHERE f_status = 1";

		$data = $this->db->fetch($sql);

		$temp;

		foreach($data as $filter){

			$props_sql = "SELECT p_id, p_name FROM filter_props WHERE p_status = 1 AND p_filter = $filter[0]";
			$props_data = $this->db->fetch($props_sql);

			$temp[$filter[0]] = array(
				"name" => $filter[1],
				"props" => $props_data
			);

		}

		return $temp;

	}

	private function html($data){

		$html = '';

		foreach($data as $filter){

			$html .= '<fieldset>';
			$html .= '<legend>' . $filter["name"] . '</legend>';

			foreach($filter["props"] as $prop){


				$html .= '<input id="filter_prop_' . $prop[0] . '" type="checkbox" />';
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

	function __construct($settings){

		$this->settings = $settings;

		$this->connect();

	}

	public $db;

	private $settings;

	private function connect(){

		$db = new mysqli($this->settings["host"], $this->settings["user"], $this->settings["pass"], $this->settings["name"]);

		if ($db->connect_errno) {
			echo "Error: Failed to make a MySQL connection: \n";
			echo "Errno: " . $db->connect_errno . "\n";
			echo "Error: " . $db->connect_error . "\n";
		}

		$this->db = $db;

	}

	public function fetch($sql){

		if (!$result = $this->db->query($sql)) {
			echo "Error: Query failed to execute: \n";
			echo "Query: " . $sql . "\n";
			echo "Errno: " . $this->db->errno . "\n";
			echo "Error: " . $this->db->error . "\n";
			exit;
		}

		if ($result->num_rows === 0) {
			
			// todo: handle this

		}

		$data = $result->fetch_all();

		return $data;

	}

}

?>