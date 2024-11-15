
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require 'layauts/head.php'; ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <?php require 'layauts/preloader.php'; ?>
  <?php require 'layauts/navbar.php'; ?>
  <?php require 'layauts/sidebar.php'; ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Validation</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Validation</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Quick Example <small>jQuery Validation</small></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="quickForm" action="../Controller/user_controller.php?action=crear" method="POST" >
                <div class="card-body">
                  <div class="form-group">
                    <label for="PrimerNombre">Nombre:</label>
                    <input type="text" name="Nombre" class="form-control" id="primerNombre" placeholder="Primer nombre">
                  </div>
                  <div class="form-group">
                    <label for="correo">Email:</label>
                    <input type="text" name="Email" class="form-control" id="correo" placeholder="Correo electrónico">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">Clave:</label>
                    <input type="password" name="Clave" class="form-control" id="exampleInputPassword1" placeholder="Password">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Clave:</label>
                    <input type="password" name="Clave2" class="form-control" id="exampleInputPassword1" placeholder="Password">
                  </div>
                  <div class="form-group">
                    <label for="preguntaSeguridad" >Pregunta de seguridad</label>
                    <br>
                    <select name="PreguntaS" class="form-control" id="preguntaSeguridad" required="required" >
                      <option>Selecciona</option>
                      <option>Nombre de tu primera mascota</option>
                      <option>Fecha de nacimiento de alguno de tus padres</option>
                      <option>Comida favorita</option>
                      <option>Color favorito</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="correo">Respuestas:</label>
                    <input type="text"   name="Respuesta" class="form-control" placeholder="Respuesta" required="required" />
                  </div>


                  <div class="form-group mb-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="terms" class="custom-control-input" id="exampleCheck1">
                      <label class="custom-control-label" for="exampleCheck1">I agree to the <a href="#">terms of service</a>.</label>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php require 'layauts/footer.php'; ?>
  <?php require 'layauts/sidebar-dark.php'; ?>
</div>
<!-- ./wrapper -->
<?php require 'layauts/script.php'; ?>
<!-- jquery-validation -->
<script src="../plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="../plugins/jquery-validation/additional-methods.min.js"></script>
<!-- jquery-validation -->
<script>
  $(function () {
    $.validator.setDefaults({
      submitHandler: function () {
        alert( "Form successful submitted!" );
        submit();
      }
    });
    $('#quickForm').validate({
      rules: {
        email: {
          required: true,
          email: true,
        },
        password: {
          required: true,
          minlength: 5
        },
        terms: {
          required: true
        },
      },
      messages: {
        email: {
          required: "Please enter a email address",
          email: "Please enter a valid email address"
        },
        password: {
          required: "Please provide a password",
          minlength: "Your password must be at least 5 characters long"
        },
        terms: "Please accept our terms"
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    });
  });
</script>
</body>
</html>
