function submitForm(form) {
    let btn = form.querySelector("button[type='submit']");
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = "Processing...";
    }
    return true; // agar form tetap dikirim
}
