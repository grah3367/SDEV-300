<?php 
require('lab3.php');

$slopeInput = array(2,5,8,10);
$areaInput = array(2,6,10, 100,1000);
$velocityInput = array(10, 30, 327, 1200);

$slopeData = slopeIntercept( $slopeInput  );
$areaData = surfaceArea($areaInput  );
$velocityData = velocity( $velocityInput );

 ?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>lab 3</title>
  </head>
  <body>
	<div class="container">
	<h1>Lab 3</h1>
		<h2>Part 1: Formula Table</h2>
		<table class="table table-bordered">
			<thead>
				<th>Slope intercept (y=mx+b)</th>
				<th>Surface Area of Sphere (A=4piR2)</th>

				<th>Distance Traveled (meters)</th>

			</thead>
			<tbody>
			
			
			<?php 
			
				$i=0;
				
				echo "<tr><td><table><thead>
				<th>input</th>
				<th>output</th>
				</thead>
				<tbody>
				";
				
				foreach($slopeData as $data){
					echo "<tr>";
					echo "<td>" . "y=(-2)(" . $slopeInput[$i] . ") + 0";
					echo "<td>" . $data . "</td>";
					echo "</tr>";
					$i++;
					
				}
				$i=0; // reset i
				echo "</tbody></table></td>";
				
				echo "<td><table><thead>
				<th>input</th>
				<th>output</th>
				</thead>
				<tbody>
				";
				
				foreach($areaData as $data){
					echo "<tr>";
					echo "<td>" . "A=4*pi*" .  $areaInput[$i] . "^2";
					echo "<td>" . $data . "</td>";
					echo "</tr>";
					$i++;
					
				}
				
				$i=0; // reset i
				echo "</tbody></table></td>";
				
				
				
				
				
				echo "<td><table><thead>
				<th>input</th>
				<th>output m/s (step in seconds) </th>
				</thead>
				<tbody>
				";
				
				
				foreach($velocityData as $data){
			
					
					
						echo "<tr>";
						echo "<td>" . "v=d(" .  $velocityInput[$i] .  ")</td>";
						echo "<td>" . printDistance($data) . "</td>";
					
					echo "</tr>";
					$i++;
				}
				echo "</tbody></table></td></tr>";
				
			
				
				
				
				function printDistance($data){
					$p=0.0;
					foreach($data as $x){
						$lol .= $x . " (" . $p . "s), ";
						$p += 0.5;
					}
					
				return $lol;
				}
			
			
			?>
			</tr>
			
			</tbody>
			</table>
		
		<h2>Part 2: Quote Table</h2>
		<table class="table table-bordered">
			<thead>
				<th>Modification</th>
				<th>Quote</th>

			</thead>
			<tbody>
			<?php $quote="Your time is limited, so don't waste it living someone else's life. Don't be trapped by dogma, which is living with the results of other people's thinking. Don't let the noise of others' opinions drown out your own inner voice. And most important, have the courage to follow your heart and intuition."; ?>
			<tr>
				<td>Original</td>
				<td><?php echo $quote; ?></td>

			</tr>
			<tr>
				<td>Capitalize the first letter of each word.</td>
				<td><?php echo ucwords($quote); ?></td>

			</tr>
			<tr>
				<td>Displays the word length of each word in the quote separated by commas.</td>
				<td><?php foreach(explode(' ',$quote) as $word) { echo strlen($word) . ", "; } ?></td>

			</tr>
			<tr>
				<td>Randomly shuffles each word in the quote.</td>
				<td><?php foreach(explode(' ',$quote) as $word) { echo str_shuffle($word).  " "; } ?></td>

			</tr>
			</tbody>
		</table>
	</div>

 
  </body>
</html>