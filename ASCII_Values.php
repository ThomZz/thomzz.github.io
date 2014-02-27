<?php
//Classe "statique" servant a définir les différentes plages possibles de valeurs ASCII.
class ASCII_Values
{
    private static $symbols;
	private static $lowers; 
	private static $caps; 
    private static $letters;
	private static $numbers;
	private static $count_symbols;
	private static $count_lowers; 
	private static $count_caps; 
    private static $count_letters;
	private static $count_numbers;
    private static $initialized = false;

    public static function initialize()
    {
    	if (self::$initialized)
    		return;

		self::$symbols = array_merge(range(33,47), range(58,64), range(91,96), range(123,126));
		self::$lowers  = range(97,122);
		self::$caps	  = range(65,90);
		self::$letters = array_merge(self::$lowers , self::$caps );
	    self::$numbers  = range(48,57);
		self::$count_symbols = count(self::$symbols);
		self::$count_lowers  = count(self::$lowers); 
		self::$count_caps    = count(self::$caps); 
		self::$count_letters = count(self::$letters);
		self::$count_numbers = count(self::$numbers);
    	self::$initialized = true;
    }

	public static function getNumber($p_index)
    {
    	self::initialize();
        return self::$numbers[$p_index];
    }

	public static function getCapitalLetter($p_index)
    {
    	self::initialize();
        return self::$caps[$p_index];
    }
	
	public static function getSymbol($p_index)
    {
    	self::initialize();
        return self::$symbols[$p_index];
    }
	
	public static function getLower($p_index)
    {
    	self::initialize();
        return self::$lowers[$p_index];
    }	
	
    public static function getNumbersValues()
    {
    	self::initialize();
        return self::$numbers;
    }
	
    
	public static function getCapsValues()
    {
    	self::initialize();
        return self::$caps;
    }
	
	public static function getLowersValues()
    {
    	self::initialize();
        return self::$lowers;
    }
	
	public static function getSymbolsValues()
    {
    	self::initialize();
        return self::$symbols;
    }
	
	public static function getLettersValues()
    {
    	self::initialize();
        return self::$letters;
    }
    
	public static function getcountSymbols()
    {
    	self::initialize();
        return self::$count_symbols;
    }
	
	public static function getcountLowers()
    {
    	self::initialize();
        return self::$count_lowers;
    }
	
	public static function getcountCaps()
    {
    	self::initialize();
        return self::$count_caps;
    }
	
	public static function getcountNumbers()
    {
    	self::initialize();
        return self::$count_numbers;
    }
}
?>