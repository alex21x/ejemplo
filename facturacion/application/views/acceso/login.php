<script type="text/javascript">
            function getCookie(cname) {
                var name = cname + "=";
                var ca = document.cookie.split(';');
                for(var i=0; i<ca.length; i++) {
                    var c = ca[i];
                    while (c.charAt(0)==' ') c = c.substring(1);
                    if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
                }
                return "";
            }
            
            
            var x = document.cookie;
            var y = getCookie('cookie');
        </script>
<h1 align="center">FACTURACION GRUPO TYTL</h1>
<br>
<p class="bg-info" align="center">
<?PHP echo $this->session->flashdata('mensaje');?>
</p>

<?PHP 
if(isset($redireccion)){
echo $redireccion;
}
?>
<div class="container">
    <div class="row">                
        <div class="col-md-3">
        </div>
        <div class="col-md-6">

            <form class="form-signin" role="form" method="post" action="<?PHP echo base_url(); ?>index.php/acceso/login">
                <h2 class="form-signin-heading">Clave de acceso</h2>
                <input class="form-control" type="password" autofocus="" required="" placeholder="Contraseña" name="usuario" id="usuario" value="<?PHP if(isset($dni)) echo $dni;?>">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" checked="" name="recordar" value="recordar">Recordarme
                    </label>
                </div>        
                <input type="submit" class="btn btn-lg btn-primary btn-block" value="Ingresar"/>
            </form>
        </div>
    </div>
    <div class="col-md-3">
    </div>
</div>