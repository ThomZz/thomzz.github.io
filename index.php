<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="thomzz_psw_gen.js"></script>
<title>ThomZz Password Gen v1.0</title>
<link href='http://fonts.googleapis.com/css?family=Press+Start+2P|Roboto+Condensed:300' rel='stylesheet' type='text/css'>
<link href="password_gen.css" rel="stylesheet" type="text/css"/>
</head>
<?php
include_once "passwordGen.php";
/*($p_passLength,
$p_noCaps,
$p_noSymbols,
$p_prctNumbers,
$p_prctCaps
$p_prctSymbols,
$p_prctLowers)*/

$passLength = 12;
$numbersMin = 0;
$capsMin = 0;
$lowersMin = 0;
$symbolsMin = 0;
$noCaps		= 0;
$noSymbols	= 0;
$chNoCaps   = 'unchecked';
$chNoSymbols = 'unchecked';

if (isset($_POST["generate"]))
{	
	if (isset($_POST["noCaps"]) and $_POST["noCaps"] <> '')
	{
		$noCaps = $_POST["noCaps"];
		if ($noCaps == 1) 
		   $chNoCaps   = 'checked';
	}
	if (isset($_POST["noSymbols"]) and $_POST["noSymbols"] <> '')
	{
		$noSymbols = $_POST["noSymbols"];
		if ($noSymbols == 1) 
		   $chNoSymbols   = 'checked';
	}
	if (isset($_POST["passLength"]) and $_POST["passLength"] <> '')
	{
		$passLength = $_POST["passLength"];
		if ($passLength > 128)
			$passLength = 128;
		else if ($passLength < 8)
			$passLength = 8;
			
	}
	if (isset($_POST["numbersMin"]) and $_POST["numbersMin"] <> '')
	{
		$numbersMin = $_POST["numbersMin"];
	}
	if (isset($_POST["capsMin"]) and $_POST["capsMin"] <> '')
	{
		$capsMin = $_POST["capsMin"];
	}
	if (isset($_POST["lowersMin"]) and $_POST["lowersMin"] <> '')
	{
		$lowersMin = $_POST["lowersMin"];
	}
	if (isset($_POST["symbolsMin"]) and $_POST["symbolsMin"] <> '')
	{
		$symbolsMin = $_POST["symbolsMin"];
	}

	$obj = new passwordGen($passLength, //Longueur du mot de passe
						   $noCaps,	    //Ne pas utiliser de majuscules
						   $noSymbols,	//Ne pas utiliser de symboles
						   $numbersMin,	//Nb. minimal de chiffres
						   $capsMin,	//Nb. minimal de majuscules
						   $symbolsMin, //Nb. minimal de symboles 
						   $lowersMin); //Nb. minimal de minuscules

	$obj->generate();
}
?>
<body>
	<div align="center">
		<div class="mainDiv">
			<BR/>
			<p class="titre" align="center">ThomZz Password Gen v1.0</p><br/>
			<form id="generator" method="POST" accept-charset="utf-8">
				<table border="0px" width="700px">
					<tr>
						<td align="right" width="170px">Longueur : </td>
						<td><input type="text" id ="txtPassLength" name="passLength" size="10" tabindex=1 value="<?php if (isset($passLength)) echo($passLength); else  echo(12) ; ?>"></td>
					</tr>				
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td align="right"><b>Mot de passe généré : </b></td>
						<td><input type="text" id="pass" name="generated_pass" size="67" readonly select value="<?php if (isset($_POST["generate"])) echo($obj->getPassword()); ?>"></td>
						<td align="right"><input type="submit" name="generate" tabindex=2 value="Générer!"></td>
					</tr>
				</table>
				<?php
					 if (isset($_POST["generate"]))
					 {   
						 echo('<BR/><div class="results"><h3>Détails du mot de passe généré :</h3>');
						 echo(' <div id="counts">');
						 echo('		<table border="0px">');
						 echo('			<tr><td>Symboles   : </td><td align="center">' . $obj->getnumberOfSym()    . '</td></tr>');
						 echo('			<tr><td>Majuscules : </td><td align="center">' . $obj->getnumberOfCaps()   . '</td></tr>');
						 echo('			<tr><td>Minuscules : </td><td align="center">' . $obj->getnumberOfLowers() . '</td></tr>');
						 echo('			<tr><td>Nombres    : </td><td align="center">' . $obj->getnumberOfNums()   . '</td></tr>');
						 echo('		</table><BR/>');
						 echo(' </div>');						 
						 echo('	<div id="demo">');
						 echo('		<div id="progressbar" align="left"><div id="progress"></div></div>');
						 echo('		<div id="status">');
						 echo('			<div id="complexity">0%</div>');
						 echo('			<div id="complexityLabel">Complexité</div>');
						 echo('		</div><BR/>');
						 echo('	</div>');
						 echo('</div>');
					 }
				?>
				<BR/>
				<div align="center" style="position:relative;width:100%;">
					<div height="1px" class="separator">&nbsp;</div>
						<div class="onglet" id="onglet_trigger">Options</div>
					<div id="options_section" align="center">
						<BR/>
						<table border="0px" width="575px">
							<tr>
								<td colspan="4">&nbsp;</td>
							</tr>	
							<tr>
								<td align="right" width="180px"><b>Occurences minimales :</b></td>
								<td width="150px">&nbsp;</td>
								<td align="right" width="125px"><b>Ne pas utiliser ...</b></td>
								
							</tr>
							<tr>
								<td align="right">Chiffres : </td>
								<td><input type="text" class="mins" id="txtNumbersMin" name="numbersMin" size="10" tabindex=3 value="<?php if (isset($_POST["numbersMin"])) echo($_POST["numbersMin"]); else  echo(0) ; ?>"></td>
								<td align="right">de majuscules </td>
								<td align="left"><input type="checkbox" name="noCaps" id="chkNoCaps" tabindex=7 value="1" <?php print $chNoCaps; ?>></td>								
							</tr>
							<tr>
								<td align="right">Majuscules : </td>
								<td><input type="text" class="mins" id="txtCapsMin" name="capsMin" size="10" tabindex=4 value="<?php if (isset($_POST["capsMin"])) echo($_POST["capsMin"]); else  echo(0) ;?>"></td>
								<td align="right">de symboles </td>
								<td align="left"><input type="checkbox" name="noSymbols" id="chkNoSymbols"   tabindex=8 value="1" <?php print $chNoSymbols; ?>></td>							
							</tr>
							<tr>
								<td align="right">Symboles : </td>
								<td><input type="text" class="mins" id="txtSymbolsMin" name="symbolsMin" size="10" tabindex=5 value="<?php if (isset($_POST["symbolsMin"])) echo($_POST["symbolsMin"]); else  echo(0) ;?>"></td>
							</tr>
							<tr>
								<td align="right">Minuscules : </td>
								<td><input type="text" class="mins" id="txtLowersMin" name="lowersMin" size="10" tabindex=6 value="<?php if (isset($_POST["lowersMin"])) echo($_POST["lowersMin"]); else  echo(0) ;?>"></td>
							</tr>
							<tr>
								<td colspan="4">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="4" align="center"><span class="error" id="errorNums"></span></td>
							</tr>
							<tr>
								<td colspan="4">&nbsp;</td>
							</tr>							
						</table>
						
					</div>
				</div>
				<BR/>
				<input type="hidden" id="hide_options" name="hide_options" size="10" value="<?php if (isset($_POST["hide_options"])) echo($_POST["hide_options"]); else  echo('1') ;?>">
			</form>
		</div>
	</div>
</body>
<?php
unset($_POST);
?>
</html>