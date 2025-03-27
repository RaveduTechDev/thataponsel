let modalValue = $("#modal")
    .val()
    .replace(/[^0-9]/g, "");
$("#modal").val(formatRupiah(modalValue));

let hargaJualValue = $("#harga-jual")
    .val()
    .replace(/[^0-9]/g, "");
$("#harga-jual").val(formatRupiah(hargaJualValue));

$("#modal").on("input", function () {
    let value = $(this)
        .val()
        .replace(/[^0-9]/g, "");
    $(this).val(formatRupiah(value));
});

$("#harga-jual").on("input", function () {
    let value = $(this)
        .val()
        .replace(/[^0-9]/g, "");
    $(this).val(formatRupiah(value));
});

function formatRupiah(angka) {
    angka = parseFloat(angka) || 0;
    return "Rp " + angka.toLocaleString("id-ID", { minimumFractionDigits: 0 });
}

$("#formSubmit").on("submit", function () {
    let modalFormatted = $("#modal").val();
    let hargaJualFormatted = $("#harga-jual").val();

    let modalNumber = parseInt(modalFormatted.replace(/[^0-9]/g, "")) || 0;
    let hargaJualNumber =
        parseInt(hargaJualFormatted.replace(/[^0-9]/g, "")) || 0;

    $("#modal").val(modalNumber);
    $("#harga-jual").val(hargaJualNumber);
});
