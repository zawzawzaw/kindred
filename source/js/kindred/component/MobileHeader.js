goog.provide('kindred.component.MobileHeader');

goog.require('goog.events.Event');
goog.require('goog.events.EventTarget');

/**
 * The CLASSNAME constructor
 * @param {object} options The object extendable like jquery plugins
 * @param {element} element The jQuery element connected to class
 * @constructor
 * @extends {goog.events.EventTarget}
 */
kindred.component.MobileHeader = function(options, element) {

  goog.events.EventTarget.call(this);
  this.options = $.extend({}, kindred.component.MobileHeader.DEFAULT, options);
  this.element = element;



  
  this.is_open = false;

  this.html = $('html');
  this.body = $('body');


  this.expand_container = $('#mobile-header-expanded');
  this.main_content = $('#PageContainer .main-content');
  


  // TOP
  
  this.menu_button = this.element.find('#mobile-header-menu-button');
  this.cart_button = this.element.find('#mobile-header-cart-menu-button');
  this.cart_button_number_element = this.element.find('#mobile-header-cart-menu-button .mobile-cart-number');
  


  // SEARCH

  this.search_txt = this.expand_container.find('#mobile-header-search-content input[type=search]');
  this.search_btn = this.expand_container.find('#mobile-header-search-content #mobile-header-search-button');
  this.search_form = this.expand_container.find('#mobile-header-search-content form');

  

  // CURRENCY
    
  this.is_currency_open = false;

  this.currency_container = this.expand_container.find('#mobile-header-currency-container');
  this.currency_title = this.expand_container.find('#mobile-header-currency-title');
  this.currency_value = this.expand_container.find('#mobile-header-currency-value');
  this.currency_expand_container = this.expand_container.find('#mobile-header-currency-expandable');
    

  this.currency_select = $('#desktop-header [name=currencies]');
  
  


  // MENU

  this.menu_element = this.expand_container.find('#mobile-header-menu');
  


  this.create_menu_btn();
  this.create_search();
  this.create_currency();
  this.create_menu();

  


  console.log('kindred.component.MobileHeader: init');
};
goog.inherits(kindred.component.MobileHeader, goog.events.EventTarget);


/**
 * like jQuery options
 * @const {object}
 */
kindred.component.MobileHeader.DEFAULT = {
  'option_01': '',
  'option_02': ''
};

/**
 * CLASSNAME Event Constant
 * @const
 * @type {string}
 */
kindred.component.MobileHeader.EVENT_01 = '';

/**
 * CLASSNAME Event Constant
 * @const
 * @type {string}
 */
kindred.component.MobileHeader.EVENT_02 = '';


//     ____ ____  _____    _  _____ _____
//    / ___|  _ \| ____|  / \|_   _| ____|
//   | |   | |_) |  _|   / _ \ | | |  _|
//   | |___|  _ <| |___ / ___ \| | | |___
//    \____|_| \_\_____/_/   \_\_| |_____|
//



kindred.component.MobileHeader.prototype.create_menu_btn = function() {

  this.menu_button.click(function(event){
    event.preventDefault();

    if (this.is_open == true) { 
      this.close_menu();
    } else {


      this.open_menu();

      // close ajax shopping cart if you are opening the menu
      this.close_timber_shoping_cart();


    }

  }.bind(this));


  // close mobile menu on open of ajax shoping cart

  this.body.on('on-timber-on-open', function(event){
    if (this.is_open == true) { 
      this.close_menu();
    }
  }.bind(this));
  

};




kindred.component.MobileHeader.prototype.create_search = function() {


  // used FormCheck 'form-check-force-submit' to class to submit :D
  /*
  this.search_btn.click(function(event){
    event.preventDefault();

    this.search_form.submit();

  }.bind(this));
  */

};
kindred.component.MobileHeader.prototype.create_currency = function() {
  // pending (need to take a look at desktop version)
  
  this.currency_title.click(function(event){
    event.preventDefault();

    if (this.is_currency_open == true){
      this.close_currency();
    } else {
      this.open_currency();
    }
  }.bind(this));


  // CREATE THE CLICK EVENTS
  
  var arr = this.currency_expand_container.find('.mobile-menu-currency-item');
  var item = null;

  for (var i = 0, l=arr.length; i < l; i++) {
    item = $(arr[i]);
    item.click(function(event){

      event.preventDefault();
      var target = $(event.currentTarget);
      var value = target.attr('data-value');

      if (goog.isDefAndNotNull(value) && value != '') {
        this.set_currency(value);

        this.close_menu();
      }

    }.bind(this));
  }
  
};
kindred.component.MobileHeader.prototype.create_menu = function() {
    
  var arr = this.menu_element.find('nav > ul > li');
  var li_element = null;
  var ul_element = null;
  var a_element = null;

  for (var i = 0, l=arr.length; i < l; i++) {
    li_element = $(arr[i]);
    ul_element = li_element.find('> ul');
    a_element = li_element.find('> a');

    if (ul_element.length != 0) {
      a_element.data('ul_element', ul_element);
      a_element.data('li_element', li_element);

      a_element.click(function(event){
        event.preventDefault();

        var target = $(event.currentTarget);
        ul_element = target.data('ul_element');
        li_element = target.data('li_element');

        if (ul_element.hasClass('sub-menu-open-version') == true) {
          // close
          li_element.removeClass('expand-version');
          ul_element.removeClass('sub-menu-open-version');
          ul_element.stop(0).slideUp(500);

        } else {
          // open & close everyone else
          this.menu_element.find('nav > ul > li > ul').slideUp(500).removeClass('sub-menu-open-version');
          li_element.addClass('expand-version');
          ul_element.addClass('sub-menu-open-version');
          ul_element.stop(0).slideDown(500);
        }
        
      }.bind(this));

    } // if

  } // for


};


//    ____  ____  _____     ___  _____ _____
//   |  _ \|  _ \|_ _\ \   / / \|_   _| ____|
//   | |_) | |_) || | \ \ / / _ \ | | |  _|
//   |  __/|  _ < | |  \ V / ___ \| | | |___
//   |_|   |_| \_\___|  \_/_/   \_\_| |_____|
//


kindred.component.MobileHeader.prototype.private_method_01 = function() {};
kindred.component.MobileHeader.prototype.private_method_02 = function() {};
kindred.component.MobileHeader.prototype.private_method_03 = function() {};
kindred.component.MobileHeader.prototype.private_method_04 = function() {};
kindred.component.MobileHeader.prototype.private_method_05 = function() {};
kindred.component.MobileHeader.prototype.private_method_06 = function() {};


//    ____  _   _ ____  _     ___ ____
//   |  _ \| | | | __ )| |   |_ _/ ___|
//   | |_) | | | |  _ \| |    | | |
//   |  __/| |_| | |_) | |___ | | |___
//   |_|    \___/|____/|_____|___\____|
//



kindred.component.MobileHeader.prototype.close_timber_shoping_cart = function(){
  
  if (goog.isDefAndNotNull(timber) &&
      goog.isDefAndNotNull(timber.RightDrawer) &&
      goog.isDefAndNotNull(timber.RightDrawer.close)) {
    timber.RightDrawer.close();
  }
  
};

kindred.component.MobileHeader.prototype.open_menu = function() {

  if (this.is_open == false) {
    this.is_open = true;

    this.expand_container.css({
      'display': 'block'
    });

    this.html.addClass('mobile-header-open-version');
    
    // this.main_content.css({
    //   'display': 'none'
    // });

  }

};
kindred.component.MobileHeader.prototype.close_menu = function() {

  if (this.is_open == true) {
    this.is_open = false;

    this.expand_container.css({
      'display': 'none'
    });

    this.html.removeClass('mobile-header-open-version');

    // this.main_content.css({
    //   'display': 'block'
    // });

    this.close_currency();          // important !!! 

  }

};
kindred.component.MobileHeader.prototype.open_currency = function() {
  if (this.is_currency_open == false) {
    this.is_currency_open = true;

    this.currency_container.addClass('expand-version');
    this.currency_expand_container.stop(0).slideDown(500);
  }
  

};
kindred.component.MobileHeader.prototype.close_currency = function() {
  if (this.is_currency_open == true) {
    this.is_currency_open = false;

    this.currency_container.removeClass('expand-version');
    this.currency_expand_container.stop(0).slideUp(500);
  }
};


kindred.component.MobileHeader.prototype.set_currency = function(str_param) {
  this.currency_select.val(str_param).trigger('change');
};
kindred.component.MobileHeader.prototype.public_method_06 = function() {};




//    _______     _______ _   _ _____ ____
//   | ____\ \   / / ____| \ | |_   _/ ___|
//   |  _|  \ \ / /|  _| |  \| | | | \___ \
//   | |___  \ V / | |___| |\  | | |  ___) |
//   |_____|  \_/  |_____|_| \_| |_| |____/
//

/**
 * @param {object} event
 */
kindred.component.MobileHeader.prototype.on_event_handler_01 = function(event) {
};

/**
 * @param {object} event
 */
kindred.component.MobileHeader.prototype.on_event_handler_02 = function(event) {
};

/**
 * @param {object} event
 */
kindred.component.MobileHeader.prototype.on_event_handler_03 = function(event) {
};

/**
 * @param {object} event
 */
kindred.component.MobileHeader.prototype.on_event_handler_04 = function(event) {
};






kindred.component.MobileHeader.prototype.sample_method_calls = function() {

  // sample override
  kindred.component.MobileHeader.superClass_.method_02.call(this);

  // sample event
  this.dispatchEvent(new goog.events.Event(kindred.component.MobileHeader.EVENT_01));
};