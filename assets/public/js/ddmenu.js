  $(document).ready(function(){
	  $(".dropdown").hover(            
		  function() {
			  $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true,true).slideDown("fast");
			  $(this).toggleClass('open');        
		  },
		  function() {
			  $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true,true).slideUp("fast");
		  $(this).toggleClass('open');       
		  }
	  );
 });
  
  
//  var stateManager = (function () {
//  var state = null;
//  var resizePage = function () {
//    if ($('body').width() < 1030) {
//      if (state !== "mobile") { displayMobile(); }
//resizeMobile(
// $(".dropdown").hover(            
//		  function() {
//			  $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true,true).slideDown("fast");
//			  $(this).toggleClass('open');        
//		  },
//		  function() {
//			  $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true,true).slideUp("fast");
//			  $(this).toggleClass('open');       
//		  }
//	  ));
//    }
//    else {
//      if (state !== "desktop") { displayDesktop(); }
//resizeDesktop(
// $(".dropdown").onclick(            
//		  function() {
//			  $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true,true).slideDown("fast");
//			  $(this).toggleClass('open');        
//		  },
//		  function() {
//			  $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true,true).slideUp("fast");
//			  $(this).toggleClass('open');       
//		  }
//	  )
//);
//    }
//}; 
//  var displayMobile = function () {
//state = "mobile";
//console.log("enter mobile");
//  };
//  var displayDesktop = function () {
//state = "desktop";
//console.log("enter desktop");
//  };
//  var resizeMobile = function () {
//    console.log("resizing mobile");
//  };
//  var resizeDesktop = function () {
//    console.log("resizing desktop");
//  };
//  return {
//    init: function () {
//      resizePage();
//      $(window).on('resize', resizePage);
//    }
//  };
//} ());
//stateManager.init();