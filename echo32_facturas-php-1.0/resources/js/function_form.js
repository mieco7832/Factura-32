$("#agregar").on("click", function () {
    let concepto = $("#concepto").val();
    let precio = $("#precio").val();
    let cantidad = $("#cantidad").val();
    let tdCount = 0;
    if ($('.counter-td')) {
        tdCount = $('.counter-td').length;
    }
    if (cantidad <= 0 || cantidad === "") {
        $('#cantidad').addClass("is-invalid");
        getToast("Cantidad no valida o esta vacío", "#FFFFFF");
        setTimeout(function () {
            $('#cantidad').removeClass("is-invalid");
        }, 3000);
    }

    if (precio <= 0.009) {
        $('#precio').addClass("is-invalid");
        getToast("El valor no es valido o esta vacío", "#FFFFFF");
        setTimeout(function () {
            $('#precio').removeClass("is-invalid");
        }, 3000);
    }

    if (concepto === "") {
        $('#concepto').addClass("is-invalid");
        getToast("Hacen falta campos por llenar", "#FFFFFF");
        setTimeout(function () {
            $('#concepto').removeClass("is-invalid");
        }, 3000);
    }

    if (concepto !== "" && precio >= 0.01 && cantidad >= 1) {
        $.ajax({
            url: "app/Get.php?newItem",
            method: "POST",
            data: {concepto, precio, cantidad, tdCount}
        }).done(function (data) {
            let sum = 0;
            if (data !== "[]") {
                $.when($("#init")).then(function () {
                    $('#table-2 tbody').children().remove("#init");
                });
                $("#table-2 tbody").append(data);
                $('.sum').each(function () {
                    sum += parseFloat($(this).text());
                });
                $('#sum-total').text("$ " + parseFloat(sum).toFixed(2));
            } else {
                if (!$("#init")) {
                    $("#items").html("<tr id='init'><td>Agrega productos</td></tr>");
                }
            }
        });
        $("#concepto").val("");
        $("#precio").val("");
        $("#cantidad").val("");
    }
});
function remove(btn) {
    $($(btn).parent().parent()).remove();
    let sum = 0;
    let num = 1;
    $('.sum').each(function () {
        sum += parseFloat($(this).text());
    });
    $('.counter-td').each(function () {
        $(this).text(num++);
    });
    $('#sum-total').text("$ " + parseFloat(sum).toFixed(2));
    setTimeout(function () {
        if ($("tbody.items").children().length === 0) {
            $(".items").html("<tr id='init'><td>Agrega productos</td></tr>");
        }
    }, 1000);
}

function getDataPdf() {
    if ($("#client").val() !== "") {
        if (!document.getElementById("init")) {

            $.ajax({
                url: "app/Get.php?getData",
                method: "POST"
            }).done(function (data) {
                $(".modal").modal('show');
                $(".modal-body").html(data);
                let sum = 0;
                $("#clientName").text($("#nombre").val());
                $("#clientTel").text($("#telefono").val());
                $("#clientMail").text($("#mail").val());
                $("#fecha").text(getNow());
                let tbody = $(".items").html();
                $("#invoice table tbody").html(tbody);
                $("#invoice table tbody tr").each(function () {
                    $(this).children("td.acctions").remove();
                });
                $('#invoice table .sum').each(function () {
                    sum += parseFloat($(this).text());
                });
                $('#totalInvoice').text("$ " + parseFloat(sum).toFixed(2));
                $(".modal-footer").html("<button type='button' class='btn btn-success' onclick='generatePDF()'>Crear Factura</button>");
                $(".modal-title").text("Factura");
            });
        } else {
            getToast("La factura no posee conceptos", "#FFFFFF");
        }
    } else {
        $('#client').addClass("is-invalid");
        getToast("Agrega un nombre a la factura", "#F2D7D5");
        setTimeout(function () {
            $('#client').removeClass("is-invalid");
        }, 3000);
    }
}

function generatePDF() {
    let element = document.getElementById("invoice");
    let fecha = $("#fecha").text();
    let concepto = "";
    let precio = "";
    let cantidad = "";
    let clientName = $("#clientName").text();
    let clientTel = $("#clientTel").text();
    let clientMail = $("#clientMail").text();
    $("#factura-pdf > tbody > tr").each(function () {
        $(this).map(function () {
            concepto = this.children[1].innerHTML;
            precio = this.children[3].innerHTML;
            cantidad = this.children[2].innerHTML;
            $.ajax({
                url: "app/Get.php?create",
                method: "POST",
                data: {concepto, precio, cantidad, clientName, clientTel, clientMail, fecha}
            });
        });
    });
    toPDF(element);
}
var f;
function toPDF(element) {
    var opt = {
        margin: 0.5,
        filename: 'invoice ' + getNow() + ".pdf",
        image: {type: 'jpeg', quality: 0.98},
        html2canvas: {scale: 2},
        jsPDF: {unit: 'in', format: 'letter', orientation: 'portrait'}
    };
    f = html2pdf().set(opt).from(element).save();

}

$('.modal').on('hidden.bs.modal', function (e) {
    if (f !== undefined) {
        window.location.href = "./";
    }
});