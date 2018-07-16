
<html>
<body>
<center><H1>Block Data Tool</h1></center>
<br>


<form action="" method="post">

<legend> Block Height </legend>
<input name="Blkhgt" id= "hght" type="text" size="10" >
<br>
<br>
<input name="submit" type="submit" value="Submit">
<input name="reset" type="reset" value="clear">
</form>
<form action="" method="post">
<input type='button' onclick='location.reload();' value='Refresh Page'>
</form>
</body>
</html>

<?php

if (isset($_POST['submit']))
{
$block_height = "$_POST[Blkhgt]";
for($x=0;$x<100;$x++)
{
//$url = "https://blockchain.info/latestblock";
//$json = json_decode(file_get_contents($url), true);
//$block = $json["height"];
//$block_index = $json["block_index"];
$block_url = "https://blockchain.info/block-height/$block_height?format=json";
//$block_url = "https://blockchain.info/block-index/$block_index?format=json";
$json_block = json_decode(file_get_contents($block_url), true);

$miner_address = $json_block["blocks"][0]["tx"][0]["out"][0]["addr"];
$block = $json_block["blocks"][0]["height"];
$block_index = $json_block["blocks"][0]["block_index"];
echo "Miner address:".$miner_address;
echo "<br>";
echo "Block Height:".$block;
echo "<br>";
echo "Block Index:".$block_index;
echo "<br>";
//total transactions
$totalTxs = $json_block["blocks"][0]["n_tx"];
echo "Total Transaction:".$totalTxs;
echo "<br>";
echo "Transactions in Latest Block";
//loop through each transaction and display all inputs and outs
for($i=1;$i<$totalTxs;$i++){
    
	echo "<table><tr><td width='550'>";
	echo "SENT FROM:<br>";
	$n_inputs = count($json_block["blocks"][0]["tx"][$i]["inputs"]);	
	
	for($ii = 0; $ii < $n_inputs; $ii++){	
		$inValue = $json_block["blocks"][0]["tx"][$i]["inputs"][$ii]["prev_out"]["value"];	
		$inValueCalc = $inValue / 100000000;	
	
		$inAddy = $json_block["blocks"][0]["tx"][$i]["inputs"][$ii]["prev_out"]["addr"];	
		
		
		echo "<button style='background-color:red;'>". rtrim(number_format($inValueCalc, 8), '0') ."</button><a href='#'>". $inAddy ."</a>";	
		echo "<br>";
		}	
	echo "</td><td>SENT TO:<br>";
	$n_outputs = count($json_block["blocks"][0]["tx"][$i]["out"]);	
	
	for($io = 0; $io < $n_outputs; $io++){	
		$outValue = $json_block["blocks"][0]["tx"][$i]["out"][$io]["value"];	
		$outValueCalc = $outValue / 100000000;	
		$outAddy = $json_block["blocks"][0]["tx"][$i]["out"][$io]["addr"];	
		if($outAddy==Null)
		{
		echo "<button style='background-color:green;'>". rtrim(number_format($outValueCalc, 8), '0') ."</button><a href='#'>". "No address" ."</a>";	
		}else{
			echo "<button style='background-color:green;'>". rtrim(number_format($outValueCalc, 8), '0') ."</button><a href='#'>". $outAddy ."</a>";
		}
		echo "<br>";	
		}	
	echo "</td></tr></table>";
}
$block_height=$block_height-1;
}
}
?>