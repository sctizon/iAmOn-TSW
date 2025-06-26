const addSwitch = document.querySelector("#addSwitch");
const modalWindow = document.querySelector("#modalWindow");
const close = document.querySelector("#close");
const createSwitch = document.querySelector("#createSwitch");
const user = document.querySelector(".userIcon");
const menu = document.querySelector(".menu");
const closeIcon = document.querySelector(".closeIcon");
const sidebarIcon = document.querySelector(".sidebarIcon");
const sidebar = document.querySelector(".sidebar");


addSwitch.addEventListener("click", () => {
  modalWindow.classList.add("active");
});

close.addEventListener("click", () => {
  modalWindow.classList.remove("active");
});

createSwitch.addEventListener("click", () => {
  modalWindow.classList.remove("active");
  alert("switch creado");
});

user.addEventListener("click", () =>{
  menu.classList.toggle("active");
});

sidebarIcon.addEventListener("click", () => {
  sidebar.classList.add("active");
});

closeIcon.addEventListener("click", () => {
  sidebar.classList.remove("active");
});
