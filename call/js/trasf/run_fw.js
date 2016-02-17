<script>
// \\portal1\shares\modules\CED\NoteSpese2p0\call\js\trasf
function run_fw(nro_reg){
    var objReq = new XMLHttpRequest();
    objReq.open("GET", "http://localhost:8888?nro_reg=" + nro_reg, true);
    objReq.send(null);
}
</script>