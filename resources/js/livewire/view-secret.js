document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("copy-secret").addEventListener("click", () => {
        navigator.clipboard
            .writeText(document.getElementById("secret-text").value)
            .then(() => {
                window.notyf.success("Secret copied to clipboard!");
            })
            .catch(() => {
                window.notyf.error(
                    "Failed to copy secret, please copy manually!"
                );
            });
    });
});
