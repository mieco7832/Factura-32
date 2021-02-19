function history() {
    $.ajax({
        url: "app/Get.php?history",
        method: "POST"
    }).done(function (data) {
        $(".modal").modal("show");
        $(".modal-title").text("Historial de Facturas");
        $(".modal-body").html(data);
        $(".modal-footer").text("");
    });
}