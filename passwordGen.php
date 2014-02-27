<?php
include_once "ASCII_Values.php";
//
class passwordGen
{
	// déclaration des propriétés
    private $password;
	
	private $passLength;
	private $noSymbols;
	private $noCaps;
	
	private	$numberOfSym;
	private	$numberOfCaps;
	private $numberOfNums;
	private $numberOfLowers;
	
	private $numbersMin;
	private $capsMin;
	private $lowersMin;
	private $symbolsMin;
	//
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
	//		
	private function analyse_type($p_option,
								  $value)
	{	
		switch ($p_option) 
		{
			case 0:
				if (in_array($value,ASCII_Values::getSymbolsValues()))
					$this->numberOfSym++;
				elseif (in_array($value,ASCII_Values::getCapsValues()))
					$this->numberOfCaps++;
				elseif (in_array($value,ASCII_Values::getNumbersValues()))
					$this->numberOfNums++;
				else
					$this->numberOfLowers++;
				break;
			case 1:
				if (in_array($value,ASCII_Values::getCapsValues()))
					$this->numberOfCaps++;
				elseif (in_array($value,ASCII_Values::getNumbersValues()))
					$this->numberOfNums++;
				else
					$this->numberOfLowers++;
				break;
			case 2:
				if (in_array($value,ASCII_Values::getSymbolsValues()))
					$this->numberOfSym++;
				elseif (in_array($value,ASCII_Values::getNumbersValues()))
					$this->numberOfNums++;
				else 
					$this->numberOfLowers++;
				break;
			case 3:
				if (in_array($value,ASCII_Values::getNumbersValues()))
					$this->numberOfNums++;
				else
					$this->numberOfLowers++;
				break;
		}
	return 0;
	}		
	//
	public function generate()
	{
	    $random_int = 0;
		$gen_index = 0;
		$from = 0;
		$to = 0;
		$valid_values = array();
		$password = array();
		$options 	  = 0;
		
	
		if ($this->noCaps == True && $this->noSymbols == True)	
		{
			$options = 3;
			$valid_values = array_merge(ASCII_Values::getLowersValues() , ASCII_Values::getNumbersValues());
		}
		elseif ($this->noCaps == True)
		{
			$options = 2;
			$valid_values = array_merge(ASCII_Values::getSymbolsValues() ,ASCII_Values::getNumbersValues(), ASCII_Values::getLowersValues() );
		}
		elseif ($this->noSymbols == True)
		{
			$options = 1;
			$valid_values = array_merge(ASCII_Values::getLettersValues(), ASCII_Values::getNumbersValues());
		}
		else
		{
			
			$valid_values = range(33,126);
		}
		
		$to	= count($valid_values) - 1;
					
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