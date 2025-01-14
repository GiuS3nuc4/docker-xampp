const body = document.getElementsByTagName("body");
function stampadati(event)
{
    event.preventDefault();
    // Catturo i valori con getElementiByID
    const nome = document.getElementById("fname");
    const cognome = document.getElementById("lname");
    const username = document.getElementById("uname");
    const email = document.getElementById("email");
    const citta = document.getElementById("citta");
    const genere = document.querySelector('input[name="genere"]:checked');
    const dataNascita = document.getElementById("data-nascita");

    // verificare che tutti i campi siano compilati
    if(!nome || !cognome || !username || !email || !citta || !genere || !dataNascita) {
        alert("Dati incompleti. Compilare tutti i campi.");
        return false
    }

    //se tutti i campi sono compilati, puoi procedere con l'invio
    alert("Form inviato correttamente!");
    return true;


    console.log(document.getElementsByName("registrazione"));
    console.log(nome);

    // Inserisce nel paragrafo p
    document.getElementById("dati").innerHTML = nome + cognome + username;
    "<br>" + cognome.value + "<br>" + username.value;
}