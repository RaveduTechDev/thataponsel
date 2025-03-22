$("#formSubmit").on("submit", function (e) {
    var subTotalFormatted = $("#sub-total").val();
    var totalBayarFormatted = $("#total-bayar").val();

    var subTotalNumber =
        parseInt(subTotalFormatted.replace(/[^0-9]/g, "")) || 0;
    var totalBayarNumber =
        parseInt(totalBayarFormatted.replace(/[^0-9]/g, "")) || 0;

    $("#sub-total").val(subTotalNumber);
    $("#total-bayar").val(totalBayarNumber);
});
