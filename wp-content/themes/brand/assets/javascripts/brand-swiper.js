jQuery(document).ready(function( $ ) {
	//initialize swiper when document ready
  var mySwiper = new Swiper ('.swiper-container', {
		// Optional parameters
	 direction: 'horizontal',
	 paginationType: 'fraction',
	 parallax:true,
	 effect: 'slide',
	 cube:{
  	slideShadows: false,
  	shadow: false
	},
	autoplay: 10000,
	 loop: true,
	 speed: 1000,
	 mousewheelControl: true,
	 keyboardControl:true,
	 mousewheelForceToAxis: true,
	 // If we need pagination
	 pagination: '.swiper-pagination',
	 scrollbar: '',

	 // Navigation arrows
	 nextButton: '.brand-swiper-button-next',
	 prevButton: '.brand-swiper-button-prev',

	 onTransitionEnd: function (mySwiper) {
		$( '.swiper-slide.swiper-slide-active' ).addClass('animation' );
	},

	onTransitionStart: function (mySwiper) {
 	 $( '.swiper-slide' ).removeClass('animation' );
	 var text_color = $( '.swiper-slide.swiper-slide-active .inner-slide' ).attr( 'data-text-color' );
	 $( '.swiper-pagination-fraction, .swiper-buttons-holder' ).css( 'color', text_color );
	 $( '.brand-swiper-button-prev svg, .brand-swiper-button-next svg' ).css( 'fill', text_color );
  }

 })

});
