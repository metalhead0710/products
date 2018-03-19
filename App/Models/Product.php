<?php

namespace App\Models;
use PDO;

class Product {

	public $id;
	public $product_name;
	public $qtys;
	public $warehouses;

	public static function getProductsAvailable($db) {
		$query = $db->query("SELECT id, 
										  product_name, 
										  SUM(qty) as qtys, 
										  GROUP_CONCAT(warehouse order by warehouse SEPARATOR ', ') as warehouses 
										FROM `products` 
										WHERE qty > 0 
										GROUP BY product_name");

		$query->setFetchMode(PDO::FETCH_CLASS, Product::class);
		$products= $query->fetchAll();
		return $products;
	}
	public static function getAll($db) {
		$query = $db->query("SELECT * from products");

		$query->setFetchMode(PDO::FETCH_ASSOC);
		$products= $query->fetchAll();
		return $products;
	}

	public static function massiveUpdate($db, $toUpdate) {
		$query = $db->prepare("UPDATE products SET qty = :qty where id = :id");
		$query->bindParam(":qty",$qty);
		$query->bindparam(":id",$id);
		foreach($toUpdate as $row) {
			$id = $row['id'];
			$qty = $row['qty'];
			$query->execute();
		}
	}
	public static function massiveCreate($db, $csv) {
		$sql = 'INSERT INTO products (product_name, qty, warehouse) VALUES ';
		$insertQuery = [];
		$insertData = [];
		$n = 0;
		foreach ($csv as $row) {
			$insertQuery[] = '(:product_name' . $n . ', :qty' . $n . ', :warehouse' . $n . ')';
			$insertData['product_name' . $n] = $row['product_name'];
			$insertData['qty' . $n] = $row['qty'];
			$insertData['warehouse' . $n] = $row['warehouse'];
			$n++;
		}

		if (!empty($insertQuery)) {
			$sql .= implode(', ', $insertQuery);
			$query = $db->prepare($sql);
			$query->execute($insertData);
		}
	}
}