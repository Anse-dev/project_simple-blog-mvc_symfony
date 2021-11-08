(function () {
  /* Element selectionner */
  let element = document.getElementById("header");
  let elementRect = element.getBoundingClientRect();
  let elementTopValue = elementRect.top;
  const width = elementRect.width;
  const heigth = elementRect.height;
  let fakeEl = document.createElement("div");
  fakeEl.style.height = heigth + "px";
  /* Functions */
  let onScroll = function () {
    const hasFixedClass = element.classList.contains("sticky");
    if (window.pageYOffset > elementTopValue && !hasFixedClass) {
      element.classList.add("sticky");
      element.style.width = width + "px";
      element.parentNode.insertBefore(fakeEl, element);
      console.log(window.pageYOffset, elementTopValue);
    } else if (window.pageYOffset == elementTopValue && hasFixedClass) {
      element.parentNode.removeChild(fakeEl);
      element.classList.remove("sticky");
    }
  };
  /* Event listenner */
  window.addEventListener("scroll", onScroll);
})();
