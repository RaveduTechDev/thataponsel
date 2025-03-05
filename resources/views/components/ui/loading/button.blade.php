<script>
    document.getElementById("formSubmit").addEventListener("submit", function() {
        const submitButton = document.getElementById("submitBtn");
        submitButton.disabled = true;
        submitButton.innerHTML = `
      <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
      Loading...
    `;
    });
</script>
