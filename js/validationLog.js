const fields = document.querySelectorAll("[required]")
console.log(fields)
document.querySelector("form").addEventListener("submit", validarFormulario => {
    function validarFormulario() {
        var email = document.getElementById('userEmail').value;
        var password = document.getElementById('userPassword').value;
        console.log(validarFormulario())
        if (!email || !password) {
            alert("Por favor, preencha todos os campos.");
            return false;
        }
        return true;}})