document.addEventListener('DOMContentLoaded', () => {
    changeForms(); // Appel de la fonction une fois que le document est prêt
});

const changeForms = () => {
    let typePeriode = document.getElementById('typePeriode')
    let periodeDeclaree = document.getElementById('periodeDeclaree')
    let buttonSubmit = document.getElementById('submit')

    typePeriode.addEventListener('input', () => {
        if(typePeriode.value === 'ANNUEL') {
            periodeDeclaree.innerHTML = '<option selected disabled value="vide">Choisir la période déclarée</option><option value="1">01</option>'
        } else if(typePeriode.value === 'MENSUEL') {
            periodeDeclaree.innerHTML = '<option selected disabled value="vide">Choisir la période déclarée</option><option value="1">01</option><option value="2">02</option><option value="3">03</option><option value="4">04</option><option value="5">05</option><option value="6">06</option><option value="7">07</option><option value="8">08</option><option value="9">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option>'
        } else if (typePeriode.value=== "TRIMESTRIEL") {
            periodeDeclaree.innerHTML = '<option selected disabledvalue="vide" >Choisir la période déclarée</option><option value="1">01</option><option value="2">02</option><option value="3">03</option><option value="4">04</option>'
        } else if(typePeriode.value === vide) {
            buttonSubmit.style = 'display: none'
        }
    })
}
