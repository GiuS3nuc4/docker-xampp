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
}