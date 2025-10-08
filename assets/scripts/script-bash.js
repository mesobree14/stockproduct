"use strict";

jQuery(function ($) {
  $(".sidebar-dropdown > a").click(function () {
    $(".sidebar-submenu").slideUp(200);
    if ($(this).parent().hasClass("active")) {
      $(".sidebar-dropdown").removeClass("active");
      $(this).parent().removeClass("active");
    } else {
      $(".sidebar-dropdown").removeClass("active");
      $(this).next(".sidebar-submenu").slideDown(200);
      $(this).parent().addClass("active");
    }
  });

  $("#close-sidebar").click(function () {
    $(".page-wrapper").removeClass("toggled");
  });
  $("#show-sidebar").click(function () {
    $(".page-wrapper").addClass("toggled");
  });
});

//$(document)
$(document).ready(function () {
  $(".multiple-select").multipleSelect({
    selectAll: false,
    classes: "input",
    classPrefix: "input",
  });
  /*Dropdown Menu*/
  $(document).on("click", ".dropdown", function () {
    $(this).attr("tabindex", 1).focus();
    $(this).toggleClass("active");
    $(this).find(".dropdown-menu").slideToggle(300);
  });

  $(document).on("focusout", ".dropdown", function () {
    $(this).removeClass("active");
    $(this).find(".dropdown-menu").slideUp(300);
  });

  $(document).on("click", ".dropdown .dropdown-menu li", function () {
    let textOnly = $(this)
      .clone()
      .children("small")
      .remove()
      .end()
      .text()
      .trim();
    $(this).parents(".dropdown").find("span").text(textOnly);
    $(this)
      .parents(".dropdown")
      .find("input")
      .attr("value", $(this).attr("id"));
  });

  $(document).on("click", ".dropdown-menu li", function () {
    var input =
        "<strong>" +
        $(this).parents(".dropdown").find("input").val() +
        "</strong>",
      msg = '<span class="msg">Hidden input value: ';
    $(".msg").html(msg + input + "</span>");
  });
});
