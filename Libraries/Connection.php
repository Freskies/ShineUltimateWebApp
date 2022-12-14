<?php
/*
 * Copyright (c) 2022.
 * Giacchini Valerio
 * Shine asd
 */

/**
 * this class facilitates querying databases.
 * it uses a mysqli connection.
 * this class uses PHP 8 features.
 *
 * @author valerio
 * @version 1.0
 * @link https://www.php.net/manual/en/book.mysqli.php
 */
class Connection
{
	/**
	 * @var mysqli the connection with a specific database
	 */
	private mysqli $conn;

	private int $mode = MYSQLI_ASSOC;

	/**
	 * all the parameters you have to set to establish a connection
	 * @param string $servername
	 * @param string $username
	 * @param string $password
	 * @param string $dbname
	 */
	public function __construct
	(
		string $dbname,
		string $servername = 'localhost',
		string $username = 'root',
		string $password = ''
	)
	{
		$this->conn = new mysqli($servername, $username, $password, $dbname);

		// Check connection
		if ($this->conn->connect_error)
			die("Connection failed: " . $this->conn->connect_error);
	}

	/**
	 * automatically closes the connection with the server
	 */
	public function __destruct()
	{
		$this->conn->close();
	}


	/**
	 * <b>IMPORTANT</b>: there are no checks on the correctness of the constants.
	 * @param int $mode the way the result is returned (use the mysqli constants)
	 * @return void
	 * @link https://www.php.net/manual/en/mysqli.constants.php
	 */
	public function change_mode(int $mode): void
	{
		$this->mode = $mode;
	}

	/**
	 * executes a query on the database
	 * @param string $query the query to be executed (you can put '?' and pass parameters in $params)
	 * @param array|null $params all parameters that fill '?' in query
	 * @return array|null associative array with all the data (if you haven't changed the mode)
	 */
	public function execute(string $query, array $params = null): ?array
	{
		$stmt = $this->conn->prepare($query);
		if (isset($params))
			$stmt->bind_param(Connection::get_types($params), ...$params);
		$stmt->execute();

		$result = $stmt->get_result();
		if ($result === false) {
			$stmt->close();
			return null;
		} else {
			// fetch the mysqli result into an associative array
			$data = $result->fetch_all($this->mode);
			$stmt->close();
			return $data;
		}
	}

	/**
	 * @param array $data associative array (2D), the output of $execute()
	 * @param array|null $header array with the name of all columns (es ["col1", "col2"])
	 * @return string html table with your data
	 */
	public static function generate_table(array $data, array $header = null): string
	{
		$table = "<table>%s%s</table>";

		// header
		if (isset($header)) {
			$table_header_row = str_repeat("<th>%s</th>", count($header));
			$table_header = sprintf("<tr>%s</tr>", vsprintf($table_header_row, $header));
		}

		// body
		$table_body = "";

		foreach ($data as $row) {
			$table_body_row = str_repeat("<td>%s</td>", count($row));
			$table_body .= sprintf("<tr>%s</tr>", vsprintf($table_body_row, $row));
		}

		return sprintf($table, $table_header ?? '', $table_body);
	}

	/**
	 * automatically returns the types of the @params array objects (i, s, d, b)
	 * it requires PHP 8 or higher
	 * @param array $params
	 * @return string
	 */
	private static function get_types(array $params): string
	{
		$types = '';
		foreach ($params as $param)
			$types .= match (gettype($param)) {
				'integer' => 'i',
				'string' => 's',
				'double' => 'd',
				default => 'b'
			};
		return $types;
	}
}