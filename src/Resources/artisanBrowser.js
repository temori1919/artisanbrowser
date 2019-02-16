// Load suggest.js
var artisanbrowserSuggestStart = function() {
    $ArtisanBrowser.artisanbrowserCachedScript("//" + location.hostname + '/__artisanbrowser/assets/suggest')
    .done(function() {
        new Suggest.Local(
            "artisanbrowser-window-command-suffix",
            "artisanbrowser-suggest",
            JSON.parse(artisanBrowserCmdList),
            {
                dispMax: 0, 
                highlight: true,    
                dispAllKey: true
            }   
        );
    });
}

$ArtisanBrowser.artisanbrowserCachedScript = function(url, options) {
    options = $ArtisanBrowser.extend(options || {}, {
        dataType: "script",
        cache: true,
        url: url
    });

    return $ArtisanBrowser.ajax( options );
};

$ArtisanBrowser(function() {
    // Determine whether click or mouse down event is in seconds.
    var artisanbrowserClickTime = 0;
    var artisanbrowserIsClick = true;
    $ArtisanBrowser(document).on("mousedown", function() {
        artisanbrowserClickTime = new Date().getTime();
    });
    $ArtisanBrowser(document).on("mouseup", function() {
        if (new Date().getTime() - artisanbrowserClickTime >= 200) {
			artisanbrowserIsClick = false;
		} else {
            artisanbrowserIsClick = true;
        }
    });

    // Start drag.
    var artisanbrowserDragEnable = false;
    var artisanbrowserOffserX = 0;
    var artisanbrowserOffserY = 0;

    $ArtisanBrowser(document).on("mouseup", ".artisanbrowser-btn", function(e) {
        artisanbrowserDragEnable = false;
        localStorage.setItem("artisanbrowserOffserX", $ArtisanBrowser(this).offset().left)
        localStorage.setItem("artisanbrowserOffserY", $ArtisanBrowser(this).offset().top)
    });

    $ArtisanBrowser(document).on("mousedown", ".artisanbrowser-btn", function(e) {
        if(e.which == 3) return false;
        artisanbrowserOffserX = e.clientX - $ArtisanBrowser(this).position().left;
        artisanbrowserOffserY = e.clientY - $ArtisanBrowser(this).position().top;
        artisanbrowserDragEnable = true;
    });

    window.onmousemove = function(e) {
        if(artisanbrowserDragEnable) {
            $ArtisanBrowser(".artisanbrowser-btn").offset({
                top: e.clientY - artisanbrowserOffserY,
                left: e.clientX - artisanbrowserOffserX
            });
        }
    }
    
    // Render app btn.
    var artisanbrowserOffserXstorage = localStorage.getItem("artisanbrowserOffserX") ? localStorage.getItem("artisanbrowserOffserX") : 0;
    var artisanbrowserOffserYstorage = localStorage.getItem("artisanbrowserOffserY") ? localStorage.getItem("artisanbrowserOffserY") : 0;
    $ArtisanBrowser(".artisanbrowser-overlay").after(
        "<div class=\"artisanbrowser-btn\" style=\"left:" + artisanbrowserOffserXstorage + "px; top:" + artisanbrowserOffserYstorage + "px;\"><div class=\"artisanbrowser-btn-inner\"><img src=\"//" + location.hostname + "/__artisanbrowser/assets/img\"></div></div>"
    );

    $ArtisanBrowser(".artisanbrowser-btn .artisanbrowser-btn-inner img").attr("onmousedown", "return false");
    $ArtisanBrowser(".artisanbrowser-btn .artisanbrowser-btn-inner img").attr("onselectstart", "return false");

    // Show ArtisanBrowser window.
    $ArtisanBrowser(document).on("click", ".artisanbrowser-btn", function() {
        if(artisanbrowserIsClick){
            $ArtisanBrowser(".artisanbrowser-root-box, .artisanbrowser-overlay").addClass("artisanbrowser-show");
        }

        $ArtisanBrowser(document).on("click", ".artisanbrowser-overlay", function() {
            $ArtisanBrowser(".artisanbrowser-root-box, .artisanbrowser-overlay").removeClass("artisanbrowser-show");
        });
    });
    
    // Switching tabs.
    $ArtisanBrowser(document).on("click", ".artisanbrowser-nav-item > a", function(e) {
        e.preventDefault();

        if(!$ArtisanBrowser(this).hasClass("artisanbrowser-nav-active")) {
            $ArtisanBrowser(".artisanbrowser-nav-item > a").removeClass("artisanbrowser-nav-active");
            $ArtisanBrowser(this).addClass("artisanbrowser-nav-active");

            $ArtisanBrowser(".artisanbrowser-window-route, .artisanbrowser-window-artisan").removeClass("artisanbrowser-show");
            var artisanbrowserWindowType = $ArtisanBrowser(this).data("artisanbrowseractive");

            $ArtisanBrowser(".artisanbrowser-window-" + artisanbrowserWindowType).addClass("artisanbrowser-show");

            if (artisanbrowserWindowType == "artisan") {
                $ArtisanBrowser("#artisanbrowser-window-command-suffix").focus();
            }
        }
    });
    // Load suggest.js.
    if (typeof Suggest == "undefined") {
        artisanbrowserSuggestStart();
    }

    // Run artisan command.
    $ArtisanBrowser(document).on("focus keypress", "#artisanbrowser-window-command-suffix", function(e) {
        if (e.keyCode == 13) {
            var artisanBrowserSuggestInputPrefixClone = $ArtisanBrowser(".artisanbrowser-window-command-prefix").eq(0).clone();
            var artisanBrowserSuggestInputClone = $ArtisanBrowser("#artisanbrowser-window-command-suffix").clone().val("");
            var artisanbrowserSuggestClone = $ArtisanBrowser("#artisanbrowser-suggest").clone();

            $ArtisanBrowser(this).attr("readonly", true).removeAttr("id");
            $ArtisanBrowser("#artisanbrowser-suggest").removeAttr("id");

            $ArtisanBrowser(".artisanbrowser-window-artisan").append("<br>");

            var artisanBrowserCmdText = $ArtisanBrowser(this).val();
            if(artisanBrowserCmdText) {
                $ArtisanBrowser.ajax({
                    url: "//" + location.hostname + "/__artisanbrowser/assets/cmd",
                    type: "post",
                    dataType: "json",
                    data:{
                        cmd: artisanBrowserCmdText,
                        _token: $ArtisanBrowser("[name=_artisanbrowser_token]").val()
                    }
                })
                .done(function(data) {
                    $ArtisanBrowser(".artisanbrowser-window-artisan").append(
                        "<div class=\"artisanbrowser-output-success\">" + 
                        "<pre>" + data.message + "<pre>" + 
                        "</div>"
                    );

                    artisanBrowserCmdList = data.cmd;
                })
                .fail(function(error) {
                    if (error.message == undefined) {
                        $ArtisanBrowser(".artisanbrowser-window-artisan").append(
                            "<br><div class=\"artisanbrowser-output-error\">" + 
                            "<pre>" + error.responseJSON.message + "<pre>" + 
                            "</div><br>"
                        );
                    } else {
                        $ArtisanBrowser(".artisanbrowser-window-artisan").append(
                            "<br><div class=\"artisanbrowser-output-error\">" + 
                            "<pre>" + error.message + "<pre>" + 
                            "</div><br>"
                        );
                    }

                    // Add last command to history.
                    artisanBrowserCmdList = "\[\"" + artisanBrowserCmdText + "\"," + artisanBrowserCmdList.replace(/^\[/, "");

                    console.error(error);
                })
                .always(function() {
                    $ArtisanBrowser(".artisanbrowser-window-artisan").append($ArtisanBrowser(artisanBrowserSuggestInputPrefixClone));
                    $ArtisanBrowser(".artisanbrowser-window-artisan").append($ArtisanBrowser(artisanBrowserSuggestInputClone));
                    $ArtisanBrowser(".artisanbrowser-window-artisan").append($ArtisanBrowser(artisanbrowserSuggestClone));

                    $ArtisanBrowser("#artisanbrowser-window-command-suffix").focus();
                    artisanbrowserSuggestStart();
                });
            } else {
                $ArtisanBrowser(".artisanbrowser-window-artisan").append($ArtisanBrowser(artisanBrowserSuggestInputPrefixClone));
                $ArtisanBrowser(".artisanbrowser-window-artisan").append($ArtisanBrowser(artisanBrowserSuggestInputClone));
                $ArtisanBrowser(".artisanbrowser-window-artisan").append($ArtisanBrowser(artisanbrowserSuggestClone));

                $ArtisanBrowser("#artisanbrowser-window-command-suffix").focus();
                artisanbrowserSuggestStart();
            }
        }
    });
});