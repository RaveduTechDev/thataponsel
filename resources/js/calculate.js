if ($("#formSubmit").length) {
    $("#formSubmit").on("submit", function () {
        ["#sub-total", "#total-bayar"].forEach((selector) => {
            if ($(selector).length) {
                let formattedValue = $(selector).val();
                let numberValue =
                    parseInt(formattedValue.replace(/[^0-9]/g, "")) || 0;
                $(selector).val(numberValue);
            }
        });
    });
}
