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
  

  




  this.create_search_pop_out();


  


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


  this.element.mouseleave(function(event){
    this.close_search();
  }.bind(this));

};


kindred.component.DesktopHeader.prototype.open_search = function() {
  if (this.is_search_open == false) {
    this.is_search_open = true;
    this.search_container.addClass('expand-version');

    TweenMax.killTweensOf(this.search_form);
    TweenMax.to(this.search_form, 0.5, {autoAlpha: 1, onComplete: function(){
      this.update_layout();
    }.bind(this)});

  }
};
kindred.component.DesktopHeader.prototype.close_search = function() {
  if (this.is_search_open == true) {
    this.is_search_open = false;
    this.search_container.removeClass('expand-version');

    TweenMax.killTweensOf(this.search_form);
    TweenMax.to(this.search_form, 0.5, {autoAlpha: 0, onComplete: function(){
      this.update_layout();
    }.bind(this)});
  }
};
kindred.component.DesktopHeader.prototype.private_method_04 = function() {};
kindred.component.DesktopHeader.prototype.private_method_05 = function() {};
kindred.component.DesktopHeader.prototype.private_method_06 = function() {};


//    ____  _   _ ____  _     ___ ____
//   |  _ \| | | | __ )| |   |_ _/ ___|
//   | |_) | | | |  _ \| |    | | |
//   |  __/| |_| | |_) | |___ | | |___
//   |_|    \___/|____/|_____|___\____|
//


kindred.component.DesktopHeader.prototype.public_method_01 = function() {};
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