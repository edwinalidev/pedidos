<?php
include("template/header.php");
?>
 <style>
  body{
    background-color: #e9ecef;
  }
 </style>
<body>
<div class="container">
    <div class="row justify-content-center ">
      <div class="col-lg-5">
      <div class="card shadow-lg border-0 rounded-lg mt-5">
        <div class="text-center card-header p-0 m-0">
            <img  src="img/login128.jpg">
        </div>
        <div class="card-body">
            <form action="include/login.php" method="post" enctype="multipart/form" class="form-control"> 
            <div class="form-floating">
              <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                <option selected>Seleccione Sucursal</option>
                <option value="1">Sucursal 1</option>
                <option value="2">Miraflores</option>
                <option value="3">Sopocachi</option>
              </select>
              <label for="floatingSelect">Seleccione Sucursal</label>
            </div>
            <div class="form-floating my-3">
                <input type="email" class="form-control" id="Email" name="Email" placeholder="name@example.com" required>
                <label for="Email">Email address</label>
            </div>
            <div class="form-floating my-3">
                <input type="password" name="password" id="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                <label for="password">Password</label>
            </div>
              <div class="form-check">
                    <input class="form-check-input" id="rememberPasswordCheck" type="checkbox" />
                    <label class="form-check-label" for="rememberPasswordCheck">Recordar Contrase&ntilde;a</label>
              </div>
            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                <a class="small" href="#">Recuperar Contrase&ntilde;a?</a>
                <button class="btn btn-success px-5" type="submit">Ingresar</button>
            </div>
            </form>
        </div>
        <div class="card-footer text-center">
          <div class="small"><a href="#" class="btn btn-light btn-block">Registra nuevo usuario? Ingresar!</a></div>
        </div>
      </div>
    </div>
    </div>
</div>
  </body>
<?php
include("template/footer.php");
?>
</html>