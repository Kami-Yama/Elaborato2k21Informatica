

function checkIfEmailIsFree(email,allEmail){

    for(let i = 0; i < allEmail.length; i++){
        console.log(allEmail[i].email)
        if(email == allEmail[i].email){
            return false;
        }

    }
    return true;

}

function checkIfLegal(dataNasc){

    let today = new Date();
    console.log(today.getUTCMonth());
    let eta = today.getFullYear()-dataNasc.substring(0,4);
    if(eta == 18){
        let mese = today.getMonth() - dataNasc.substring(5,7);
        console.log(mese);
        if(mese == 0){
            let giorno = today.getDay() - dataNasc.substring(8,10);
            console.log(giorno);
            if(giorno >= 0)
                return true;
        }
        if (mese > 0)
            return true;
    }
    else{
        if (eta > 18 && eta < 140)
            return true;
    }
    return false;
}