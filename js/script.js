const container = document.querySelector('.projects-cards')

function criarItens(projetos) {

    let itens;

    for(let i in projetos){
        
        itens = projetos[i]

        const imagem = itens.img;
        const nome = itens.name;
        const habilidades = itens.skills;
        const links1 = itens.link1;

        const tagDiv = document.createElement('div');
        const tagImg = document.createElement('img');
        const tagH2 = document.createElement('h2');
        const tagP = document.createElement('p');
        const tagA = document.createElement('a');

        tagDiv.classList.add('project-card');
        tagImg.src = imagem;
        tagH2.innerText = nome;
        tagP.innerText = habilidades;
        tagA.href = links1;
        tagA.target = "_blank";
        tagA.title = 'Clique na imagem para ver o projeto'

        tagA.appendChild(tagImg)
        tagDiv.append(tagA, tagH2, tagP)
        container.appendChild(tagDiv)
        
    }
}
criarItens(projetos)