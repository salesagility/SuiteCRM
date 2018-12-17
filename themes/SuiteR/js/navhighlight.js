$(document).ready(function() {
    //adding the css classes to the current-module-nav-item & link
    $("li.topnav:has(span.currentTab)").addClass("current-selected-module");
    $("li.topnav span.currentTab a").addClass("current-selected-module-link");
});
