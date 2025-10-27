let formShown = false;

const hamburgerButton = document.getElementById("hamburger");
const dropdownContent = document.getElementById("dropdownContent");
let menu = document.querySelectorAll(".nav-menu");

hamburgerButton.addEventListener("click", toggleDropdown);

document.body.addEventListener("click", (event) => {
  if (
    !dropdownContent.contains(event.target) &&
    !hamburgerButton.contains(event.target)
  ) {
    dropdownContent.classList.remove("active");
  }
});
menu.forEach((menu) => {
  menu.addEventListener("click", function (e) {
    e.preventDefault();
    dropdownContent.classList.remove("active");
  });
});

function toggleDropdown() {
  dropdownContent.classList.toggle("active");
}

function toggleSearchDropdown() {
  dropdownContent.classList.toggle("active");
  searchInput.focus();
}

window.addEventListener("scroll", () => {
  if (dropdownContent && dropdownContent.classList.contains("active")) {
    dropdownContent.classList.remove("active");
  }
});

// tabs
function openfeat(feat, features, sectionId, button = "tab_button") {
  // Declare all variables
  let i, tabcontentfea, tablinksfea;

  // Get all elements with class="tabcontent" within the specified section and hide them
  tabcontentfea = document.querySelectorAll(`#${sectionId} .features`);
  tabcontentfea.forEach((tab) => {
    tab.style.display = "none";
  });

  // Get all elements with class="tablinks" within the specified section and remove the class "active"
  tablinksfea = document.querySelectorAll(`#${sectionId} .${button}`);
  tablinksfea.forEach((tab) => {
    tab.classList.remove("active");
  });

  // Show the current tab, and add an "active" class to the button that opened the tab
  document.getElementById(features).style.display = "flex";
  feat.currentTarget.classList.add("active");
}

document.querySelector(".tab_head .tab_button:first-child").click();
document.querySelector(".tab_head .gallery_tab_button:first-child").click();

// Banner Carousel with auto-slide
document.addEventListener("DOMContentLoaded", () => {
  const bannerSlides = document.querySelectorAll(".banner-carousel .slide");
  const bannerRadioButtons = document.querySelectorAll(".banner-carousel .radio-button");

  if (bannerSlides.length > 0) {
    bannerSlides[0].classList.add("active");
  }
  if (bannerRadioButtons.length > 0) {
    bannerRadioButtons[0].classList.add("active");
  }

  let currentBannerIndex = 0;

  // Make goToSlide function global for onclick handlers
  window.goToSlide = function(index) {
    currentBannerIndex = index;
    updateBannerSlides();
    updateBannerRadioButtons();
  }

  function updateBannerSlides() {
    bannerSlides.forEach((slide, index) => {
      if (index === currentBannerIndex) {
        slide.classList.add("active");
      } else {
        slide.classList.remove("active");
      }
    });
  }

  function updateBannerRadioButtons() {
    bannerRadioButtons.forEach((button, index) => {
      if (index === currentBannerIndex) {
        button.classList.add("active");
      } else {
        button.classList.remove("active");
      }
    });
  }

  function moveToNextBanner() {
    currentBannerIndex = (currentBannerIndex + 1) % bannerSlides.length;
    updateBannerSlides();
    updateBannerRadioButtons();
  }

  // Auto-slide every 5 seconds
  setInterval(moveToNextBanner, 5000);
});

/* onclick Menu list scroll to respective section */
function go_to_section(getId) {
  const targetElement = document.querySelector(getId);

  if (targetElement) {
    window.scrollTo({
      top: targetElement.offsetTop - 100,
      behavior: "smooth",
    });
  }
}

let overlay = document.querySelector(".overlay");
let popup = document.querySelector(".popup_form");
let otpPopup = document.querySelector(".otpp_form");

// Function to open the popup
function openPopup() {
  overlay.style.display = "block";
  popup.classList.add("open");
  isOpen = true;

  document.querySelector(".overlay").addEventListener("click", closePopup);
}

// 		function for timer
let timerInterval;
let countdownTime = 5 * 60; // 5 minutes in seconds

function startTimer() {
  const timerDisplay = document.getElementById("timer");
  let resend_otp = document.querySelector(".resend_otp");

  countdownTime = 5 * 60;

  timerInterval = setInterval(() => {
    const minutes = Math.floor(countdownTime / 60);
    const seconds = countdownTime % 60;

    timerDisplay.textContent = `${minutes}:${
      seconds < 10 ? "0" : ""
    }${seconds}`;

    if (countdownTime <= 0) {
      timerDisplay.style.display = "none";
      resend_otp.style.display = "block";
    }

    countdownTime--;
  }, 1000);
}

// function to open galley popup
let galleryPopup = document.querySelector(".amenities_gallery_popup");

function openGallery(num) {
  galleryPopup.style.top = "50%";
  overlay.style.display = "block";
  isOpen = true;

  document.querySelector(".overlay").addEventListener("click", closeGallery);
  document
    .querySelector(".tab_head .gallery_tab_button:nth-child(" + num + ")")
    .click();
}

// Function to close the popup
function closePopup() {
  popup.classList.remove("open");

  overlay.style.display = "none";

  isOpen = false;
}

function closeOtp() {
  overlay.style.display = "block";
  otpPopup.classList.remove("open");
  isOpen = true;
}

function closeGallery() {
  overlay.style.display = "none";

  galleryPopup.style.top = "-100%";
  isOpen = false;
}

// This object holds all the different text arrays for your points
const pointsData = {
  "download brochure": [
    "Project Overview",
    "High-Res Images",
    "Amenities List",
    "Unit Configurations",
  ],
  "floor plan": [
    "All Unit Layouts",
    "Room Dimensions",
    "Carpet Area Details",
    "Vastu Compliance",
  ],
  "unlock price": [
    "Base Price Breakdown",
    "Detailed Cost Sheet",
    "Exclusive Offers",
    "Payment Schedules",
  ],
  "costing details": [
    "Base Price Breakdown",
    "Detailed Cost Sheet",
    "Exclusive Offers",
    "Payment Schedules",
  ],
  "Play video": [
    "Property Walkthrough",
    "Amenities Tour",
    "Sample Flat Tour",
    "Construction Update",
  ],
  // Default points for any other case
  default: [
    "Detailed Pricing",
    "Payment Schedule",
    "Special Offers",
    "Hidden Costs Info",
  ],
};

function showPopupForm(e, clicked) {
  closePopup(); // Close any open forms before showing a new one

  if (!formShown) {
    formShown = true;
  }

  let popformHeading = document.querySelector(".popup_details h2");
  document.getElementById("clicked_on1").value = clicked;

  const pointsListItems = document.querySelectorAll(
    ".popup-highlights .points li"
  );
  const newPointsText = pointsData[clicked] || pointsData.default;

  pointsListItems.forEach((li, index) => {
    if (li.lastChild && newPointsText[index]) {
      li.lastChild.textContent = " " + newPointsText[index];
    }
  });

  // This part of your code remains the same
  if (clicked === "download brochure") {
    popformHeading.innerHTML = "Download the brochure";
    openPopup();
  } else if (clicked == "floor plan") {
    popformHeading.innerHTML = "Unlock the floor plan";
    openPopup();
  } else if (clicked == "unlock price" || clicked == "costing details") {
    popformHeading.innerHTML = "Unlock the price";
    openPopup();
  } else if (clicked == "Play video") {
    popformHeading.innerHTML = "Virtual tour video";
    openPopup();
  } else if (clicked == "whatsApp" || clicked == "call") {
    popformHeading.innerHTML = "Get the best deals";
    openPopup();
  } else {
    popformHeading.innerHTML = "Get the best deals on this project";
    openPopup();
  }
}

const yearSpan = document.getElementById("discYear");
const currentYear = new Date().getFullYear();
yearSpan.textContent = currentYear;

// Prevent drag
document.addEventListener("dragstart", function (event) {
  event.preventDefault();
});

// Page Zoom In / Out Prevent
document.addEventListener("keydown", (event) => {
  if ((event.ctrlKey || event.metaKey) && ["=", "-", "0"].includes(event.key)) {
    event.preventDefault();
  }
});
document.addEventListener(
  "wheel",
  (event) => {
    if (event.ctrlKey) {
      event.preventDefault();
    }
  },
  { passive: false }
);

// Prevent right-click
document.addEventListener("contextmenu", function (event) {
  event.preventDefault();
  showPopupForm(event, "Enquire Now");
});

// Auto Popup
setTimeout(() => {
  if (!formShown) {
    showPopupForm("", "Enquire Now");
  }
}, 10000);

// Scroll Popup
const triggerElement = document.getElementById("about-builder");
const observer = new IntersectionObserver((entries, observer) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      showPopupForm("", "Enquire Now");
      observer.unobserve(triggerElement);
    }
  });
});
observer.observe(triggerElement);

// Form Mobile Validation
function setupPhoneValidation(inputId, errorId) {
  const phoneInput = document.getElementById(inputId);
  const errorMsg = document.getElementById(errorId);

  if (!phoneInput || !errorMsg) {
    console.error("Validation elements not found for input:", inputId);
    return;
  }

  errorMsg.style.display = "none";
  const invalidStartDigits = ["0", "1", "2", "3", "4", "5"];

  const handleLiveValidation = () => {
    const value = phoneInput.value;
    errorMsg.style.display = "none";
    if (value.length > 0 && invalidStartDigits.includes(value[0])) {
      errorMsg.textContent =
        "Phone number cannot start with 0, 1, 2, 3, 4, or 5.";
      errorMsg.style.display = "block";
    } else if (value.length > 0 && value.length !== 10) {
      errorMsg.textContent = "Phone number must be exactly 10 digits long.";
      errorMsg.style.display = "block";
    }
  };

  phoneInput.addEventListener("input", function () {
    if (this.value.length > 10) {
      this.value = this.value.slice(0, 10);
    }
    handleLiveValidation();
  });

  phoneInput.addEventListener("blur", function () {
    if (this.value.length === 0) {
      errorMsg.textContent = "Phone number is required.";
      errorMsg.style.display = "block";
    } else {
      handleLiveValidation();
    }
  });
}

function initializeFormValidation(phoneFields, submitButtonId) {
  const submitButton = document.getElementById(submitButtonId);
  if (!submitButton) {
    console.error("Submit button not found:", submitButtonId);
    return;
  }

  const form = submitButton.form;
  if (!form) {
    console.error(
      "Submit button '",
      submitButtonId,
      "'Not found within a form."
    );
    return;
  }

  phoneFields.forEach((field) => {
    setupPhoneValidation(field.inputId, field.errorId);
  });

  form.addEventListener("submit", function (event) {
    let isFormValid = true;

    for (const field of phoneFields) {
      const inputElement = document.getElementById(field.inputId);
      const errorElement = document.getElementById(field.errorId);
      const value = inputElement.value;
      const invalidStartDigits = ["0", "1", "2", "3", "4", "5"];

      errorElement.style.display = "none";

      if (value.length === 0) {
        errorElement.textContent = "Phone number is required.";
        errorElement.style.display = "block";
        isFormValid = false;
        break;
      } else if (invalidStartDigits.includes(value[0])) {
        errorElement.textContent =
          "Phone number cannot start with 0, 1, 2, 3, 4, or 5.";
        errorElement.style.display = "block";
        isFormValid = false;
        break;
      } else if (value.length !== 10) {
        errorElement.textContent =
          "Phone number must be exactly 10 digits long.";
        errorElement.style.display = "block";
        isFormValid = false;
        break;
      }
    }

    if (!isFormValid) {
      event.preventDefault();
    }
  });
}

document.addEventListener("DOMContentLoaded", function () {
  initializeFormValidation(
    [{ inputId: "input_phone_id", errorId: "M_error-msg" }],
    "submit-btn-1"
  );

  initializeFormValidation(
    [{ inputId: "input_phone_id_2", errorId: "M_error-msg_2" }],
    "submit-btn-2"
  );
});

// Read More
document.addEventListener("DOMContentLoaded", function () {
  const charLimit = 800;
  const elements = document.querySelectorAll(".expandable-text");
  elements.forEach((p) => {
    p.setAttribute("data-fulltext", p.innerHTML);
    if (p.innerHTML.length > charLimit) {
      const fullText = p.getAttribute("data-fulltext");
      const shortText = fullText.substring(0, charLimit);
      p.innerHTML = `${shortText}... <a href="#" class="toggle-link">Read more</a>`;
    }
  });
  document.addEventListener("click", function (event) {
    if (event.target.classList.contains("toggle-link")) {
      const p = event.target.closest(".expandable-text");
      const fullText = p.getAttribute("data-fulltext");
      const shortText = fullText.substring(0, charLimit);
      if (event.target.textContent === "Read more") {
        p.innerHTML = `${fullText} <a href="#" class="toggle-link">Read less</a>`;
      } else {
        p.innerHTML = `${shortText}... <a href="#" class="toggle-link">Read more</a>`;
      }
    }
  });
});

// Popup Background Page Scroll Block
if (popup) {
  const observerCallback = function (mutationsList, observer) {
    for (const mutation of mutationsList) {
      if (
        mutation.type === "attributes" &&
        mutation.attributeName === "class"
      ) {
        if (popup.classList.contains("open")) {
          document.body.classList.add("no-scroll");
          console.log("Popup opened. Scrolling disabled.");
        } else {
          document.body.classList.remove("no-scroll");
          console.log("Popup closed. Scrolling enabled.");
        }
      }
    }
  };
  const observer = new MutationObserver(observerCallback);
  observer.observe(popup, { attributes: true });
} else {
  console.error("Element with class .popup_form not found.");
}
