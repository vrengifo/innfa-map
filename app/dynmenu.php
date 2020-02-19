<?
	class dynmenu
	{
		var $menu = array();			//Array contentente i titoli delle voci di menu
		var $text = array();			//Array contentente i testi dei contenuti
		var $action = array();			//Array contentente le azioni javacript custom per ogni voce 
		var $speed;						//Velocita di apertura
		var $opened;					//Voce di menu da aprire subito dopo la creazione
		
		function dynmenu($opened=0, $speed=1)
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
			foreach ($this->menu as $menu) {
				
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

	<?
		$menu = new dynmenu(1,2.5);// primer parametro con 1 si se carga abierto el menu y 0 para que se muestre contraido 
		
		for ($i=1;$i<5;$i++)
			$contenuto.="<a href='#' style='display:block'>Test link $i</a><input type='text' name='hola_$i' value='$i'>";
		
		$menu->add_item("Menu Item 1","Content 1");
		$menu->add_item("Menu Item 2","Content 2","alert('Test click action 2');");
		$menu->add_item("Menu Item 3","$contenuto");
		$menu->add_item("Menu Item 4","Content 4");
		$menu->add_item("Menu Item 5","Content 5");
		$menu->add_item("Menu Item 6","Content 6");
	?>
	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Dynamic Menu Sample</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style>
body{
	font-family:tahoma;
	font-size:12px;
}
.menu {
	padding:6px;
	background-color: #F4F7F5;
	width: 238px;
	height:18px;
	margin-bottom: 1px;
	border: 1px solid #E2E2E2;
	background-image:url(../images/button.jpg);
}
.contenuto {
	padding-left:6px;
	padding-right:6px;
	width: 238px;
	margin-bottom: 1px;
	border: 1px solid #E2E2E2;
	display:none;
	overflow:hidden;
}	
</style>
<script>
var opened = 1;
var height = 200;
var opening = 0;

function open_menu(menu)
{
	if(!opening)
	{
		id_menu = menu.id;
		menu_array = id_menu.split("_");
		menu_num = menu_array[1];
		
		menu  = document.getElementById("menu_"+opened);
		menu.style.backgroundImage = "url('images/button.jpg')";
		
		menu  = document.getElementById("menu_"+menu_num);
		menu.style.backgroundImage = "url('images/active.jpg')";

		opening = 1;
		window.setTimeout("chiudi(menu_num)", 10);
	}
}

function getElementsByClass(searchClass) {
	var classElements = new Array();
	tag = 'div';
	var els = document.getElementsByTagName(tag);
	var elsLen = els.length;
	var pattern = new RegExp("(^|\\s)"+searchClass+"(\\s|$)");
	for (i = 0, j = 0; i < elsLen; i++) {
		if ( pattern.test(els[i].className) ) {
			classElements[j] = els[i];
			j++;
		}
	}
	return classElements;
}

function chiudi(menu_num)
{
	contenuto = document.getElementById("contenuto_"+opened);
	altezza = contenuto.style.height;
	altezza = parseFloat(altezza);

	if(altezza<40)
		altezza = altezza-(2*speed);
	else if(altezza<200)
		altezza = altezza-(10*speed);
	else
		altezza = altezza-(20*speed);

	if(altezza<0)altezza = 0;
	contenuto.style.height = altezza + "px";
	
	if(altezza > 0)
		window.setTimeout("chiudi(menu_num)", 10);
	else
	{
		contenuto.style.display = 'none';
		window.setTimeout("apri(menu_num)", 300);
	}
}
function apri(menu_num)
{
	contenuto = document.getElementById("contenuto_"+menu_num);
	altezza = contenuto.style.height;
	altezza = parseFloat(altezza);
	
	if(altezza>height-40)
		altezza = altezza+(2*speed);
	else if(altezza>height-200)
		altezza = altezza+(10*speed);
	else
		altezza = altezza+(20*speed);
	contenuto.style.display = 'block';
	contenuto.style.height = altezza + "px";
	
	if(altezza <= height)
		window.setTimeout("apri(menu_num)", 10);
	else
	{
		opening = 0;
		opened = menu_num;
	}
}
</script>
<?
	$menu->print_styles();
	$menu->print_scripts();
?>
</head>
<body>
<div style='float:left'>
<?	
	$menu->create();
?>
</div>
</body>
</html>