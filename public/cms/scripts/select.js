(function polyfill() {
  const relList = document.createElement("link").relList;
  if (relList && relList.supports && relList.supports("modulepreload")) {
    return;
  }
  for (const link of document.querySelectorAll('link[rel="modulepreload"]')) {
    processPreload(link);
  }
  new MutationObserver((mutations) => {
    for (const mutation of mutations) {
      if (mutation.type !== "childList") {
        continue;
      }
      for (const node of mutation.addedNodes) {
        if (node.tagName === "LINK" && node.rel === "modulepreload")
          processPreload(node);
      }
    }
  }).observe(document, { childList: true, subtree: true });
  function getFetchOpts(link) {
    const fetchOpts = {};
    if (link.integrity)
      fetchOpts.integrity = link.integrity;
    if (link.referrerPolicy)
      fetchOpts.referrerPolicy = link.referrerPolicy;
    if (link.crossOrigin === "use-credentials")
      fetchOpts.credentials = "include";
    else if (link.crossOrigin === "anonymous")
      fetchOpts.credentials = "omit";
    else
      fetchOpts.credentials = "same-origin";
    return fetchOpts;
  }
  function processPreload(link) {
    if (link.ep)
      return;
    link.ep = true;
    const fetchOpts = getFetchOpts(link);
    fetch(link.href, fetchOpts);
  }
})();
const burgerMenu = document.querySelector(".burger");
const menu = document.querySelector(".aside");
if (burgerMenu) {
  burgerMenu.addEventListener("click", () => {
    if (menu.classList.contains("hide")) {
      menu.classList.remove("hide");
      burgerMenu.classList.remove("hide");
    } else {
      menu.classList.add("hide");
      burgerMenu.classList.add("hide");
    }
  });
}
const spoilersArray = document.querySelectorAll("[data-spoilers]");
if (spoilersArray.length > 0) {
  let initspoilers = function(spoilersArray2, matchMedia = false) {
    spoilersArray2.forEach((spoilersBlock) => {
      spoilersBlock = matchMedia ? spoilersBlock.item : spoilersBlock;
      if (matchMedia.matches || !matchMedia) {
        spoilersBlock.classList.add("init");
        initspoilerBody(spoilersBlock);
        spoilersBlock.addEventListener("click", setspoilerAction);
      } else {
        spoilersBlock.classList.remove("init");
        initspoilerBody(spoilersBlock, false);
        spoilersBlock.removeEventListener("click", setspoilerAction);
      }
    });
  }, initspoilerBody = function(spoilersBlock, hidespoilerBody = true) {
    const spoilerTitles = spoilersBlock.querySelectorAll("[data-spoiler]");
    if (spoilerTitles.length > 0) {
      spoilerTitles.forEach((spoilerTitle) => {
        if (hidespoilerBody) {
          spoilerTitle.removeAttribute("tabindex");
          if (!spoilerTitle.classList.contains("active")) {
            spoilerTitle.nextElementSibling.hidden = true;
          }
        } else {
          spoilerTitle.setAttribute("tabindex", "-1");
          spoilerTitle.nextElementSibling.hidden = false;
        }
      });
    }
  }, setspoilerAction = function(e) {
    const el = e.target;
    if (el.hasAttribute("data-spoiler") || el.closest("[data-spoiler]")) {
      const spoilerTitle = el.hasAttribute("data-spoiler") ? el : el.closest("[data-spoiler]");
      const spoilersBlock = spoilerTitle.closest("[data-spoilers]");
      const onespoiler = spoilersBlock.hasAttribute("data-one-spoiler") ? true : false;
      if (!spoilersBlock.querySelectorAll(".slide").length) {
        if (onespoiler && !spoilerTitle.classList.contains("active")) {
          hidespoilersBody(spoilersBlock);
        }
        spoilerTitle.classList.toggle("active");
        _slideToggle(spoilerTitle.nextElementSibling, 300);
      }
      e.preventDefault();
    }
  }, hidespoilersBody = function(spoilersBlock) {
    const spoilerActiveTitle = spoilersBlock.querySelector("[data-spoiler].active");
    if (spoilerActiveTitle) {
      spoilerActiveTitle.classList.remove("active");
      _slideUp(spoilerActiveTitle.nextElementSibling, 300);
    }
  };
  var initspoilers2 = initspoilers, initspoilerBody2 = initspoilerBody, setspoilerAction2 = setspoilerAction, hidespoilersBody2 = hidespoilersBody;
  const spoilersRegular = Array.from(spoilersArray).filter(function(item, index, self) {
    return !item.dataset.spoilers.split(",")[0];
  });
  if (spoilersRegular.length > 0) {
    initspoilers(spoilersRegular);
  }
  const spoilersMedia = Array.from(spoilersArray).filter(function(item, index, self) {
    return item.dataset.spoilers.split(",")[0];
  });
  if (spoilersMedia.length > 0) {
    const breakpointsArray = [];
    spoilersMedia.forEach((item) => {
      const params = item.dataset.spoilers;
      const breakpoint = {};
      const paramsArray = params.split(",");
      breakpoint.value = paramsArray[0];
      breakpoint.type = paramsArray[1] ? paramsArray[1].trim() : "max";
      breakpoint.item = item;
      breakpointsArray.push(breakpoint);
    });
    let mediaQueries = breakpointsArray.map(function(item) {
      return "(" + item.type + "-width: " + item.value + "px)," + item.value + "," + item.type;
    });
    mediaQueries = mediaQueries.filter(function(item, index, self) {
      return self.indexOf(item) === index;
    });
    mediaQueries.forEach((breakpoint) => {
      const paramsArray = breakpoint.split(",");
      const mediaBreakpoint = paramsArray[1];
      const mediaType = paramsArray[2];
      const matchMedia = window.matchMedia(paramsArray[0]);
      const spoilersArray2 = breakpointsArray.filter(function(item) {
        if (item.value === mediaBreakpoint && item.type === mediaType) {
          return true;
        }
      });
      matchMedia.addListener(function() {
        initspoilers(spoilersArray2, matchMedia);
      });
      initspoilers(spoilersArray2, matchMedia);
    });
  }
}
let _slideUp = (target, duration = 300) => {
  if (!target.classList.contains("slide")) {
    target.classList.add("slide");
    target.style.transitionProperty = "height, margin, padding";
    target.style.transitionDuration = duration + "ms";
    target.style.height = target.offsetHeight + "px";
    target.offsetHeight;
    target.style.overflow = "hidden";
    target.style.height = 0;
    target.style.paddingTop = 0;
    target.style.paddingBottom = 0;
    target.style.marginTop = 0;
    target.style.marginBottom = 0;
    window.setTimeout(() => {
      target.hidden = true;
      target.style.removeProperty("height");
      target.style.removeProperty("padding-top");
      target.style.removeProperty("padding-bottom");
      target.style.removeProperty("margin-top");
      target.style.removeProperty("margin-bottom");
      target.style.removeProperty("overflow");
      target.style.removeProperty("transition-duration");
      target.style.removeProperty("transition-property");
      target.classList.remove("slide");
    }, duration);
  }
};
let _slideDown = (target, duration = 300) => {
  if (!target.classList.contains("slide")) {
    target.classList.add("slide");
    if (target.hidden) {
      target.hidden = false;
    }
    let height = target.offsetHeight;
    target.style.overflow = "hidden";
    target.style.height = 0;
    target.style.paddingTop = 0;
    target.style.paddingBottom = 0;
    target.style.marginTop = 0;
    target.style.marginBottom = 0;
    target.offsetHeight;
    target.style.transitionProperty = "height, margin, padding";
    target.style.transitionDuration = duration + "ms";
    target.style.height = height + "px";
    target.style.removeProperty("padding-top");
    target.style.removeProperty("padding-bottom");
    target.style.removeProperty("margin-top");
    target.style.removeProperty("margin-bottom");
    window.setTimeout(() => {
      target.style.removeProperty("height");
      target.style.removeProperty("overflow");
      target.style.removeProperty("transition-duration");
      target.style.removeProperty("transition-property");
      target.classList.remove("slide");
    }, duration);
  }
};
let _slideToggle = (target, duration = 300) => {
  if (target.hidden) {
    return _slideDown(target, duration);
  } else {
    return _slideUp(target, duration);
  }
};
const aside = document.querySelector(".aside");
if (aside) {
  let closeAllSubmenu = function(current = null) {
    let parents = [];
    if (current) {
      let currentParent = current.parentNode;
      while (currentParent) {
        if (currentParent.classList.contains("aside"))
          break;
        if (currentParent.nodeName === "UL")
          parents.push(currentParent);
        currentParent = currentParent.parentNode;
      }
    }
    const subMenu = document.querySelectorAll(".aside__submenu");
    subMenu.forEach((item) => {
      if (item != current && !parents.includes(item)) {
        item.classList.remove("show");
        if (item.previousElementSibling.classList.contains("aside__link--sublist")) {
          item.previousElementSibling.classList.remove("show");
        }
      }
    });
  };
  var closeAllSubmenu2 = closeAllSubmenu;
  const asideList = document.querySelector(".aside__menu");
  asideList.addEventListener("mouseover", (evt) => {
    if (!evt.target.classList.contains("aside__link--sublist"))
      return;
    const submenu = evt.target.nextElementSibling;
    closeAllSubmenu(submenu);
    submenu.classList.add("show");
    evt.target.classList.add("show");
    const subMenuCoord = evt.target.getBoundingClientRect().top;
    submenu.style.top = subMenuCoord + "px";
  });
  asideList.addEventListener("mouseout", (evt) => {
    if (evt.relatedTarget && evt.relatedTarget.closest("ul") && evt.relatedTarget.closest("ul").previousElementSibling == evt.target) {
      evt.target.classList.add("show");
      evt.target.nextElementSibling.classList.add("show");
    } else {
      closeAllSubmenu(evt.target);
      evt.target.classList.remove("show");
    }
  });
  asideList.addEventListener("mouseleave", closeAllSubmenu);
}
class NewWaveSelect {
  constructor(selector) {
    const WRAPPER_CLASS = "select";
    const WRAPPER_ACTIVE_CLASS = "active";
    const WRAPPER_DATA_SET = "data-select";
    const SELECTED_TEXT_CLASS = "select__chosen input";
    const LIST_CLASS = "select__list";
    const OPTION_CLASS = "select__option";
    const OPTION_ACTIVE_CLASS = "active";
    let customSelects = document.querySelectorAll(selector);
    customSelects.forEach((customSelect) => {
      let wrapper = document.createElement("div");
      wrapper.className = WRAPPER_CLASS;
      customSelect.replaceWith(wrapper);
      wrapper.setAttribute(WRAPPER_DATA_SET, "");
      wrapper.appendChild(customSelect);
      let selectedText = document.createElement("p");
      selectedText.className = SELECTED_TEXT_CLASS;
      selectedText.textContent = customSelect.options[customSelect.selectedIndex].text;
      wrapper.appendChild(selectedText);
      let dropdownList = document.createElement("ul");
      dropdownList.className = LIST_CLASS;
      wrapper.appendChild(dropdownList);
      let opts = customSelect.querySelectorAll("option");
      opts.forEach((opt) => {
        let optionsItem = document.createElement("li");
        optionsItem.className = OPTION_CLASS;
        optionsItem.setAttribute("data-value", opt.value);
        optionsItem.textContent = opt.textContent;
        dropdownList.appendChild(optionsItem);
      });
      dropdownList.addEventListener("click", (e) => {
        const optionValue = e.target.closest("li");
        selectedText.textContent = optionValue.textContent;
        customSelect.value = optionValue.dataset.value;
        wrapper.classList.remove(WRAPPER_ACTIVE_CLASS);
      });
      selectedText.addEventListener("click", () => {
        if (wrapper.classList.contains(WRAPPER_ACTIVE_CLASS)) {
          wrapper.classList.remove(WRAPPER_ACTIVE_CLASS);
        } else {
          let activeDropdown = document.querySelectorAll("[" + WRAPPER_DATA_SET + "]." + WRAPPER_ACTIVE_CLASS);
          activeDropdown.forEach((item) => item.classList.remove(OPTION_ACTIVE_CLASS));
          wrapper.classList.add(WRAPPER_ACTIVE_CLASS);
        }
      });
      document.addEventListener("click", (e) => {
        let activeDropdown = document.querySelectorAll("[" + WRAPPER_DATA_SET + "]." + WRAPPER_ACTIVE_CLASS);
        if (!e.target.closest("[" + WRAPPER_DATA_SET + "]") && activeDropdown) {
          activeDropdown.forEach((item) => item.classList.remove(OPTION_ACTIVE_CLASS));
        }
      });
    });
  }
}
new NewWaveSelect(".select");
