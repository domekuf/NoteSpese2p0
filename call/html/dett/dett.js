var soglia=[soglia];
var importo_richiesto=[importo_richiesto];
var limite_spesa=[limite_spesa];
var sforo = importo_richiesto-limite_spesa;
$("#ob1_[id_dett]").html(parseFloat(Math.round(sforo * 100) / 100).toFixed(2));

if (sforo>0){
	$("#ob1_[id_dett]").addClass("over");
	$("#ob2_[id_dett]").addClass("over");
	$("#ob2_[id_dett]").html(parseFloat(Math.round(sforo * 100) / 100).toFixed(2) + '<i class="fa fa-exclamation-triangle"></i>');
}else{
	$("#ob1_[id_dett]").removeClass("over");
	$("#ob2_[id_dett]").removeClass("over");
	$("#ob2_[id_dett]").html(parseFloat(Math.round(sforo * 100) / 100).toFixed(2));
}