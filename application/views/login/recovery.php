<form method="POST" id="login_form" class="row row-eq-height lockscreen  mt-5 mb-5">
    <div class="lock-image col-12 col-sm-5"></div>
        <div class="login-form col-12 col-sm-7">
            <div class="form-group mb-3 text-center">
                <p>Por favor introduzca su correo electrónico para recuperar su contraseña.</p>
            </div>
                       
        <div class="form-group mb-3">
            <label for="emailaddress">Correo Electrónico</label> 
            <input class="form-control" name="email"  id="emailaddress" required="" placeholder="Escribe tu correo electrónico">
        </div>                              

        <div class="form-group mb-0">
            <button class="btn btn-primary" type="button" onclick="recuperar()"> Recuperar </button>
        </div>                          
                           
    </div>
</form>