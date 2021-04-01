<form method="POST" id="login_form" class="row row-eq-height lockscreen  mt-5 mb-5">
    <div class="lock-image col-12 col-sm-5"></div>
    <div class="login-form col-12 col-sm-7">
        <div class="form-group mb-3 text-center">
            <p>Por favor introduzca su usuario y contraseña para acceder a la aplicación.</p>
        </div>
    
        <div class="form-group mb-3">
            <label for="emailaddress">Usuario</label> 
            <input class="form-control" name="user" type="text"  required="" placeholder="Enter your email">
        </div>

        <div class="form-group mb-3">
            <label for="password">Contraseña</label>
            <input class="form-control" name="password" type="password" required="" id="password" placeholder="Enter your password">
        </div>

        <div class="form-group mb-3">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="checkbox-signin" checked="">
                <label class="custom-control-label" for="checkbox-signin">Remember me</label>
            </div>
        </div>

        <div class="form-group mb-0">
            <button class="btn btn-primary" type="button" onclick="login()"> Ingresar </button>
        </div>
        
        <!-- <div class="mt-2"> ¿Olvidaste tu contraseña? 
            <p> <a href="Login/PasswordRecovery">Recuperar Contraseña</a> </p>
        </div> -->
        
    </div>
</form>