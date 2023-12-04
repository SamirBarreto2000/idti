<?php
ob_start();
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header('location: ../login.php');

    $id = $_SESSION['id'];
}
?>



<!DOCTYPE html>
<html lang="es">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<?php include_once("../includes/head.php") ?>




<body>

    <!-- SIDEBAR -->
    <?php include_once("../includes/slidebar.php") ?>
    <!-- SIDEBAR -->

    <!-- NAVBAR -->
    <?php include_once("../includes/navbar.php") ?>
    <!-- NAVBAR -->



    <!-- MAIN -->
    <main>

        <button onclick="location.href='nuevo.php'" class="btn btn-secondary"><i class="bi bi-person-add"></i>
            &nbsp;Agregar paciente</button>

        <div class="data">
            <div class="content-data">
                <div class="head">
                    <h3 style="color: #1E2C4B;"><i class="bi bi-people"></i> | Listado de pacientes</h3>
                </div>


                <div class="table-responsive" style="overflow-x:auto;">
                    <?php
                    require '../../backend/bd/Conexion.php';
                    $sentencia = $connect->prepare("SELECT * FROM patients ORDER BY idpa DESC;");
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
                                    <th scope="col">
                                        <center>DNI</center>
                                    </th>
                                    <th scope="col">
                                        <center>Paciente</center>
                                    </th>
                                    <th scope="col">
                                        <center>Sexo</center>
                                    </th>
                                    <th scope="col">
                                        <center>Teléfono</center>
                                    </th>
                                    <th scope="col">
                                        <center>Estado</center>
                                    </th>
                                    <th scope="col">
                                        <center>Acciones</center>
                                    </th>
                                </tr>
                                <center>
                            </thead>


                            <tbody style="border: 0.5px  solid #6BAEC8;">
                                <?php foreach ($data as $d): ?>
                                    <tr style="border: 2px solid #E3E3E3;">
                                        <th scope="row" style="border: 0.5px  solid #6BAEC8;">
                                            <center>
                                                <?php echo $d->numhs ?>
                                            </center>
                                        </th>
                                        <td data-title="Paciente" style="border: 0.5px solid #6BAEC8;">
                                            <?php echo $d->nompa ?>&nbsp;
                                            <?php echo $d->apepa ?>
                                        </td>

                                        <td data-title="Sexo" style="border: 0.5px  solid #6BAEC8;">
                                            <?php echo $d->sex ?>
                                        </td>

                                        <td data-title="Teléfono" style="border: 0.5px  solid #6BAEC8;"><a
                                                style="color: #1E2C4B;" href="tel:<?php echo $d->phon ?>"><i
                                                    class="bi bi-whatsapp"></i>&nbsp;
                                                <?php echo $d->phon ?>
                                            </a></td>


                                        <td data-title="Estado" style="border: 1px solid #6BAEC8;">

                                            <label class="switch">
                                                <input type="checkbox" id="<?= $d->idpa ?>" value="<?= $d->state ?>"
                                                    <?= $d->state == '1' ? 'checked' : ''; ?> />

                                                <span class="slider"></span>
                                            </label>
                                        </td>
                                        <td style="border: 1px solid #6BAEC8;">

                                            <div class="dropdown">
                                                <button class="btn btn-dark dropdown-toggle btn-sm" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    Acciones
                                                </button>


                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"
                                                    style="font-size: 15px; font-size: 15px; box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.2);">
                                                    <a class="dropdown-item"
                                                        href="../pacientes/editar.php?id=<?php echo $d->idpa ?>"><i
                                                            class="bi bi-pencil-square"></i>&nbsp; Actualizar</a>
                                                    <a class="dropdown-item"
                                                        href="../pacientes/info.php?id=<?php echo $d->idpa ?>"><i
                                                            class="bi bi-exclamation-circle"></i>&nbsp; Detalles</a>
                                                    <a class="dropdown-item"
                                                        href="../pacientes/historia.php?id=<?php echo $d->idpa ?>"><i
                                                            class="bi bi-file-check"></i>&nbsp; Historial medico</a>
                                                    <a class="dropdown-item"
                                                        href="../pacientes/pago.php?id=<?php echo $d->idpa ?>"><i
                                                            class="bi bi-pencil-square"></i>&nbsp; Pagos</a>
                                                    <?php
                                                    if ($d->rol == '2') {
                                                        // code...
                                                        echo '<a class="dropdown-item" title="Cambiar contraseña"  href="../pacientes/password.php?id=' . $d->idpa . '"><i class="bi bi-eye-slash"></i>&nbsp; Contaseña</a>';
                                                    } else {
                                                        echo '<a class="dropdown-item" title="Crear perfil" href="../pacientes/crear.php?id=' . $d->idpa . '" ><i class="bi bi-person-add"></i>&nbsp; Usuario</a>';
                                                    }

                                                    ?>


                                                    <!-- <form onsubmit="return confirm('¿Realmente desea eliminar el registro?');"
                                                        method='POST' action='<?php $_SERVER['PHP_SELF'] ?>'>
                                                        <input type='hidden' name='idpa' value="<?php echo $d->idpa; ?>">

                                                        <button name='delete_patients' style="cursor: pointer;"
                                                            class="fa fa-trash"></button>
                                                    </form>  -->

                                                </div>
                                            </div>

                                            <!--  
                                       
                                          
                                            <a title="Pagos" 
                                                class="fa fa-money"></a>

                                            

                                            
 -->


                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>

                        <div class="alert">
                            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                            <strong>¡Alerta!</strong> No hay datos.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </main>
    <!-- MAIN -->
    </section>




    <?php include_once '../../backend/php/delete_patients.php' ?>
    <!-- NAVBAR -->
    <script src="../../backend/js/jquery.min.js"></script>

    <script src="../../backend/js/script.js"></script>

    <!-- Data Tables -->
    <script type="text/javascript" src="../../backend/js/datatable.js"></script>
    <script type="text/javascript" src="../../backend/js/datatablebuttons.js"></script>
    <script type="text/javascript" src="../../backend/js/jszip.js"></script>
    <script type="text/javascript" src="../../backend/js/pdfmake.js"></script>
    <script type="text/javascript" src="../../backend/js/vfs_fonts.js"></script>
    <script type="text/javascript" src="../../backend/js/buttonshtml5.js"></script>
    <script type="text/javascript" src="../../backend/js/buttonsprint.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'Copiar', 'csv', 'excel', 'pdf', 'Imprimir'
                ]
            });
        });
    </script>

    <script type="text/javascript">
        let popUp = document.getElementById("cookiePopup");
        //When user clicks the accept button
        document.getElementById("acceptCookie").addEventListener("click", () => {
            //Create date object
            let d = new Date();
            //Increment the current time by 1 minute (cookie will expire after 1 minute)
            d.setMinutes(2 + d.getMinutes());
            //Create Cookie withname = myCookieName, value = thisIsMyCookie and expiry time=1 minute
            document.cookie = "myCookieName=thisIsMyCookie; expires = " + d + ";";
            //Hide the popup
            popUp.classList.add("hide");
            popUp.classList.remove("shows");
        });
        //Check if cookie is already present
        const checkCookie = () => {
            //Read the cookie and split on "="
            let input = document.cookie.split("=");
            //Check for our cookie
            if (input[0] == "myCookieName") {
                //Hide the popup
                popUp.classList.add("hide");
                popUp.classList.remove("shows");
            } else {
                //Show the popup
                popUp.classList.add("shows");
                popUp.classList.remove("hide");
            }
        };
        //Check if cookie exists when page loads
        window.onload = () => {
            setTimeout(() => {
                checkCookie();
            }, 2000);
        };
    </script>

</body>


<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>

</html>