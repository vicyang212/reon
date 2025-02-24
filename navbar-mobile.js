const menuIcon = document.querySelector(".fa-bars");
const openIcon1 = document.querySelectorAll(".side-item-1 .item-title .icon1");

menuIcon.addEventListener("click", (e) => {
    const menu = document.querySelector(".side-menu");
    const allSideMenu2 = document.querySelectorAll('.side-menu-2');
    const allSideMenu3 = document.querySelectorAll('.side-menu-3');
    const allIcon1 = document.querySelectorAll('.side-item-1 .item-title .icon1');
    const allIcon2 = document.querySelectorAll('.side-item-2 .item-title .icon2');

    // 切换
    menu.classList.toggle('show-menu');

    // 如果菜單隱藏，重置版面
    if (!menu.classList.contains('show-menu')) {
        // 收合二
        allSideMenu2.forEach(sideMenu2 => {
            sideMenu2.style.height = '0px';
            sideMenu2.classList.remove('active');
        });

        // 收合三
        allSideMenu3.forEach(sideMenu3 => {
            sideMenu3.style.height = '0px';
            sideMenu3.classList.remove('active');
        });

        // 重置圖標
        allIcon1.forEach(icon1 => {
            icon1.classList.remove('fa-rotate-180');
        });

        allIcon2.forEach(icon2 => {
            icon2.classList.remove('fa-rotate-180');
        });
    }
});

openIcon1.forEach(icon1 => {
    icon1.addEventListener("click", (e) => {
        const parentSideItem1 = e.target.closest('.side-item-1');
        const currentSideMenu2 = parentSideItem1.querySelector('.side-menu-2');
        let actualHeight2 = currentSideMenu2.scrollHeight;

        if (currentSideMenu2.classList.contains('active')) {
            // 收二時收三
            const allSideMenu3 = parentSideItem1.querySelectorAll('.side-menu-3');
            const allIcon2 = parentSideItem1.querySelectorAll('.side-item-2 .item-title .icon2');
            
            allSideMenu3.forEach(sideMenu3 => {
                sideMenu3.style.height = '0px';
                sideMenu3.classList.remove('active');
            });

            allIcon2.forEach(icon2 => {
                icon2.classList.remove('fa-rotate-180');
            });

            currentSideMenu2.style.height = `0px`;
            currentSideMenu2.classList.remove('active');
            icon1.classList.remove('fa-rotate-180');
        } else {
            currentSideMenu2.style.height = `${actualHeight2}px`;
            currentSideMenu2.classList.add('active');
            icon1.classList.add('fa-rotate-180');
        }

        // 監聽目前side-item-1下的所有icon2
        const openIcon2 = parentSideItem1.querySelectorAll('.side-item-2 .item-title .icon2');
        
        openIcon2.forEach(icon2 => {
            // 先移除之前可能存在的事件监听，防止重复绑定
            icon2.removeEventListener("click", icon2.clickHandler);
            
            icon2.clickHandler = (e2) => {
                const parentSideItem2 = e2.target.closest('.side-item-2');
                const parentSideMenu2 = e2.target.closest('.side-menu-2');
                const currentSideMenu3 = parentSideItem2.querySelector('.side-menu-3');
                const actualHeight3 = currentSideMenu3.scrollHeight;

                if (currentSideMenu3.classList.contains('active')) {
                    currentSideMenu3.style.height = `0px`;

                    if (parentSideMenu2.scrollHeight > actualHeight2) {
                        parentSideMenu2.style.height = `${parentSideMenu2.scrollHeight - actualHeight3}px`;
                    } else {
                        parentSideMenu2.style.height = `${actualHeight2}px`;
                    }

                    currentSideMenu3.classList.remove('active');
                    icon2.classList.remove('fa-rotate-180');
                } else {
                    currentSideMenu3.style.height = `${actualHeight3}px`;
                    parentSideMenu2.style.height = `${parentSideMenu2.scrollHeight + actualHeight3}px`;
                    currentSideMenu3.classList.add('active');
                    icon2.classList.add('fa-rotate-180');
                }
            };

            // 監聽
            icon2.addEventListener("click", icon2.clickHandler);
        });
    });
});

// const menuIcon = document.querySelector(".fa-bars")
// const openIcon1 = document.querySelectorAll(".side-item-1 .item-title .icon1")
// const openIcon2 = document.querySelectorAll(".side-item-1 .item-title .icon2");

// menuIcon.addEventListener("click", (e) => {
//     const menu = document.querySelector(".side-menu");
//     menu.classList.toggle('show-menu');
// })

// openIcon1.forEach(icon1 => {
//     icon1.addEventListener("click", (e) => {
//         const parentSideItem1 = e.target.closest('.side-item-1');
//         const currentSideMenu2 = parentSideItem1.querySelector('.side-menu-2');
//         let actualHeight2 = currentSideMenu2.scrollHeight;

//         if (currentSideMenu2.classList.contains('active')) {
//             currentSideMenu2.style.height = `0px`;
//             currentSideMenu2.classList.remove('active');
//             icon1.classList.remove('fa-rotate-180')
//         } else {
//             currentSideMenu2.style.height = `${actualHeight2}px`;
//             currentSideMenu2.classList.add('active');
//             icon1.classList.add('fa-rotate-180');
//         }

//         // 如果有第三層
//         if (openIcon2) {
//             openIcon2.forEach(icon2 => {
//                 icon2.addEventListener("click", (e2) => {
//                     const parentSideItem2 = e2.target.closest('.side-item-2');
//                     const parentSideMenu2 = e2.target.closest('.side-menu-2');
//                     const currentSideMenu3 = parentSideItem2.querySelector('.side-menu-3')
//                     const actualHeight3 = currentSideMenu3.scrollHeight;
//                     console.log(currentSideMenu2)
//                     console.log(parentSideItem2)

//                     if (currentSideMenu3.classList.contains('active')) {
//                         currentSideMenu3.style.height = `0px`;

//                         if (parentSideMenu2.scrollHeight > actualHeight2) {
//                             parentSideMenu2.style.height = `${parentSideMenu2.scrollHeight - actualHeight3}px`;
//                         } else {
//                             parentSideMenu2.style.height = `${actualHeight2}px`;
//                         }

//                         currentSideMenu3.classList.remove('active');
//                         icon2.classList.remove('fa-rotate-180');
//                         openHeight = 0
//                     } else {
//                         openHeight = actualHeight2 + actualHeight3;
//                         currentSideMenu3.style.height = `${actualHeight3}px`;
//                         parentSideMenu2.style.height = `${parentSideMenu2.scrollHeight + actualHeight3}px`;
//                         currentSideMenu3.classList.add('active');
//                         icon2.classList.add('fa-rotate-180')
//                     }
//                 })
//             })
//         }
//     })
// })