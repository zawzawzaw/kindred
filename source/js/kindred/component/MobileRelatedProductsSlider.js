goog.provide('kindred.component.MobileRelatedProductsSlider');

goog.require('goog.events.Event');
goog.require('goog.events.EventTarget');

/**
 * The CLASSNAME constructor
 * @param {object} options The object extendable like jquery plugins
 * @param {element} element The jQuery element connected to class
 * @constructor
 * @extends {goog.events.EventTarget}
 */
kindred.component.MobileRelatedProductsSlider = function(options, element) {

  goog.events.EventTarget.call(this);
  this.options = $.extend({}, kindred.component.MobileRelatedProductsSlider.DEFAULT, options);
  this.element = element;


  /**
   * @type {Array.{jQuery}}
   */
  this.product_item_array = [];


  this.is_tea_version = false;

  // this.slider_element = this.element.find('#product-item-container');
  this.slider_element = this.element.find('#product-item-mobile-slider');


  if (this.element.hasClass('tea-version')) { 
    this.is_tea_version = true;
  }


  this.create_product_item_array();
  this.create_slider_html();

  

  
  // a bit redundant, but i might need is_tea_version later

  if (this.is_tea_version == true) {
    this.create_tea_slider();
  } else {
    this.create_slider();
  }
  





  console.log('kindred.component.MobileRelatedProductsSlider: init');
};
goog.inherits(kindred.component.MobileRelatedProductsSlider, goog.events.EventTarget);


/**
 * like jQuery options
 * @const {object}
 */
kindred.component.MobileRelatedProductsSlider.DEFAULT = {
};

/**
 * CLASSNAME Event Constant
 * @const
 * @type {string}
 */
kindred.component.MobileRelatedProductsSlider.SLIDER_INIT = 'slider_init';

/**
 * CLASSNAME Event Constant
 * @const
 * @type {string}
 */
kindred.component.MobileRelatedProductsSlider.SLIDER_UPDATE = 'slider_update';







//     ____ ____  _____    _  _____ _____
//    / ___|  _ \| ____|  / \|_   _| ____|
//   | |   | |_) |  _|   / _ \ | | |  _|
//   | |___|  _ <| |___ / ___ \| | | |___
//    \____|_| \_\_____/_/   \_\_| |_____|
//



kindred.component.MobileRelatedProductsSlider.prototype.create_product_item_array = function() {

  // remove from product-item-column
  var arr = this.element.find('#product-item-mobile-container').find('.product-item');

  var item = null;

  for (var i = 0, l=arr.length; i < l; i++) {
    item = $(arr[i]);
    this.product_item_array[i] = item;
  }

  this.product_item_array = manic.util.ArrayUtil.shuffle(this.product_item_array);

};
kindred.component.MobileRelatedProductsSlider.prototype.create_slider_html = function() {

  var mobile_fragment = $(document.createDocumentFragment());
  var item = null;

  for (var i = 0, l=this.product_item_array.length; i < l; i++) {
    item = this.product_item_array[i];
    mobile_fragment.append(item);
  }

  this.slider_element.append(mobile_fragment);

};




/*
normal slider
mobile = 1
tablet portait = 2
tablet landscape = 3

----------------------

tea slider
mobile = 2
tablet portait = 3
tablet landscape = 4
*/

kindred.component.MobileRelatedProductsSlider.prototype.create_slider = function() {

  this.slider_element.on('init', function(event, slick){
    this.dispatchEvent(new goog.events.Event(kindred.component.MobileRelatedProductsSlider.SLIDER_INIT));
  }.bind(this));
  this.slider_element.on('breakpoint init reInit setPosition', function(event, slick, breakpoint){
    this.dispatchEvent(new goog.events.Event(kindred.component.MobileRelatedProductsSlider.SLIDER_UPDATE));
  }.bind(this));


  this.slider_element.slick({
    'speed': 350,
    'dots': false,
    'arrows': true, // has arrows
    'infinite': false,
    'slidesToShow': 2,
    'slidesToScroll': 2,                // tablet portrait
    'pauseOnHover': false,
    'autoplay': true,
    'autoplaySpeed': 4000,
    'responsive': [

      /*
      {
        'breakpoint': 1199, // this won't even get there (cause tablet landscape renders the desktop related images)
        'settings':{
          'slidesToShow': 3,
          'slidesToScroll': 3
        }
      },
      {
        'breakpoint': 991,
        'settings':{
          'slidesToShow': 2,
          'slidesToScroll': 2
        }
      },
      */
      
      {
        'breakpoint': 767,
        'settings':{
          'slidesToShow': 1,
          'slidesToScroll': 1
        }
      }
    ]

  });

};
kindred.component.MobileRelatedProductsSlider.prototype.create_tea_slider = function() {

  this.slider_element.on('init', function(event, slick){
    this.dispatchEvent(new goog.events.Event(kindred.component.MobileRelatedProductsSlider.SLIDER_INIT));
  }.bind(this));
  this.slider_element.on('breakpoint init reInit setPosition', function(event, slick, breakpoint){
    this.dispatchEvent(new goog.events.Event(kindred.component.MobileRelatedProductsSlider.SLIDER_UPDATE));
  }.bind(this));


  this.slider_element.slick({
    'speed': 350,
    'dots': false,
    'arrows': true,                   // has arrows
    'infinite': false,
    'slidesToShow': 3,
    'slidesToScroll': 3,
    'pauseOnHover': false,
    'autoplay': true,
    'autoplaySpeed': 4000,
    'responsive': [
      /*
      {
        'breakpoint': 1199, // this won't even get there (cause tablet landscape renders the desktop related images)
        'settings':{
          'slidesToShow': 4,
          'slidesToScroll': 4
        }
      },
      {
        'breakpoint': 991,
        'settings':{
          'slidesToShow': 3,
          'slidesToScroll': 3  // moved to 
        }
      },
      */
      
      {
        'breakpoint': 991,
        'settings':{
          'slidesToShow': 2,
          'slidesToScroll': 2
        }
      },
      {
        'breakpoint': 480,
        'settings':{
          'slidesToShow': 1,
          'slidesToScroll': 1
        }
      }
    ]

  });

};



kindred.component.MobileRelatedProductsSlider.prototype.private_method_04 = function() {};
kindred.component.MobileRelatedProductsSlider.prototype.private_method_05 = function() {};
kindred.component.MobileRelatedProductsSlider.prototype.private_method_06 = function() {};


//    ____  _   _ ____  _     ___ ____
//   |  _ \| | | | __ )| |   |_ _/ ___|
//   | |_) | | | |  _ \| |    | | |
//   |  __/| |_| | |_) | |___ | | |___
//   |_|    \___/|____/|_____|___\____|
//


kindred.component.MobileRelatedProductsSlider.prototype.public_method_01 = function() {};
kindred.component.MobileRelatedProductsSlider.prototype.public_method_02 = function() {};
kindred.component.MobileRelatedProductsSlider.prototype.public_method_03 = function() {};
kindred.component.MobileRelatedProductsSlider.prototype.public_method_04 = function() {};
kindred.component.MobileRelatedProductsSlider.prototype.public_method_05 = function() {};
kindred.component.MobileRelatedProductsSlider.prototype.public_method_06 = function() {};


//    _______     _______ _   _ _____ ____
//   | ____\ \   / / ____| \ | |_   _/ ___|
//   |  _|  \ \ / /|  _| |  \| | | | \___ \
//   | |___  \ V / | |___| |\  | | |  ___) |
//   |_____|  \_/  |_____|_| \_| |_| |____/
//

/**
 * @param {object} event
 */
kindred.component.MobileRelatedProductsSlider.prototype.on_event_handler_01 = function(event) {
};

/**
 * @param {object} event
 */
kindred.component.MobileRelatedProductsSlider.prototype.on_event_handler_02 = function(event) {
};

/**
 * @param {object} event
 */
kindred.component.MobileRelatedProductsSlider.prototype.on_event_handler_03 = function(event) {
};

/**
 * @param {object} event
 */
kindred.component.MobileRelatedProductsSlider.prototype.on_event_handler_04 = function(event) {
};






kindred.component.MobileRelatedProductsSlider.prototype.sample_method_calls = function() {

  // sample override
  kindred.component.MobileRelatedProductsSlider.superClass_.method_02.call(this);

  // sample event
  this.dispatchEvent(new goog.events.Event(kindred.component.MobileRelatedProductsSlider.EVENT_01));
};
