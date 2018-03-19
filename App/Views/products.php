<!DOCTYPE html>
<html lang="en">
<head>
  <title>Products</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script type="text/javascript">
        window.App = {
            Settings: {
                root: "/"
            }
        };
  </script>
</head>
<body>

<div class="jumbotron text-center">
  <h1>Product workflow page</h1>
  <p>Upload *.csv file to make it work</p>
</div>
  
<div class="container">
  <div style="width:50%; margin:0 auto;">
    <table class="table table-hover">
		<thead>
			<tr>
				<th>Product</th>
				<th>Quantity</th>
				<th>Warehouse(s)</th>
			</tr>
		<thead>
		<tbody>
			<?php if (count($products) > 0) :?>
				<?php foreach ($products as $product) :?>
				<tr>
					<td><?= $product->product_name ?></td>
					<td><?= $product->qtys ?></td>
					<td><?= $product->warehouses ?></td>

				</tr>
				<?endforeach; ?>
			<?php else:?>
			<tr>
				<td class="bg-primary text-center" colspan="4">
					No products, put csv to add
				</td>
			</tr>
			<?php endif;?>
		<tbody>
	</table>

	<form method="post" class="form form-horizontal" action="/update" id="csv-form" enctype="multipart/form-data">
		<label class="btn btn-default" for="fileinput">
			<input id="fileinput" type="file" style="display:none" name="csv">
			Choose File
		</label>
		<span class="label label-info file-name"></span>		
		<input type="submit" class="btn btn-primary" value="Send" />
	</form>
  </div> 
    

</div>
<script type="text/javascript" src="/assets/js/common.js"></script>
<script type="text/javascript" src="/assets/js/products.js"></script>
<script type="text/javascript">
	$(function() {
        App.Page.Products();
    })
</script>
</body>
</html>






