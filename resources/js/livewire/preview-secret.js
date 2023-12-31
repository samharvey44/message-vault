document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("copy-secret").addEventListener("click", () => {
        navigator.clipboard
            .writeText(document.getElementById("secret-url").value)
            .then(() => {
                window.notyf.success("Secret link copied to clipboard!");
            })
            .catch(() => {
                window.notyf.error(
                    "Failed to copy link, please copy manually!"
                );
            });
    });
});
