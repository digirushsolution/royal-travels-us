
  (function ($) {
    "use strict";
    $(window).on("elementor/frontend/init", function () {
      elementorFrontend.hooks.addAction("frontend/element_ready/bwdmp_Modal_Popup.default",function(){

          function sliderAllWrapper(modalItem) {

            function modalPopup(modal) {
              const btnWrapper = modalItem.querySelector(".bwdmp-popup-btn-wrapper");
              const modalMain = modal.querySelector(".bwdmp-modal");
              const button = btnWrapper.querySelector(".bwdmp-popup-swr-btn");
              const crossBtn = modal.querySelector(".bwdmp-modal-close-btn");
              const overlay =  modal.querySelector(".bwdmp-overlay");
          
              const load = modal.getAttribute("data-load");
              const inlet = modal.getAttribute("data-inlet");
              const inactivityTime = modal.getAttribute("data-inactivity");
              const scrollOffset = modal.getAttribute("data-scroll-offset");
              const popUpAnimDir = modal.getAttribute("data-popup-dir");
          
              // all event is handled here
              function eventListener(event, elem, cb) {
                elem.addEventListener(event, (e) => {
                  cb(e);
                });
              }
          
              function allPopupTrigger() {
                // onload trigger
                if (load) {
                  modalMain.classList.add("bwdmp-active-modal");
                  modal.classList.add("bwdmp-active-overlay");
                  modalMain.classList.add(popUpAnimDir);
                }
                // scroll trigger
                if (scrollOffset) {
                  const userScrollOffsetVal = parseInt(scrollOffset);
                  eventListener("scroll", window, () => {
                    if (window.scrollY > userScrollOffsetVal) {
                      modalMain.classList.add("bwdmp-active-modal");
                      modal.classList.add("bwdmp-active-overlay");
                      modalMain.classList.add(popUpAnimDir);
                    }
                  });
                  
                }
                // inlet trigger
                if (inlet) {
                  eventListener("mouseleave", document, () => {
                    modalMain.classList.add("bwdmp-active-modal");
                    modal.classList.add("bwdmp-active-overlay");
                    modalMain.classList.add(popUpAnimDir);
                  });
                }
                //inactivity trigger
                if (inactivityTime) {
                  const userInactivityTime = parseInt(inactivityTime);
                  let time;
          
                  let resetTimer = function () {
                    clearTimeout(time);
                    time = setTimeout(() => {
                      modalMain.classList.add("bwdmp-active-modal");
                      modalMain.classList.add(popUpAnimDir);
                      modal.classList.add("bwdmp-active-overlay");
                    }, userInactivityTime);
                  };
          
                  eventListener("load", window, resetTimer);
                  eventListener("mousemove", document, resetTimer);
                  eventListener("keydown", document, resetTimer);
                  eventListener("scroll", document, resetTimer);
                  eventListener("click", document, resetTimer);
                  eventListener("scroll", document, resetTimer);
                }
              }
              allPopupTrigger();
              // all active event will trigger when clicked the button
              if (button) {
                button.addEventListener("click",()=>{
                  modalMain.classList.add("bwdmp-active-modal");
                  modalMain.classList.add(popUpAnimDir);
                  modal.classList.add("bwdmp-active-overlay");
                });
              }
              function modalClose() {
                modalMain.classList.remove("bwdmp-active-modal");
                modalMain.classList.remove(popUpAnimDir);
                modal.classList.remove("bwdmp-active-overlay");
              }
              //close modal by clicked btn
              if(crossBtn){
               eventListener("click", crossBtn, modalClose);
              }
          
              overlay.addEventListener('click',()=>{
                modalClose()
              })
            }
            //all  player
            const modalPopupTrigger = () => {
              const modal = modalItem.querySelector(".bwdmp-modal-wrapper");
              modalPopup(modal);
            };
          
            // editMode active or not
            let renderObserver = (getEditMode) => {
              // elementor render observing
              const bwdfgGalleryFilteringObserver = new MutationObserver((mutations) => {
                mutations.map((record) => {
                  if (record.addedNodes.length) {
                    record.addedNodes.forEach((singleItem) => {
                      if (singleItem.nodeName == "DIV") {
                        if (singleItem.querySelector(".bwdmp-modal-wrapper")) {
                          let observedItem = singleItem.querySelector(
                            ".bwdmp-modal-wrapper"
                          );
                          modalPopup(observedItem);
                        }
                      }
                    });
                  }
                });
              });
          
              bwdfgGalleryFilteringObserver.observe(getEditMode, {
                subtree: true,
                childList: true,
              });
            };
            // edit mode checker
            (() => {
              let IntervalId;
              if (
                document.querySelector(".elementor-edit-area") ||
                document.querySelector(".bwdmp-modal-wrapper")
              ) {
                modalPopupTrigger();
              } else {
                IntervalId = setInterval(() => {
                  let ElementorEditArea = document.querySelector(".elementor-edit-area") || document.querySelector(".page");
                  
                  if (ElementorEditArea) {
                    clearInterval(IntervalId);
                    // play ===============
                    renderObserver(ElementorEditArea);
                  }
                }, 300);
              }
            })();

          }
          const allSliderItem = document.querySelectorAll('.bwdmp-slider-common')
          for(let item of allSliderItem){
          sliderAllWrapper(item)
          }

      });
    });
    })(jQuery);

