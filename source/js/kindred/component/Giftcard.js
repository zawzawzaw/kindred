goog.provide('kindred.component.Giftcard');

goog.require('goog.events.Event');
goog.require('goog.events.EventTarget');

/**
 * The CLASSNAME constructor
 * @param {object} options The object extendable like jquery plugins
 * @param {element} element The jQuery element connected to class
 * @constructor
 * @extends {goog.events.EventTarget}
 */
kindred.component.Giftcard = function(options, element) {

  goog.events.EventTarget.call(this);
  this.options = $.extend({}, kindred.component.Giftcard.DEFAULT, options);
  this.element = element;

  // if class has parent
  //goog.events.EventTarget.call(this, options, element);
  //this.options = $.extend(this.options, kindred.component.Giftcard.DEFAULT, options);
  

  this.item_array = [];

  


  this.name_elements = this.element.find('.product-page-giftcard-design-text h1');
  this.message_elements = this.element.find('.product-page-giftcard-design-text p');
  this.price_elements = this.element.find('.product-page-giftcard-design-text h4 .value');
  


  

  


  this.copy_container = $('#product-page-detail-copy');       // cheating :P                /// IMPORTANT AS HELL


  this.current_design = '';
  this.current_name = '';
  this.current_message = '';
  this.current_price = '';


  this.design_dropdown = this.copy_container.find('#select-giftcard-design');
  this.name_txt = this.copy_container.find('#input-giftcard-name');
  this.message_txt = this.copy_container.find('#input-giftcard-message');

  this.price_dropdown = this.copy_container.find('#productSelect-option-0');

  this.name_chars_left = this.copy_container.find('#giftcard-name-char-left');
  this.message_words_left = this.copy_container.find('#giftcard-message-words-left');



  //    ___ _   _ ___ _____
  //   |_ _| \ | |_ _|_   _|
  //    | ||  \| || |  | |
  //    | || |\  || |  | |
  //   |___|_| \_|___| |_|
  //


  var arr = this.element.find('.product-page-giftcard-design');
  var item = null;

  for (var i = 0, l=arr.length; i < l; i++) {
    item = $(arr[i]);
    this.item_array[i] = item;
  }

  this.design_dropdown.on('change', function(event){
    this.update_design_layout();
  }.bind(this));


  this.name_txt.on('change', function(event){
    this.update_text_layout();
  }.bind(this));

  
  this.name_txt.keyup(function(event) {

    this.trim_name_txt();
    this.update_text_layout();

  }.bind(this));





  this.message_txt.on('change', function(event){
    this.update_text_layout();
  }.bind(this));  
  this.message_txt.keyup(function(event) {

    this.trim_message_txt();    // important         // http://jsfiddle.net/7DT5z/9/
    this.update_text_layout();

  }.bind(this));

  this.price_dropdown.on('change', function(event){
    this.update_text_layout();
  }.bind(this))


  this.trim_name_txt();
  this.trim_message_txt();

  this.update_design_layout();
  this.update_text_layout();

  


  console.log('kindred.component.Giftcard: init');
};
goog.inherits(kindred.component.Giftcard, goog.events.EventTarget);


/**
 * like jQuery options
 * @const {object}
 */
kindred.component.Giftcard.DEFAULT = {
  'option_01': '',
  'option_02': ''
};

/**
 * @const
 * @type {string}
 */
kindred.component.Giftcard.MAX_NAME_CHAR = 50;

/**
 * @const
 * @type {string}
 */
kindred.component.Giftcard.MAX_MESSAGE_WORDS = 100;


//    ____  ____  _____     ___  _____ _____
//   |  _ \|  _ \|_ _\ \   / / \|_   _| ____|
//   | |_) | |_) || | \ \ / / _ \ | | |  _|
//   |  __/|  _ < | |  \ V / ___ \| | | |___
//   |_|   |_| \_\___|  \_/_/   \_\_| |_____|
//


kindred.component.Giftcard.prototype.private_method_01 = function() {};
kindred.component.Giftcard.prototype.private_method_02 = function() {};
kindred.component.Giftcard.prototype.private_method_03 = function() {};
kindred.component.Giftcard.prototype.private_method_04 = function() {};
kindred.component.Giftcard.prototype.private_method_05 = function() {};
kindred.component.Giftcard.prototype.private_method_06 = function() {};


//    ____  _   _ ____  _     ___ ____
//   |  _ \| | | | __ )| |   |_ _/ ___|
//   | |_) | | | |  _ \| |    | | |
//   |  __/| |_| | |_) | |___ | | |___
//   |_|    \___/|____/|_____|___\____|
//


kindred.component.Giftcard.prototype.update_design_layout = function() {

  var temp_val = this.design_dropdown.val()
  if(this.current_design != temp_val) {

    this.current_design = temp_val;

    var item = null;

    for (var i = 0, l=this.item_array.length; i < l; i++) {
      item = this.item_array[i];

      if (item.attr('data-value') == this.current_design) {

        // show design
        TweenMax.killTweensOf(item);
        TweenMax.to(item, 0.5, {autoAlpha:1});
        
      } else {

        // hide_design
        TweenMax.killTweensOf(item);
        TweenMax.to(item, 0.5, {autoAlpha:0});

      }

    } // for
  } // if 
  
  
};
kindred.component.Giftcard.prototype.update_text_layout = function() {

  this.current_name = this.name_txt.val();
  this.current_message = this.message_txt.val();
  this.current_price = this.price_dropdown.val()

  

  // update the text in the overlays
  this.name_elements.html(this.current_name);
  this.message_elements.html(this.current_message);

  this.price_elements.html(this.current_price);

    
};






kindred.component.Giftcard.prototype.trim_name_txt = function() {
  
  var value = '' + this.name_txt.val();
  var words = value.length;
  if (words > kindred.component.Giftcard.MAX_NAME_CHAR) {
    
    var trimmed = value.substr(0, kindred.component.Giftcard.MAX_NAME_CHAR);
    this.name_txt.val(trimmed + " ");

  } else {

    var words_left = kindred.component.Giftcard.MAX_NAME_CHAR - words;
    this.name_chars_left.html('(' + words_left + ' characters left)');

  }
};

kindred.component.Giftcard.prototype.trim_message_txt = function() {
  var value = '' + this.message_txt.val();
  var words = value.match(/\S+/g).length;
  if (words > kindred.component.Giftcard.MAX_MESSAGE_WORDS) {
    // Split the string on first 50 words and rejoin on spaces
    var trimmed = value.split(/\s+/, kindred.component.Giftcard.MAX_MESSAGE_WORDS).join(" ");
    // Add a space at the end to keep new typing making new words
    this.message_txt.val(trimmed + " ");
  } else {

    var words_left = kindred.component.Giftcard.MAX_MESSAGE_WORDS - words;
    this.message_words_left.html('(' + words_left + ' words left)');
  }
};

kindred.component.Giftcard.prototype.public_method_05 = function() {};
kindred.component.Giftcard.prototype.public_method_06 = function() {};


//    _______     _______ _   _ _____ ____
//   | ____\ \   / / ____| \ | |_   _/ ___|
//   |  _|  \ \ / /|  _| |  \| | | | \___ \
//   | |___  \ V / | |___| |\  | | |  ___) |
//   |_____|  \_/  |_____|_| \_| |_| |____/
//

/**
 * @param {object} event
 */
kindred.component.Giftcard.prototype.on_event_handler_01 = function(event) {
};

/**
 * @param {object} event
 */
kindred.component.Giftcard.prototype.on_event_handler_02 = function(event) {
};

/**
 * @param {object} event
 */
kindred.component.Giftcard.prototype.on_event_handler_03 = function(event) {
};

/**
 * @param {object} event
 */
kindred.component.Giftcard.prototype.on_event_handler_04 = function(event) {
};






kindred.component.Giftcard.prototype.sample_method_calls = function() {

  // sample override
  kindred.component.Giftcard.superClass_.method_02.call(this);

  // sample event
  this.dispatchEvent(new goog.events.Event(kindred.component.Giftcard.EVENT_01));
};