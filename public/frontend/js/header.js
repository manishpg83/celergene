function toggleClass1() {
	var screensize = screen.width;
	var dropmenu1 = document.getElementById("sub-menu1");
	var mainmenu1 = document.getElementById("main-menu1");
	if(screensize < 992){
	dropmenu1.classList.toggle("show");
	mainmenu1.classList.toggle("active");
	}	

	var plusicon1 = document.getElementById("plusicon1");  
  if (plusicon1.classList.contains("fa-plus")) {
    plusicon1.classList.remove ("fa-plus");
    plusicon1.classList.add ("fa-minus");
  } else {
    plusicon1.classList.remove ("fa-minus");
    plusicon1.classList.add ("fa-plus");
  }
}

function toggleClass2() {
	var screensize = screen.width;
	var dropmenu2 = document.getElementById("sub-menu2");
	var mainmenu2 = document.getElementById("main-menu2");
	if(screensize < 992){
	dropmenu2.classList.toggle("show");
	mainmenu2.classList.toggle("active");
	}	
var plusicon2 = document.getElementById("plusicon2");  
  if (plusicon2.classList.contains("fa-plus")) {
    plusicon2.classList.remove ("fa-plus");
    plusicon2.classList.add ("fa-minus");
  } else {
    plusicon2.classList.remove ("fa-minus");
    plusicon2.classList.add ("fa-plus");
  }
}

function toggleClass3() {

	var screensize = screen.width;
	var dropmenu3 = document.getElementById("sub-menu3");
	var mainmenu3 = document.getElementById("main-menu4");
	if(screensize < 992){
	dropmenu3.classList.toggle("show");
	mainmenu3.classList.toggle("active");
	}

  if (plusicon3.classList.contains("fa-plus")) {
    plusicon3.classList.remove ("fa-plus");
    plusicon3.classList.add ("fa-minus");
  } else {
    plusicon3.classList.remove ("fa-minus");
    plusicon3.classList.add ("fa-plus");
  }
}


$(document).ready(function() {
  $(window).scroll(function() {
    if ($(this).scrollTop() > 50) {
        $("#header").removeClass("expand-header");
        $("#header").addClass("shrink-header");
        $("#menubar1").addClass("menubar1-hide");
        $("#menubar2").removeClass("menubar2-border");
        $("#headerlogo").addClass("shrink-logo");
        $("#headerlogo").removeClass("expand-logo");
        $("#menu-wrap").removeClass("menu-container");
        $("#menu-wrap").addClass("menu-container-p0");
		
    } else {
        $("#header").removeClass("shrink-header");
        $("#header").addClass("expand-header");
        $("#menubar1").removeClass("menubar1-hide");
        $("#menubar2").addClass("menubar2-border");
        $("#headerlogo").removeClass("shrink-logo");
        $("#headerlogo").addClass("expand-logo");
        $("#menu-wrap").removeClass("menu-container-p0");
        $("#menu-wrap").addClass("menu-container");
    }
  });
});// JavaScript Document