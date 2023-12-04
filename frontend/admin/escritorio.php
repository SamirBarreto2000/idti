<?php
ob_start();
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
  header('location: ../login.php');

  $id = $_SESSION['id'];
}
?>
<?php
require_once('../../backend/bd/Conexion.php');
$req = $connect->prepare("SELECT id, title, start, end, color FROM events");
$req->execute();
$events = $req->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <?php include_once("../includes/head.php") ?>
  <!-- FullCalendar -->
  <link href='../../backend/css/fullcalendar.css' rel='stylesheet' />
  <style type="text/css">
    #calendar {
      max-width: 1200px;
    }

    .col-centered {
      float: none;
      margin: 0 auto;
    }
  </style>

  <title>IDTI | Panel administrativo</title>
</head>

<body>

  <!-- SIDEBAR -->
  <?php include_once("../includes/slidebar.php") ?>
  <!-- SIDEBAR -->

  <!-- NAVBAR -->
  <section id="content">
    <!-- NAVBAR -->
    <nav style="background-color: #6BAEC8;">
      <i class='bx bx-menu toggle-sidebar' style="background-color: #1E2C4B; color: #1E2C4B;"></i>
      <form action="#">
        <div class="form-group">

        </div>
      </form>


      <span class="divider"></span>
      <div class="profile">
        <img
          src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixid=MnwxMjA3fDB8MHxzZWFyY2h8NHx8cGVvcGxlfGVufDB8fDB8fA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60"
          alt="">
        <ul class="profile-link">
          <li><a href="../profile/mostrar.php"><i class='bx bxs-user-circle icon'></i> Perfil</a></li>

          <li>
            <a href="../salir.php"><i class='bx bxs-log-out-circle'></i> Salir</a>
          </li>

        </ul>
      </div>
    </nav>


    <!-- NAVBAR -->

    <!-- MAIN -->
    <main>
      <h1 class="title">Bienvenido
        <?php echo '<strong>' . $_SESSION['username'] . '</strong>'; ?>
      </h1>

      <div class="info-data">
        <div class="card">
          <div class="head">
            <div>

              <?php
              $sql = "SELECT COUNT(*) total FROM patients";
              $result = $connect->query($sql); //$pdo sería el objeto conexión
              $total = $result->fetchColumn();

              ?>
              <h2>
                <?php echo $total; ?>
              </h2>
              <p>Pacientes</p>
            </div>
            <i class="bi bi-people" style="font-size: 30px"></i>
          </div>



        </div>


        <div class="card">
          <div class="head">
            <div>

              <?php
              $sql = "SELECT COUNT(*) total FROM doctor";
              $result = $connect->query($sql); //$pdo sería el objeto conexión
              $total = $result->fetchColumn();

              ?>
              <h2>
                <?php echo $total; ?>
              </h2>
              <p>Medicos</p>
            </div>
            <i class="bi bi-person-bounding-box" style="font-size: 30px"></i>
          </div>

        </div>



        <div class="card">
          <div class="head">
            <div>
              <?php
              $sql = "SELECT COUNT(*) total FROM users";
              $result = $connect->query($sql); //$pdo sería el objeto conexión
              $total = $result->fetchColumn();

              ?>
              <h2>
                <?php echo $total; ?>
              </h2>
              <p>Usuarios</p>
            </div>
            <i class="bi bi-person-workspace" style="font-size: 30px;"></i>
          </div>

        </div>


        <div class="card">
          <div class="head">
            <div>
              <?php
              $sql = "SELECT SUM(monto) total FROM events";
              $result = $connect->query($sql); //$pdo sería el objeto conexión
              $total = $result->fetchColumn();

              ?>
              <h2>S/.
                <?php echo $total; ?>
              </h2>
              <p>Citas</p>
            </div>
            <i class="bi bi-cash-stack" style="font-size: 30px;"></i>
          </div>
        </div>
      </div>






      <div class="data">
        <div class="content-data">
          <div class="table-responsive" style="overflow-x:auto;">
            <?php

            $sentencia = $connect->prepare("SELECT * FROM doctor ORDER BY idodc DESC LIMIT 10;");
            $sentencia->execute();
            $data = array();
            if ($sentencia) {
              while ($r = $sentencia->fetchObject()) {
                $data[] = $r;
              }
            }
            ?>
            <?php if (count($data) > 0): ?>
              <table id="example" class="responsive-table">
                <thead>
                  <tr>
                    <th style="text-align: center;" scope="col">Nuevos especialistas</th>
                    <th style="text-align: center;" scope="col">Especialidad</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($data as $d): ?>
                    <tr>

                      <td data-title="Paciente">
                        <?php echo $d->nodoc ?>&nbsp;
                        <?php echo $d->apdoc ?>
                      </td>
                      <td data-title="Especialidad">
                        <?php echo $d->nomesp ?>
                      </td>

                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            <?php else: ?>

              <div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                <strong>Danger!</strong> No hay datos.
              </div>
            <?php endif; ?>


          </div>

        </div>

        <div class="content-data">

          <div class="table-responsive" style="overflow-x:auto;">
            <?php

            $sentencia = $connect->prepare("SELECT * FROM patients ORDER BY idpa DESC LIMIT 10;");
            $sentencia->execute();
            $data = array();
            if ($sentencia) {
              while ($r = $sentencia->fetchObject()) {
                $data[] = $r;
              }
            }
            ?>
            <?php if (count($data) > 0): ?>
              <table id="example" class="responsive-table">
                <thead>
                  <tr>
                    <th style="text-align: center;" scope="col">Nuevos pacientes</th>

                  </tr>
                </thead>
                <tbody>

                  <?php foreach ($data as $d): ?>
                    <tr>

                      <td data-title="Paciente">
                        <?php echo $d->nompa ?>&nbsp;
                        <?php echo $d->apepa ?>
                      </td>

                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            <?php else: ?>

              <div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                <strong>Danger!</strong> No hay datos.
              </div>
            <?php endif; ?>


          </div>
        </div>
      </div>

      <div class="data">
        <div class="content-data">
          <div class="head">
            <h3><i class="bi bi-calendar-check"></i> &nbsp;Calendario de citas</h3> <hr>

          </div>
          <div id="calendar" class="col-centered">

          </div>
        </div>
      </div>



    </main>
    <!-- MAIN -->
  </section>
  <!-- NAVBAR -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script src="../../backend/js/script.js"></script>

  <!-- Data Tables -->
  <script src="../../backend/vendor/datatables/dataTables.min.js"></script>
  <script src="../../backend/vendor/datatables/dataTables.bootstrap.min.js"></script>


  <!-- Custom Data tables -->
  <script src="../../backend/vendor/datatables/custom/custom-datatables.js"></script>
  <script src="../../backend/vendor/datatables/custom/fixedHeader.js"></script>


  <!-- FullCalendar -->
  <script src='../../backend/js/moment.min.js'></script>
  <script src='../../backend/js/fullcalendar/fullcalendar.min.js'></script>
  <script src='../../backend/js/fullcalendar/fullcalendar.js'></script>
  <script src='../../backend/js/fullcalendar/locale/es.js'></script>

  <script>

    $(document).ready(function () {

      var date = new Date();
      var yyyy = date.getFullYear().toString();
      var mm = (date.getMonth() + 1).toString().length == 1 ? "0" + (date.getMonth() + 1).toString() : (date.getMonth() + 1).toString();
      var dd = (date.getDate()).toString().length == 1 ? "0" + (date.getDate()).toString() : (date.getDate()).toString();

      $('#calendar').fullCalendar({
        header: {
          language: 'es',
          left: 'prev,next today',
          center: 'title',
          right: 'month,basicWeek,basicDay',

        },
        defaultDate: yyyy + "-" + mm + "-" + dd,
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        selectable: true,
        selectHelper: true,
        select: function (start, end) {

          $('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
          $('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
          $('#ModalAdd').modal('show');
        },
        eventRender: function (event, element) {
          element.bind('dblclick', function () {
            $('#ModalEdit #id').val(event.id);
            $('#ModalEdit #title').val(event.title);
            $('#ModalEdit #color').val(event.color);
            $('#ModalEdit').modal('show');
          });
        },
        eventDrop: function (event, delta, revertFunc) { // si changement de position

          edit(event);

        },
        eventResize: function (event, dayDelta, minuteDelta, revertFunc) { // si changement de longueur

          edit(event);

        },
        events: [
          <?php foreach ($events as $event):

            $start = explode(" ", $event['start']);
            $end = explode(" ", $event['end']);
            if ($start[1] == '00:00:00') {
              $start = $start[0];
            } else {
              $start = $event['start'];
            }
            if ($end[1] == '00:00:00') {
              $end = $end[0];
            } else {
              $end = $event['end'];
            }
            ?>
              {
              id: '<?php echo $event['id']; ?>',
              title: '<?php echo $event['title']; ?>',
              start: '<?php echo $start; ?>',
              end: '<?php echo $end; ?>',
              color: '<?php echo $event['color']; ?>',
            },
          <?php endforeach; ?>
        ]
      });



    });

  </script>
</body>

</html>