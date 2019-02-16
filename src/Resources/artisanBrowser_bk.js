if(window.addEventListener) {
    window.addEventListener("load", function() {
        artisanBrowserMethod.artisanBrowserLoadConfirm();
        artisanBrowserMethod.artisanBrowserShowWindow();
        artisanBrowserMethod.artisanBrowserSwichTab();
        artisanBrowserMethod.artisanBrowserSuggest();
        artisanBrowserMethod.artisanBrowserLoadConfirmAjax();
        artisanBrowserMethod.artisanBrowserAjax();
    }, false );
}
else {
    window.attachEvent("onload", function() {
        artisanBrowserMethod.artisanBrowserLoadConfirm();
        artisanBrowserMethod.artisanBrowserShowWindow();
        artisanBrowserMethod.artisanBrowserSwichTab();
        artisanBrowserMethod.artisanBrowserSuggest();
        artisanBrowserMethod.artisanBrowserLoadConfirmAjax();
        artisanBrowserMethod.artisanBrowserAjax();
    });
}

var artisanBrowserMethod = {
    // Show ArtisanBrowser window.
    artisanBrowserShowWindow: function() {
        var artisanbrowserRootBox = document.getElementsByClassName("artisanbrowser-root-box");
        var artisanbrowserOverLay = document.getElementsByClassName("artisanbrowser-overlay");
        
        var artisanbrowserAppBtn = document.getElementsByClassName("artisanbrowser-btn");
        artisanbrowserAppBtn[0].addEventListener("click", function() {
            artisanbrowserRootBox[0].classList.add("artisanbrowser-show");
            artisanbrowserOverLay[0].classList.add("artisanbrowser-show");
            
            artisanbrowserOverLay[0].addEventListener("click", function() {
                artisanbrowserRootBox[0].classList.remove("artisanbrowser-show");
                artisanbrowserOverLay[0].classList.remove("artisanbrowser-show");
            }, false);
        }, false);
    },

    // Switching tabs.
    artisanBrowserSwichTab: function() {
        var artisanbrowserBtn = document.getElementsByClassName("artisanbrowser-nav-item");
        for (var i = 0; i < artisanbrowserBtn.length; i++) {
            artisanbrowserBtn[i].firstElementChild.addEventListener("click", function(e) {
                var artisanbrowserAhrf = e.target;
                e.preventDefault();
                
                if(!artisanbrowserAhrf.classList.contains("artisanbrowser-nav-active")) {
                    if(artisanbrowserAhrf.tagName == 'A') {
                        for (var n = 0; n < artisanbrowserBtn.length; n++) {
                            artisanbrowserBtn[n].firstElementChild.classList.remove("artisanbrowser-nav-active")
                        }
                        artisanbrowserAhrf.classList.add("artisanbrowser-nav-active");
                        
                        var artisanbrowserRoute = document.getElementsByClassName("artisanbrowser-window-route");
                        var artisanbrowserArtisan = document.getElementsByClassName("artisanbrowser-window-artisan");
                        
                        artisanbrowserRoute[0].classList.remove("artisanbrowser-show");
                        artisanbrowserArtisan[0].classList.remove("artisanbrowser-show");
    
                        var artisanbrowserWindowType = artisanbrowserAhrf.dataset.artisanbrowseractive;
                        var artisanbrowserWindow = document.getElementsByClassName("artisanbrowser-window-" + artisanbrowserWindowType);
                        artisanbrowserWindow[0].classList.add("artisanbrowser-show");

                        if(artisanbrowserWindowType == "artisan") {
                            document.getElementById("artisanbrowser-window-command-suffix").focus();
                        }
                    }
                }
            }, false);
        }
    },

    // Load suggest.js.
    artisanBrowserLoadConfirm: function() {
        if(typeof Suggest == "undefined") {
            var head = document.getElementsByTagName("head");
            var script = document.createElement("script");
            script.setAttribute("src", "//www.enjoyxstudy.com/javascript/suggest/suggest.js");
            script.setAttribute("type","text/javascript");
        
            document.head.appendChild(script);
        }
    },

    // Strat suggests.
    artisanBrowserSuggest: function() {
        var artisanBrowserSuggestObj = null;
        var artisanBrowserSuggestInput = document.getElementById("artisanbrowser-window-command-suffix");
        
        artisanBrowserSuggestInput.addEventListener("focus", function() {
            if(artisanBrowserSuggestObj == null) {
                artisanBrowserSuggestObj = new Suggest.Local(
                    "artisanbrowser-window-command-suffix", // Input Element.
                    "artisanbrowser-suggest",       // Suggest area.
                    JSON.parse(artisanBrowserCmdList),    // Haystack.
                    {
                        dispMax: 0, 
                        highlight: true
                    }   
                );
            }
        }, false);
    },

    artisanBrowserLoadConfirmAjax: function() {
        if(typeof axios == "undefined") {
            var head = document.getElementsByTagName("head");
            var script = document.createElement("script");
            script.setAttribute("src", "//unpkg.com/axios/dist/axios.min.js");
            script.setAttribute("type","text/javascript");
        
            document.head.appendChild(script);
        }
    },

    artisanBrowserAjax: function() {
        var artisanBrowserSuggestInputPrefixClone = document.getElementsByClassName("artisanbrowser-window-command-prefix")[0].cloneNode(true);
        var artisanBrowserSuggestInputClone = document.getElementById("artisanbrowser-window-command-suffix").cloneNode(true);
        var artisanbrowserSuggestClone = document.getElementById("artisanbrowser-suggest").cloneNode(true);

        var artisaBrowserWindowArtisan = document.getElementsByClassName('artisanbrowser-window-artisan');
        var artisanBrowserSuggestInput = document.getElementById("artisanbrowser-window-command-suffix");

        artisanBrowserSuggestInput.addEventListener("focus", function(e) {
            var artisanBrowserSuggestInputFocus = e.target;

            e.target.addEventListener("keypress", function(e) {
                if(e.keyCode == 13) {
                    artisanBrowserSuggestInputFocus.readOnly = true;
                    artisaBrowserWindowArtisan[0].appendChild(document.createElement("br"));

                    document.getElementById("artisanbrowser-window-command-suffix").removeAttribute("id");
                    document.getElementById("artisanbrowser-suggest").removeAttribute("id");
                    
                    axios.post("//" + location.hostname + "/__artisanbrowser/assets/cmd", {
                        cmd: artisanBrowserSuggestInput.value,
                        _token: document.getElementsByName('_artisanbrowser_token').value
                    })
                    .then(function(res) {
                        var artisaBrowserConsoleOutput = document.createElement('div');
                        artisaBrowserConsoleOutput.className = "artisanbrowser-output-success";
                        artisaBrowserConsoleOutput.innerText = res.data[0].output;

                        artisaBrowserWindowArtisan[0].appendChild(artisaBrowserConsoleOutput);
                    })
                    .catch(function(err) {
                        console.log(err);
                        var artisaBrowserConsoleOutput = document.createElement('div');
                        artisaBrowserConsoleOutput.className = "artisanbrowser-output-error";
                        artisaBrowserConsoleOutput.innerText = err.data[0].output;

                        artisaBrowserWindowArtisan[0].appendChild(artisaBrowserConsoleOutput);
                        console.error(err);
                    })
                    .finally(function() {
                        artisaBrowserWindowArtisan[0].appendChild(artisanBrowserSuggestInputPrefixClone);
                        artisaBrowserWindowArtisan[0].appendChild(artisanBrowserSuggestInputClone);
                        artisaBrowserWindowArtisan[0].appendChild(artisanbrowserSuggestClone);

                        document.getElementById("artisanbrowser-window-command-suffix").focus();
                    }, false);
                }
            }, false);
        });
    }
}
