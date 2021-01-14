  
        checkBrowser();
        function checkBrowser()
        {
            // Opera 8.0+
            var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;

            // Firefox 1.0+
            var isFirefox = typeof InstallTrigger !== 'undefined';

            // Safari 3.0+ "[object HTMLElementConstructor]" 
            var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || (typeof safari !== 'undefined' && safari.pushNotification));

            // Internet Explorer 6-11
            var isIE = /*@cc_on!@*/false || !!document.documentMode;

            // Edge 20+
            var isEdge = !isIE && !!window.StyleMedia;

            // Chrome 1+
            var isChrome = !!window.chrome && !!window.chrome.webstore;

            // Blink engine detection
            var isBlink = (isChrome || isOpera) && !!window.CSS;

            if (isIE) {
              var html = '';
              html += '<div style=" text-align: center;width: 100%;color: rgb(96, 96, 96);padding: 20px;margin-top: 45px;/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#ffffff+0,e5e5e5+11,e5e5e5+20,e5e5e5+26,ededed+35,e5e5e5+45,f3f3f3+50,ededed+51,f9f9f9+83,ffffff+100 */background: rgb(255,255,255); /* Old browsers */background: -moz-linear-gradient(45deg, rgba(255,255,255,1) 0%, rgba(229,229,229,1) 11%, rgba(229,229,229,1) 20%, rgba(229,229,229,1) 26%, rgba(237,237,237,1) 35%, rgba(229,229,229,1) 45%, rgba(243,243,243,1) 50%, rgba(237,237,237,1) 51%, rgba(249,249,249,1) 83%, rgba(255,255,255,1) 100%); /* FF3.6-15 */background: -webkit-linear-gradient(45deg, rgba(255,255,255,1) 0%,rgba(229,229,229,1) 11%,rgba(229,229,229,1) 20%,rgba(229,229,229,1) 26%,rgba(237,237,237,1) 35%,rgba(229,229,229,1) 45%,rgba(243,243,243,1) 50%,rgba(237,237,237,1) 51%,rgba(249,249,249,1) 83%,rgba(255,255,255,1) 100%); /* Chrome10-25,Safari5.1-6 */background: linear-gradient(45deg, rgba(255,255,255,1) 0%,rgba(229,229,229,1) 11%,rgba(229,229,229,1) 20%,rgba(229,229,229,1) 26%,rgba(237,237,237,1) 35%,rgba(229,229,229,1) 45%,rgba(243,243,243,1) 50%,rgba(237,237,237,1) 51%,rgba(249,249,249,1) 83%,rgba(255,255,255,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#ffffff\',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */">';
                html += '<h1>Lo sentimos, su navegador no es compatible </h1>';
                html += '<h3>Recomendamos usar  Google Chrome </h3>';
                html += '<a href="https://www.google.com/chrome/"><img src="/img/Google_Chrome_icon.png"  height="80" ></a>';
              html += '</div>'
              document.getElementsByTagName("BODY")[0].innerHTML = html;
            }
        }