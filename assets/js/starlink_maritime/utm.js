/* UTM parameter capture -> cookies -> hidden form fields (moved from inline template script) */
    (function () {
        function getParameterByName(name) {
            const url = new URL(window.location.href);
            return url.searchParams.get(name);
        }

        function setCookie(name, value, days) {
            const expires = new Date();
            expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
            document.cookie = `${name}=${value};expires=${expires.toUTCString()};path=/`;
        }

        function getCookie(name) {
            const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
            return match ? match[2] : null;
        }

        const utmParams = ["utm_source", "utm_medium", "utm_campaign", "utm_id"];
        utmParams.forEach(param => {
            const value = getParameterByName(param);
            if (value) {
                setCookie(param, value, 30); // Store for 30 days
            }
        });

        document.addEventListener("DOMContentLoaded", function () {
            utmParams.forEach(param => {
                const cookieValue = getCookie(param);
                if (cookieValue) {
                    const input = document.querySelector(`input[name="${param}"]`);
                    if (input) {
                        input.value = cookieValue;
                    }
                }
            });
        });
    })();
