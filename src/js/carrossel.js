jQuery(document).ready(function () {
  jQuery(".carrossel-animation .list-items").each(function () {
    let carrossel = jQuery(this);
    let conteudo = carrossel.html();
    let containerCarrossel = jQuery("<div>").addClass("carrossel-ativo");

    containerCarrossel.html(conteudo);
    carrossel.empty().append(containerCarrossel);

    let larguraCarrossel = carrossel.outerWidth();
    let larguraConteudos = containerCarrossel[0].scrollWidth;
    let copias = Math.ceil(larguraCarrossel / larguraConteudos);

    for (let i = 0; i < copias; i++) {
      containerCarrossel.append(conteudo);
    }

    containerCarrossel.append(conteudo);
  });
});
