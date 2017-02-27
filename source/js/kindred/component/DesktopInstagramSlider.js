// REQUIRES INSTAFEED & SLICK


goog.provide('kindred.component.DesktopInstagramSlider');

goog.require('goog.events.Event');
goog.require('goog.events.EventTarget');

/**
 * The CLASSNAME constructor
 * @param {object} options The object extendable like jquery plugins
 * @param {element} element The jQuery element connected to class
 * @constructor
 * @extends {goog.events.EventTarget}
 */
kindred.component.DesktopInstagramSlider = function(options, element) {

  goog.events.EventTarget.call(this);
  this.options = $.extend({}, kindred.component.DesktopInstagramSlider.DEFAULT, options);
  this.element = element;


  this.instagram_feed = null;

  // this.feed_container = this.element.find('#home-instagram-feed-container');
  this.item_container = this.element.find('#home-instagram-item-container');

  this.item_template = [
    '<a href="{{link}}" target="_blank" class="home-instagram-item">',
      '<div class="white-bg"></div>',
      '<div class="manic-image-container" data-scale-mode="best_fit_no_scale_down">',
        '<img src="" data-image="{{image}}">',
      '</div>',
    '</a>'
  ].join('');


  this.data_access_token = '';
  this.data_user_id = '';

  

  if (goog.isDefAndNotNull(this.element.attr('data-access-token')) && this.element.attr('data-access-token') != '' &&
      goog.isDefAndNotNull(this.element.attr('data-user-id')) && this.element.attr('data-user-id') != '') {

    this.data_access_token = this.element.attr('data-access-token');
    this.data_user_id = this.element.attr('data-user-id');

    this.create_feed();

  } else {
    console.log('ERROR: kindred.component.DesktopInstagramSlider: data attributes not set')
  }

  
  



  // if class has parent
  //goog.events.EventTarget.call(this, options, element);
  //this.options = $.extend(this.options, kindred.component.DesktopInstagramSlider.DEFAULT, options);
  




  


  console.log('kindred.component.DesktopInstagramSlider: init');
};
goog.inherits(kindred.component.DesktopInstagramSlider, goog.events.EventTarget);


/**
 * like jQuery options
 * @const {object}
 */
kindred.component.DesktopInstagramSlider.DEFAULT = {
  'option_01': '',
  'option_02': ''
};

/**
 * CLASSNAME Event Constant
 * @const
 * @type {string}
 */
kindred.component.DesktopInstagramSlider.ON_INSTAGRAM_FEED_GENERATED = 'on_instagram_feed_generated';

/**
 * CLASSNAME Event Constant
 * @const
 * @type {string}
 */
kindred.component.DesktopInstagramSlider.EVENT_02 = '';


//    ____  ____  _____     ___  _____ _____
//   |  _ \|  _ \|_ _\ \   / / \|_   _| ____|
//   | |_) | |_) || | \ \ / / _ \ | | |  _|
//   |  __/|  _ < | |  \ V / ___ \| | | |___
//   |_|   |_| \_\___|  \_/_/   \_\_| |_____|
//


kindred.component.DesktopInstagramSlider.prototype.create_feed = function() {


  this.instagram_feed = new Instafeed({
    // 'target': 'home-instagram-feed-container',    // go strait to the item container
    'target': 'home-instagram-item-container',
    'get': 'user',

    'userId': this.data_user_id,
    'accessToken': this.data_access_token,

    'template': this.item_template,
    'after': this.on_after_instafeed_create_html.bind(this),
    'limit': 24,            // this number can be smaller
    // 'resolution': 'standard_resolution'
    'resolution': 'low_resolution'
    // 'resolution': 'thumbnail'
  });
  this.instagram_feed.run();

};

kindred.component.DesktopInstagramSlider.prototype.create_slider = function() {


  if (this.item_container.length != 0) {

    this.item_container.on('init', function(event, slick, breakpoint){
      this.dispatchEvent(new goog.events.Event(kindred.component.DesktopInstagramSlider.ON_INSTAGRAM_FEED_GENERATED));
    }.bind(this));
    this.item_container.on('breakpoint init reInit setPosition', function(event, slick, breakpoint){
      this.update_layout();
    }.bind(this));
    
    this.item_container.slick({
      'speed': 350,
      'dots': false,
      'arrows': false,
      'infinite': false,
      'slidesToShow': 6,
      'slidesToScroll': 1,
      'pauseOnHover': false,
      'autoplay': true,
      // 'autoplaySpeed': 1000,
      'autoplaySpeed': 4000,
      'responsive': [
        {
          'breakpoint': 1380,
          'settings':{
            'slidesToShow': 5,
            'slidesToScroll': 1
          }
        },
        {
          'breakpoint': 1180,
          'settings':{
            'slidesToShow': 4,
            'slidesToScroll': 1
          }
        },
        {
          'breakpoint': 991,  //   tablet portrait
          'settings':{
            'slidesToShow': 3,
            'slidesToScroll': 1
          }
        },
        {
          'breakpoint': 767,  //   mobile
          'settings':{
            'slidesToShow': 1,
            'slidesToScroll': 1
          }
        }
      ]
    });

    
    
    

    /*
    this.item_container.on('init', function(event, slick){
      this.update_layout();
    }.bind(this));
    */

  }

};

kindred.component.DesktopInstagramSlider.prototype.private_method_05 = function() {};
kindred.component.DesktopInstagramSlider.prototype.private_method_06 = function() {};


//    ____  _   _ ____  _     ___ ____
//   |  _ \| | | | __ )| |   |_ _/ ___|
//   | |_) | | | |  _ \| |    | | |
//   |  __/| |_| | |_) | |___ | | |___
//   |_|    \___/|____/|_____|___\____|
//


kindred.component.DesktopInstagramSlider.prototype.update_layout = function() {

};
kindred.component.DesktopInstagramSlider.prototype.public_method_02 = function() {};
kindred.component.DesktopInstagramSlider.prototype.public_method_03 = function() {};
kindred.component.DesktopInstagramSlider.prototype.public_method_04 = function() {};
kindred.component.DesktopInstagramSlider.prototype.public_method_05 = function() {};
kindred.component.DesktopInstagramSlider.prototype.public_method_06 = function() {};


//    _______     _______ _   _ _____ ____
//   | ____\ \   / / ____| \ | |_   _/ ___|
//   |  _|  \ \ / /|  _| |  \| | | | \___ \
//   | |___  \ V / | |___| |\  | | |  ___) |
//   |_____|  \_/  |_____|_| \_| |_| |____/
//

/**
 * @param {object} event
 */
kindred.component.DesktopInstagramSlider.prototype.on_after_instafeed_create_html = function(event) {

  this.create_slider();


  this.dispatchEvent(new goog.events.Event(kindred.component.DesktopInstagramSlider.ON_INSTAGRAM_FEED_GENERATED));

};

/**
 * @param {object} event
 */
kindred.component.DesktopInstagramSlider.prototype.on_event_handler_02 = function(event) {
};

/**
 * @param {object} event
 */
kindred.component.DesktopInstagramSlider.prototype.on_event_handler_03 = function(event) {
};

/**
 * @param {object} event
 */
kindred.component.DesktopInstagramSlider.prototype.on_event_handler_04 = function(event) {
};






kindred.component.DesktopInstagramSlider.prototype.sample_method_calls = function() {

  // sample override
  kindred.component.DesktopInstagramSlider.superClass_.method_02.call(this);

  // sample event
  
};