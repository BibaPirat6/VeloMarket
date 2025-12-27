window.addEventListener("scroll", () => {
    const header = document.querySelector("header");

    if (window.scrollY > 50) {
        header.classList.add("scrolled");
    } else {
        header.classList.remove("scrolled");
    }
});


document.querySelector(".burger-open").addEventListener("click", () => {
    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
    document.querySelector(".burger-modal").classList.add("active");
    document.body.style.overflow = "hidden";
});

document.querySelector(".burger-close").addEventListener("click", () => {
    document.querySelector(".burger-modal").classList.remove("active");
    document.body.style.overflow = "";
});

document.querySelectorAll(".burger__item").forEach(item => {
    item.addEventListener("click", () => {
        document.querySelector(".burger-modal").classList.remove("active");
        document.body.style.overflow = "";
    });
});


// admin
// document.querySelector(".panel-add").addEventListener("click", () => {
//     document.querySelector(".admin-modal__overlay").classList.add("active");
//     document.body.style.overflow = "hidden"; 
// });

// document.querySelector(".admin-modal__overlay").addEventListener("click", (e) => {
//     if (!e.target.closest(".admin-modal")) {
//         document.querySelector(".admin-modal__overlay").classList.remove("active");
//         document.body.style.overflow = "";
//     }
// });
const addBtn = document.querySelector(".panel-add");
const modalOverlay = document.querySelector(".admin-modal__overlay");

if (addBtn && modalOverlay) {
    addBtn.addEventListener("click", () => {
        document.querySelector(".admin-modal__overlay").classList.add("active");
        document.body.style.overflow = "hidden";
    });
    modalOverlay.addEventListener("click", (e) => {
        if (!e.target.closest(".admin-modal")) {
            document.querySelector(".admin-modal__overlay").classList.remove("active");
            document.body.style.overflow = "";
        }
    });
}


const buttons = document.querySelectorAll('.rent-btn');

buttons.forEach(btn => {
    btn.addEventListener('click', () => {
        const logged = btn.dataset.logged === '1';
        if (!logged) {
            window.location.href = './profile.php';
        } else {
            // document.querySelector(".order-modal__overlay").classList.add("active")
            // document.body.style.overflow = "hidden";

            // document.querySelector(".order-modal__overlay").addEventListener("click", (e) => {
            //     if (!e.target.closest(".order-modal")) {
            //         document.querySelector(".order-modal__overlay").classList.remove("active");
            //         document.body.style.overflow = "";
            //     }
            // });
            window.location.href = './rent.php';
        }
    });
});




