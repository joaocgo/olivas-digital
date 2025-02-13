jQuery(document).ready(function () {
  // Máscara para telefone
  var SPMaskBehavior = function (val) { 
    return val.replace(/\D/g, '').length === 11 ? '+55 (00) 00000-0000' : '+55 (00) 0000-00009'; 
  };
  var spOptions = { 
    onKeyPress: function (val, e, field, options) { 
      field.mask(SPMaskBehavior.apply({}, arguments), options); 
    } 
  };

  // Máscara para CPF e CNPJ
  var cpfcnpjOptions = { 
    onKeyPress: function (cpf, e, field, options) { 
      var masks = ['000.000.000-00', '00.000.000/0000-00'];
      field.mask((cpf.replace(/\D/g, '').length > 11) ? masks[1] : masks[0], options);
    } 
  };

  // Aplicar máscara de telefone
  jQuery('.phonebr').mask(SPMaskBehavior, spOptions);

  // Aplicar máscara de CPF e CNPJ
  jQuery('.cpfcnpj').mask('000.000.000-00', cpfcnpjOptions);

  // Máscara fixa para CNPJ
  jQuery('.cnpj').mask('00.000.000/0000-00', { reverse: true });

  // Máscara para CEP
  jQuery('.cep').mask('00000-000', { reverse: true });

  // Máscara para Nota Fiscal
  jQuery('.nf').mask('000.000.000', { reverse: true });
});