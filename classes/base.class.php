<?php
abstract class Base {
	private static function open_connection() {
		return new PDO('mysql:host='.DATABASE_HOST.';dbname='.DATABASE_NAME.';charset=utf8', DATABASE_USERNAME, DATABASE_PASSWORD);
	}

	protected function fetch_all($query, $params) {
		try {
			$con = self::open_connection();
			$query .= " WHERE";
			$i = 0;
			foreach($params as $att => $val) {
				$query .=  " " .$att . " = :" . $att;
				if($i < count($params) - 1)
					$query .= " AND ";
				$i++;
			}
			$sth = $con->prepare($query);
			foreach($params as $att => &$val)
				$sth->bindParam(":".$att, $val);
			$sth->execute();
			$result = $sth->fetch(PDO::FETCH_ASSOC);
			if(!$result)
				throw new Exception('No results.');
			foreach($result as $att => $val)
				$this->{$att} = $val;
		} 
		catch(PDOException $e) {
			ErrorHelper::log_error($e);
			die();
		}
		catch(Exception $e) {
			ErrorHelper::query_error($e);
		}
		finally {
			unset($con);
		}
	}
}
?>