import intlTelInput from "intl-tel-input";
import "intl-tel-input/build/css/intlTelInput.css";

document.addEventListener("DOMContentLoaded", function () {
    const phoneInput = document.getElementById("phone");
    if (phoneInput) {
        const iti = intlTelInput(phoneInput, {
            initialCountry: "id",
            allowDropdown: true,
            separateDialCode: true,
            nationalMode: false, //
            autoPlaceholder: "polite",
            formatAsYouType: true,
            formatOnDisplay: true,
            placeholderNumberType: "MOBILE",
            strictMode: true,
            countryOrder: ["ID", "US", "MY", "SG", "TH", "VN"],

            loadUtils: () => import("intl-tel-input/build/js/utils.js"),
        });

        document
            .getElementById("formSubmit")
            .addEventListener("submit", function (e) {
                const phone = iti.getNumber();
                document.getElementById("phone").value = phone;
                if (!phone) {
                    location.reload();
                }
            });
    } else {
        console.error("Element dengan id 'phone' tidak ditemukan");
    }
});
