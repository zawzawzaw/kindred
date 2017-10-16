// requires cache


goog.provide('kindred.component.MailingListPopup');

goog.require('goog.events.Event');
goog.require('goog.events.EventTarget');


goog.require('goog.net.cookies');   // notice the lowercaps


/**
 * The CLASSNAME constructor
 * @param {object} options The object extendable like jquery plugins
 * @param {element} element The jQuery element connected to class
 * @constructor
 * @extends {goog.events.EventTarget}
 */
kindred.component.MailingListPopup = function(options, element) {

  goog.events.EventTarget.call(this);
  this.options = $.extend({}, kindred.component.MailingListPopup.DEFAULT, options);
  this.element = element;

  // if class has parent
  //goog.events.EventTarget.call(this, options, element);
  //this.options = $.extend(this.options, kindred.component.MailingListPopup.DEFAULT, options);
  

  this.black_bg = this.element.find('.black-bg');
  this.close_btn = this.element.find('#mailing-list-pop-up-close-btn')

  this.is_open = false;

  this.cookies = goog.net.cookies;


  // init

  this.black_bg.click(function(event){
    this.close_popup();
  }.bind(this));

  this.close_btn.click(function(event){
    this.close_popup();
  }.bind(this));
  



  var cookie_value = this.cookies.get('kindredpopup');


  // if no cookie is available
  if (goog.isDefAndNotNull(cookie_value) == false) {


    var max_seconds = 60 * 60 * 10;   // 10 hr expiry

    this.cookies.set('kindredpopup', 'hascookie', max_seconds);

    TweenMax.delayedCall(12, this.open_popup, [], this);
    
    console.log('doesnt have cookie, will open in 5 secs');
  } else {
    console.log('already has cookie');
  }
  


  console.log('kindred.component.MailingListPopup: init');
};
goog.inherits(kindred.component.MailingListPopup, goog.events.EventTarget);


/**
 * like jQuery options
 * @const {object}
 */
kindred.component.MailingListPopup.DEFAULT = {
  'option_01': '',
  'option_02': ''
};

/**
 * CLASSNAME Event Constant
 * @const
 * @type {string}
 */
kindred.component.MailingListPopup.EVENT_01 = '';

/**
 * CLASSNAME Event Constant
 * @const
 * @type {string}
 */
kindred.component.MailingListPopup.EVENT_02 = '';


//    ____  ____  _____     ___  _____ _____
//   |  _ \|  _ \|_ _\ \   / / \|_   _| ____|
//   | |_) | |_) || | \ \ / / _ \ | | |  _|
//   |  __/|  _ < | |  \ V / ___ \| | | |___
//   |_|   |_| \_\___|  \_/_/   \_\_| |_____|
//



kindred.component.MailingListPopup.prototype.private_method_03 = function() {};
kindred.component.MailingListPopup.prototype.private_method_04 = function() {};
kindred.component.MailingListPopup.prototype.private_method_05 = function() {};
kindred.component.MailingListPopup.prototype.private_method_06 = function() {};


//    ____  _   _ ____  _     ___ ____
//   |  _ \| | | | __ )| |   |_ _/ ___|
//   | |_) | | | |  _ \| |    | | |
//   |  __/| |_| | |_) | |___ | | |___
//   |_|    \___/|____/|_____|___\____|
//


kindred.component.MailingListPopup.prototype.open_popup = function() {
  if (this.is_open == false) {
    this.is_open = true;

    this.element.addClass('open-version');
    TweenMax.killTweensOf(this.element);
    TweenMax.to(this.element, 0.5, {autoAlpha: 1});

  }
};
kindred.component.MailingListPopup.prototype.close_popup = function() {
  if (this.is_open == true) {

    this.is_open = false;

    TweenMax.killTweensOf(this.element);
    TweenMax.to(this.element, 0.5, {autoAlpha: 0, onComplete: function(){

      this.element.removeClass('open-version');

    }.bind(this)});

  }
};


kindred.component.MailingListPopup.prototype.public_method_01 = function() {};
kindred.component.MailingListPopup.prototype.public_method_02 = function() {};
kindred.component.MailingListPopup.prototype.public_method_03 = function() {};
kindred.component.MailingListPopup.prototype.public_method_04 = function() {};
kindred.component.MailingListPopup.prototype.public_method_05 = function() {};
kindred.component.MailingListPopup.prototype.public_method_06 = function() {};


//    _______     _______ _   _ _____ ____
//   | ____\ \   / / ____| \ | |_   _/ ___|
//   |  _|  \ \ / /|  _| |  \| | | | \___ \
//   | |___  \ V / | |___| |\  | | |  ___) |
//   |_____|  \_/  |_____|_| \_| |_| |____/
//

/**
 * @param {object} event
 */
kindred.component.MailingListPopup.prototype.on_event_handler_01 = function(event) {
};

/**
 * @param {object} event
 */
kindred.component.MailingListPopup.prototype.on_event_handler_02 = function(event) {
};

/**
 * @param {object} event
 */
kindred.component.MailingListPopup.prototype.on_event_handler_03 = function(event) {
};

/**
 * @param {object} event
 */
kindred.component.MailingListPopup.prototype.on_event_handler_04 = function(event) {
};






kindred.component.MailingListPopup.prototype.sample_method_calls = function() {

  // sample override
  kindred.component.MailingListPopup.superClass_.method_02.call(this);

  // sample event
  this.dispatchEvent(new goog.events.Event(kindred.component.MailingListPopup.EVENT_01));
};