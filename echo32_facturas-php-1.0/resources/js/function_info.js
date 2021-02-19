function setting() {
    $(".modal").modal("show");
    $(".modal-footer").html("<div id='alert'></div><button type='button' class='btn btn-success' onclick='setInfo()'>Guardar</button>");
    $(".modal-title").text("Factura");
    $.ajax({
        url: "app/Get.php?info",
        method: "POST"
    }).done(function (data) {
        $(".modal-body").html(data);
        setTimeout(function () {
            $("#input-tel").mask("0000 0000 0000");
        }, 1000);
    });
}

function getLoad() {
    $("#img-ch").removeAttr("disabled");
    $("#title-img-input").text($("input[name=images]").val());
}

function loadImg() {
    var images = $("#images").prop('files')[0];
    var formData = new FormData();
    formData.append('file',images);
    $.ajax({
        url: "app/Get.php?img",
        dataType: 'text',
        method: "POST",
        data: formData,
        contentType: false,
        processData: false,
        cache: false
    }).done(function () {
        $("#img-div").html("<img calss='border rounded' src='resources/img/logo.png' width='200'>");
        window.location.href = "./";
    });
}

function setInfo() {
    let nombre = $("#input-name").val();
    let correo = $("#input-mail").val();
    let telefo = $("#input-tel").val();
    let direcc = $("#input-direction").val();
    if (nombre !== "" && correo !== "" && telefo !== "" && direcc !== "") {
        $.ajax({
            url: "app/Get.php?setInfo",
            method: "POST",
            data: {nombre, correo, telefo, direcc}
        }).done(function (data) {
            console.log(data);
            $(".modal").modal("hide");
            getToast("¡Datos Actualizados con exito!", "#FFFFFF");
        });
    }
    if (direcc === "") {
        $('#input-direction').addClass("is-invalid");
        $('#alert').html(getAlert("¡Verifica!", "La dirección está vacía", "alert-danger"));
        setTimeout(function () {
            $('#input-direction').removeClass("is-invalid");
        }, 3000);
    }
    if (telefo === "") {
        $('#input-tel').addClass("is-invalid");
        $('#alert').html(getAlert("¡Verifica!", "El número teléfono está vacío", "alert-danger"));
        setTimeout(function () {
            $('#input-tel').removeClass("is-invalid");
        }, 3000);
    }
    if (correo === "") {
        $('#input-mail').addClass("is-invalid");
        $('#alert').html(getAlert("¡Verifica!", "El correo está vacío", "alert-danger"));
        setTimeout(function () {
            $('#input-mail').removeClass("is-invalid");
        }, 3000);
    }
    if (nombre === "") {
        $('#input-name').addClass("is-invalid");
        $('#alert').html(getAlert("¡Verifica!", "Nombre de la empresa vacío", "alert-danger"));
        setTimeout(function () {
            $('#input-name').removeClass("is-invalid");
        }, 3000);
    }
}

function getAlert(title, text, color) {
    let alert = "<div class='alert " + color + " alert-dismissible fade show' role='alert'>";
    alert += "<strong>" + title + "</strong>" + text;
    alert += "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
    return alert;
}