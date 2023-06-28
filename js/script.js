const container = document.querySelector('.projects-cards')

function criarItens(projetos) {

    let itens;

    for(let i in projetos){
        
        itens = projetos[i]

        const imagem = itens.img;
        const nome = itens.name;
        const habilidades = itens.skills;
        const links1 = itens.link1;
        const links2 = itens.link2;
        const botao1 = itens.button1;
        const botao2 = itens.button2;

        const tagDiv = document.createElement('div');
        const tagDiv2 = document.createElement('div');
        const tagImg = document.createElement('img');
        const tagH2 = document.createElement('h2');
        const tagP = document.createElement('p');
        const tagA = document.createElement('a');
        const tagA2 = document.createElement('a');

        tagDiv.classList.add('project-card');
        tagDiv2.classList.add('project-button');
        tagImg.src = imagem;
        tagH2.innerText = nome;
        tagP.innerText = habilidades;
        tagA.href = links1;
        tagA2.href = links2;
        tagA.target = "_blank";
        tagA2.target = "_blank";
        tagA.innerText = botao1
        tagA2.innerText = botao2
  
        tagDiv2.append(tagA, tagA2)

        tagDiv.append(tagImg, tagH2, tagP, tagDiv2)
        container.appendChild(tagDiv)
        
    }
}
criarItens(projetos)