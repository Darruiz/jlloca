function formatKilometers(input) {
    var kmValue = input.value.replace(/\D/g, ''); 
    var formattedValue = parseFloat(kmValue).toLocaleString("pt-BR"); 
    input.value = formattedValue + " Km"; 
}

var kmInput = document.getElementById("km");
kmInput.addEventListener("blur", function () {
    formatKilometers(kmInput);
});
