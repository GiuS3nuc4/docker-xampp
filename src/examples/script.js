async function fetchData() 
{
    //percorso relativo
    const url = "../api/data.php";
    try
    {
        const response = await fetch(url);
        const data = await response.json();
        console.log(data);
        return data;
    }
    catch(error)
    {
        CloseEvent.error("Errore recupero dat:", error);
        return[];
    }
}

//event handler del bottone
async function populateTable()
{
    const data = await fetchData();
    const data_table = document.getElementById("data-table");

    //pulisce il contenuno della tabella
    //data_table.innerHTML = ''; 

    data.forEach(element => {
        const row = document.createElement('tr');
        const data1 = document.createElement('td');
        const data2 = document.createElement('td');
        const data3 = document.createElement('td');
        data1.textContent = element.nome;
        data2.textContent = element.cognome;
        data3.textContent = element.email;
        row.appendChild(data1);
        row.appendChild(data2);
        row.appendChild(data3);
        data_table.appendChild(row);
    });
}

document.getElementById("load-data-button").addEventListener("click", populateTable);