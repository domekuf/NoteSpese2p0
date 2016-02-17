/*
pi.loader.focusOnExit = 'f1';
pi.loader.focusOnError = 'f1';
*/

function initMap(lat1, lon, zoom1) {
		//alert('chiamata');
		var directionsService = new google.maps.DirectionsService;
		var directionsDisplay = new google.maps.DirectionsRenderer;
        lat1 = lat1 || 44;
        lon = lon || 12;
        zoom1 = zoom1 || 8;
        var styles = [
               {
                   featureType: "all",
                   stylers: [
                     { saturation: -80 }
                   ]
               }, {
                   featureType: "road.arterial",
                   elementType: "geometry",
                   stylers: [
                     { hue: "#523629" },
                     { saturation: 50 }
                   ]
               }, {
                   featureType: "poi.business",
                   elementType: "labels",
                   stylers: [
                     { visibility: "off" }
                   ]
               }
  ];
  var myLatlng = {lat: lat1, lng: lon};
  var styledMap = new google.maps.StyledMapType(styles, { name: "poltronesofà" });
  var mapOptions = {
      zoom: zoom1,
      center: myLatlng,
      mapTypeControlOptions: {
          mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
      }
  }
  map = new google.maps.Map(document.getElementById("map"), mapOptions);
  map.mapTypes.set('map_style', styledMap);
  map.setMapTypeId('map_style');
  
  
   directionsDisplay.setMap(map);

  var onChangeHandler = function() {
    calculateAndDisplayRoute(directionsService, directionsDisplay);
  };
  //document.getElementById('sel').addEventListener('change', onChangeHandler);
  //document.getElementsByClassName('ClassSel')[0].addEventListener('click', onChangeHandler);
  document.getElementById('calc').addEventListener('click', onChangeHandler);
}

var waypts=[];


function sistemaTappe(data_str,luogo_str){
	waypts=[];
	//console.log(luogo_str);
	if(data_str[data_str.length-1]==':'){
		data_str=data_str.substring(0,data_str.length-1);
	}
	if(data_str[0]==':'){
		data_str=data_str.substring(1,data_str.length);
	}
	if(luogo_str[luogo_str.length-1]==':'){
		luogo_str=luogo_str.substring(0,luogo_str.length-1);
	}
	if(luogo_str[0]==':'){
		luogo_str=luogo_str.substring(1,luogo_str.length);
	}
	
	//console.log(luogo_str);
	luoghi=luogo_str.split(":");
	
	//data=data_str.split(":");
	//$('#luogo_str').val(luogo.join(':'));
	console.log(luoghi);
	for(i=0;i<luoghi.length;i++){
		if(luoghi[i][2]==','){
			//alert('i = '+i)
			str2match=luoghi[i].substring(0,2);
			//alert(str2match)
			matched=0;
			for(j=0;j<ls_negozi.length && !matched;j++){
				if (ls_negozi[j].codice==str2match){
					if (ls_negozi[j].google_indirizzo != null){
						//alert(luoghi[i].substring(4,luoghi[i].length-1));
					luoghi[i]=ls_negozi[j].google_indirizzo;
					matched=1;
					}
				}
			}
			if (!matched){
				tmp_str=luoghi[i];
				//alert(tmp_str.length);
				luoghi[i]=tmp_str.substring(4,tmp_str.length);
			}
		}
		if(i>0 && i< luoghi.length-1){
			waypts.push({
				location: luoghi[i],
				stopover: true
			});
		}
	}
	console.log(luoghi);
	return luoghi;
}
	  
function calculateAndDisplayRoute(directionsService, directionsDisplay) {
	$("#win_auto_save").css("display","block");
	data_str=$("#data_str").val();
	luogo_str=$("#luogo_str").val();
	data_str=data_str.replace(/:+/g,':');
	luogo_str=luogo_str.replace(/:+/g,':');
	if(data_str == ':' || luogo_str == ':'){
		//todo
		alert('Tappe Non Inserite Correttamente (verificare le date) ');
	}else{
	luoghi=sistemaTappe(data_str,luogo_str);
  directionsService.route({
    origin: luoghi[0],//document.getElementById('start').value,
	waypoints: waypts,
    destination: luoghi[luoghi.length-1],//document.getElementById('end').value,
    travelMode: google.maps.TravelMode.DRIVING
  }, function(response, status) {
    if (status === google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(response);
	  console.log('response');
	  kms=[];
	  total=0;
	  for(i=0;i<response.routes[0].legs.length;i++){
		kms[i]=response.routes[0].legs[i].distance.value/1000;  
		total += kms[i];
	  }
	  $("#tot_km").val(total);
	  console.log(kms);
	  //$("#kms_str").val(kms.join(':'))
	  $("#kms_str").val(total);
    } else {
      window.alert('Directions request failed due to ' + status);
    }
  });
	}
}


function shortcut_onload(){
	//shortcut("enter",on_enter,{type:'keydown',propagate:false,target:'f1'});
	/*shortcut("F9",cerca);*/
	shortcut("esc",win_close);
	//$('#f1').focus();
	//$("#f2").datepicker();
}
function test_alert(){alert('testa')};
function win_close(){pi.win.close();}

$(document).ready(shortcut_onload);

function on_enter(){
	if($("#on_keypress_enter_first").length){
		$("#on_keypress_enter_first").click()
	}else{
		if($("#on_keypress_enter").length){
			$("#on_keypress_enter").click()
		}
	}
}
function ShowSelection()
{
  var textComponent = document.getElementById('Editor');
  var selectedText;
  // IE version
  if (document.selection != undefined)
  {
    textComponent.focus();
    var sel = document.selection.createRange();
    selectedText = sel.text;
  }
  // Mozilla version
  // else if (textComponent.selectionStart != undefined)
  // {
    // var startPos = textComponent.selectionStart;
    // var endPos = textComponent.selectionEnd;
    // selectedText = textComponent.value.substring(startPos, endPos)
  // }
  alert("You selected: " + selectedText);
}
function test(){
	//$("#id_desc").getSelection;
	//area.innerHTML='&lt;strong&gt;asdasdasd&lt;/strong&gt;';
	asd=$("#id_desc").getSelection
	alert(asd);
}

function tx_id(x,cont,id){
    id=id||'';
    str_id='';
	if(id!=''){
		str_id = ' id="'+id+'"';
	}
	return '<t'+x+str_id+'>'+cont+'</t'+x+'>';
}


function dett_html_id2(id){ //uguale alla html_id2, ma con aggiunto il campo KM
	out_str=tx_id('r',
		tx_id('h',
		'Luogo'
		)+tx_id('d class="orange" ',
		'<input class="key_prevented" onchange="tappa_edit('+id+')" id="luogo_id_'+id+'" name="luogo" type="text" value="" />'
		)+tx_id('d class="orange"',
		'<select id="sel_neg_trasf_itin_'+id+'" onchange="Trasf_Itin_Load_Select('+id+')"><option selected value="">Negozio</option>'+json2option()+'</select>'
		)+tx_id('h',
		'Data'
		)+tx_id('d class="orange"',
		'<input onchange="tappa_edit('+id+')" id="data_id_'+id+'" name="datatime" type="text" value=""/>'
		//)+tx_id('h',
		//'Km'
		//)+tx_id('d class="orange"',
		//'<input onchange="tappa_edit('+id+')" id="km_id_'+id+'" name="km" type="text" readonly/>'
		)+tx_id('d class="orange"',
		'<button onclick="tappa_del('+id+')" style="cursor:pointer;" class="del icon"><div></div></button>'
		),'tappa_id_'+id+'');
	return out_str;
}


function html_id2(id){
	out_str=tx_id('r',
		tx_id('h',
		'Luogo'
		)+tx_id('d class="orange" ',
		'<input class="key_prevented" onchange="tappa_edit('+id+')" id="luogo_id_'+id+'" name="luogo" type="text" value="" />'
		)+tx_id('d class="orange"',
		'<select id="sel_neg_trasf_itin_'+id+'" onchange="Trasf_Itin_Load_Select('+id+')"><option selected value="">Negozio</option>'+json2option()+'</select>'
		)+tx_id('h',
		'Data'
		)+tx_id('d class="orange"',
		'<input onchange="tappa_edit('+id+')" id="data_id_'+id+'" name="datatime" type="text" value=""/>'
		)+tx_id('d class="orange"',
		'<button onclick="tappa_del('+id+')" style="cursor:pointer;" class="del icon"><div></div></button>'
		),'tappa_id_'+id+'');
	return out_str;
}
 function loadJSON() {
        var xhReq = new XMLHttpRequest();
        xhReq.open("GET", "http://www.poltronesofa.com/Ws/Service1.asmx/getNegoziGoogle", false);
        xhReq.send(null);
        var out = xhReq.responseXML;
        jsStr = xml2json(out);
        jsStr = jsStr.replace("undefined", "");
        var aon = JSON.parse(jsStr);
        lsnegozi = aon.ArrayOfNegozioGoogle.NegozioGoogle;
        n_neg = lsnegozi.length;
        console.log(lsnegozi);
        return lsnegozi;
    }

var n_neg=0;	
var ls_negozi = loadJSON();

function number_only(){
	$('.numeric').keypress(function(e){
	if(e.which==46){ //.
		return 46;
	}
	if(e.which==44){ //,
		this.value = this.value+'.';
		return false;
	}
	if(e.which<48 || e.which>57){ //only numbers
		return false;
	}
	});
}

function key_prevent(classname){
	$('.'+classname).keypress(function(e){
	if(e.which==58 || e.which==39){
		return false;
	}});
}

function configure(id,luogo,data){
	$('#data_id_'+id).datepicker()
	$("#luogo_str").val($("#luogo_str").val()+luogo+":");
	$("#data_str").val($("#data_str").val()+data+":");
}

function json2option(){
	str_out='';
	for(i=0;i<n_neg;i++){
		c_neg=ls_negozi[i];
		str_out+='<option value="'+c_neg.codice+', '+c_neg.citta.replace('\'',' ')+'">'+c_neg.citta+'</option>';
	}
	return str_out;
}


function tappa_edit(id){
	//alert(id);
	luogo[id]=$('#luogo_id_'+id).val();$('#luogo_str').val(luogo.join(':'));
	data[id]=$('#data_id_'+id).val();$("#data_str").val(data.join(':'));
	//verificare se non da problemi nell'aggiunta di tappe alla trasferta
	//kms[id]=$('#km_id_'+id).val();$("#kms_str").val(kms.join(':'));
}


function Trasf_Itin_Load_Select(id){
	$('#luogo_id_'+id).val($('#sel_neg_trasf_itin_'+id).val());
	tappa_edit(id);
}

function tappa_add(id){
	//id=100;
	$('#list').append(html_id2(id));
	$('#data_id_'+id).datepicker();
	$('#button_cont').html('<button onclick="tappa_add('+(id+1)+')" style="cursor:pointer;" class="plus"><div>Nuova Tappa</div></button>');
	//$('#button_cont').html('');
	key_prevent("key_prevented");
}

function dett_tappa_add(id){
	//id=100;
	$('#list').append(dett_html_id2(id));
	$('#data_id_'+id).datepicker();
	$('#button_cont').html('<button onclick="dett_tappa_add('+(id+1)+')" style="cursor:pointer;" class="plus"><div>Nuova Tappa</div></button>');
	//$('#button_cont').html('');
	key_prevent("key_prevented");
	
}

function natura_select(id_natura,id_dett){
	//alert(id_natura);
	id_natura=parseInt(id_natura);
	//if (id_natura>2){
	//	$("#id_app0").css("visibility","visible");
	//	$("#id_app1").css("visibility","visible");
	//	switch (id_natura)
	//	{
	//	case 3:
	//		pi.requestQ('wallet','Dett_Win_Hotel');
	//		break;
	//	case 4:
	//		pi.requestQ('wallet','Dett_Win_Auto');
	//		break;
	//	case 5:
	//		pi.requestQ('wallet','Dett_Win_Auto');
	//		break;
	//	}
	//}else{
	//	$("#id_app0").css("visibility","hidden");
	//	$("#id_app1").css("visibility","hidden");
	//}
	pi.requestQ("transazione","Trans_Edit_Db_New");
	//trans_Edit("id_dett");
}

function update_wallet(name,value){
	$('#'+name).val(value);
	//alert(name+'='+value);
}

function trans_Edit(id,id_hotel,id_hotel_padre){
	update_wallet("wall_id_trans",id);
	update_wallet("wall_id_hotel",id_hotel);
	update_wallet("wall_id_hotel_padre",id_hotel_padre);
	pi.requestQ("wallet","Trans_Edit");
}

function amm_Trans_Edit(id){
	update_wallet("wall_id_trans",id);
	pi.requestQ("wallet","Amm_Trans_Edit");
}

function Trans_Load_Button_Plus(){
	
}

function tappa_del(id){
	$('#tappa_id_'+id).hide(250);
	luogo[id]='';$('#luogo_str').val(luogo.join(':'));
	data[id]='';$("#data_str").val(data.join(':'));
}

//function invokeWs(url) {
//		xhReq = new XMLHttpRequest();
//        xhReq.open("GET", url, false);
//        xhReq.send(null);
//        jsStr = xhReq.response;
//        jsStr = jsStr.replace(/<.*>/g, "");
//        var out = JSON.parse(jsStr);
//        return out;
//    }

function calcHotel(){

	var n_notti=parseInt($("#n_notti").val());
	var n_colazioni=parseInt($("#n_colazioni").val());
	var n_pranzi=parseInt($("#n_pranzi").val());
	var n_cene=parseInt($("#n_cene").val());
	var tot_notti=parseFloat($("#tot_notti").val());
	var tot_colazioni=parseFloat($("#tot_colazioni").val());
	var tot_pranzi=parseFloat($("#tot_pranzi").val());
	var tot_cene=parseFloat($("#tot_cene").val());
	var altro=parseFloat($("#altro").val());
	var totale_fattura=parseFloat($("#totale_fattura").val());
	//var totale=$("#totale").val();
	
	$("#totale").val(tot_colazioni +tot_pranzi +tot_cene +altro +tot_notti);
	var totale=parseFloat($("#totale").val());
	if(totale==totale_fattura){
		$("#hotel_save").css("display","inline");
		$("#hotel_error").css("display","none");
	}else{
		$("#hotel_save").css("display","none");
		$("#hotel_error").css("display","inline");
	}
	
}
function append_id(_id,id_trans){
	if(isNaN(id_trans)){
		id_trans=0;
	}
	if($("#"+_id).val()==""){
		$("#"+_id).val(id_trans);
	}else{
		$("#"+_id).val($("#"+_id).val()+":"+id_trans);
	}
	console.log(_id+"="+id_trans);
}
function update_importi(){
	$("#wall_importi_approv").val("");
	arr_id=String($("#wall_id_importi_approv").val()).split(":");
	for(i=0;i<arr_id.length;i++){
		append_id("wall_importi_approv",$("#importo_approvato_"+arr_id[i]).val());
	}
}
function transAlert(){
	html='';
	html+='<h1><i class="fa fa-exclamation-triangle fa-3x"></i></h1>';
	html+='<h3>Transazione già chiusa. Contattare l\'Amministrazione</h3>';
	//pi.win.open(html);
	pi.requestQ("transAlert","Trans_Alert");
}


(function() {

	var fieldSelection = {

		getSelection: function() {

			var e = (this.jquery) ? this[0] : this;

			return (

				/* mozilla / dom 3.0 */
				('selectionStart' in e && function() {
					var l = e.selectionEnd - e.selectionStart;
					return { start: e.selectionStart, end: e.selectionEnd, length: l, text: e.value.substr(e.selectionStart, l) };
				}) ||

				/* exploder */
				(document.selection && function() {

					e.focus();

					var r = document.selection.createRange();
					if (r === null) {
						return { start: 0, end: e.value.length, length: 0 }
					}

					var re = e.createTextRange();
					var rc = re.duplicate();
					re.moveToBookmark(r.getBookmark());
					rc.setEndPoint('EndToStart', re);

					return { start: rc.text.length, end: rc.text.length + r.text.length, length: r.text.length, text: r.text };
				}) ||

				/* browser not supported */
				function() { return null; }

			)();

		},

		replaceSelection: function() {

			var e = (typeof this.id == 'function') ? this.get(0) : this;
			var text = arguments[0] || '';

			return (

				/* mozilla / dom 3.0 */
				('selectionStart' in e && function() {
					e.value = e.value.substr(0, e.selectionStart) + text + e.value.substr(e.selectionEnd, e.value.length);
					return this;
				}) ||

				/* exploder */
				(document.selection && function() {
					e.focus();
					document.selection.createRange().text = text;
					return this;
				}) ||

				/* browser not supported */
				function() {
					e.value += text;
					return jQuery(e);
				}

			)();

		}

	};

	jQuery.each(fieldSelection, function(i) { jQuery.fn[i] = this; });

})();



