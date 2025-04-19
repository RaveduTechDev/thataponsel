<script>
    document.getElementById("formSubmit").addEventListener("submit", function() {
        const submitButton = document.getElementById("submitBtn");
        submitButton.disabled = true;
        submitButton.innerHTML = `
      <span class="spinner-border spinner-border-sm" style="margin: 4px 2px 0 0;" role="status" aria-hidden="true"></span>
      Loading...
    `;
    });
</script>
