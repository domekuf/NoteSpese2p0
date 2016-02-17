
<? 
$sd->add_script('./lib/js.shortcuts.php');
$sd->add_script($sd->get_mod_include().'/xml2json.js');
$sd->add_script($sd->get_mod_include().'/script.js');
$js = '$.ajaxSetup({
				url:"'.$sd->get_mod_include().'/remote.php",
			});';
$sd->add_script($js,false);

/* importiamo la libreria di php per l'interfacciamento al db*/
include './lib/php.db.php';
/* instanziamo la variabile di gestione del db */
$db = new PI_DB($_SESSION[MSID]['db']);  
$qry_ins='';
function generaAmmElencoUtenti(){
		global $usr_list,$qry_ins;
		$out='';
		foreach($usr_list as $v => $k){
			if(isset($k['rs_usr']) && $k['rs_usr']>0){
			$out.='<option value="'.$v.'">'.$k['nome'].'</option>';
			$qry_ins.="
			insert into psofa.pso_tab_appl_utenti_funz (utente,cod_appl,cod_funz)
			values 
			(".$k['nome'].",'PORTAL1',".$k['rs_usr'].")	;";
			
			}
		}
		return $out;
	}
//$db = new PI_DB('WWWDC');
/* riga aggiuntiva con il count.. non usare perchè se ordini la tabella, viene ordinata anche questa*/
$db->set_opt('rowindex',false);
/* tutti gli header di colonna li mettiamo in piccolo  */	
$db->set_opt('lowercase',true); 
	$pathroot='/var/www/modules/CED/NoteSpese2p0/call/usr_interface/'; //importo tutte le interfacce da html esterni, situati qui
	$qrypath='/var/www/modules/CED/NoteSpese2p0/call/_common/qry/'; //importo tutte le interfacce da html esterni, situati qui
	
	$p=$qrypath.'gruppo.sql';
	$f=fopen($p,'r');
	$qry_gruppo=fread($f,filesize($p));
	
	
	$usr = $_SESSION[MSID]["usr"];
	$qry_gruppo=str_replace('[login_utente]',$usr,$qry_gruppo);
	
	$res=$db->get_data($qry_gruppo);
	if(count($res)>0){
		$gruppo=$res[0]['descrizione'];
	}else{
		$gruppo='';
	}
	$usr_list = parse_ini_file('/var/www/settings/users.ini',true); //a quanto pare non vede la common
	$isAmm = $usr_list[$usr]['rs_usr']==0;
	$utente = $usr_list[$usr]['nome'];
	$load_trasferte = '<button onmouseover="updateFields()" onclick="pi.requestQ(\'wallet\',\'Trasf_Load\')" style="cursor:pointer;" class="reload"><div>Elenco Trasferte</div></button>';
	$elenco_note_spese ='pi.requestQ(\'wallet\',\'TrasfLoad\')';
	$amm_elenco_note_spese ='pi.requestQ(\'wallet\',\'AmmTrasfLoad\')';
	$storico ='pi.requestQ(\'wallet\',\'TrasfLoadStorico\')';
	$gestisci_gruppi ='pi.requestQ(\'wallet\',\'Gruppi\')';
	$gestisci_eventi ='pi.requestQ(\'wallet\',\'Eventi\')';
	$amm_storico ='pi.requestQ(\'wallet\',\'AmmTrasfLoadStorico\')';
	$amm_elenco_utenti='
	<select id="amm_utente" name="amm_utente">'.generaAmmElencoUtenti().'
	</select>';
	$amm_load_trasferte = '<button onmouseover="updateFields()" onclick="pi.requestQ(\'wallet\',\'Amm_Trasf_Load\')" style="cursor:pointer;" class="reload"><div>Elenco Trasferte</div></button>';
	$load_transazioni = '<button  onclick="pi.requestQ(\'wallet\',\'Trans_Load\')" style="cursor:pointer;" class="reload"><div>Elenco Transazioni</div></button>';
	$data_da = '<input type="text" name="data_da" id="data_da">';
	$data_a = '<input type="text" name="data_a" id="data_a">';
	$switch_debug = '<button onclick="$(\'#wallet\').toggle()" style="cursor:pointer;" class="option icon"><div></div></button>';
	$contabilizza = '<button onclick="alert(\'todo\')" style="cursor:pointer;" class="confirm"><div>Contabilizza</div></button>';
	$lang = '<select class="round std" name="lingua" style="text-align:center;"> 
			<option value="I" selected> Italia </option>
			<option value="F"> Francia </option>
			';
	$interface = '
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="/modules/CED/NoteSpese2p0/colors.css">
	<link rel="stylesheet" href="/modules/CED/NoteSpese2p0/grid.css">
	<link rel="stylesheet" href="/modules/CED/NoteSpese2p0/notespese.css">';
	if(!$isAmm){
		$p=$pathroot.'1.html';
		$f=fopen($p,'r');
		$s=fread($f,filesize($p));
		$s=str_replace("[utente]", $utente, $s);
		$s=str_replace("[gruppo]", $gruppo, $s);
		$s=str_replace("[elenco_note_spese]", $elenco_note_spese, $s);
		$s=str_replace("[storico]", $storico, $s);
		$interface .= $s;
	}else{
		$p=$pathroot.'0.html';
		$f=fopen($p,'r');
		$s=fread($f,filesize($p));
		$s=str_replace("[utente]", $utente, $s);
		$s=str_replace("[elenco_note_spese]", $amm_elenco_note_spese, $s);
		$s=str_replace("[storico]", $amm_storico, $s);
		$s=str_replace("[amm_elenco_utenti]", $amm_elenco_utenti, $s);
		$s=str_replace("[gestisci_gruppi]", $gestisci_gruppi, $s);
		$s=str_replace("[gestisci_eventi]", $gestisci_eventi, $s);
		$interface .= $s;
	}
	$p=$pathroot.'wallet.html';
	$f=fopen($p,'r');
	$s=fread($f,filesize($p));
	$s=str_replace("[usr]", $usr, $s);
	$s=str_replace("[isAmm]", $isAmm, $s);
	$s=str_replace("[rs_usr]", $usr_list[$usr]['rs_usr'], $s);
	$interface .= $s;
	$interface .= '
	<script>
		$("#data_da").datepicker();
		$("#data_a").datepicker();
		
		function updateFields(){
			$("#wall_data_a").val($("#data_a").val());
			$("#wall_data_da").val($("#data_da").val());
			$("#wall_amm_utente").val($("#amm_utente").val());	
		}
		updateFields();
	</script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKAjdzzT93RxNe5LjAigHNCQtVTGGAba8" async defer></script>

	';
?>

