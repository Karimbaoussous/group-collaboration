


function handleRightMsgContainerMouseEnter(rightMsgContainer){

    // console.log("debug")

    const divContainer = rightMsgContainer.parentElement

    const optionsContainer = document.createElement("div");

    optionsContainer.style.cssText = `
        display: flex;
        order: 0;
        flex-direction: row-reverse;
        align-items: center;
        justify-content: center;

        gap: var(--gap-h);
    `;

    const moreBtn = document.createElement("div");

    const btnsContainer = document.createElement('div');
    btnsContainer.classList.add("btnsContainer")

    moreBtn.innerText = "..."
    moreBtn.classList.add("moreBtn");

    `

    <optionsContainer>

        <moreBtn class="moreBtn">
            ...
        </moreBtn>

        <btnsContainer>

            <editBtn class="optionsBtn" onclick="updateMsg('${divContainer.id}')">
                edit 
            </div>

            <removeBtn class="optionsBtn" onclick="removeMsg('${divContainer.id}')">
                remove 
            </div>

        </btnsContainer>

    </optionsContainer>
    `
    
    moreBtn.onmouseenter = ()=>{
                
        btnsContainer.innerHTML = `

            <div class="optionsBtn" onclick="removeMsg('${divContainer.id}')">
                remove 
            </div>

            <div class="optionsBtn" onclick="updateMsg('${divContainer.id}')">
                edit 
            </div>
           
        `;

        optionsContainer.appendChild(btnsContainer);

    }

    optionsContainer.onmouseleave = ()=>{
        btnsContainer.remove()
    }

    optionsContainer.appendChild(moreBtn)

    rightMsgContainer.appendChild(optionsContainer);

}


function handleRightMsgContainerMouseLeave(rightMsgContainer){

    // console.log(rightMsgContainer)

    if(rightMsgContainer.children.length  != 2) {
        console.warn("right msg must have 2 children's otherwise it may generate an error");
        return 
    }

    const optionsContainer = rightMsgContainer.children[1];

    if(optionsContainer.children.length > 0){

        const moreBtn = optionsContainer.children[0];
        moreBtn.remove()
        optionsContainer.remove()

    }

    
}

