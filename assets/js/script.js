const pop_up_mdp = document.querySelector("#pop_up_mdp")
const password = document.querySelector("#password")
console.log("ok")
console.dir(password)
password.addEventListener("click",function (){
    pop_up_mdp.classList.remove("cacher")
    pop_up_mdp.classList.add("show_pop_up_mdp")
console.dir(password)
})