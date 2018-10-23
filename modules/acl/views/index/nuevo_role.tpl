<div style="width: 75%; float:left; margin: 0px auto">
    <h4>NUEVO ROL</h4>
    <form class="form-horizontal" role="form" name="form1" action="" method="post" >
        <input type="hidden" name="guardar" value="1" />

        <div class="form-group">
            <div class="col-lg-10">
                <p><input class="form-control"  type="text" name="role" value="{$datos.role|default:""}" /></p>
            </div>
            <p><button class="btn btn-primary" type="submit"  ><i class="glyphicon glyphicon-ok"> </i>  Guardar</button></p>
        </div>
    </form>
</div>
    