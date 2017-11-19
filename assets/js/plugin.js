(function ($, window, document, undefined){
  "use strict";

  window.greenimp             = window.greenimp || {};
  window.greenimp.industries  = window.greenimp.industries || {};

  window.greenimp.industries.slider = new function(){
    /**
     * The component scope.
     * Used within functions instead of `this`
     *
     * @type {window.greenimp.industries.slider}
     */
    var lib = this;

    var defaultOptions  = {
      slidesToShow: 1,
      slidesToScroll: 1
    };

    /**
     * Component namespace.
     * Used for things like data attributes for event handlers.
     * It's public (using `this`) so we can use it from other components:
     * `console.log('The namespace is: ', greenimp.industries.slider.namespace);`
     *
     * @type {string}
     */
    this.namespace  = 'industries-slider';

    $('[data-' + this.namespace + ']').each(function (i, elm){
      var $slider = $(elm),
          handle  = $slider.attr('data-handle'),
          options = {};

      if($slider.hasClass('slider-parent')){
        // slider is a parent - set it to trigger it's navigation
        options.asNavFor  = '[data-' + lib.namespace + '].slider-nav[data-handle=' + handle + ']';
      }else if($slider.hasClass('slider-nav')){
        // slider is navigation for a parent - set it to trigger it's parent
        options.asNavFor  = '[data-' + lib.namespace + '].slider-parent[data-handle=' + handle + ']';

        // set up the nav specific options
        options.slidesToShow    = 5;
        options.slidesToScroll  = 1;
        options.focusOnSelect   = true;
      }

      // initialise the slider
      $slider.slick($.extend({}, defaultOptions, options));
    });
  };
}(jQuery, window, window.document));
