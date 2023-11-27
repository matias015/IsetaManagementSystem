const pass = document.getElementById("pw-input"),
    icon = document.querySelector(".ti");

icon.addEventListener("click", e => {
    if (pass.type === "password") {
        pass.type = "text";
        icon.classList.remove('ti-eye')
        icon.classList.add('ti-eye-off')
    } else {
        pass.type = "password"
        icon.classList.add('ti-eye')
        icon.classList.remove('ti-eye-off')
    }
})
