import intlTelInput from "intl-tel-input";
import "intl-tel-input/build/css/intlTelInput.css";
import Inputmask from "inputmask";

document.addEventListener("DOMContentLoaded", function () {
    const phoneInput = document.getElementById("phone");
    if (phoneInput) {
        const iti = intlTelInput(phoneInput, {
            initialCountry: "id",
            allowDropdown: false,
            separateDialCode: true,
            nationalMode: false,
            autoPlaceholder: "aggressive",
            utilsScript: new URL(
                "intl-tel-input/build/js/utils.js",
                import.meta.url
            ).href,
        });

        Inputmask({
            mask: "999 9999 9999[9]",
            placeholder: "",
            greedy: false,
            showMaskOnHover: false,
            showMaskOnFocus: false,
        }).mask(phoneInput);

        document.querySelector("#formSubmit").addEventListener("submit", () => {
            phoneInput.value = iti.getNumber(intlTelInput.numberFormat.E164);
        });
    } else {
        console.error("Element dengan id 'phone' tidak ditemukan");
    }
});
