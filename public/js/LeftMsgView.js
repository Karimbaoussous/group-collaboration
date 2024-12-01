


function handleLeftMsgContainerMouseEnter(leftMsgContainer){

    const optionsContainer = document.createElement("div");

    optionsContainer.style.cssText = `
        display: flex;
        align-items: center;
        justify-content: center;
        gap: var(--gap-h);
    `;

    const moreBtn = document.createElement("div");
    const btnsContainer = document.createElement('div');

    moreBtn.innerText = "..."
    moreBtn.classList.add("moreBtn");
    
    moreBtn.onmouseenter = ()=>{

        const divContainer = leftMsgContainer.parentElement

        btnsContainer.innerHTML = `
            <div class="optionsBtn" onclick="removeMsg('${ divContainer.id}')">
                remove 
            <div>
        `;

        optionsContainer.appendChild(btnsContainer);

    }

    optionsContainer.onmouseleave = ()=>{
        btnsContainer.remove()
    }

    optionsContainer.appendChild(moreBtn)

    leftMsgContainer.appendChild(optionsContainer);

}


function handleLeftMsgContainerMouseLeave(leftMsgContainer){

    // console.log(leftMsgContainer)

    if(leftMsgContainer.children.length  != 2) {
        console.warn("may generate an error");
        return 
    }

    const optionsContainer = leftMsgContainer.children[1];

    if(optionsContainer.children.length > 0){

        const moreBtn = optionsContainer.children[0];
        moreBtn.remove()
        optionsContainer.remove()

    }

    
}

