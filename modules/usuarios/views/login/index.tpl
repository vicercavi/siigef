
<div class="container">
    <div class="row">  
        <div class="center-block col-md-4 " style="float: none;">  
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{$lenguaje.label_welcome|default}</h3>
                </div>
                <div class="panel-body">
                    <form role="form"method="post">
                        <fieldset>
                            <p>{$lenguaje.label_iniciar|default}</p>
                            <div class="form-group">
                                <input class="form-control" type="text" id="usuario" name="usuario" value="{$usuario|default:""}" placeholder="User" required/>

                            </div>
                            <div class="form-group">
                                <input class="form-control" type="password"  id="pass" name="pass" placeholder="Password" required/>                             
                            </div>   
                            <div class="form-group">
                                <button id="logear"  name="logear" class="btn btn-sm btn-success" type="submit" value="Login" >Login</button>
                            </div>    
                            <!-- Change this to a button or input when using this as a form -->


                        </fieldset>
                    </form>
                </div>
            </div>

        </div>
    </div>


</div>
