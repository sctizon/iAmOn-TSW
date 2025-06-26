const addSwitch = document.querySelector("#addSwitch");
const modalWindow = document.querySelector("#modalWindow");
const close = document.querySelector("#close");
const createSwitch = document.querySelector("#createSwitch");
const user = document.querySelector(".userIcon");
const menu = document.querySelector(".menu");
const closeIcon = document.querySelector(".closeIcon");
const sidebarIcon = document.querySelector(".sidebarIcon");
const sidebar = document.querySelector(".sidebar");
const stateCheckbox = document.getElementById("stateCheckbox");
const durationField = document.getElementById("durationField");


addSwitch.addEventListener("click", () => {
  modalWindow.classList.add("active");
});

close.addEventListener("click", () => {
  modalWindow.classList.remove("active");
});

createSwitch.addEventListener("click", () => {
  modalWindow.classList.remove("active");
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

stateCheckbox.addEventListener("change", function () {
    if (stateCheckbox.checked) {
        durationField.style.display = "block";
    } else {
        durationField.style.display = "none";
    }
});