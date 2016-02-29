<script>
function toggle_id_save(_id){
	if($('#importo_to_save_'+_id).val()==1){
		$('#importo_to_save_'+_id).val('0');
		$('#id_dett'+_id).removeClass('to-save');
	}else{
		$('#importo_to_save_'+_id).val('1');
		$('#id_dett'+_id).addClass('to-save');
	}
}
update_wallet('wall_id_trasf','[id_trasf]');
update_wallet('wall_totale','[totale]');
update_wallet('wall_totale_ob','[totale_ob]');
update_wallet('wall_data','[data]');
// update_wallet(\'wall_id_trans\',0);
</script>