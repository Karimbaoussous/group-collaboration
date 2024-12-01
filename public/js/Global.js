

function scrollToLastMsg() {

    const container = document.getElementById("chatAreaView");

    let lastMessage = container.children[container.children.length - 2];
    
    if(!lastMessage) return

    lastMessage.scrollIntoView({ 
        behavior: "smooth", 
        block: "end"
    });

    // console.log(lastMessage);

}

