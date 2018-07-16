<?php

function getOutputAddress(&$address){
	$returnArray=[];
	$count=0;
	$blockdatafile="blockdata-5block.json";
	ini_set('memory_limit', '-1');
	$json=json_decode(file_get_contents($blockdatafile), true);
	$totalTxs= count($json["tx"]);
	//$totalTxs= $json["n_tx"];
		for($i=1; $i<$totalTxs; $i++)
		{
			$n_outputs = count($json["tx"][$i]["out"]);	
			for($io = 0; $io < $n_outputs; $io++)
			{	
				
				$outValue= $json["tx"][$i]["out"][$io]["value"];
				if($outValue != 0)
				{
					$outAddy = $json["tx"][$i]["out"][$io]["addr"];
					if($address==$outAddy)
					{
						$outTime = $json["tx"][$i]["time"];
						echo "output transaction time:".$outTime."<br>";
						$returnArray[$count] = [];
						
						$n_inputs = count($json["tx"][$i]["inputs"]);	
						for($ii = 0; $ii < $n_inputs; $ii++)
						{	
							$inAddy = $json["tx"][$i]["inputs"][$ii]["prev_out"]["addr"].PHP_EOL;
							echo "Input Address:".$inAddy;
							echo "<br>";
							$returnArray[$count][$ii] = $inAddy;
						}
						$count = $count+1;
					}	
				}		
			}			
		}
		return $returnArray;
	}	
$add='1N74ATCjN9PLrY7uvuS7rMpfi7foLu9Hd5';
$array = getOutputAddress($add);	
echo "<br>";
$nextAddress = $array[0][0];
echo $nextAddress;
getOutputAddress($nextAddress);


?>					