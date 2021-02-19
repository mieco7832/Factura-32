<!DOCTYPE html>
<html>
    <head>
        <title>App - Factura</title>
        <link rel="icon" type="image/png" href="resources/img/btn-logo.png">
        <link rel="stylesheet" href="resources/css/bootstrap.min.css">
        <link rel="stylesheet" href="resources/css/other.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">   
    </head>
    <body>
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
            <div class="toast-header">
                <strong class="mr-auto">Notificación &nbsp</strong>
                <small class="text-muted"></small>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body text-left">
            </div>
        </div>
        <div class="text-center load">
            <div class="spinner-border text-primary align-middle" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <nav class="navbar navbar-light bg-light border-bottom sticky-top">
            <a class="navbar-brand" href="./app">
                <img src="resources/img/btn-logo.png" width="60" height="60" alt="">
            </a>
            <div class="dropdown ml-auto" style="margin-right: 25px;">
                <button type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown">
                    Opciones
                </button>
                <div class="dropdown-menu">
                    <button type="button" class="dropdown-item" onclick="setting()">Factura</button>
                    <button type="button" class="dropdown-item" onclick="history()">Historial</button>
                    <button type="button" class="dropdown-item">Tema</button>
                </div>
            </div>
        </nav>
        <div class="br"></div>
        <div class="container">
            <div class="row">
                <div class="col-xl-6">
                    <div class="row">
                        <div class="col-xl-6">
                            <h3>Factura</h3>
                        </div>
                        <div class="col-xl-4"></div>
                        <div class="col-xl-2"></div>
                    </div>
                </div>
                <div class="col-xl-6"></div>
            </div>
            <div class="br"></div>
            <div class="row">
                <div class="col-xl-4">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Nombre del Cliente" id="nombre" maxlength="50">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Nombre</span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" data-mask="0000 0000 0000" placeholder="Número Teléfono (Opcional)" id="telefono">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Tel.</span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Correo Electrónico (Opcional)" id="mail" maxlength="50">
                        <div class="input-group-prepend">
                            <span class="input-group-text">@</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Descripción del Producto" id="concepto" maxlength="120">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Concepto</span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="input-group mb-3">
                        <input type="number" min=".01" max="9999999999.99" step=".01" class="form-control" placeholder="0.00" id="precio">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="input-group mb-3">
                        <input type="number" min="1" class="form-control" placeholder="Cantidad" id="cantidad">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Cantidad</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-2">
                    <button id="agregar" type="button" class="btn btn-primary">Agregar</button>
                </div>
                <div class="col-xl-10"></div>
            </div>
            <div class="row">
                <div class="col-xl" style="width: 100vw;">
                    <table class="table" id="table-1">
                        <thead>
                            <tr>
                                <th style="width: 10%;">#</th>
                                <th style="width: 50%;">Concepto</th>
                                <th style="width: 10%;">Cantidad</th>
                                <th style="width: 10%;">Precio/u</th>
                                <th style="width: 10%;">Precio</th>
                                <th style="width: 10%;">Acciones</th>
                            </tr>
                        </thead>
                    </table>
                    <div class="overflow-auto" style="height: 35vh;">
                        <table class="table" id="table-2">
                            <tbody class='items'>
                                <tr id="init">
                                    <td colspan="5">Agrega productos</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <table class="table" id="table-3">
                        <tfoot>
                            <tr>
                                <th scope="col" style="width: 90%;">Total</th>
                                <th scope="col" style="width: 10%;" id="sum-total">$ 0.00</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-xl text-left">
                    <button type="button" class="btn btn-success" onclick="getDataPdf()">Verificar</button>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade modalrg" tabindex="-1" role="dialog"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Factura</h5>
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </div>
        <script src="resources/js/jquery-3.1.1.min.js"></script>
        <script src="resources/js/bootstrap.min.js"></script>
        <script src="resources/js/popper.min.js"></script>
        <script src="resources/js/html2pdf.bundle.min.js"></script>
        <script src="resources/js/functions.js" type="text/javascript"></script>
        <script src="resources/js/function_nav.js" type="text/javascript"></script>
        <script src="resources/js/function_form.js" type="text/javascript"></script>
        <script src="resources/js/function_info.js" type="text/javascript"></script>
        <script src="resources/js/function_record.js" type="text/javascript"></script>
        <script src="resources/js/jquery.mask.min.js" type="text/javascript"></script>
    </body>
</html>