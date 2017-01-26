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

  // if class has parent
  //goog.events.EventTarget.call(this, options, element);
  //this.options = $.extend(this.options, kindred.component.MobileHeader.DEFAULT, options);
  




  


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


kindred.component.MobileHeader.prototype.public_method_01 = function() {};
kindred.component.MobileHeader.prototype.public_method_02 = function() {};
kindred.component.MobileHeader.prototype.public_method_03 = function() {};
kindred.component.MobileHeader.prototype.public_method_04 = function() {};
kindred.component.MobileHeader.prototype.public_method_05 = function() {};
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