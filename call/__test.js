function html_id(){
	
	return	\'<tr class="new"><th>Luogo</th><td class="orange"><input id="luogo_id" name="luogo" type="text" value="" /></td><td class="orange"><select onchange="$(\'#luogo_id\').val($(this).val())"><option selected value="">Negozio</option>'.$lista_negozi.'</select></td><th>Data</th><td class="orange"><input id="data_id_new" name="datatime" type="text" value=""/></td><script>$(\'#data_id_new\').datepicker()<button onclick="tappa_del(0)" style="cursor:pointer;" class="del icon"><div></div></button></tr>\';
}


function html_id(){
			out_str=\'\';
			out_str+=\'<tr class="new">\'
			out_str+=\'<th>Luogo</th>\'
			out_str+=\'<td class="orange"><input id="luogo_id" name="luogo" type="text" value="" /></td>\'
			out_str+=\'<td class="orange">\'
			out_str+=\'<select onchange="$(\'#luogo_id\').val($(this).val())"><option selected value="">Negozio</option>\'
			out_str+=\''.$lista_negozi.'\'
			out_str+=\'</select>\'
			out_str+=\'</td>\'
			out_str+=\'<th>Data</th>\'
			out_str+=\'<td class="orange">\'
			out_str+=\'<input id="data_id_new" name="datatime" type="text" value=""/></td>\'
			out_str+=\'<script>$(\'#data_id_new\').datepicker()\'
			out_str+=\'<button onclick="tappa_del(0)" style="cursor:pointer;" class="del icon">\'
			out_str+=\'<div></div>\'
			out_str+=\'</button>\'
			out_str+=\'</tr>\';
			return out_str;
}


			out_str+=\''.str_replace('""','\'',$lista_negozi).'\';