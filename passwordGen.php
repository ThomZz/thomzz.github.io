<?php
include_once "ASCII_Values.php";
//*****Classe du générateur de mot de passe*****
class passwordGen
{
	// déclaration des propriétés
    private $password;
	
	private $passLength;  	 //Longueur du mot de passe
	private $noSymbols;   	 //Indicateur "Utiliser symboles"
	private $noCaps;	  	 //Indicateur "Utiliser Majuscules"
	
	private	$numberOfSym;    //Nombre de symboles dans le mot de passe généré
	private	$numberOfCaps;   //Nombre de majs ...
	private $numberOfNums; 	 //Nombre de chiffres ...
	private $numberOfLowers; //Nombre de mins ...
	
	private $numbersMin; 	 //Nombre d'occurences minimales de chiffres désiré
	private $capsMin;	 	 //... Majuscules désiré
	private $lowersMin;	 	 //... Minuscules désiré
	private $symbolsMin; 	 //... Symboles   désiré
	//
	//Constructeur
	function __construct($p_passLength,
						 $p_noCaps,
						 $p_noSymbols,
						 $p_numbersMin,
						 $p_capsMin,
						 $p_symbolsMin,
						 $p_lowersMin) 
	{
		$this->password	      = '';
		$this->passLength	  = $p_passLength;
		$this->noCaps 	 	  = $p_noCaps;
        $this->noSymbols 	  = $p_noSymbols;
		
		$this->numbersMin	  = $p_numbersMin;
		$this->capsMin	 	  = $p_capsMin;
		$this->symbolsMin	  = $p_symbolsMin;
		$this->lowersMin	  = $p_lowersMin;
		
		$this->numberOfSym 	  = 0;
		$this->numberOfCaps   = 0;
		$this->numberOfNums   = 0;
		$this->numberOfLowers = 0;
	}
	
    // déclaration des méthodes
    public function getPassword() {
        return htmlspecialchars($this->password);
    }
	
    public function getnumberOfSym() {
        return htmlspecialchars($this->numberOfSym);
    }
	
    public function getnumberOfCaps() {
        return htmlspecialchars($this->numberOfCaps);
    }
	
    public function getnumberOfNums() {
        return htmlspecialchars($this->numberOfNums);
    }
	
    public function getnumberOfLowers() {
        return htmlspecialchars($this->numberOfLowers);
    }
	//Méthode servant a déterminer le nombres d'occurences pour chaque types qui sont ajoutés dans le mot de passe		
	private function analyse_type($p_option,
								  $value)
	{	
		switch ($p_option) 
		{
			case 0: //Aucune options de restriction de types
				if (in_array($value,ASCII_Values::getSymbolsValues()))
					$this->numberOfSym++;
				elseif (in_array($value,ASCII_Values::getCapsValues()))
					$this->numberOfCaps++;
				elseif (in_array($value,ASCII_Values::getNumbersValues()))
					$this->numberOfNums++;
				else
					$this->numberOfLowers++;
				break;
			case 1: //Sans Symboles
				if (in_array($value,ASCII_Values::getCapsValues()))
					$this->numberOfCaps++;
				elseif (in_array($value,ASCII_Values::getNumbersValues()))
					$this->numberOfNums++;
				else
					$this->numberOfLowers++;
				break;
			case 2: //Sans Majuscules
				if (in_array($value,ASCII_Values::getSymbolsValues()))
					$this->numberOfSym++;
				elseif (in_array($value,ASCII_Values::getNumbersValues()))
					$this->numberOfNums++;
				else 
					$this->numberOfLowers++;
				break;
			case 3: //Sans Symboles, sans Majuscules
				if (in_array($value,ASCII_Values::getNumbersValues()))
					$this->numberOfNums++;
				else
					$this->numberOfLowers++;
				break;
		}
	return 0;
	}		
	//Méthode de la génération du mot de passe
	public function generate()
	{
	    $random_int = 0;
		$gen_index = 0;
		$from = 0;
		$to = 0;
		$valid_values = array();
		$password = array();
		$options 	  = 0;
		
	
		if ($this->noCaps == True && $this->noSymbols == True)	//Sans symboles, sans majs.
		{
			$options = 3;
			//La plage de valeurs possibles pour la génération de mots de passe selon les options de restrictions. 
			$valid_values = array_merge(ASCII_Values::getLowersValues() , ASCII_Values::getNumbersValues());
		}
		elseif ($this->noCaps == True) // Sans majs
		{
			$options = 2;
			//...
			$valid_values = array_merge(ASCII_Values::getSymbolsValues() ,ASCII_Values::getNumbersValues(), ASCII_Values::getLowersValues() );
		}
		elseif ($this->noSymbols == True) //Sans symboles
		{
			$options = 1;
			//...
			$valid_values = array_merge(ASCII_Values::getLettersValues(), ASCII_Values::getNumbersValues());
		}
		else //Aucune restrictions de types
		{
			
			$valid_values = range(33,126);
		}
					
		//Boucle de génération du mot de passe, en ce basant sur les valeurs d'occurences minimales passées
		for ($i=0;$i<$this->passLength;$i++) {
			
			if ($this->numbersMin > 0 && $this->numberOfNums < $this->numbersMin)
			{
				$ran_num = mt_rand(0,ASCII_Values::getCountNumbers() - 1);
				$password[$i] = chr(ASCII_Values::getNumber($ran_num)); //Aller chercher un chiffre dans le tableau de chiffres.
				$this->numberOfNums++;
			}
			elseif ($this->lowersMin > 0 && $this->numberOfLowers < $this->lowersMin)
		    {
				$ran_num = mt_rand(0,ASCII_Values::getCountLowers() - 1);
				$password[$i] = chr(ASCII_Values::getLower($ran_num)); //Aller chercher une lettre minuscule dans le tableau de lettres minuscules.
				$this->numberOfLowers++;
			}
			elseif ($this->noCaps == False && $this->capsMin > 0 && $this->numberOfCaps < $this->capsMin)
		    {
				$ran_num = mt_rand(0,ASCII_Values::getCountCaps() - 1);
				$password[$i] = chr(ASCII_Values::getCapitalLetter($ran_num)); //Aller chercher une lettre majuscule dans le tableau de maj.
				$this->numberOfCaps++;
			}
			elseif ($this->noSymbols == False && $this->symbolsMin > 0 && $this->numberOfSym < $this->symbolsMin)
		    {
				$ran_num = mt_rand(0,ASCII_Values::getCountSymbols() - 1);
				$password[$i] = chr(ASCII_Values::getSymbol($ran_num)); //Aller chercher un caractère spécial dans le tableau de symboles.
				$this->numberOfSym++;
			}
			else
			{
				$to	= count($valid_values) - 1;
				$ran_num = mt_rand($from,$to);
				$this->analyse_type($options,$valid_values[$ran_num]);
				$password[$i] = chr($valid_values[$ran_num]);
			}
		}
		
		shuffle($password); //Remélanger les éléments du mot de passe.
		$this->password = implode($password);
		
	 return 0;
	}
}		
?>