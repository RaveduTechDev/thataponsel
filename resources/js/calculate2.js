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

initializeInputFormatting("#harga-jual");
initializeInputFormatting("#biaya");
initializeInputFormatting("#dp-server");
initializeInputFormatting("#modal");
initializeInputFormatting("#sisa-server");
initializeInputFormatting("#profit");

if ($("#formSubmit").length) {
    $("#formSubmit").on("submit", function () {
        if ($("#modal").length) {
            let modalFormatted = $("#modal").val();
            let modalNumber =
                parseInt(modalFormatted.replace(/[^0-9]/g, "")) || 0;
            $("#modal").val(modalNumber);
        }

        if ($("#dp-server").length) {
            let dpServerFormatted = $("#dp-server").val();
            let dpServerNumber =
                parseInt(dpServerFormatted.replace(/[^0-9]/g, "")) || 0;
            $("#dp-server").val(dpServerNumber);
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

        if ($("#sisa-server").length) {
            let sisaServerFormatted = $("#sisa-server").val();
            let sisaServerNumber =
                parseInt(sisaServerFormatted.replace(/[^0-9]/g, "")) || 0;
            $("#sisa-server").val(sisaServerNumber);
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
    let dpModalVal = $("#dp-server").val();
    let biayaVal = $("#biaya").val();

    let modal =
        parseInt(
            modalVal !== undefined ? modalVal.replace(/[^0-9]/g, "") : "0"
        ) || 0;
    let dpModal =
        parseInt(
            dpModalVal !== undefined ? dpModalVal.replace(/[^0-9]/g, "") : "0"
        ) || 0;
    let biaya =
        parseInt(
            biayaVal !== undefined ? biayaVal.replace(/[^0-9]/g, "") : "0"
        ) || 0;
    let profit = biaya - modal;

    let sisaServer = modal - dpModal;

    $("#profit").val(formatRupiah(profit));
    $("#sisa-server").val(formatRupiah(sisaServer));

    handleSisaServerChange(sisaServer);
}

const selesaiOptionHTML = '<option value="selesai">Selesai</option>';
let previousStatus = $("#status").val();
let hideMessageTimeout;

function handleSisaServerChange(sisa) {
    const statusSelect = $("#status");
    const selesaiOption = statusSelect.find("option[value='selesai']");

    if (sisa > 0) {
        if (selesaiOption.length) selesaiOption.remove();
        if (statusSelect.val() === "selesai") {
            statusSelect.val(previousStatus || "proses");
        }
        $("#status-message").removeClass("d-none");
        $("#server").addClass("is-invalid");
        $("#sisa-server").addClass("is-invalid");

        clearTimeout(hideMessageTimeout);
        hideMessageTimeout = setTimeout(() => {
            $("#status-message").addClass("d-none");
            $("#server").removeClass("is-invalid");
            $("#sisa-server").removeClass("is-invalid");
        }, 15000);
    } else {
        if (!statusSelect.find("option[value='selesai']").length) {
            statusSelect.append(selesaiOptionHTML);
        }
        $("#status-message").addClass("d-none");
        $("#server").removeClass("is-invalid");
        $("#sisa-server").removeClass("is-invalid");

        clearTimeout(hideMessageTimeout);
    }

    previousStatus = statusSelect.val();
}

$("#status").on("change", function () {
    const sisa = formatRupiah($("#sisa-server").val());
    if ($(this).val() === "selesai" && sisa > 0) {
        $(this).val(previousStatus);
    } else {
        previousStatus = $(this).val();
    }
});

$("#modal, #harga-jual, #biaya, #dp-server, #sisa-server").on(
    "input",
    calculateProfit
);
$(document).ready(function () {
    calculateProfit();
});
