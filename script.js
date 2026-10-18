// GameRack front-end interactions

//delete button: gives a confirmation popup and deletes the row if yes  
function deleteGame(n){
    if(confirm("Delete this game?")){
        document.getElementById("row" + n).remove();
    }
}

// lets you quickly change the status to "completed" without using edit form
function markCompleted(n){
    document.getElementById("status" + n).innerText = "Completed";
}

// button to filter games from the table based on what you input
function filterGames(){
    const status = document.getElementById("filterStatus").value;
    const platform = document.getElementById("filterPlatform").value;
    const genre = document.getElementById("filterGenre").value.toLowerCase();

    // change this later once PHP is connected!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    for(let n = 1; n <= 4; n++){
        const row = document.getElementById("row" + n);

        // skips rows that were already deleted
        if(row !== null){
            const rowStatus = document.getElementById("status" + n).innerText;
            const rowPlatform = document.getElementById("platform" + n).innerText;
            const rowGenre = document.getElementById("genre" + n).innerText.toLowerCase();

            // Start by showing the row, then hide it if any filter doesn't match
            let show = true;
            if(status !== "" && rowStatus !== status){
                show = false;
            }
            if(platform !== "" && rowPlatform !== platform){
                show = false;
            }
            if(genre !== "" && !rowGenre.includes(genre)){
                show = false;
            }

            if(show){
                row.style.display = "";
            }
            else{
                row.style.display = "none";
            }
        }
    }
}

// makes sure that passwords match when registering a new account
function validateRegister(){
    const pass = document.getElementById("reg_password").value;
    const confirmPass = document.getElementById("reg_confirm").value;
    if(pass !== confirmPass){
        alert("Passwords do not match.");
        return false;
    }
    return true;
}