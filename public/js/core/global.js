$(document).ready(function() {
    $(".toggle-btn").on("click", function () {
        $(".layout").toggleClass("collapsed");
    });

    $(".pass-wrapper input").on("input", function () {
        $(this).siblings(".toggle-password").toggle($(this).val().length > 0);
    });

    $(".toggle-password").click(function () {
        let target = $("#" + $(this).data("target"));
        let type = target.attr("type") === "password" ? "text" : "password";

        target.attr("type", type);

        
        let imgSrc = type === "password" ? "/img/hidden-icon.png" : "/img/show-icon.png";
        $(this).attr("src", imgSrc);
    });
});