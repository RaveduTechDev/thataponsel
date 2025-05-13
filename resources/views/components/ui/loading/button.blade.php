<script>
    document.addEventListener('DOMContentLoaded', function() {
        const formSubmit = document.getElementById("formSubmit") ?? null;
        if (formSubmit) {
            formSubmit.addEventListener("submit", function() {
                const submitButton = document.getElementById("submitBtn");
                submitButton.disabled = true;
                submitButton.innerHTML = `
                    <span class="spinner-border spinner-border-sm" style="margin: 4px 2px 0 0;" role="status" aria-hidden="true"></span>
                    Loading...
                `;
            });
        }

        const formSubmitPopUp = document.getElementById("formSubmitPopUp") ?? null;
        if (formSubmitPopUp) {
            formSubmitPopUp.addEventListener("submit", function() {
                const submitButton = document.getElementById("submitBtnPopUp");
                submitButton.disabled = true;
                submitButton.innerHTML = `
                    <span class="spinner-border spinner-border-sm" style="margin: 4px 2px 0 0;" role="status" aria-hidden="true"></span>
                    Loading...
                `;
            });
        }

        // form and button for querySelectorAll class
        const formSubmitAll = document.querySelectorAll(".formSubmit");
        const submitBtnAll = document.querySelectorAll(".submitBtn");
        formSubmitAll.forEach((form, index) => {
            form.addEventListener("submit", function() {
                const submitButton = submitBtnAll[index];
                submitButton.disabled = true;
                submitButton.innerHTML = `
                    <span class="spinner-border spinner-border-sm" style="margin: 4px 2px 0 0;" role="status" aria-hidden="true"></span>
                    Loading...
                `;
            });
        });
    });
</script>
