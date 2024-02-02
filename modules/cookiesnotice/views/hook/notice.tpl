<div class="cookies-notice">
    <span>{$cookie_text}</span>
    <span class="btn-close">X</span>
</div>

{literal}
    <style>
        .cookies-notice {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 60px;
            background-color: rgb(0 0 0 / 80%);
            text-align: center;
            display: flex;
            flex-wrap: nowrap;
            align-content: center;
            align-items: center;
            justify-content: center;
            color: white;
            z-index: 10;
        }

        .btn-close {
            position: absolute;
            top: 1px;
            right: 1px;
            width: 20px;
            height: 20px;
            color: #ff9a52;
            background-color: transparent;
            font-family: ui-monospace;
            padding: 2px;
            cursor: pointer;
        }
    </style>
    <script defer>
        function showCookies(){
            document.querySelector('.cookies-notice').style.display = 'flex';
        }
        function hideCookies(){
            let element = document.querySelector('.cookies-notice');
            localStorage.setItem('cookies-notice-viewed', true);
            element.style.display = 'none';

        }
        document.addEventListener('DOMContentLoaded', function () {
            let showed = localStorage.getItem('cookies-notice-viewed');
            if (showed === 'true') {
                hideCookies();
            } else {
                showCookies();
            }
            document.querySelector('.btn-close').addEventListener('click', function (event) {
                hideCookies();
            });
        });

    </script>
{/literal}
