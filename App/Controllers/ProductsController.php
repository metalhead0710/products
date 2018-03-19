<?php

namespace App\Controllers;

use App\Components\Controller as BaseController;
use App\Models\Product;


class ProductsController extends BaseController {


	public function index() {
		$products= Product::getProductsAvailable($this->db);
		$this->view->vars(compact('products'));
		return $this->view->render('products');
	}

	public function update() {
		try {
			$csv_mimetypes = [
				'text/csv',
				'application/csv',
				'text/comma-separated-values',
				'application/excel',
				'application/vnd.ms-excel',
				'application/vnd.msexcel',
			];

			if (!in_array($_FILES['csv']['type'], $csv_mimetypes)) {
				throw new \Exception("You can download only csv files!!");
			}
			$tmpName = $_FILES['csv']['tmp_name'];
			$rows = array_map('str_getcsv', file($tmpName));


			$products = Product::getAll($this->db);
			$toUpdate = [];

			$csv = $this->makeArrayFromCSV($rows);

			foreach ($products as $product)	{
				foreach($csv as $key=>$row) {
					if($product['product_name'] === $row['product_name'] && $product['warehouse'] === $row['warehouse']){
						$product['qty'] += $row['qty'];
						array_push($toUpdate, $product);
						unset($csv[$key]);
					}
				}
			}
			/*echo "<pre>";
			print_r($csv);*/
			Product::massiveUpdate($this->db, $toUpdate);
			Product::massiveCreate($this->db, $csv);
			return header('Location: /');
		} catch (\Exception $e)	{
			error_log($e->getMessage());
			die($e->getMessage());
		}

	}

	private function makeArrayFromCSV($rows)
	{
		try {
			$keys = array_shift($rows);
			$csv = [];
			foreach($rows as $row) {
				if (array_combine($keys, $row))
				{
					$csv[] = array_combine($keys, $row);
				}
				else {
					throw new \Exception("Check your csv file structure");
				}
			}
			foreach ( $csv as $row ) {
				if ( !array_key_exists( 'product_name', $row ) ||
				     !array_key_exists( 'qty', $row ) ||
				     !array_key_exists( 'warehouse', $row )
				) {
					throw new \Exception("Csv is not valid");
				}
			}
			return $csv;
		} catch (\Exception $e)
		{
			error_log($e->getMessage());
			die ($e->getMessage());
		}
	}
}