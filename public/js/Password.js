


function checkPassword(p1, p2){

    const IS_VALID = p1 === p2;
    console.log(IS_VALID, p1, p2)
    if(!IS_VALID) alert("incorrect password")
    return IS_VALID;

} 