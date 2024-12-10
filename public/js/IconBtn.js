


class IconBtn{


    #container;
    #img;

    constructor(src,  size = "5dvh",  alt="icon"){


        this.#container = document.createElement("div")

        if(this.onclick){
            this.#container.onclick = ()=>{
                this.onclick();
            }
        }
      
        this.#container.style.cssText = `
    
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            user-select: none;

        `

        this.#img = document.createElement("img");

        this.#img.src = src;
        this.#img.alt = alt;

        this.#img.style.width = size;
        this.#img.style.height = size;

        this.#container.appendChild(this.#img);


    }


    addClass(className){
        this.#container.classList.add(className)
    }


    appendStyle(style){
        this.#container.style.cssText  += style
    } 

    setStyle(style){
        this.#container.style.cssText  = style
    }  


    setRedirect(redirect){

        this.#container.onclick = ()=>{
            window.location = redirect;
        };

    }  


    setID(id){

        this.#container.id = id;
    }  

    setText(text){

        this.#container.innerHTML = text;
    }  


    display(div){

        if(this.onclick){
            this.#container.onclick = ()=>{
                this.onclick();
            }
        }

        div.appendChild(this.#container);

    }

    onclick = ()=>{}




}