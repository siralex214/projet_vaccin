// const pop_up_mdp = document.querySelector("#pop_up_mdp")
// const password = document.querySelector("#password")
// console.log("ok")
// if (password != null || pop_up_mdp != null){
//     password.addEventListener("click",function (){
//         pop_up_mdp.classList.remove("cacher")
//         pop_up_mdp.classList.add("show_pop_up_mdp")
//     })
// }

const button1 = document.querySelector("#button1")
const button2 = document.querySelector("#button2")
const button3 = document.querySelector("#button3")
const block1 = document.querySelector("#block1")
const block2 = document.querySelector("#block2")
const block3 = document.querySelector("#block3")


if (button1 != null || button2 != null || button3 != null){
    button1.addEventListener("click",function (){
        console.log("click1")
        block1.classList.remove('cacher')
        block1.classList.add('d_on')
        block2.classList.remove("d_on")
        block2.classList.add("cacher")
        block3.classList.remove("d_on")
        block3.classList.add("cacher")
    })
    button2.addEventListener("click",function (){
        console.log("click2")
        block2.classList.remove('cacher')
        block2.classList.add('d_on')
        block1.classList.remove("d_on")
        block1.classList.add("cacher")
        block3.classList.remove("d_on")
        block3.classList.add("cacher")
    })
    button3.addEventListener("click",function (){
        console.log("click3")
        block3.classList.remove('cacher')
        block3.classList.add('d_on')
        block1.classList.remove("d_on")
        block1.classList.add("cacher")
        block2.classList.remove("d_on")
        block2.classList.add("cacher")
    })
}
