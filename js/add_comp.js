document.getElementById("p_login").addEventListener("input", () => {
    document.getElementById("company_name").value = document.getElementById("p_login").value;
})

document.getElementById("p_login").addEventListener("input", () => {
    document.getElementById("p_login_cv").value = document.getElementById("p_login").value;
})

document.getElementById("p_passwort").addEventListener("input", () => {
    document.getElementById("p_passwort_cv").value = document.getElementById("p_passwort").value;
})
