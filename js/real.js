
    function formatCurrency(input) {
      
        var value = input.value.replace(/\D/g, '');

    
        var formattedValue = (parseInt(value) / 100).toLocaleString('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        });

       
        input.value = formattedValue;
    }

