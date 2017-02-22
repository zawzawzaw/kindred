goog.provide('kindred.component.DesktopHeader');

goog.require('goog.events.Event');
goog.require('goog.events.EventTarget');

/**
 * The CLASSNAME constructor
 * @param {object} options The object extendable like jquery plugins
 * @param {element} element The jQuery element connected to class
 * @constructor
 * @extends {goog.events.EventTarget}
 */
kindred.component.DesktopHeader = function(options, element) {

  goog.events.EventTarget.call(this);
  this.options = $.extend({}, kindred.component.DesktopHeader.DEFAULT, options);
  this.element = element;

  

  


  // for search
  this.search_container = this.element.find('#desktop-header-search-container');
  this.search_form = this.element.find('#desktop-header-search-form');
  this.search_txt = this.element.find('#desktop-header-search-form input[type=search]');
  this.search_btn = this.element.find('#desktop-header-search-button');
  this.is_search_open = false;

  this.search_str = 'search';

  if (goog.isDefAndNotNull(this.search_container.attr('data-search-placeholder')) && this.search_container.attr('data-search-placeholder') != '') {
    this.search_str = this.search_container.attr('data-search-placeholder')
  }
  



  // for currencies
  this.currency_btn = this.element.find('#desktop-menu-currency-btn');
  this.currency_container = this.element.find('#desktop-menu-currency-item-container');
  this.currency_container_container = this.element.find('#desktop-menu-currency-item-container-container');
  this.currency_select = this.element.find('[name=currencies]');

  this.currency_item_elements = null;
  this.currency_item_array = [];

  this.is_currency_open = false;
  



  this.create_search_pop_out();
  this.create_currency_pop_out();


  // 
  this.element.mouseleave(function(event){

    console.log('this.element.mouseleave');

    this.close_search();
    this.close_currency();

  }.bind(this));


  console.log('kindred.component.DesktopHeader: init');
};
goog.inherits(kindred.component.DesktopHeader, goog.events.EventTarget);


/**
 * like jQuery options
 * @const {object}
 */
kindred.component.DesktopHeader.DEFAULT = {
  'option_01': '',
  'option_02': ''
};

/**
 * CLASSNAME Event Constant
 * @const
 * @type {string}
 */
kindred.component.DesktopHeader.EVENT_01 = '';

/**
 * CLASSNAME Event Constant
 * @const
 * @type {string}
 */
kindred.component.DesktopHeader.EVENT_02 = '';






//    ____  _____    _    ____   ____ _   _
//   / ___|| ____|  / \  |  _ \ / ___| | | |
//   \___ \|  _|   / _ \ | |_) | |   | |_| |
//    ___) | |___ / ___ \|  _ <| |___|  _  |
//   |____/|_____/_/   \_\_| \_\\____|_| |_|
//

kindred.component.DesktopHeader.prototype.create_search_pop_out = function() {

  this.search_btn.click(function(event){

    if(this.is_search_open == true) {

      if (this.search_txt.val() != this.search_str) {
        this.search_form.submit();
      }
    } else {
      this.open_search();
    }

  }.bind(this));



  // empty the search txt
  this.search_txt.val(this.search_str);

  this.search_txt.focus(function(event){

    if (this.search_txt.val() == this.search_str) {
      this.search_txt.val('');
    }

  }.bind(this));
  this.search_txt.blur(function(event){

    this.close_search();

    if (this.search_txt.val() == '') {
      this.search_txt.val(this.search_str);
    }

  }.bind(this));


  

};


kindred.component.DesktopHeader.prototype.open_search = function() {
  if (this.is_search_open == false) {
    this.is_search_open = true;
    this.search_container.addClass('expand-version');

    TweenMax.killTweensOf(this.search_form);
    TweenMax.to(this.search_form, 0.5, {autoAlpha: 1, onComplete: function(){
      // this.update_layout();
    }.bind(this)});

  }
};
kindred.component.DesktopHeader.prototype.close_search = function() {
  if (this.is_search_open == true) {
    this.is_search_open = false;
    this.search_container.removeClass('expand-version');

    TweenMax.killTweensOf(this.search_form);
    TweenMax.to(this.search_form, 0.5, {autoAlpha: 0, onComplete: function(){
      // this.update_layout();
    }.bind(this)});
  }
};







//     ____ _   _ ____  ____  _____ _   _  ______   __
//    / ___| | | |  _ \|  _ \| ____| \ | |/ ___\ \ / /
//   | |   | | | | |_) | |_) |  _| |  \| | |    \ V /
//   | |___| |_| |  _ <|  _ <| |___| |\  | |___  | |
//    \____|\___/|_| \_\_| \_\_____|_| \_|\____| |_|
//



kindred.component.DesktopHeader.prototype.create_currency_pop_out = function() {

  this.currency_btn.click(function(event){

    if (this.is_currency_open == true) {
      this.close_currency();
    } else {
      this.open_currency();
    }

  }.bind(this));



  this.currency_item_elements = this.currency_container.find('.desktop-menu-currency-item');
  var item = null;


  for (var i = 0, l=this.currency_item_elements.length; i < l; i++) {
    item = $(this.currency_item_elements[i]);

    item.click(function(event){
      var target = $(event.currentTarget);
      var value = target.attr('data-value');

      if (goog.isDefAndNotNull(value) && value != '') {
        this.set_currency(value);
      }
      
      
    }.bind(this));

    this.currency_item_array[i] = item;

  }
  
  

  


};
kindred.component.DesktopHeader.prototype.open_currency = function() {

  if (this.is_currency_open == false) {
    this.is_currency_open = true;

    this.currency_container_container.addClass('expand-version');

    TweenMax.killTweensOf(this.currency_container);
    TweenMax.to(this.currency_container, 0.3, {autoAlpha: 1});
  }
};

kindred.component.DesktopHeader.prototype.close_currency = function() {
  if (this.is_currency_open == true) {
    this.is_currency_open = false;

    this.currency_container_container.removeClass('expand-version');

    TweenMax.killTweensOf(this.currency_container);
    TweenMax.to(this.currency_container, 0.3, {autoAlpha: 0});
  }

};



//    ____  _   _ ____  _     ___ ____
//   |  _ \| | | | __ )| |   |_ _/ ___|
//   | |_) | | | |  _ \| |    | | |
//   |  __/| |_| | |_) | |___ | | |___
//   |_|    \___/|____/|_____|___\____|
//


/**
 * @param {String} str_param
 */
kindred.component.DesktopHeader.prototype.set_currency = function(str_param) {

  this.currency_select.val(str_param).trigger('change');

  // select class is added on the callback of the select (in the original code currencies.liquid)

};
kindred.component.DesktopHeader.prototype.public_method_02 = function() {};
kindred.component.DesktopHeader.prototype.public_method_03 = function() {};
kindred.component.DesktopHeader.prototype.public_method_04 = function() {};
kindred.component.DesktopHeader.prototype.public_method_05 = function() {};
kindred.component.DesktopHeader.prototype.public_method_06 = function() {};


//    _______     _______ _   _ _____ ____
//   | ____\ \   / / ____| \ | |_   _/ ___|
//   |  _|  \ \ / /|  _| |  \| | | | \___ \
//   | |___  \ V / | |___| |\  | | |  ___) |
//   |_____|  \_/  |_____|_| \_| |_| |____/
//

/**
 * @param {object} event
 */
kindred.component.DesktopHeader.prototype.on_event_handler_01 = function(event) {
};

/**
 * @param {object} event
 */
kindred.component.DesktopHeader.prototype.on_event_handler_02 = function(event) {
};

/**
 * @param {object} event
 */
kindred.component.DesktopHeader.prototype.on_event_handler_03 = function(event) {
};

/**
 * @param {object} event
 */
kindred.component.DesktopHeader.prototype.on_event_handler_04 = function(event) {
};






kindred.component.DesktopHeader.prototype.sample_method_calls = function() {

  // sample override
  kindred.component.DesktopHeader.superClass_.method_02.call(this);

  // sample event
  this.dispatchEvent(new goog.events.Event(kindred.component.DesktopHeader.EVENT_01));
};