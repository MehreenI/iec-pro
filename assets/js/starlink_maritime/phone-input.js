/* Starlink enquiry phone input + promo validation (moved from inline template script) */
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.menu-items svg').forEach(svg => {
            svg.addEventListener('click', () => {
                document.body.classList.toggle('no-over');
            });
        });

        const CanadaAreaCodes = [
            "204", "236", "249", "250", "289", "306", "343", "365", "387",
            "403", "416", "418", "431", "437", "438", "450", "506", "514",
            "519", "548", "579", "581", "587", "604", "613", "639", "647",
            "672", "705", "709", "742", "778", "780", "782", "807", "819",
            "825", "867", "873", "902", "905"
        ];
        const allCountries = [
            ["United Arab Emirates (‫الإمارات العربية المتحدة‬‎)", "ae", "971", "+999-9-999-99999"],
            ["Afghanistan (‫افغانستان‬‎)", "af", "93", "+99-99-999-9999"],

            ["Åland Islands", "ax", "358", ""],

            ["Albania (Shqipëri)", "al", "355", "+999(999)999-999"],

            ["Algeria (‫الجزائر‬‎)", "dz", "213", "+999-99-999-9999"],

            ["American Samoa", "as", "1684", "+9(999)999-9999"],

            ["Andorra", "ad", "376", "+999-999-999"],

            ["Angola", "ao", "244", "+999(999)999-999"],

            ["Anguilla", "ai", "1264", "+9(999)999-9999"],

            ["Antarctica", "aq", "672", ""],

            ["Antigua and Barbuda", "ag", "1268", "+9(999)999-9999"],

            ["Argentina", "ar", "54", "+99(999)999-9999"],

            ["Armenia (Հայաստան)", "am", "374", "+999-99-999-999"],

            ["Aruba", "aw", "297", "+999-999-9999"],

            ["Australia", "au", "61", "+99 999 999 999"],

            ["Austria (Österreich)", "at", "43", "+99(999)999-9999"],

            ["Azerbaijan (Azərbaycan)", "az", "994", "+999-99-999-99-99"],

            ["Bahamas", "bs", "1242", "+9(999)999-9999"],

            ["Bahrain (‫البحرين‬‎)", "bh", "973", "+999-9999-9999"],

            ["Bangladesh (বাংলাদেশ)", "bd", "880", "+999-99-999-999"],

            ["Barbados", "bb", "1246", "+9(999)999-9999"],

            ["Belarus (Беларусь)", "by", "375", "+999(99)999-99-99"],

            ["Belgium (België)", "be", "32", "+99 999 99 99 99"],

            ["Belize", "bz", "501", "+999-999-9999"],

            ["Benin (Bénin)", "bj", "229", "+999-99-99-9999"],

            ["Bermuda", "bm", "1441", "+9(999)999-9999"],

            ["Bhutan (འབྲུག)", "bt", "975", "+999-9-999-999"],

            ["Bolivia", "bo", "591", "+999-9-999-9999"],

            ["Bosnia and Herzegovina (Босна и Херцеговина)", "ba", "387", "+999-99-9999"],

            ["Botswana", "bw", "267", "+999-99-999-999"],

            ["Bouvet Island", "aq", "672", ""],

            ["Brazil (Brasil)", "br", "55", "+99-99-9999-9999"],

            ["British Indian Ocean Territory", "io", "246", "+999-999-9999"],

            ["British Virgin Islands", "vg", "1284", "+9(999)999-9999"],

            ["Brunei", "bn", "673", "+999-999-9999"],

            ["Bulgaria (България)", "bg", "359", "+999(999)999-999"],

            ["Burkina Faso", "bf", "226", "+999-99-99-9999"],

            ["Burundi (Uburundi)", "bi", "257", "+999-99-99-9999"],

            ["Cambodia (កម្ពុជា)", "kh", "855", "+999-99-999-999"],

            ["Cameroon (Cameroun)", "cm", "237", "+999-9999-9999"],

            ["Canada", "ca", "1", "+9 (999) 999-9999", 1, CanadaAreaCodes],

            ["Cape Verde (Kabu Verdi)", "cv", "238", "+999(999)99-99"],

            ["Caribbean Netherlands", "bq", "599", "+999-999-9999", 1],

            ["Cayman Islands", "ky", "1345", "+9(999)999-9999"],

            [
                "Central African Republic (République centrafricaine)",

                "cf",

                "236",

                "+999-99-99-9999"
            ],

            ["Chad (Tchad)", "td", "235", "+999-99-99-99-99"],

            ["Chile", "cl", "56", "+99-9-9999-9999"],

            ["China (中国)", "cn", "86", "+99 99-99999999"],

            ["Christmas Island", "cx", "61", ""],

            ["Cocos (Keeling) Islands", "cc", "61", ""],

            ["Colombia", "co", "57", "+99(999)999-9999"],

            ["Comoros (‫جزر القمر‬‎)", "km", "269", "+999-99-99999"],

            [
                "Congo (DRC) (Jamhuri ya Kidemokrasia ya Kongo)",

                "cd",

                "243",

                "+999(999)999-999"
            ],

            ["Congo (Republic) (Congo-Brazzaville)", "cg", "242", "+999-99-999-9999"],

            ["Cook Islands", "ck", "682", "+999-99-999"],

            ["Costa Rica", "cr", "506", "+999 9999-9999"],

            ["Côte d’Ivoire", "ci", "225", "+999-99-999-999"],

            ["Croatia (Hrvatska)", "hr", "385", "+999-99-999-999"],

            ["Cuba", "cu", "53", "+99-9-999-9999"],

            ["Curaçao", "cw", "599", "+999-999-9999", 0],

            ["Cyprus (Κύπρος)", "cy", "357", "+999-99-999-999"],

            ["Czech Republic (Česká republika)", "cz", "420", "+999(999)999-999"],

            ["Denmark (Danmark)", "dk", "45", "+99 99 99 99 99"],

            ["Djibouti", "dj", "253", "+999-99-99-99-99"],

            ["Dominica", "dm", "1767", "+9(999)999-9999"],

            [
                "Dominican Republic (República Dominicana)",

                "do",

                "1",

                "+9(999)999-9999",

                2,

                ["809", "829", "849"]
            ],

            ["Ecuador", "ec", "593", "+999-9-999-9999"],

            ["Egypt (‫مصر‬‎)", "eg", "20", "+99(999)999-9999"],

            ["El Salvador", "sv", "503", "+999 9999-9999"],

            ["Equatorial Guinea (Guinea Ecuatorial)", "gq", "240", "+999-99-999-9999"],

            ["Eritrea", "er", "291", "+999-9-999-999"],

            ["Estonia (Eesti)", "ee", "372", "+999-999-9999"],

            ["Ethiopia", "et", "251", "+999-99-999-9999"],

            ["Falkland Islands (Islas Malvinas)", "fk", "500", "+999-99999"],

            ["Faroe Islands (Føroyar)", "fo", "298", "+999-999-999"],

            ["Fiji", "fj", "679", "+999-99-99999"],

            ["Finland (Suomi)", "fi", "358", "+999 99 9999 9999"],

            ["France", "fr", "33", "+99 9 99 99 99 99"],

            ["French Guiana (Guyane française)", "gf", "594", "+999-99999-9999"],

            ["French Polynesia (Polynésie française)", "pf", "689", "+999-99-99-99"],

            ["French Southern and Antarctic Lands", "tf", "262", ""],

            ["Gabon", "ga", "241", "+999-9-99-99-99"],

            ["Gambia", "gm", "220", "+999(999)99-99"],

            ["Georgia (საქართველო)", "ge", "995", "+999(999)999-999"],

            ["Germany (Deutschland)", "de", "49", "+99 999 9999999"],

            ["Ghana (Gaana)", "gh", "233", "+999(999)999-999"],

            ["Gibraltar", "gi", "350", "+999-999-99999"],

            ["Greece (Ελλάδα)", "gr", "30", "+99(999)999-9999"],

            ["Greenland (Kalaallit Nunaat)", "gl", "299", "+999-99-99-99"],

            ["Grenada", "gd", "1473", "+9(999)999-9999"],

            ["Guadeloupe", "gp", "590", "", 0],

            ["Guam", "gu", "1671", "+9(999)999-9999"],

            ["Guatemala", "gt", "502", "+999 9999-9999"],

            ["Guernsey", "gg", "44", ""],

            ["Guinea (Guinée)", "gn", "224", "+999-99-999-999"],

            ["Guinea-Bissau (Guiné Bissau)", "gw", "245", "+999-9-999999"],

            ["Guyana", "gy", "592", "+999-999-9999"],

            ["Haiti", "ht", "509", "+999 9999-9999"],

            ["Heard Island and McDonald Islands", "hm", "672", ""],

            ["Honduras", "hn", "504", "+999-9999-9999"],

            ["Hong Kong (香港)", "hk", "852", "+999 9999 9999"],

            ["Hungary (Magyarország)", "hu", "36", "+99(999)999-999"],

            ["Iceland (Ísland)", "is", "354", "+999 999 9999"],

            ["India (भारत)", "in", "91", "+99 99999-99999"],

            ["Indonesia", "id", "62", "+99-999-9999-9999"],

            ["Iran (‫ایران‬‎)", "ir", "98", "+99(999)999-9999"],

            ["Iraq (‫العراق‬‎)", "iq", "964", "+999(999)999-9999"],

            ["Ireland", "ie", "353", "+999 99 9999999"],

            ["Isle of Man", "im", "44", ""],

            ["Israel (‫ישראל‬‎)", "il", "972", "+999-9-999-9999"],

            ["Italy (Italia)", "it", "39", "+99 999 999999", 0],

            ["Jamaica", "jm", "1876", "+9(999)999-9999"],

            ["Japan (日本)", "jp", "81", "+99 999 99 9999"],

            ["Jersey", "je", "44", ""],

            ["Jordan (‫الأردن‬‎)", "jo", "962", "+999-9-9999-9999"],

            ["Kazakhstan (Казахстан)", "kz", "7", "+9 999 999-99-99", 1],

            ["Kenya", "ke", "254", "+999-999-999999"],

            ["Kiribati", "ki", "686", "+999-99-999"],

            ["Kosovo", "xk", "383", ""],

            ["Kuwait (‫الكويت‬‎)", "kw", "965", "+999-9999-9999"],

            ["Kyrgyzstan (Кыргызстан)", "kg", "996", "+999(999)999-999"],

            ["Laos (ລາວ)", "la", "856", "+999-99-999-999"],

            ["Latvia (Latvija)", "lv", "371", "+999-99-999-999"],

            ["Lebanon (‫لبنان‬‎)", "lb", "961", "+999-9-999-999"],

            ["Lesotho", "ls", "266", "+999-9-999-9999"],

            ["Liberia", "lr", "231", "+999-99-999-999"],

            ["Libya (‫ليبيا‬‎)", "ly", "218", "+999-99-999-999"],

            ["Liechtenstein", "li", "423", "+999(999)999-9999"],

            ["Lithuania (Lietuva)", "lt", "370", "+999(999)99-999"],

            ["Luxembourg", "lu", "352", "+999(999)999-999"],

            ["Macau (澳門)", "mo", "853", "+999-9999-9999"],

            ["Macedonia (FYROM) (Македонија)", "mk", "389", "+999-99-999-999"],

            ["Madagascar (Madagasikara)", "mg", "261", "+999-99-99-99999"],

            ["Malawi", "mw", "265", "+999-9-9999-9999"],

            ["Malaysia", "my", "60", "+99 99-9999-9999"],

            ["Maldives", "mv", "960", "+999-999-9999"],

            ["Mali", "ml", "223", "+999-99-99-9999"],

            ["Malta", "mt", "356", "+999-9999-9999"],

            ["Marshall Islands", "mh", "692", "+999-999-9999"],

            ["Martinique", "mq", "596", "+999(999)99-99-99"],

            ["Mauritania (‫موريتانيا‬‎)", "mr", "222", "+999-99-99-9999"],

            ["Mauritius (Moris)", "mu", "230", "+999-999-9999"],

            ["Mayotte", "yt", "262", ""],

            ["Mexico (México)", "mx", "52", "+99-99-99-9999"],

            ["Micronesia", "fm", "691", "+999-999-9999"],

            ["Moldova (Republica Moldova)", "md", "373", "+999-9999-9999"],

            ["Monaco", "mc", "377", "+999-99-999-999"],

            ["Mongolia (Монгол)", "mn", "976", "+999-99-99-9999"],

            ["Montenegro (Crna Gora)", "me", "382", "+999-99-999-999"],

            ["Montserrat", "ms", "1664", "+9(999)999-9999"],

            ["Morocco (‫المغرب‬‎)", "ma", "212", "+999-99-9999-999"],

            ["Mozambique (Moçambique)", "mz", "258", "+999-99-999-999"],

            ["Myanmar (Burma) (မြန်မာ)", "mm", "95", "+99-999-999"],

            ["Namibia (Namibië)", "na", "264", "+999-99-999-9999"],

            ["Nauru", "nr", "674", "+999-999-9999"],

            ["Nepal (नेपाल)", "np", "977", "+999-99-999-999"],

            ["Netherlands (Nederland)", "nl", "31", "+99 99 99999999"],

            ["New Caledonia (Nouvelle-Calédonie)", "nc", "687", "+999-99-9999"],

            ["New Zealand", "nz", "64", "+99 999-999-9999"],

            ["Nicaragua", "ni", "505", "+999-9999-9999"],

            ["Niger (Nijar)", "ne", "227", "+999-99-99-9999"],

            ["Nigeria", "ng", "234", "+999-99-999-99"],

            ["Niue", "nu", "683", "+999-9999"],

            ["Norfolk Island", "nf", "672", "+999-999-999"],

            ["North Korea (조선 민주주의 인민 공화국)", "kp", "850", "+999-999-999"],

            ["Northern Mariana Islands", "mp", "1670", "+9(999)999-9999"],

            ["Norway (Norge)", "no", "47", "+99 999 99 999"],

            ["Oman (‫عُمان‬‎)", "om", "968", "+999-99-999-999"],

            ["Pakistan (‫پاکستان‬‎)", "pk", "92", "+99 999-9999999"],

            ["Palau", "pw", "680", "+999-999-9999"],

            ["Palestine (‫فلسطين‬‎)", "ps", "970", "+999-99-999-9999"],

            ["Panama (Panamá)", "pa", "507", "+999-999-9999"],

            ["Papua New Guinea", "pg", "675", "+999(999)99-999"],

            ["Paraguay", "py", "595", "+999(999)999-999"],

            ["Peru (Perú)", "pe", "51", "+99(999)999-999"],

            ["Philippines", "ph", "63", "+99 999 9999"],

            ["Pitcairn Islands", "pn", "64", ""],

            ["Poland (Polska)", "pl", "48", "+99 999-999-999"],

            ["Portugal", "pt", "351", "+999-99-999-9999"],

            ["Puerto Rico", "pr", "1", "+9 (999) 999-9999", 3, ["787", "939"]],

            ["Qatar (‫قطر‬‎)", "qa", "974", "+999-9999-9999"],

            ["Réunion (La Réunion)", "re", "262", "+999-99999-9999"],

            ["Romania (România)", "ro", "40", "+99-99-999-9999"],

            ["Russia (Россия)", "ru", "7", "+9 999 999-99-99", 0],

            ["Rwanda", "rw", "250", "+999(999)999-999"],

            ["Saint Barthélemy (Saint-Barthélemy)", "bl", "590", "", 1],

            ["Saint Helena", "sh", "290"],

            ["Saint Kitts and Nevis", "kn", "1869", "+9(999)999-9999"],

            ["Saint Lucia", "lc", "1758", "+9(999)999-9999"],

            ["Saint Martin (Saint-Martin (partie française))", "mf", "590", "", 2],

            ["Saint Pierre and Miquelon (Saint-Pierre-et-Miquelon)", "pm", "508"],

            ["Saint Vincent and the Grenadines", "vc", "1784", "+9(999)999-9999"],

            ["Samoa", "ws", "685", "+999-99-9999"],

            ["San Marino", "sm", "378", "+999-9999-999999"],

            ["São Tomé and Príncipe (São Tomé e Príncipe)", "st", "239", "+999-99-99999"],

            [
                "Saudi Arabia (‫المملكة العربية السعودية‬‎)",

                "sa",

                "966",

                "+999-9-999-9999"
            ],

            ["Senegal (Sénégal)", "sn", "221", "+999-99-999-9999"],

            ["Serbia (Србија)", "rs", "381", "+999-99-999-9999"],

            ["Seychelles", "sc", "248", "+999-9-999-999"],

            ["Sierra Leone", "sl", "232", "+999-99-999999"],

            ["Singapore", "sg", "65", "+99 9999-9999"],

            ["Sint Maarten", "sx", "1721", "+9(999)999-9999"],

            ["Slovakia (Slovensko)", "sk", "421", "+999(999)999-999"],

            ["Slovenia (Slovenija)", "si", "386", "+999-99-999-999"],

            ["Solomon Islands", "sb", "677", "+999-99999"],

            ["Somalia (Soomaaliya)", "so", "252", "+999-9-999-999"],

            ["South Africa", "za", "27", "+99-99-999-9999"],

            ["South Georgia and the South Sandwich Islands", "gs", "500", ""],

            ["South Korea (대한민국)", "kr", "82", "+99-99-999-9999"],

            ["South Sudan (‫جنوب السودان‬‎)", "ss", "211", "+999-99-999-9999"],

            ["Spain (España)", "es", "34", "+99 999 999 999"],

            ["Sri Lanka (ශ්‍රී ලංකාව)", "lk", "94", "+99-99-999-9999"],

            ["Sudan (‫السودان‬‎)", "sd", "249", "+999-99-999-9999"],

            ["Suriname", "sr", "597", "+999-999-999"],

            ["Svalbard and Jan Mayen", "sj", "47", ""],

            ["Swaziland", "sz", "268", "+999-99-99-9999"],

            ["Sweden (Sverige)", "se", "46", "+99 99 999 99 99"],

            ["Switzerland (Schweiz)", "ch", "41", "+99 99 999 99 99"],

            ["Syria (‫سوريا‬‎)", "sy", "963", "+999-99-9999-999"],

            ["Taiwan (台灣)", "tw", "886", "+999-9999-9999"],

            ["Tajikistan", "tj", "992", "+999-99-999-9999"],

            ["Tanzania", "tz", "255", "+999-99-999-9999"],

            ["Thailand (ไทย)", "th", "66", "+99-99-999-999"],

            ["Timor-Leste", "tl", "670", "+999-999-9999"],

            ["Togo", "tg", "228", "+999-99-999-999"],

            ["Tokelau", "tk", "690", "+999-9999"],

            ["Tonga", "to", "676", "+999-99999"],

            ["Trinidad and Tobago", "tt", "1868", "+9(999)999-9999"],

            ["Tunisia (‫تونس‬‎)", "tn", "216", "+999-99-999-999"],

            ["Turkey (Türkiye)", "tr", "90", "+99 999 999 99 99"],

            ["Turkmenistan", "tm", "993", "+999-9-999-9999"],

            ["Turks and Caicos Islands", "tc", "1649", "+9(999)999-9999"],

            ["US Virgin Islands", "vi", "1340", "+9(999)999-9999"],

            ["Uganda", "ug", "256", "+999(999)999-999"],

            ["Ukraine (Україна)", "ua", "380", "+999(99)999-99-99"],

            [
                "United Arab Emirates (‫الإمارات العربية المتحدة‬‎)",

                "ae",

                "971",

                "+999-9-999-9999"
            ],

            ["United Kingdom", "gb", "44", "+99 9999 999999"],

            ["United States", "us", "1", "+9 (999) 999-9999", 0],

            ["United States Minor Outlying Islands", "um", "1", ""],

            ["Uruguay", "uy", "598", "+999-9-999-99-99"],

            ["Uzbekistan (Oʻzbekiston)", "uz", "998", "+999-99-999-9999"],

            ["Vanuatu", "vu", "678", "+999-99999"],

            ["Vatican City (Città del Vaticano)", "va", "39", "+99 9999 999999", 1],

            ["Venezuela", "ve", "58", "+99(999)999-9999"],

            ["Vietnam (Việt Nam)", "vn", "84", "+99-99-9999-999"],

            ["Wallis and Futuna", "wf", "681", "+999-99-9999"],

            ["Western Sahara", "eh", "212", "+999-99-9999"],

            ["Yemen (‫اليمن‬‎)", "ye", "967", "+999-9-999-999"],

            ["Zambia", "zm", "260", "+999-99-999-9999"],

            ["Zimbabwe", "zw", "263", "+999-9-999999"]

        ];
        const input = document.querySelector("#phone");
        if (!input) return;

        const iti = window.intlTelInput(input, {
            initialCountry: "us",
            separateDialCode: false,
            nationalMode: false,
            useFullscreenPopup: false,
            autoPlaceholder: "off",
            utilsScript: ( window.iecConfig && window.iecConfig.intlTelUtils ) || ""
        });

        function getMaxDigitsFromMask(mask) {
            if (!mask) return 15;
            return (mask.match(/9/g) || []).length;
        }

        input.addEventListener("input", function () {
            input.value = input.value.replace(/[^\d+]/g, "");

            const selectedCountryData = iti.getSelectedCountryData();
            const iso2 = selectedCountryData.iso2;

            const country = allCountries.find(c => c[1] === iso2);
            let maxDigits = 15;

            if (country && country[3]) {
                maxDigits = getMaxDigitsFromMask(country[3]);
            }

            if (iso2 === 'ua') {
                const dialCode = selectedCountryData.dialCode;
                let rawInputValue = input.value;
                const fullDialCodePrefix = rawInputValue.startsWith('+') ? '+' + dialCode : dialCode;

                if (rawInputValue.startsWith(fullDialCodePrefix)) {
                    const indexAfterDialCode = fullDialCodePrefix.length;
                    if (indexAfterDialCode < rawInputValue.length && rawInputValue[indexAfterDialCode] === '0') {
                        input.value = rawInputValue.substring(0, indexAfterDialCode) + rawInputValue.substring(indexAfterDialCode + 1);
                    }
                }
            }

            const fullDigitsNumber = iti.getNumber().replace(/\D/g, '');
            if (fullDigitsNumber.length > maxDigits) {
                const dialCode = selectedCountryData.dialCode;
                let trimmedValue = input.value;

                if (trimmedValue.startsWith('+' + dialCode)) {
                    const digitsAfterCode = fullDigitsNumber.slice(dialCode.length);
                    if (digitsAfterCode.length > (maxDigits - dialCode.length)) {
                        const allowedDigits = digitsAfterCode.slice(0, maxDigits - dialCode.length);
                        input.value = '+' + dialCode + allowedDigits;
                    }
                } else {
                    input.value = fullDigitsNumber.slice(0, maxDigits);
                }
            }
        });

        input.addEventListener("keydown", function (e) {
            const selectionStart = input.selectionStart;
            const currentValue = input.value;

            if (e.key === "Backspace" || e.key === "Delete") {
                const dialCode = iti.getSelectedCountryData().dialCode;
                if (currentValue.startsWith('+' + dialCode) && selectionStart <= dialCode.length + 1) {
                    e.preventDefault();
                }
            }
        });
        input.addEventListener("blur", function () {
            if (input.value.trim() === "") {
                const selectedCountryData = iti.getSelectedCountryData();
                input.value = "+" + selectedCountryData.dialCode;
            }
            const selectedCountryData = iti.getSelectedCountryData();
            const iso2 = selectedCountryData.iso2;
            const dialCode = selectedCountryData.dialCode;

            const country = allCountries.find(c => c[1] === iso2);
            const maxDigits = country && country[3] ? getMaxDigitsFromMask(country[3]) : 15;

            const fullNumber = iti.getNumber();
            const digitsOnly = fullNumber.replace(/\D/g, '');

            const fieldParent = input.closest('.form-field');

            if (digitsOnly.length < maxDigits) {
                if (fieldParent) {
                    fieldParent.classList.add('field-invalid');
                }
            } else {
                if (fieldParent) {
                    fieldParent.classList.remove('field-invalid');
                }
            }
        });
        const promoInput = document.getElementById('promo_code');
        const promoWrapper = document.getElementById('promo_wrapper');
        const validCode = 'philmarine25';

        promoInput.addEventListener('input', function () {
            const value = promoInput.value.trim().toLowerCase();
            let errorSpan = promoWrapper.querySelector('.error-promo');

            if (value !== validCode && value !== '') {
                promoInput.classList.add('field-invalid');
                if (!errorSpan) {
                    errorSpan = document.createElement('span');
                    errorSpan.className = 'error-promo';
                    errorSpan.textContent = 'Incorrect value';
                    promoWrapper.appendChild(errorSpan);
                }
            } else {
                promoInput.classList.remove('field-invalid');
                if (errorSpan) errorSpan.remove();
            }
        });
    });
