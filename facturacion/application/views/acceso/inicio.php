<div align="center" style="font-size: 27px">SISTEMA GENERAL GRUPO TYTL</div>
<div class="container">
    <div class="row">
        <div style="font-family: tahoma; font-size: 20px" class="col-md-6">
            <span>Bienvenido:</span><?PHP echo " " . ucfirst($this->session->userdata('tipo_empleado')) . "&nbsp;&nbsp;&nbsp;" . $this->session->userdata('usuario') . ", " . $this->session->userdata('apellido_paterno'); ?>&nbsp;&nbsp;&nbsp;
        </div>
        <div class="col-md-6">
            <?PHP
            if ($this->session->userdata('tipo_empleado_id') != 1 && $this->session->userdata('tipo_empleado_id') != 2 && $this->session->userdata('tipo_empleado_id')!= 8 && $this->session->userdata('tipo_empleado_id')!= 9) { //secretaria, contabilidad o administrador no ingresan
                ?>
                <div align="center">
                    <a href="<?PHP echo base_url() ?>index.php/actividades/nuevo" class="btn btn-success btn-sm" role="button">Ingresar Nueva Actividad</a>
                </div>
                <?PHP
            }
            ?>            
        </div>
    </div>
    <hr>
</div>

<?PHP
if ($this->session->userdata('tipo_empleado_id') != 1 && $this->session->userdata('tipo_empleado_id') != 2 && $this->session->userdata('tipo_empleado_id')!= 8 && $this->session->userdata('tipo_empleado_id')!= 9) { //secretaria, contabilidad o administrador no ingresan
    ?>
    <link href='<?PHP echo base_url() ?>librerias_externas/fullcalendar/fullcalendar.css' rel='stylesheet' />
    <link href='<?PHP echo base_url() ?>librerias_externas/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
    <script src='<?PHP echo base_url() ?>librerias_externas/fullcalendar/lib/moment.min.js'></script>

    <script src='<?PHP echo base_url() ?>librerias_externas/fullcalendar/fullcalendar.min.js'></script>
    <script src='<?PHP echo base_url() ?>librerias_externas/fullcalendar/lang/es.js'></script>
    <script src='<?PHP echo base_url() ?>librerias_externas/fullcalendar/gcal.js'></script>
    <script>

        $(document).ready(function () {

            $('#calendar').fullCalendar({
                
                lang: 'es',
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                events: {
                    url: '<?PHP echo base_url() ?>index.php/actividades/json_calendario',
                    error: function () {
                        $('#script-warning').show();
                    }
                },
                eventClick: function (event) {
                    // opens events in a popup window
                    window.open(event.url, 'gcalevent', 'width=700,height=600');
                    return false;
                },
                loading: function (bool) {
                    $('#loading').toggle(bool);
                }
            });

        });

    </script>
    <style>

        body {
            margin: 0;
            padding: 0;
            font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
            font-size: 14px;
        }

        #script-warning {
            display: none;
            background: #eee;
            border-bottom: 1px solid #ddd;
            padding: 0 10px;
            line-height: 40px;
            text-align: center;
            font-weight: bold;
            font-size: 12px;
            color: red;
        }

        #loading {
            display: none;
            position: absolute;
            top: 10px;
            right: 10px;
        }

        #calendar {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 10px;
        }

    </style>



    <div id='script-warning'>
        <code>Cargando data.....</code> Buscando....
    </div>

    <div id='loading'>loading...</div>

    <div id='calendar'></div>

<?PHP
}
?>            