goog.provide('kindred.page.Default');

goog.require('goog.events.Event');
goog.require('goog.events.EventTarget');


goog.require('manic.page.Page');


goog.require('kindred.component.DesktopInstagramSlider');



/**
 * The Default Page constructor
 * @inheritDoc
 * @constructor
 * @extends {manic.page.Page}
 */
kindred.page.Default = function(options) {

  manic.page.Page.call(this, options);
  this.options = $.extend(this.options, kindred.page.Default.DEFAULT, options);


  if ($('body').hasClass('chinese-version')) {
    manic.SITE_LANGUAGE = 'cn';
  }
  if ($('body').hasClass('bahasa-version')) {
    manic.SITE_LANGUAGE = 'in';
  }
  

  /**
   * @type {kindred.component.DesktopInstagramSlider}
   */
  this.desktop_instagram_slider = null;


  


};
goog.inherits(kindred.page.Default, manic.page.Page);


/**
 * like jQuery options
 * @const {object}
 */
kindred.page.Default.DEFAULT = {
};

/**
 * Default Event Constant
 * @const
 * @type {string}
 */
kindred.page.Default.EVENT_01 = '';

/**
 * Default Event Constant
 * @const
 * @type {string}
 */
kindred.page.Default.EVENT_02 = '';



//    ___ _   _ ___ _____
//   |_ _| \ | |_ _|_   _|
//    | ||  \| || |  | |
//    | || |\  || |  | |
//   |___|_| \_|___| |_|
//



/**
 * @override
 */
kindred.page.Default.prototype.init = function() {
  kindred.page.Default.superClass_.init.call(this);




  if ($('#home-page-banner').length != 0) {
    $('#home-page-banner').slick({
      'speed': 350,
      'dots': false,
      'arrows': false,
      'infinite': false,
      'slidesToShow': 1,
      'slidesToScroll': 1,
      'pauseOnHover': false,
      'autoplay': true,
      'autoplaySpeed': 4000
    });

    // update on slick init/resize
    $('#home-page-banner').on('breakpoint', function(event, slick, breakpoint){
      this.update_page_layout();
    }.bind(this));
    $('#home-page-banner').on('init', function(event, slick){
      this.update_page_layout();
    }.bind(this));


  } // #home-page-banner


  if ($('#home-page-shop-item-container').length != 0) {
    $('#home-page-shop-item-container').slick({
      'speed': 350,
      'dots': false,
      'arrows': true,
      'infinite': false,
      'slidesToShow': 5,
      'slidesToScroll': 5,
      'pauseOnHover': false,
      'autoplay': true,
      'autoplaySpeed': 4000,
      'responsive': [
        {
          'breakpoint': 1180,
          'settings':{
            'slidesToShow': 4,
            'slidesToScroll': 4
          }
        },
        {
          'breakpoint': 1010,
          'settings':{
            'slidesToShow': 3,
            'slidesToScroll': 3
          }
        }
      ]
    });

    // update on slick init/resize
    $('#home-page-shop-item-container').on('breakpoint', function(event, slick, breakpoint){
      this.update_page_layout();
    }.bind(this));
    $('#home-page-shop-item-container').on('init', function(event, slick){
      this.update_page_layout();
    }.bind(this));

  } // #home-page-shop-item-container




  if ($('#home-instagram-slider').length != 0) {


    this.desktop_instagram_slider = new kindred.component.DesktopInstagramSlider({}, $('#home-instagram-slider'));
    
    goog.events.listen(this.desktop_instagram_slider, kindred.component.DesktopInstagramSlider.ON_INSTAGRAM_FEED_GENERATED, function(event){

      console.log('instagram feed generated');
      this.create_image_container();

    }.bind(this));

    
    

    
  }
  
  

  


  

  console.log('kindred.page.Default: init');
};

//    ____  ____  _____     ___  _____ _____
//   |  _ \|  _ \|_ _\ \   / / \|_   _| ____|
//   | |_) | |_) || | \ \ / / _ \ | | |  _|
//   |  __/|  _ < | |  \ V / ___ \| | | |___
//   |_|   |_| \_\___|  \_/_/   \_\_| |_____|
//



kindred.page.Default.prototype.private_method_04 = function() {};
kindred.page.Default.prototype.private_method_05 = function() {};
kindred.page.Default.prototype.private_method_06 = function() {};


//    ____  _   _ ____  _     ___ ____
//   |  _ \| | | | __ )| |   |_ _/ ___|
//   | |_) | | | |  _ \| |    | | |
//   |  __/| |_| | |_) | |___ | | |___
//   |_|    \___/|____/|_____|___\____|
//

kindred.page.Default.prototype.public_method_03 = function() {};
kindred.page.Default.prototype.public_method_04 = function() {};
kindred.page.Default.prototype.public_method_05 = function() {};
kindred.page.Default.prototype.public_method_06 = function() {};




//    _        _ __   _____  _   _ _____
//   | |      / \\ \ / / _ \| | | |_   _|
//   | |     / _ \\ V / | | | | | | | |
//   | |___ / ___ \| || |_| | |_| | | |
//   |_____/_/   \_\_| \___/ \___/  |_|
//


/**
 * @override
 * @inheritDoc
 */
kindred.page.Default.prototype.update_page_layout = function(){
  kindred.page.Default.superClass_.update_page_layout.call(this);

  


};


//    _______     _______ _   _ _____ ____
//   | ____\ \   / / ____| \ | |_   _/ ___|
//   |  _|  \ \ / /|  _| |  \| | | | \___ \
//   | |___  \ V / | |___| |\  | | |  ___) |
//   |_____|  \_/  |_____|_| \_| |_| |____/
//

/**
 * @param {object} event
 */
kindred.page.Default.prototype.on_event_handler_01 = function(event) {

  // desktop-header-spacer
};

/**
 * @param {object} event
 */
kindred.page.Default.prototype.on_event_handler_02 = function(event) {
};

/**
 * @param {object} event
 */
kindred.page.Default.prototype.on_event_handler_03 = function(event) {
};

/**
 * @param {object} event
 */
kindred.page.Default.prototype.on_event_handler_04 = function(event) {
};






kindred.page.Default.prototype.sample_method_calls = function() {

  // sample override
  kindred.page.Default.superClass_.method_02.call(this);

  // sample event
  this.dispatchEvent(new goog.events.Event(kindred.page.Default.EVENT_01));
};