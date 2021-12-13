<script>
function funcion(){
    if(document.formulario.box.checked == true){
        document.formulario.nombre.disabled = false;
        document.formulario.campo2.disabled = false;
    }
    else{
        document.formulario.nombre.disabled = true;
        document.formulario.campo2.disabled = true;
    }
}
</script>
<form name="formulario">
<input type="checkbox" name="box" onclick="funcion()" />
<input type="text" name="nombre" disabled />
<input type="text" name="campo2" disabled />
</form>
