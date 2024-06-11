const fields = document.querySelectorAll("[required]")
console.log(fields)
document.querySelector("form").addEventListener("submit", validarFormulario => {
    function validarFormulario() {
        var name = document.getElementById('userName').value;
        var number = document.getElementById('userNumber').value;
        var email = document.getElementById('email').value;
        var CEP = document.getElementById('userCEP').value;
        var password = document.getElementById('password').value;
        console.log(validarFormulario())
        if (!name || !number || !email || !CEP || !password) {
            alert("Por favor, preencha todos os campos.");
            return false;
        }
        return true;}})