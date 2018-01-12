<?
	class cDynmenu
	{
		var $menu = array();			//Array contentente i titoli delle voci di menu
		var $text = array();			//Array contentente i testi dei contenuti
		var $action = array();			//Array contentente le azioni javacript custom per ogni voce 
		var $speed;						//Velocita di apertura
		var $opened;					//Voce di menu da aprire subito dopo la creazione
		
		function cDynmenu($opened=0, $speed=1)
		{
			$this->opened = $opened;
			$this->speed = $speed;
		}
		
		function __construct($opened=0, $speed=1)
		{
			$this->opened = $opened;
			$this->speed = $speed;
		}
		
		function add_item($title,$text,$action="")
		{
			array_push($this->menu,$title);
			array_push($this->text,$text);
			array_push($this->action,$action);
		}
	
		function create()
		{
			$i = 1;
			foreach ($this->menu as $menu) 
			{
				$contenuto = $this->text[$i-1];
				$azione = $this->action[$i-1];
				echo "<div class=\"menu\" id=\"menu_$i\" onClick=\"open_menu(this);$azione\" onMouseOver=\"this.style.cursor='pointer'\">$menu</div>";
				echo "<div class=\"contenuto\" id=\"contenuto_$i\" style=\"height:0px;\">$contenuto</div>";
				$i++;		
			}
			if($this->opened)
			{
				$azione = $this->action[$this->opened-1];
				echo "<script>\nvar to_open = document.getElementById(\"menu_".$this->opened."\");open_menu(to_open);$azione</script>\n";
			}
		}
		
		function createIndicadorParametro()
		{
			$i = 1;
			foreach ($this->menu as $menu) 
			{
				$contenuto = $this->text[$i-1];
				$azione = $this->action[$i-1];
				echo "<div class=\"menu\" id=\"menu_$i\" onClick=\"open_menu(this);$azione\" onMouseOver=\"this.style.cursor='pointer'\">$menu</div>";
				echo "<div class=\"contenuto\" id=\"contenuto_$i\" style=\"height:0px;\">$contenuto</div>";
				$i++;		
			}
			if($this->opened)
			{
				$azione = $this->action[$this->opened-1];
				echo "<script>\nvar to_open = document.getElementById(\"menu_".$this->opened."\");open_menu(to_open);$azione</script>\n";
			}
		}
		
		function print_scripts()
		{
			echo "<script language=\"JavaScript\" type=\"text/javascript\" src=\"js/dynmenu.js\"></script>\n";
			echo "<script>\nvar speed = ".$this->speed.";</script>\n";
		}
		
		function print_styles()
		{
			echo "<link href=\"css/dynmenu.css\" rel=\"stylesheet\" type=\"text/css\" />\n";
		}
		
	}
?>