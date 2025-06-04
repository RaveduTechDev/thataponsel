import $ from "jquery";

function formatRupiah(angka) {
    angka = parseFloat(angka) || 0;
    return "Rp " + angka.toLocaleString("id-ID", { minimumFractionDigits: 0 });
}

function initializeInputFormatting(selector) {
    if ($(selector).length) {
        let value =
            $(selector)
                .val()
                .replace(/[^0-9]/g, "") || "0";
        $(selector).val(formatRupiah(value));

        $(selector).on("input", function () {
            let inputValue =
                $(this)
                    .val()
                    .replace(/[^0-9]/g, "") || "0";
            $(this).val(formatRupiah(inputValue));
        });
    }
}

initializeInputFormatting("#modal");
initializeInputFormatting("#harga-jual");
initializeInputFormatting("#biaya");
initializeInputFormatting("#profit");

if ($("#formSubmit").length) {
    $("#formSubmit").on("submit", function () {
        if ($("#modal").length) {
            let modalFormatted = $("#modal").val();
            let modalNumber =
                parseInt(modalFormatted.replace(/[^0-9]/g, "")) || 0;
            $("#modal").val(modalNumber);
        }

        if ($("#harga-jual").length) {
            let hargaJualFormatted = $("#harga-jual").val();
            let hargaJualNumber =
                parseInt(hargaJualFormatted.replace(/[^0-9]/g, "")) || 0;
            $("#harga-jual").val(hargaJualNumber);
        }

        if ($("#biaya").length) {
            let biayaFormatted = $("#biaya").val();
            let biayaNumber =
                parseInt(biayaFormatted.replace(/[^0-9]/g, "")) || 0;
            $("#biaya").val(biayaNumber);
        }

        if ($("#profit").length) {
            let profitFormatted = $("#profit").val();
            let profitNumber =
                parseInt(profitFormatted.replace(/[^0-9]/g, "")) || 0;
            $("#profit").val(profitNumber);
        }
    });
}
if ($("#formSubmit").length) {
    $("#formSubmit").on("submit", function () {
        ["#modal", "#harga-jual", "#biaya", "#profit"].forEach((selector) => {
            if ($(selector).length) {
                let formattedValue = $(selector).val();
                let numericValue =
                    parseInt(formattedValue.replace(/[^0-9]/g, "")) || 0;
                $(selector).val(numericValue);
            }
        });
    });
}

function calculateProfit() {
    let modalVal = $("#modal").val();
    let biayaVal = $("#biaya").val();

    let modal =
        parseInt(
            modalVal !== undefined ? modalVal.replace(/[^0-9]/g, "") : "0"
        ) || 0;
    let biaya =
        parseInt(
            biayaVal !== undefined ? biayaVal.replace(/[^0-9]/g, "") : "0"
        ) || 0;
    let profit = biaya - modal;

    $("#profit").val(formatRupiah(profit));
}
$("#modal, #harga-jual, #biaya").on("input", calculateProfit);
$(document).ready(function () {
    calculateProfit();
});
